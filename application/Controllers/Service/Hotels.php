<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Region\Country;
use Model\Region\HalalHotel;
use Elasticsearch\ClientBuilder;
use Model\HotelView;

class Hotels extends Service{

    public function __construct() {
        
        $opts = ['cache' => true,'max-age' => 3600];
        parent::__construct($opts);
    }

    public function get($term = '') {
        $this->suggest($term);
    }
    
    public function suggest($term = '') {
        
        if(empty($term)){
            $term = \Helper\Input::post('q');
        }

        $halal = \Helper\Input::get('halal',0);
        
        //$client    = new Client();
        $countries = Country::where(array('is_active' => 1))->limit(200)->get();
        
        $priority   = [];
        $all        = [];
        
        
        foreach($countries as $country){
            if($country->priority == 1){
                array_push($priority, $country->code);
            }
            array_push($all,$country->code);
        }
                 
        $output = [];
        $index = 0;

        if($halal == 1){
            
            $halalBooking = HalalHotel::where('name', 'like', '%' . $term . '%')->get();
            $halalHotels  = $halalBooking->toArray();


            foreach($halalHotels as $key => $record){

                $output[$index] = array(
                    'sort'          => 1,
                    'code'          => $record['code'],
                    'giataCode'     => $record['code'],
                    'label'         => $record['name'],
                    'value'         => $record['name'],
                    'city'          => $record['city'],
                    'region'        => $record['region'],
                    'source'        => 'HalalBooking',
                    'sort'          => 999
                );

                $index++;

            }
            $this->response->setData($output)->setStatus(true)->out();
        }
        
        try {
            
            $client = ClientBuilder::create()->build();
            
            $params = [
                'index' => 'hotels',
                'type'  => 'hotels',
                'body'  => [
                    'query' => [
                        "match_phrase_prefix" => [
                            "value" =>($term),  
                        ]
                    ],
                    "from"  => 0, 
                    "size"  => 15,
                    'sort' => [
                       ['score' => 'desc'],'_score' 
                    ]
                ]
            ];

            $response = $client->search($params);
            foreach($response['hits']['hits'] as $key => $record){
               
                $record = (object)$record['_source'];
                $output[$index] = array(
                    'sort'          => 1,
                    'code'          => $record->ortCode,
                    'giataCode'     => $record->giataCode,
                    'label'         => $record->label,
                    'value'         => $record->value,
                    'city'          => $record->zielName,
                    'region'        => $record->regionName,
                    'source'        => 'TravelIT'
                );
                if(in_array($record->regionCode, $priority)){
                   $output[$index]['sort'] = 999;
                }
                
                $index++;
            }
            
        }catch(\Exception $e){
             
        }
        
        $this->response->setData($output)->setStatus(true)->out();
        
      
    }
    
    public function getHotelData($tab = 'all') {
        
        $opts = array(
            'gid' => \Helper\Input::get('gid'),
            'oc'  => \Helper\Input::get('goc'),
            'vc'  => \Helper\Input::get('vc','1')
        );
        
        $key = 'hotel_'.str_replace(',','-',$tab).'_'.$opts['gid'].'_'.$opts['vc'].'_l_'.\Core\Translation\Language::getLanguage();
        $this->dbCache->setKey($key);
        $data = $this->dbCache->pull(); 
        
        if($data == false){
            $api = new \Model\Api\Hotel();
            $data = $api->get($opts['gid'], $opts['oc'], $opts['vc'],$tab);
            $this->dbCache->put($data);
        }    
        
        return $data;
      
    }
    
    public function getBasic() {
        $hotelView = new HotelView();
        $data = $this->getHotelData();        
        if(!is_array($data)){
            $this->response->setStatus(false)->setMessage('Hotel Info')->out();
        }
        $data = $hotelView->get($data);
        $this->response->setStatus(true)->setData($data)->out();
    }
    
    public function getImages() {
        
        $data = $this->getHotelData('pictures');
        $this->response->setStatus(true)->setData($data)->out();
    }
    
    public function getMap() {
        
        $data = $this->getHotelData('geo');
        $this->response->setStatus(true)->setData($data)->out();
    }
    
    public function getWeather($lat,$lon) {
        
        // to do cache
        $app = 'f44943c031a0bde1f5d1e8940da4a40b';
        $url = 'https://api.openweathermap.org/data/2.5/weather?lat='.(int)$lat.'&lon='.(int)$lon.'&units=metric&cnt=5&lang=de&appid='.$app;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);
        curl_close($ch);
        $this->response->setStatus(true)->setData(json_decode($r),true)->out();
                
    }
}
