<?php

namespace Application\Api\Engine;

use Core\Base\Service;
use Model\Api\Client\HalalBooking as BookingService;

class HalalBooking extends Service {

    private $api;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->dbCache->setTimeout(60);
        $this->api   = new BookingService();
        
    }

    public function offers() {
        
        $params = \Helper\Input::json();
        var_dump($params);
        $this->api->setParamsBot($_GET);
        $response = $this->api->offers();
      
        $this->response->setData($response)->setStatus(true)->out();
    }
    
    public function getHotel() {
        $params = \Helper\Input::json();
        $this->api->setParams(json_decode(json_encode($params), true));
        $response = $this->api->hotel();
        $this->response->setData($response)->setStatus(true)->out();
    }
    
    public function getHotelFeatures($id) {
        $response = $this->api->getHotelFeatures($id);
        $this->response->setData($response)->setStatus(true)->out();
    }
    
    
    public function filters() {
        
        $filters = \Model\Api\HalalBookingFilter::all()->toArray();
        foreach($filters as $k =>  $f){
            if($f['code'] == 'locations'){
                $filters[$k]['options'] = $this->getLocations();
            }else{
                $filters[$k]['options'] = \Model\Api\HalalBookingOption::where('parent_code',$f['code'])->get()->toArray();
            }
        }
        
        $this->response->setData($filters)->setStatus(true)->out();

    }
    
    public function getLocations() {
        
        $language = \Model\User\Customer::getLanguage();
        
        $records = \Model\Region\Defaults\Country::where('halalbooking_code','>','0')->get()->toArray();
        foreach($records as &$r){
            $r['code'] = $r['halalbooking_code'];
            $r['name'] = isset($r['name_'.$language]) ? $r['name_'.$language] : $r['name_de'];
        }
        
        return $records;
    }
        
}
