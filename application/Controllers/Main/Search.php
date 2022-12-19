<?php

namespace Application\Main;

use Core\Base\Application;
use Carbon\Carbon;
use Model\Api\HotelOffer;

class Search  extends Application{

    private $step = 0;
    
    public function __construct() {

        parent::__construct();
        $this->view->searchEngine = 1;
    }
    
    public function defaultDate(){
        
        $defaultDate	 = (object)[
            'week' 	 => Carbon::now()->addWeek()->format('ymd'),
            'month'	 => Carbon::now()->addMonth()->format('ymd'),
        ];

        return $defaultDate;
    }
    
    public function hotelOffer() {
        
        $hotelOffer  = new HotelOffer(); 
        $response    = $hotelOffer->get();
        $flightCheck = $hotelOffer->flightCheck(); 
       
        $this->view->offer          = $response;
        $this->view->flightCheck    = $flightCheck;
        
        $this->view->render('search/offer');

    }
    
    public static function params($data,$step = 2,$landing = false) {
        
        $keys = ['children','adults','date','departure','destination','params','sf','vc','ref','gid','duration','flight','operators','seaview','transfer','attributes','travel_type','city','priceMax'];
        
        if(!isset($data['children'])){
            $data['children'] = [];
        }
        
        if(!isset($data['adults']) || empty($data['adults'])){
            $data['adults']  = 2;
        }
        
        if(!isset($data['date']) || empty($data['date']['start'])){
            $data['date']['start']  = \Carbon\Carbon::now()->addMonth(1)->format('Y-m-d');
        }
        
        if(!isset($data['date']) || empty($data['date']['end'])){
           
            $days = $landing ? 120 : 90; 
            if(is_numeric($data['duration']) && $data['duration'] > 0){
                $days = $data['duration'];
            }else if ($data['duration'] > 0 ){
                $explode = explode('-', $data['duration']);
                $days = $explode[1];
            }
          
            $data['date']['end']    = \Carbon\Carbon::parse($data['date']['start'])->addDay(90)->format('Y-m-d');
        }
        
        if(!isset($data['sf']) ){
            $data['sf'] = 2;
        }
        
        if(!isset($data['operators']) ){
            $data['operators'] = [];
        }
        
        if(!isset($data['vc']) ){
            $data['vc'] = $data['vc'];
        }
        
        if(!isset($data['destination'])){
            $data['destination'] = array(
                'type' => '',
                'name' => '',
                'code' => ''
            );
        }
        
        if(!isset($data['departure'])){
            $data['departure'] = array(
                'name' => '',
                'code' => ''
            );
        }
        
        if(!isset($data['duration']) ){
            $data['duration'] = 7;
        }
        
        if(!isset($data['attributes']) ){
            $data['attributes'] = [];
        }
        
        if(!isset($data['seaview']) ){
            $data['seaview'] = 0;
        }    
        
        if(!isset($data['transfer']) ){
            $data['transfer'] = 0;
        }    
        if(!isset($data['city']) ){
            $data['city'] = 0;
        }    
              
        foreach($data as $k => $d){
            if(!in_array($k, $keys)){
                unset($data[$k]);
            }
        }
        
        
        return $data;
    }
        
    public function region() {
        
        $this->step = 1;
        $this->view->step = 1;
        $this->view->header_title  = _lang('header.region', true);
        $this->view->header_button = _lang('header.search', true);
        $this->header();
        $params = $this->params($_GET, $this->step);
        echo '<script>window.addEventListener("load", function (event) { window.Marti.page = "region-results"; window.Marti.filter = JSON.parse(\''.json_encode($params).'\'); });</script>';
        $this->view->render('search/region');
        $this->footer();
                    
        return;
       
    }
    
    public function hotels($param = null) {
       
        // eski linkler
        if(strlen($param) == 2 || strlen($param) == 3 ){
            return $this->redirect($param);
        }
        
        $this->step = 2;
        $this->view->step = 2;

        $this->view->header_title  = _lang('header.hotels', true);
        $this->view->header_button = _lang('header.region', true);
        $this->header();        
        $params = self::params($_GET, $this->step);
       
        echo '<script>window.addEventListener("load", function (event) { window.Marti.page = "hotel-results"; window.Marti.filter = JSON.parse(\''.json_encode($params).'\'); });</script>';
        
        $_SESSION['step'][1] = \Helper\Input::getFullUrl();
        $this->view->render('search/hotel');
        $this->footer();
        
    }

    public function hotelOffers() {
     
        $this->step = 3;
        $this->view->step = 3;

        $this->view->header_title  = _lang('header.hotel_offers', true);
        $this->view->header_button = _lang('header.hotels', true);
        $this->view->page = 'hotel';

        $this->header();
        $params =  self::params($_GET, $this->step);
        $params['params'] = 'search/hotel-offers';

        \Core\Session\Session::set('booking', $params);
        $_SESSION['step'][2] = \Helper\Input::getFullUrl();

        echo '<script>window.addEventListener("load", function (event) { window.Marti.page = "hotel-detail"; window.Marti.filter = JSON.parse(\''.json_encode($params).'\'); });</script>';
        $this->view->render('search/hotel-detail');
        $this->footer();
        
    }
    
    public function hotelBooking() {
        
        \Core\Session\Session::set('basket_url', \Helper\Input::getFullUrl()); 
        
        $this->step = 4;
        $this->view->step = 4;

        $this->view->header_title  = _lang('header.booking', true);
        $this->view->header_button = _lang('header.hotel_offers', true);
        $this->view->page = 'checkout';

        $this->header();
        $params =  self::params($_GET, $this->step);
        $_SESSION['step'][3] = \Helper\Input::getFullUrl();

        \Core\Session\Session::set('bookingRef', $_GET['ref']);
        echo '<script>window.addEventListener("load", function (event) {  window.Marti.page = "booking"; window.Marti.filter = JSON.parse(\''.json_encode($params).'\');  window.Marti.booking = JSON.parse(\''.json_encode(\Core\Session\Session::get('booking')).'\');});</script>';
        $this->view->render('search/hotel-booking');
        $this->footer();
        
    }
    
    public function redirect($param) {
        
        $redirect = null;
        
        if(strlen($param) == 2){
            
            $record = \Model\Region\Country::where('code',mb_strtoupper($param))->first();
            if($record !=null){
               $link =  \Model\Link::where(['table_id' => $record->id , 'type' => 'landing_country'])->where('value','like', 'urlaub/%')->first();
               $redirect = $link->value;
            }
            // country
        }else{
            // state
            $record = \Model\Region\State::where('code',mb_strtoupper($param))->first();
            if($record !=null){
               $link =  \Model\Link::where(['table_id' => $record->id , 'type' => 'landing_state'])->where('value','like', 'urlaub/%')->first();
               $redirect = $link->value;
            }
        }
        
        if($redirect != null) {
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: /".$redirect);
        }
    }
}


