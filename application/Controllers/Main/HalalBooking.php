<?php

namespace Application\Main;

use Core\Base\Application;

class HalalBooking  extends Application{
    
    public function __construct() {
        
        parent::__construct();
        $this->view->page = 'halalbooking';

    }
        
    public function halalParams($data) {
        
        $keys = ['children','adults','date','destination','params','ref','gid','room_id','rate_plan_id','holiday_type'];
        
        $merge = [
            'property_types'=> [],
            // öğün planı
            'meal_plans'=> [],
            // yıldız
            'stars'=> [],
            // puan
            'scores'=> [],
            // halal meals
            'feature_group_1'=> [],
            // drunk
            'feature_group_2'=> [],
            'feature_group_3'=> [],
            'locations' => [],
        ];
        
        if(!isset($data['children'])){
            $data['children'] = [];
        }
        
        if(!isset($data['adults']) || empty($data['adults'])){
            $data['adults']  = 2;
        }
        
        if(!isset($data['date']) || empty($data['date']['start'])){
            $data['date']['start']  = \Carbon\Carbon::now()->addWeek()->format('Y-m-d');
        }
        
        if(!isset($data['date']) || empty($data['date']['end'])){
            $data['date']['end']    = \Carbon\Carbon::now()->addWeek(2)->format('Y-m-d');
        }
                
        if(!isset($data['destination'])){
            $data['destination'] = array(
                'type' => '',
                'name' => '',
                'code' => ''
            );
        }
        
        $data['destination']['name'] = str_replace("'"," ",($data['destination']['name']));
        
        if(!isset($data['duration']) ){
            $data['duration'] = 7;
        }
        
        if(!isset($data['seaview']) ){
            $data['seaview'] = 0;
        }    
        
        if(!isset($data['transfer']) ){
            $data['transfer'] = 0;
        }    
        
        foreach($data as $k => $d){
            if(!in_array($k, $keys)){
                unset($data[$k]);
            }
        }
                
        return array_merge($data,$merge);
    }
        
    
    public function defaultDate(){
        
        $defaultDate	 = (object)[
            'week' 	 => Carbon::now()->addWeek()->format('ymd'),
            'month'	 => Carbon::now()->addMonth()->format('ymd'),
        ];

        return $defaultDate;
    }
    
    public function hotels($type = '',$param = '') {
        
        $this->view->page = 'halalbooking';
        $this->step = 2;
        $this->view->step = 2;
        $_SESSION['stephalalbooking'][1] = \Helper\Input::getFullUrl();

        if(!empty($type) && $type == 'country'){
            
            $country = \Model\Region\Defaults\Country::where('id',$param)->first();
            
            $_GET['destination'] = [
                'type' => 'region',
                'code' => $country->halalbooking_code > 0 ? $country->halalbooking_code : $param,
                'name' => $country->name_de
            ];
            $this->view->region_name = isset($country->{'name_'.$this->language}) ? $country->{'name_'.$this->language} : $country->name_de;
        }
        
        if(!empty($type) && $type == 'filter'){
            $_GET['holiday_type'] = $param;
        }
        
        $params = $this->halalParams($_GET);
        $params['params'] = 'halal-booking/hotels';
        
        $this->header();
        $this->view->render('halalbooking/offer');
        //$this->render('halalbooking/offer_results');
        echo '<script>window.addEventListener("load", function (event) { window.Marti.filter = JSON.parse(\''.json_encode($params).'\'); });</script>';
        $this->footer();
      
    }
    
    public function hotelOffers() {
        
        $this->view->page = 'halalbooking';
        $this->step = 3;
        $this->view->step = 3;
        $_SESSION['stephalalbooking'][2] = \Helper\Input::getFullUrl();

        $params = $this->halalParams($_GET);
        $params['destination']['name'] = str_replace("'"," ",($params['destination']['name']));
        $this->header();
        $this->view->render('halalbooking/hotel-detail');
        echo '<script>window.addEventListener("load", function (event) { window.Marti.filter = JSON.parse(\''.json_encode($params).'\'); });</script>';
        //$this->render('halalbooking/offer_results');
        $this->footer();
    }
    
    public function hotelBooking() {
        
        $this->step = 4;
        $this->view->step = 4;
        $_SESSION['stephalalbooking'][3] = \Helper\Input::getFullUrl();

        $this->header();
        $params = $this->halalParams($_GET);
        
        $ref =  base64_encode($_GET['room_id'].'|'.$_GET['rate_plan_id'].'|'.$_GET['gid']);
        \Core\Session\Session::set('bookingRef_halal',$ref);
        echo '<script>window.addEventListener("load", function (event) { window.Marti.filter = JSON.parse(\''.json_encode($params).'\');  window.Marti.booking = JSON.parse(\''.json_encode(\Core\Session\Session::get('booking')).'\'); });</script>';
        $this->view->render('halalbooking/hotel-booking');
        $this->footer();
        
    }
}