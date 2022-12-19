<?php

namespace Application\Api\Engine;

use Model\Providers\Connector;
use Core\Base\Service;

class Offer extends Service {
            
    private $connector;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function get() {
        
        $this->connector->setFilter();
        $offers = $this->connector->offers();
        
        $this->response->setData($offers)->setStatus(true)->out();
    }
    
    public function checkOffer($type = '') {
        
        $data = \Helper\Input::json();
        $this->connector->setFilter();
  
        $offers = $this->connector->checkOffer($data->code,(string)$type);
        if(!empty($offers)){
            $offers['response']->totalPrice->label = number_format( $offers['response']->totalPrice->value,'2',',','');
        }
        
        $this->response->setData($offers)->setStatus(!$offers['error'])->setMessage($offers['message'])->out();
    }
    
}
