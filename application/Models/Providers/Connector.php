<?php

namespace Model\Providers;

use Model\Providers\Traffics\Client;

/*
 *  Abstract layer
 *  Martireisen <-> Tourism APi
 */
class Connector {
    
    private $gate;
    private $filter;
    private $limit = 10;
    private $stats = [];
    
    public function __construct() {
        $this->gate   = new Client();
    }
    
    
    public function statics() {
                
        $this->requestStart();
        $response        = $this->gate->statics();
        
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != ''
        );
        
        return $return;
    }
    
    
    public function regions() {
        
        $this->gate->filter($this->filter);
        
        $this->requestStart();
        $response        = $this->gate->region();
        $response        = $this->gate->converter->region($response);
        
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'duration' => $this->gate->durationChanged,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }
    
    public function completions($query = '',$type = 'pauschal',$loc = 0) {
        
        $this->requestStart();
        $response        = $this->gate->completions($query,$type,$loc);
     //   $response        = $this->gate->converter->region($response);
        $response        = $this->gate->converter->completion($response);


        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }
    
    public function hotels($top = false) {
        
        $this->gate->filter($this->filter);
        $this->gate->top = $top;
        
        $this->requestStart();
        $response        = $this->gate->hotel();
        $response        = $this->gate->converter->hotel($response);

        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'duration' => $this->gate->durationChanged,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }

    public function hotelByGiata() {
        $data = \Helper\Input::json();
        $this->requestStart();
        $result = [];
        foreach ($data->codes as $id) {
            $this->gate  = new Client();
            $htl = $this->gate->hotel($id);
            array_push($result, $htl);
        }
        $response = $result;
        $response = $this->gate->converter->hotel($response);
        $this->requestEnd();

        $return   = array(
            'request'  => $data,
            'response' => $response,
            'stats'    => $this->stats,
            'duration' => $this->gate->durationChanged,
            'error'    => $response->error != '' || $response->api_error != ''

        );

        return $return;
    }
    
    public function hotelDetail($id) {
       // $this->gate->filter($filter);
        
        $this->gate->payload = ['tourOperatorList' => $this->filter->tourOperatorList];
        $this->requestStart();
        $response        = $this->gate->hotel($id);
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }
    
    public function reviews($id) {
        
        
        $this->requestStart();
        $response        = $this->gate->reviews($id);
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }
    
    public function offers() {
        
        $this->gate->filter($this->filter);
        
        $this->requestStart();
        $response = $this->gate->offer();
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }
    
    public function checkOffer($code,$type) {
       
        $this->gate->filter($this->filter);
        
        $this->requestStart();
        $response = $this->gate->offer($code,$type);
        $response = $this->gate->converter->offer($response);
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != '' ||  $response->statusCode == 'XX' || $response->statusCode == 'NK',
            'message'  => (string) $response->tomaMessage

        );
        
        return $return;
    }
    
    public function booking($id) {
        
       // $this->gate->filter($this->filter);
        
        $this->requestStart();
        $response        = $this->gate->bookingDetail($id);
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getPayload(),
            'response' => $response,
            'stats'    => $this->stats,
            'error'    => $response->error != '' || $response->api_error != ''

        );
        
        return $return;
    }
    
    public function createBooking($apiData) {
        
        $this->gate->setBookingData($apiData);
      
        $this->requestStart();
        $response = $this->gate->booking();
      
        $this->requestEnd();
        
        $return   = array(
            'request'  => $this->gate->getBookingData(),
            'response' => $response,
            'stats'    => $this->stats
        );
        
        return $return;
    }
    
    public function requestStart() {
        $this->stats['start']  = microtime(TRUE);
    }
    
    public function requestEnd() {
        
        $this->stats['end']    = microtime(TRUE);
        $this->stats['time']   = ceil($this->stats['end'] - $this->stats['start']).' sec';
    }
    
    public function convert($type,$data) {
        
        $result = [];
        
        switch($type){
            case 'region' : 
                $result = $this->gate->converter->region($data);
                break;
             case 'hotel' : 
                $result = $this->gate->converter->hotel($data);
                break;
        }
        
        return $result;
        
    }
    // mapping filters
    public function setFilter($data = null) {
        
        $data = $data != null ? $data : \Helper\Input::json();
        $filter = new \Model\Providers\Filter();
        
        $filter->setNavigation('1,'.$this->limit);
        
        if(isset($data->page)){
            $filter->setNavigation((((($data->page-1) * $this->limit)) +1) .','. $this->limit);
        }
        
        if(isset($data->sf)){
            $filter->setType($data->sf);
        }
        
        if(isset($data->productSubType) && !empty($data->productSubType)){
            $filter->setProductSubType($data->productSubType);
        }
        
        if(isset($data->date)){
            if(!empty($data->date->start) || !empty($data->date->end)) {
                $opts = array(
                    'from' => strtotime($data->date->start),
                    'to'   => strtotime($data->date->end),
                    'duration' => $data->duration
                );
               $filter->setDate($opts);
            }
        }
        
        if(isset($data->adults) && $data->adults > 0){
            $filter->setAdults($data->adults);
        }
        
        if(isset($data->sort) && !empty($data->sort)){
            if($data->sort == 'PRICE') {
                $filter->setSortBy('price');
                $filter->setSortDir('up');
            }else if($data->sort == 'PRICE_ZA'){
                $filter->setSortBy('price');
                $filter->setSortDir('down');
            }
        }
        
        if(isset($data->children) && count($data->children) > 0){
            $children = array_values(array_column($data->children, 'jahre'));
            $filter->setChildren(implode(',',$children));
        }
        
        if(isset($data->departure) && !empty($data->departure->code)){
            $filter->setDepartureAirportList($data->departure->code);
        }
        
        if(isset($data->destination->code) && ($data->destination->type == 'state' || $data->destination->type == 'location' || $data->destination->type == 'city' )){
            $filter->setLocationList($data->destination->code);
        }
        
        if(isset($data->city) && !empty($data->city)){
            $filter->setLocationList($data->city);
        }
        
        if(isset($data->destination->code) && $data->destination->type == 'region' ){
            $filter->setRegionList($data->destination->code);
        }
        
        if(isset($data->destination->code) && $data->destination->type == 'country' ){
            $filter->setRegionList($data->destination->code);
        }

        if(isset($data->giataIdList)){
            $filter->setGiataIdList($data->giataIdList);
        }

        if(isset($data->star) && $data->star > 0){
            $filter->setMinCategory($data->star);
        }
        
        if(isset($data->reviewRate) && !empty($data->reviewRate)){
            $filter->setMinRecommendation($data->reviewRate);
        }
        
        if(isset($data->pansion) && !empty($data->pansion)){
            $filter->setMinBoardType($data->pansion);
        }else if($data->sf == 2){
            $filter->setMinBoardType('OV');
        }
        
        if(isset($data->room) && !empty($data->room)){
            $filter->setRoomTypeList($data->room);
        }
        
        if(isset($data->operators) && is_array($data->operators) && count($data->operators) > 0 ){
            
            $data->operators = implode(',',array_filter($data->operators));
            $filter->setTourOperatorList(($data->operators));
        }else if(!empty($data->operators)) { 
            $data->operators = $data->operators;
            $filter->setTourOperatorList(($data->operators));
        }else if ($data !== false){
            $data->operators = implode(',',array_filter($this->getOperators()));
            $filter->setTourOperatorList($data->operators); 
        }
        
        if(isset($data->keywordList) && count($data->keywordList) > 0 ){
            $data->keywordList = implode(',',array_filter($data->keywordList));
            $filter->setKeywordList(($data->keywordList));
        }
        
        if(isset($data->attributes) && count($data->attributes) > 0 ){
            $data->attributes = implode(',',array_filter($data->attributes));
            $filter->setKeywordList(($data->attributes));
        }
        
        
        if(isset($data->transfer) && ($data->transfer) == 1){
            $filter->setTransferList('MT');
        }
        
        if(isset($data->seaview) && $data->seaview == 1){
            $filter->setLocatedList('MB');
        }
        
        if(isset($data->directness) && $data->directness == 1){
            $filter->setFlightDirectness('N');
        }
        
        
        if($data->landing === true){
            $filter->setNavigation('1,6');
            $filter->setFilterNoPictures(true);
        }
        
        if(isset($data->priceMax) && !empty($data->priceMax)){
            $filter->setMaxPricePerPerson((int)$data->priceMax);
        }
        
         /*
       
        if(isset($data['priceMax']) && intval($data['priceMax']) > 0){
            $this->gate->setPriceMax($data['priceMax']);
        }
        
        if(isset($data['destination']) && !empty($data['destination']['code']) && $data['destination']['type'] == 'region'){
            $data['destination']['code'] = $data['destination']['code']  == 'GF' ? 'GF/GI' : $data['destination']['code'];
            $this->gate->setState($data['destination']['code']);
        }
        
        if(isset($data['destination']) && !empty($data['destination']['code']) && $data['destination']['type'] == 'city'){
            if((float)$data['destination']['lat'] > 0 ) {
                $this->gate->setCoordinate(number_format($data['destination']['lat'],8,'.','').','.number_format($data['destination']['lng'],8,'.',''));
               // $_GET['sort'] = 'ORT';
            }else{
                $this->gate->setCity($data['destination']['code']);
            }
        }
      
    */
        
        $this->filter = $filter;
        return $filter;
        
    }
    
     public function getOperators() {
        
        $dbCache = new \Core\Cache\DbCache();
         
        $dbCache->setKey('operators');
        $data = $dbCache->pull();
        $data = false;
        if($data == false){
            $data   = \Model\Booking\Operator::where('is_active',1)->get()->toArray();
            $dbCache->put($data);
        }        
        
        $operators = array_column($data, 'code');
        return $operators;
        
    }
    
    public function setLimit($limit) {
        $this->limit = $limit;
    }
}
