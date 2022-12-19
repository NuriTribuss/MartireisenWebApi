<?php

namespace Model\Block;

use Model\Localization\Translate;
use Model\Block\Week;
use Model\Api\Client\Api;

class All  {
    
    private $api;
    
    public function __construct() {
        $this->api = new Api();
        $this->api->setLanguage();
        
    }

    public function getWeekBlocks() {
        
        $records    = Week::where('is_active',1)->orderBy('sort_number','ASC')->get()->toArray();
        $return     = array();
        
        $translate  = new Translate;
        
        foreach($records as $key => $value){
            
            $return[$key]['title']    = $translate->get($value['id'], 'weektabs', \Core\Translation\Language::getLanguage(), $value['title']);
            if(!empty($value['giata_ids'])){
                $return[$key]['children'] = $this->getHotelsById($value['giata_ids']);
            }else{
                $return[$key]['children'] =  $this->getHotelsByRegion($value['code']);
            }            
        }
        
        return $return;
    }
    
    public function getTopOffers() {
        return $this->getHotelsByRegion('/TR/DO/DS');
    } 
    
    public function getTopRegions() {
                
        $this->api->setParams($_GET);
        $this->api->sort(array('sort' => 'TOP'),'region');
        
        $regions = [];
        
        $response = $this->api->regions();
        
        if($response['response']['PAGE'] !== 'error'){
            $regions  = $response['response']['TOP']['REGION'];
            foreach($regions as &$region){
                $region = $this->travelItToRegion($region);
            }
        }
        
        return $regions;
    }
    
    public function getHotelsByRegion($code = '') {
        
        $data = new \stdClass();
        $data->sf = 2;
        $data->adults = 2;
        $data->destination->type = 'country';
        $data->destination->code = $code;
        $data->star = 4;
         
        $trafficsApi = new \Model\Providers\Connector();
        $trafficsApi->setLimit(5);
        $trafficsApi->setFilter($data);
        $return = $trafficsApi->hotels();
        $hotels = [];
        
        if(!$return['response']->error){
            $hotels = $return['response']->hotelList;
            foreach ($hotels as &$hotel){
                $hotel = $this->mappingHotel($hotel);
            }
        }
        return array_slice($hotels,0,10);
    }
    
    public function getHotelsById($id) {
        
        $data = new \stdClass();
        $data->sf = 2;
        $data->adults = 2;
        $data->destination->type = 'hotel';
        $data->destination->code = $id;
        
        $trafficsApi = new \Model\Providers\Connector();
        $trafficsApi->setLimit(5);
        $trafficsApi->setFilter($data);
        $return = $trafficsApi->hotels();
        $hotels = [];
        
        if(!$return['response']->error){
            $hotels = $return['response']->hotelList;
            foreach ($hotels as &$hotel){
                $hotel = $this->mappingHotel($hotel); 
            }
        }
        return array_slice($hotels,0,10);
    }
        
    public function mappingHotel($hotel) {
       
        $return = array(
            'name'      => $hotel->name,
            'name_sef'  => \Helper\Url::beautify($hotel->name),
            'region'    => $hotel->location->region->name,
            'state'     => $hotel->location->name,
            'star'      => (int)$hotel->category,
            'price'     => $hotel->bestPricePerPerson->value,
            'duration'  => 7,
            'image'     => str_replace('=150','=400',$hotel->mediaData->pictureUrl),
            //'time'   => 
            'giataCode' => $hotel->giata->hotelId
        );
        
        return $return;
    }
    
    public function travelItToRegion($region) {
        
        $return = array(
            'name'   => $region['NAME'],
            'price'  => $region['PREIS'],
            'code'   => $region['REGIONCODE']
        );
        
        if(is_array($region['ZIEL'])){
            $return['children'] = [];
            foreach($region['ZIEL'] as $key =>  $state){
                $return['children'][$key] = $this->travelItToState($state);
            }
        }
        
        return $return;
    }
    
    public function travelItToState($state) {
        
         $return = array(
            'name'   => $state['NAME'],
            'price'  => $state['PREIS'],
            'code'   => $state['REF'],
            'watertemp' => $state['WASSERTEMP'],
            'temp'      => $state['LUFTTEMP']
        );
        
        return $return;
    }

}