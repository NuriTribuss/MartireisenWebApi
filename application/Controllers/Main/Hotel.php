<?php

namespace Application\Main;

use Core\Base\Application;
use Model\Region\Hotel as Model;
use Model\Landing\Otel;

class Hotel  extends Application{
    
    private $dbCache;

    public function __construct() {
        
        parent::__construct();
        
        $this->view->link = \Core\App::$linkData;
        $this->dbCache    = new \Core\Cache\DbCache('db/landing');
        $this->dbCache->setTimeout(300);
    }
    
    public function index($param) {
        
        // eski linkler
        if(is_numeric($param)){
            return $this->redirectHotel($param);
        }
        
    }
    
        
    public function redirectHotel($param) {
         
        $redirect = null;
        
        if(is_numeric($param)) {
            $link     =  \Model\Link::where(['table_id' => $param , 'type' => 'landing_hotel'])->first();
            $redirect =  $link->value;
        }
        
        if($redirect != null) {
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: /".$redirect);
        }else{
            
            $hotel = Model::where('giataCode',$param)->first();
            if($hotel != NULL){
                
                header("HTTP/1.1 301 Moved Permanently"); 
                header("Location: /hotel/".\Helper\Url::beautify($hotel->value)."_hid_".$param);
                exit();
                
            }
            
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: /hotel/show/".$param);
        }
    }
    
    public function show($giata) {
        
        $data = Otel::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->where(['code' =>$giata])->first();

        if($data!= null){
            $this->view->landing = $data;
        }
        
        $this->view->hotel = $this->getData($giata);
        $this->step = 3;
        
        $meta =  $this->view->meta;
                
        $meta['title']       = str_replace(['{{hotel_name}}','{{city_name}}','{{country_name}}'],[$data['translate']['title'],'',''],$meta['title']);
        $meta['description'] = str_replace(['{{hotel_name}}','{{city_name}}','{{country_name}}'],[$data['translate']['title'],'',''],$meta['description']);
        
        $this->view->meta = $meta;
        $this->header();
        $params = Search::params($_GET, $this->step,true);
        unset($params['params']);
        unset($params['city']);
      
        $params['destination'] = ['code' => $giata ,'name' => $hotel['info']['name'], 'type' => 'hotel'];
        
        echo '<script>window.addEventListener("load", function (event) { window.Marti.page = "hotel-detail"; window.Marti.filter = JSON.parse(\''. str_replace("'","\'",json_encode($params)).'\'); });</script>';
       
        $this->view->landingFooter = $this->getFooterLinks();
        $this->view->page = 'landing_hotel';
        $this->view->render('landing/hotel');
        $this->footer();
        
    }
    
    public function getData($gid) {
        
        $key = 'landing_otel_'.$gid;
        $this->dbCache->setKey($key);
        $this->dbCache->setSubDirectory('landing');
        $data = $this->dbCache->pull(); 
       
        if($data === false) {
            
            $connector = new \Model\Providers\Connector();

            $req = new \stdClass();
            $req->adults   = 2;
            $req->destination->type = 'hotel';
            $req->destination->code = $gid;

            $connector->setFilter($req);
            $data     = $connector->hotels();

            $hotelConnector = new \Model\Providers\Connector();

            $req = new \stdClass();
            $req->operators = ['ANEX'];
            $hotelConnector->setFilter($req);
            $hotelData  = $hotelConnector->hotelDetail($gid);

            $hotelView = new \Model\HotelView();
            $data = $hotelView->get($data['response']->hotelList[0],$hotelData);
            $this->dbCache->put($data);
        }
        return $data;
    }
    
     public function getFooterLinks() {
        
        $links = \Model\Landing\Footer::with(['translate' => function($q) {
           $q->where('language', $this->language);
        }])->get();
        
        $links = $links->toArray();
        foreach($links as $key=> $l){
            $links[$key]['translate']['url'] = $links[$key]['translate']['url'].'/';
        }
        
       // $links = \Model\Landing\FooterLink::where('language', \Model\User\Customer::getLanguage())->get()->toArray();
        return $links;
    }
}