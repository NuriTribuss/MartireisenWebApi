<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Booking\Operator;

class Operators extends Service{

    public function __construct() {
        
        $opts = ['cache' => true,'max-age' => 3600];
        parent::__construct($opts);
    }

    public function get() {
        
        $this->dbCache->setKey('operators');
        $data = $this->dbCache->pull();
        $data = false;
        if($data == false){
            $data   = Operator::where('is_active',1)->orderBy('name','ASC')->get()->toArray();
            $this->dbCache->put($data);
        }        
        $this->response->setData($data)->setStatus(true)->out();        
    }   
    
    
    public function condition($code = '') {
        
        $data = Operator::where('code',$code)->first();
        $traffics = new \Model\Providers\Traffics\Client();
        if($data != null && !empty($data->filename)){
           $url  = $traffics->getUrl().'documents/'.$data->filename;
           \Core\Http\Redirect::go($url);    
        }else{
            die('Unavailable operator page');
        }
    }
}
