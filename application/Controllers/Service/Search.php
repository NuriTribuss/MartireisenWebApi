<?php

die('unavailable');

namespace Application\Service;

use Core\Base\Service;
use Model\Booking\Operator;
use Model\HotelOffer;
use Model\BookingView;
use Model\HotelList;

class Search extends Service{

    private $api;
    
    public function __construct() {
               
        parent::__construct();
        
        $this->dbCache->setTimeout(60);
        
        $this->api = new \Model\Api\Client\Api();
        $operators = array_column($this->getOperators(), 'code');
        $this->api->setOperators($operators);
        $this->api->setLanguage();
        
    }

    public function region() {
        
        $translateModel = new \Model\Localization\Translate();
        
        $this->api->setParams($_GET);
        $this->api->sort($_GET);
        
        $response = $this->api->regions();
        
        if($response['response']['PAGE'] == 'error'){
            $this->response->setData($response)->out();
        }  
        
        if(isset($response['response']['TOP']['REGION']['REF'])){
            $response['response']['TOP']['REGION'] = [$response['response']['TOP']['REGION']];
        }
        
        if(!isset($response['response']['REGION'])){
            $response['response']['REGION'] = [];
        }
        
        foreach($response['response']['REGION'] AS &$region){
            $region['NAME'] = $translateModel->get($region['REGIONCODE'], 'CountryTitle', \Model\User\Customer::getLanguage(), $region['NAME']);
        }
         foreach($response['response']['TOP']['REGION'] AS &$region){
            $region['NAME'] = $translateModel->get($region['REGIONCODE'], 'CountryTitle', \Model\User\Customer::getLanguage(), $region['NAME']);
        }
        
        $this->response->setData($response)->setStatus(true)->out();

    }
    
    public function hotel() {
        
        $this->api->setParams($_GET);
        $this->api->sort($_GET,'hotel');
        $this->api->paginate($_GET,'hotel');
        
        $response = $this->api->hotels();
        if($response['response']['PAGE'] == 'error'){
            $this->response->setData($response)->out();
        }    
        $response['response']['ANGEBOT'] = isset($response['response']['ANGEBOT']['HOTEL']) ?  [ $response['response']['ANGEBOT'] ] :  $response['response']['ANGEBOT']  ;
        
        $hotelList = new HotelList();
        $response['response'] = $hotelList->get($response['response']);
        
        $this->response->setData($response)->setStatus(true)->out();

    }
    
    public function hotelOffers() {
        
        $this->api->setParams($_GET);
        $this->api->sort($_GET,'offer');
        $this->api->paginate($_GET,'offer');
        
        $response = $this->api->hotelOffers();
        
        if($response['response']['PAGE'] == 'error'){
            $this->response->setData($response)->out(); 
        }    
        
        if($response['response']['TERMINE'] == 0){
            $response['response']['TERMINE'] = [];
        }
        
        $hotelOffers = new HotelOffer();
        $response['response'] = $hotelOffers->get($response['response']);
        
        $this->response->setData($response)->setStatus(true)->out();

    }
    
    public function booking() {
        
        $this->api->setBookingParams($_POST);
        $this->api->isBookingPage = true;
        $response = $this->api->booking();
        if($response['response']['PAGE'] == 'error'){
            $this->response->setData($response)->out(); 
        }    
        
        if($response['response']['TERMINE'] == 0){
            $response['response']['TERMINE'] = [];
        }
        
        $this->response->setData($response)->setStatus(true)->out();

    }
    
    public function bookingPage() {
        
        
        $this->api->setBookingParams($_POST);
        $this->api->isBookingPage = true;
        $response = $this->api->booking();
        if($response['response']['PAGE'] == 'error'){
            $this->response->setData($response)->out(); 
        }    
        
        if($response['response']['TERMINE'] == 0){
            $response['response']['TERMINE'] = [];
        }
        
        if(isset($response['response']['SERVICE']['FLIGHTLIST'])){
            $flight = $response['response']['SERVICE']['FLIGHTLIST'];
            if(isset($flight['INBOUND']['SEGMENT']['DEPARTURE'])){
                $flight['INBOUND']['SEGMENT'] = array($flight['INBOUND']['SEGMENT']);
            }
            if(isset($flight['OUTBOUND']['SEGMENT']['DEPARTURE'])){
                $flight['OUTBOUND']['SEGMENT'] = array($flight['OUTBOUND']['SEGMENT']);
            }
            $response['response']['SERVICE']['FLIGHTLIST'] = $flight;
        }
        
        $response['response']['INSURANCE'] = false ; //$this->api->getInsuranceInfo($response['response']);
        
        $bookingView = new BookingView();
        $response['response'] = $bookingView->get($response['response']);

       // $response['response']['FLIGHT'] = $this->api->getFlightInfo();
        
        $this->response->setData($response)->setStatus(true)->out();

    }
    
    public function getOperators() {
        
        $this->dbCache->setKey('operators');
        $data = $this->dbCache->pull();
        
        if($data == false){
            $data   = Operator::where('is_active',1)->get()->toArray();
            $this->dbCache->put($data);
        }        
        
        return $data;
        
    }
        
}
