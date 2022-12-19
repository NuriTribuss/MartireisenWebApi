<?php

namespace Model\Api\Client;

use Model\Api\Client\Travelit;
use Model\Api\Client\Traffics;
use Model\Api\Client\TravelitMapping;

class Api {
    
    private $gate;
    private $gateMap;
    private $params;
    private $bookingParams;
    private $isTest = true;
    private $filters = array(
        
    );
    
    private $defaultLanguage = 'DE';
    private $allowedLanguage = ['DE','EN','TR','FR','HU','CZ','DK','NL','PL','SL'];
    
    private $defaultSort = array(
        'region' => 'TOP',
        'hotel'  => 'PRICE',
        'offer'  => 'PRICE'
    );
    
    private $allowedSort = ['PRICE','PRICE_ZA','GPRICE','NAME','NAME_ZA','TOP','TOPFERN','TOPFAM','DATE','ROOM','BOARD','AIRPORT','DURATION','ORT'];
    
    
    public function __construct() {
        $this->gate     = new Travelit();
        $this->gateMap  = new TravelitMapping();
        $this->isTest     = \Helper\Config::get('TEST_MODE') == 1;
    }
    
    public function getGate() {
        return $this->gate;
    }
        
    public function regions() {
        
        $this->gate->endpoint('regions');
        
        $stats['start']  = microtime(TRUE);
        $response        = $this->gate->toArray();
        $stats['end']    = microtime(TRUE);
        $stats['time']   = ceil($stats['end'] - $stats['start']).' sec';
        
        $return   = array(
            'request'  => $this->gate->queryBuilder(false),
            'response' => $response,
            'stats'    => $stats
        );
        
        return $return;
    }
    
    public function hotels() {
                
        $this->gate->endpoint('hotels');

        $stats['start']  = microtime(TRUE);
        $response        = $this->gate->toArray();
        $stats['end']    = microtime(TRUE);
        $stats['time']   = ceil($stats['end'] - $stats['start']).' sec';
        
        $return   = array(
            'request'  => $this->gate->queryBuilder(false),
            'response' => $response,
            'stats'    => $stats
        );
        
        return $return;
    }
    
    public function hotelOffers() {
                
        $stats['start']  = microtime(TRUE);
        $response        = $this->gate->toArray();
        $stats['end']    = microtime(TRUE);
        $stats['time']   = ceil($stats['end'] - $stats['start']).' sec';
        
        $return   = array(
            'request'  => $this->gate->queryBuilder(false),
            'response' => $response,
            'stats'    => $stats
        );
        
        return $return;
    }
    
    public function booking() {
        
        $stats['start']  = microtime(TRUE);
        //var_dump($this->bookingParams);
        $response        = $this->gate->bookingPage(
            $this->bookingParams['GID'],
            $this->bookingParams['code'],
            $this->bookingParams['CITY']
        );
        
        $response = $this->gateMap->booking($response);
   //     if($this->gate->sf == 2){
        $response['FLIGHT'] = $this->gate->flightCheck($this->bookingParams['code']);
        
        // $gid, $source, $aptz, $versant, $ref, $sf, $datum, $rrtag, $adults
       /* $response['ALTERNATIVE_FLIGHT'] = $this->gate->alternativeFlights(
            $this->bookingParams['GID'],
            $this->bookingParams['SOURCE'],
            $this->bookingParams['APTZ'],
            $this->bookingParams['VERANST'],
            $this->bookingParams['code'],
            $this->bookingParams['sf'],
            $this->bookingParams['datum'],
            $this->bookingParams['rrtag'],
            $this->bookingParams['rrtag'],
        );*/
     //   }
        
        
        $stats['end']    = microtime(TRUE);
        $stats['time']   = ceil($stats['end'] - $stats['start']).' sec';
        
        $return   = array(
            'request'  => $this->gate->getOptions(),
            'response' => $response,
            'stats'    => $stats
        );
        return $return;
    }
    
    public function createBooking($data) {
        
        $stats['start']  = microtime(TRUE);
        
        $response  = $this->gate->createBooking($data, $this->isTest);
        
        $stats['end']    = microtime(TRUE);
        $stats['time']   = ceil($stats['end'] - $stats['start']).' sec';
        
        $return   = array(
            'request'  => $this->gate->getOptions(),
            'response' => $response,
            'stats'    => $stats
        );
        return $return;
    }
    
    
    public function getFlightInfo($ref = '') {
        if(empty($ref)){
            $ref = $this->bookingParams['code'];
        }
        return $this->gate->flightCheck($ref); 
    }
    
    public function getInsuranceInfo($bookingData) {
        
        $birthdayData = '';
        foreach($bookingData['TOUROPPERSONLIST']['PERSON'] as $el) {
            if(is_string($el['BIRTHDATE'])){
                $birthdayData.= $el['BIRTHDATE'].' ';
            }
        }
        $data = array (
            "RequestData" => [
               "startDate"=>  str_replace('.','',($bookingData['SERVICE']['TERMIN'])),
               "personCount"=> $bookingData['SERVICE']['PERSONS'],
               "flightType"=> $bookingData['SF'] == 2 ? 'PAUSCHAL' : 'HOTEL',  
               "requestorIdentidy"=> $bookingData['CFG'], 
               "insuranceCompany"=> "ERV",
               "organizer"=> $bookingData['SERVICE']['VERANST'],
               "destinationAirport"=> "AYT",
            //   "birthdayData"=> rtrim($birthdayData,' '),
               "totalAmount"=> $bookingData['SERVICE']['GPREIS'],
               "endDate"=> str_replace('.','',($bookingData['SERVICE']['RRTAG'])),
               "mode"=> "IBE"
           ]
        );
        
        return $this->gate->getInsuranceInfo($data);
    }
        
    public function setLanguage() {
        if(in_array(strtoupper(\Core\Translation\Language::getLanguage()), $this->allowedLanguage)){
            return $this->gate->setLanguage(strtoupper(\Core\Translation\Language::getLanguage()));
        }
        
        return $this->gate->setLanguage($this->defaultLanguage);
    }
    
    public function setParams($data,$booking = false) {
        
        if($booking == false) {
            $data =  $this->fromSession($data);
        }
        if(isset($data['type'])){
            $this->gate->setType($data['type']);
        }
        if(isset($data['date'])){
            if(!empty($data['date']['start']) || !empty($data['date']['start'])) {
                $opts = array(
                    'start' => strtotime($data['date']['start']),
                    'end'   => strtotime($data['date']['end'])
                );
                $this->gate->setDate($opts);
            }
        }
        
        if(isset($data['adults']) && $data['adults'] > 0){
            $this->gate->setAdults($data['adults']);
        }
        
        if(isset($data['children']) && count($data['children']) > 0){
            $this->gate->setChildren($data['children']);
        }
        
        if(isset($data['priceMax']) && intval($data['priceMax']) > 0){
            $this->gate->setPriceMax($data['priceMax']);
        }
        
        if(isset($data['destination']) && !empty($data['destination']['code']) && $data['destination']['type'] == 'state'){
            
            if(is_numeric($data['destination']['code'])){
                $this->gate->setCity($data['destination']['code']);
            }else{
                
                $data['destination']['code'] = $data['destination']['code']  == 'PUJ' ? 'AZS/POP/PUJ/SDQ/DOM' : $data['destination']['code'];
                $data['destination']['code'] = $data['destination']['code']  == 'VRA' ? 'CCC/CYO/VRA/HOG/TND' : $data['destination']['code'];
                $data['destination']['code'] = $data['destination']['code']  == 'CGK' ? 'CGK/DPS/BXT/JOG/LOP/BTJ/BIK/TNJ/PNK/JKT/PKG' : $data['destination']['code'];

                $this->gate->setState($data['destination']['code']);
            }
            
        }
        
        if((int)$data['city'] > 0 ){
            $this->gate->setCity($data['city']);
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
        
        if(isset($data['destination']) && !empty($data['destination']['code']) && $data['destination']['type'] == 'hotel'){
            $this->gate->setHotel($data['destination']['code']);
        }
        if((int)$data['gid'] > 0 ){
            $this->gate->setHotel($data['gid']);
        }
        
        if(isset($data['departure']) && !empty($data['departure']['code'])){
            $this->gate->setDeparture($data['departure']['code']);
        }
        
        if(isset($data['star']) && ($data['star']) > 0){
            $this->gate->setStar($data['star']);
        }
         
        if(isset($data['reviewRate']) && intval($data['reviewRate']) > 0){
            $this->gate->setReview($data['reviewRate']);
        }
        
        if(isset($data['room']) && ($data['room']) > 0){
            $this->gate->setRoom($data['room']);
        }
        
        if(isset($data['sf']) && ($data['sf']) > 0){
            $this->gate->setType($data['sf']);
        }
        
        if(isset($data['pansion']) && ($data['pansion']) > 0){
            $this->gate->setPansion($data['pansion']);
        }
        
        if(isset($data['duration']) && ($data['duration']) > 0){
            $this->gate->setDuration($data['duration']);
        }
        
        if(isset($data['transfer']) && ($data['transfer']) > 0){
            $this->gate->setTransfer($data['transfer']);
        }
        
        if(isset($data['seaview']) && ($data['seaview']) > 0){
            $this->gate->setSeaView($data['seaview']);
        }
        
        if(isset($data['attributes']) && count($data['attributes']) > 0){
            $this->gate->setGlobalTypes($data['attributes']);
        }
        
        if(isset($data['travel_type']) && !empty($data['travel_type'])){
            $this->gate->setTravelTypes($data['travel_type']);
        }
        
        if(isset($data['flight']['departure'])){
            $values = $data['flight']['departure'];
            if(!($values[0] == '00:00' && $values[1] == '23:59')) {
                $this->gate->setDepMinTimeFlt(str_replace(':','',$values[0]));
                $this->gate->setDepMaxTimeFlt(str_replace(':','',$values[1]));
            }
        }
        
       if(isset($data['flight']['arrival'])){
            $values = $data['flight']['arrival'];
            if(!($values[0] == '00:00' && $values[1] == '23:59')) {
                $this->gate->setRetMinTimeFlt(str_replace(':','',$values[0]));
                $this->gate->setRetMaxTimeFlt(str_replace(':','',$values[1]));
            }
          
        }
        
        if(isset($data['operators']) && count($data['operators']) > 0){
            foreach($data['operators'] as $i =>  $operator){
                if(empty($operator)){
                    unset($data['operators'][$i]);
                }
            }
            $codes   = implode('/',$data['operators']);
            if(!empty($codes)){
                $this->gate->setOperators($codes);
            }
           
        }
        
        if(!empty(\Model\User\Customer::getCurrency())){
            $this->gate->setCurrency(\Model\User\Customer::getCurrency());
        }
        
        
    }
    
    public function fromSession($data) {
        
        if(is_array($_SESSION['landing']['destination'])) {
            $data['destination']  =  $_SESSION['landing']['destination'];
        }
        
        if(is_array($_SESSION['landing']['date'])) {
            $data['date']  =  $_SESSION['landing']['date'];
        }
        
        if(isset($_SESSION['landing']['type'])) {
            $data['sf']  =  $_SESSION['landing']['type'];
        }
        
        if(isset($_SESSION['landing']['attributes'])) {
            $data['attributes']  =  $_SESSION['landing']['attributes'];
        }
        
        if(isset($_SESSION['landing']['travel_type'])) {
            $data['travel_type']  =  $_SESSION['landing']['travel_type'];
        }
        
        if(isset($_SESSION['landing']['priceMax'])) {
            $data['priceMax']  =  $_SESSION['landing']['priceMax'];
        }
        
        if(isset($_SESSION['landing']['duration'])) {
            $data['duration']  =  $_SESSION['landing']['duration'];
        }
        
        unset($_SESSION['landing']);
        return $data;
    }
    
    public function setBookingParams($arr) {
      
        $this->bookingParams = $arr;
        
        
        if(isset($arr['FILTER'])){
            
            $filter = json_decode($arr['FILTER']);
            
           
            $data  = array(
                'adults'    => $filter->adults,
                'children'  => $filter->children,
                'type'      => $filter->sf
            );
            $data = json_decode(json_encode($filter),true);
            $data['type'] = $filter->sf;
            
            $this->setParams($data,true);
        }else if($arr['travel']) {
            $data  = array( 
                'adults'    => $arr['travel']['adult'], //filter->adults,
                'children'  => $arr['travel']['children'],
                'type'      => $arr['travel']['sf'],
                'gid'       => $arr['gid'],
            );
            $this->setParams($data,true);
        }
    }
    
    public function setOperators($operator) {
        
        //$codeArr = array_column($operator, 'code');
        $codes   = implode('/',$operator);
        $this->gate->setOperators($codes);
    }
    
    public function sort($data,$type = 'region') {
        
        $mapping = array(
            'region' => 'RSORT',
            'hotel'  => 'HSORT',
            'offer'  => 'TSORT'
        );
        
        if(isset($data['sort']) && in_array($data['sort'], $this->allowedSort)){
            $this->gate->setParams($mapping[$type],$data['sort']);
        }else{
            $this->gate->setParams($mapping[$type], $this->defaultSort[$type]);
        }

    }
    
    public function paginate($data,$type = 'region') {
        
        if(!isset($data['page']) || (int)$data['page'] == 0){
            return false;
        }
        
        $limit = (int)$data['limit'] > 0  ? (int)$data['limit'] : 30;
        $pos = $data['page'] == 1 ? 0 : (($data['page']- 1) * $limit);
        
        $mapping = array(
            'hotel'  => ['APS','POS'],
            'offer'  => ['TPS','TPOS']
        );
        
        $this->gate->setParams($mapping[$type][0],$limit);  
        $this->gate->setParams($mapping[$type][1],$pos);  

    }
    
    public function setGiata($arr) {
        return $this->gate->setGiata($arr);
    }
    
    public function setParam($key, $value) {
        return $this->gate->setParams($key, $value);
    }
}