<?php

namespace Model\Providers\Traffics;
use Model\Providers\Filter;

class Client {

    private $url = 'https://connector-staging.traffics-switch.de/v3/rest/';
    private $bookingUrl = 'https://connector-staging.traffics-switch.de/v3/rest/';
    private $headers;
    public $payload = null;
    private $bookingData = null;
    private $isTest = false;
    public $top = false;
    public $durationChanged = false;
    public $converter;
    
    public function __construct() {
         
        $this->headers[]     = "Authorization: ".$this->getApiKey();
        
        $this->converter     = new \Model\Providers\Traffics\Converter();
        $this->isTest        = \Helper\Config::get('TRAFFICS_TEST_MODE') == 1;
        $this->url           = $this->isTest ? $this->url : 'https://connector.traffics.de/v3/rest/';
        $this->bookingUrl    = $this->isTest ? $this->bookingUrl : 'https://connector.traffics.de/v3/rest/';
    }
    
    public function region() {
        
        $this->url.='regions';
        return $this->doGet( $this->url, $this->payload, $this->headers);
    }
    
    public function hotel($id = 0) {
        
        $this->url.='hotels'.($id > 0 ? '/'.$id : '');
        $this->url.= ($this->top ? '/top' : '');
        return $this->doGet( $this->url, $this->payload, $this->headers);
    }
    
    public function reviews($id = 0) {
        
        $this->url.='hotels/'.$id.'/reviews?source=holidaycheck';
        return $this->doGet( $this->url, $this->payload, $this->headers);
    }
    
    public function offer($code = '',$type = '') {
        
        $this->url.='offers'.(!empty($code) ? '/'.$code : '');
        if(!empty($code)) {
            $tmp = $this->payload;
            $send = [];
            if(!empty($type)){
                $send['type'] = $type;
            }
            $send['adults'] = $tmp['adults'];
            if(!empty($tmp['children'])){
                $send['children'] = $tmp['children'];
            }
            $this->payload = $send;
        }
      
        return $this->doGet( $this->url, $this->payload, $this->headers);
    }
    
    public function booking() {
        
        $this->bookingUrl.='bookings';
        $this->headers[] = "Content-Type: application/json";
        
        return $this->doPost( $this->bookingUrl, $this->bookingData, $this->headers);
    }
    
    public function bookingDetail($id) {
        
        $this->bookingUrl.='bookings/'.$id;
        $this->headers[] = "Content-Type: application/json";
        
        return $this->doGet( $this->bookingUrl, [], $this->headers);
    }
    
    public function updateBooking($id,$data) {
        
        $this->bookingUrl.='bookings/'.$id;
        $this->headers[] = "Content-Type: application/json";
        
        return $this->doPatch( $this->bookingUrl, $data, $this->headers);
    }
    
    public function completions($query,$type,$loc) {
        
        $this->payload = [
            'subTypeGiataHotel' => "true",
           // 'subTypeLocation' => "true",
           // 'subTypeRegion' => "true",
          //  'subTypeCountry' => "true",
            'searchValue' => $query,
            'productType' => $type,
        ];
        
        if($loc == 1){
            $this->payload['subTypeLocation'] = "true";
            $this->payload['subTypeRegion']   = "true";
            $this->payload['subTypeCountry']  = "true";
            $this->payload['subTypeGiataHotel']  = "false";
        }
        
        $this->url.='completions';
        
        return $this->doGet($this->url, $this->payload, $this->headers);
    }
    
    public function tourOperators() {
        
        $url = $this->url.'tourOperators';
        return $this->doGet( $url, $this->payload, $this->headers);
    }
    
    public function documents($name) {
        
        $url = $this->url.'documents/'.$name;
        return $this->doGet( $url, $this->payload, $this->headers);
    }
    
     
    public function statics() {
        
        $this->url.='static';
        return $this->doGet( $this->url, $this->payload, $this->headers);
    }
    
    public function createDocument() {
        
        $url = $this->url.'documents/conditions';
        $this->headers[] = "Content-Type: application/json";
        return $this->doPost( $url, $this->payload, $this->headers);
    }
    
    public function filter(Filter $filter) {
       
        
        $date = $filter->getDate();
        $substractDay = ($date['to'] - $date['from']) / (3600*24);
        
        if($date['duration'] > $substractDay) {
            $date['duration'] = $substractDay;
            $this->durationChanged = true;
        }
        
        $this->payload =   [
            'productType'       => $filter->getType() ?? 'pauschal',
            'adults'            => $filter->getAdults() ?? 2,
            'searchDate'        => date('dmy',$date['from']).','.date('dmy',$date['to']).','.$date['duration'],
            'rating' => [
                'source' => 'holidaycheck'
            ],
           // 'optionHeliView' => true,
           // 'optionHotelFilter' => -2,
            'sortBy'    => 'quality',
           // 'mediaOperatorList' => 'TUI,FTI,5VF,ALL,ANEX,OGE'
           
        ];
        
        if(!empty($filter->getSortBy())) {
             $this->payload['sortBy'] = $filter->getSortBy();
        }
        
        if(!empty($filter->getSortDir())) {
             $this->payload['sortDir'] = $filter->getSortDir();
        }
        
        if(!empty($filter->getDepartureAirportList())) {
             $this->payload['departureAirportList'] = $filter->getDepartureAirportList();
        }
        
        if(!empty($filter->getChildren())) {
             $this->payload['children'] = $filter->getChildren();
        }
        
        if(!empty($filter->getLocationList())) {
             $this->payload['locationList'] = $filter->getLocationList();
        }
        
        if(!empty($filter->getRegionList())) {
             $this->payload['regionList'] = $filter->getRegionList();
        }
        
        if(!empty($filter->getCountryList())) {
             $this->payload['countryList'] = $filter->getCountryList();
        }
        
        if(!empty($filter->getGiataIdList())) {
             $this->payload['giataIdList'] = $filter->getGiataIdList();
        }
        
        if(!empty($filter->getMinCategory())) {
             $this->payload['minCategory'] = $filter->getMinCategory();
        }
        
        if(!empty($filter->getMinRecommendation())) {
             $this->payload['rating']['recommendation'] = $filter->getMinRecommendation();
        }
        
        if(!empty($filter->getRoomTypeList())) {
             $this->payload['roomTypeList'] = $filter->getRoomTypeList();
        }
        
        if(!empty($filter->getMinBoardType())) {
             $this->payload['minBoardType'] = $filter->getMinBoardType();
        }
        
        if(!empty($filter->getTourOperatorList())) {
             $this->payload['tourOperatorList'] = $filter->getTourOperatorList();
        }
        
        if(!empty($filter->getKeywordList())) {
             $this->payload['keywordList'] = $filter->getKeywordList();
        }
        
        if(!empty($filter->getNavigation())) {
             $this->payload['navigation'] = $filter->getNavigation();
        }
        
        if(!empty($filter->getFilterNoPictures())) {
             $this->payload['filterNoPictures'] = $filter->getFilterNoPictures();
        }
        
        if(!empty($filter->getLocatedList())) {
             $this->payload['locatedList'] = $filter->getLocatedList();
        }
        
        if(!empty($filter->getTransferList())) {
             $this->payload['inclusiveList'] = $filter->getTransferList();
        }
        
        if(!empty($filter->getProductSubType())) {
             $this->payload['productSubType'] = $filter->getProductSubType();
        }
        
         if(!empty($filter->getMaxPricePerPerson())) {
             $this->payload['maxPricePerPerson'] = $filter->getMaxPricePerPerson();
        }
        
        if(!empty($filter->getFlightDirectness())) {
            $this->payload['flight']['directness']       = $filter->getFlightDirectness();
            $this->payload['returnFlight']['directness'] = $filter->getFlightDirectness();
        }
        
      /*  $this->payload  = [
            'subTypeGiataHotel' => "true",
            'searchValue'       => 'hilton',
            'limit'             => 40,
        ];*/
    }
    
    
    public function setBookingData($apiData) {
        
        $booking = array(
            'type' => $this->isTest ? 'test' : 'registration',
            'offerCode' => $apiData['ref'],
            'reference' => 'Martireisen OTA',
            'travellerList' => [],
            'customer' => [
                "street"        => $apiData['personal']['address'],
                "zipCode"       => $apiData['personal']['state'],
                "city"          => $apiData['personal']['city'],
                "countryCode"   => strtolower($apiData['personal']['country']),
                "email"         => $apiData['personal']['email'],
                "phone"         => $apiData['personal']['phone'],
                "mobilePhone"   => $apiData['personal']['phone'],
                "firstname"     => $apiData['personal']['name'],
                "lastname"      => $apiData['personal']['surname'],
                "requirement"   => ""
            ],
        );
        
        foreach($apiData['traveller'] as $traveller) {
            array_push($booking['travellerList'],[
                "type"          => "H",
                "firstname"     => $traveller['name'],
                "lastname"      => $traveller['surname'],
                "nationality"   => "de",
                "identity"  => [
                  "document"        => "PASS",
                  "dateOfIssue"     => "2020-01-01",
                  "dateOfValidity"  => "2025-12-31",
                  "countryOfIssue"  => "de"
                ]
            ]);
        }
        
        foreach($apiData['children'] as $traveller) {
            array_push($booking['travellerList'],[
                "type"          => "K",
                "firstname"     => $traveller['name'],
                "lastname"      => $traveller['surname'],
                "nationality"   => "de",
                "identity"  => [
                  "document"        => "PASS",
                  "dateOfIssue"     => "2020-01-01",
                  "dateOfValidity"  => "2025-12-31",
                  "countryOfIssue"  => "de"
                ]
            ]);
        }
        
        $this->bookingData = $booking;
    }
    
    public function getPayload() {
        return array_merge(['url' => $this->url],  $this->payload);
    }
    
    public function getBookingData() {
        return array_merge(['url' => $this->bookingUrl],  $this->bookingData);
    }
    
    public function getApiKey() {
        return base64_encode(\Helper\Config::get('TRAFFICS_USERNAME').':'.\Helper\Config::get('TRAFFICS_PASSWORD'));
    }
    
    public function doGet($url,$payload,$headers) {
        
        if(is_array($payload) && count($payload) > 0 ){
            $payload = http_build_query($payload);
            $url = $url.'?'.$payload;
        }

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");

        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
      
        $response =  json_decode($response);
        
        if($info['http_code'] != 200){
            return ['error' => $error , 'url' => $url , 'api_error' => $response->error];
        }
        
        return $response;
    }
    
    public function doPost($url,$payload,$headers) {
        
        if(is_array($payload) && count($payload) > 0 ){
            $payload = json_encode($payload);
        }

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        $response =  json_decode($response);
        
        if($info['http_code'] != 200 && $info['http_code'] != 201){
            return ['error' => $error , 'url' => $url , 'api_error' => $response->error];
        }
        
        return $response;
    }
    
     public function doPatch($url,$payload,$headers) {
        
        if(is_array($payload) && count($payload) > 0 ){
            $payload = json_encode($payload);
        }

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        if (count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
       
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        $response =  json_decode($response);
        
        if($info['http_code'] != 200 && $info['http_code'] != 201){
            return ['error' => $error , 'url' => $url , 'api_error' => $response->error];
        }
        
        return $response;
    }
    
    public function setPayload($payload) {
        $this->payload = $payload;
    }
    
    public function getUrl() {
        return $this->url;
    }
       
}
