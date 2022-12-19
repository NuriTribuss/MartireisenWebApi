<?php

namespace Application\Api\Engine;

use Model\Providers\Connector;
use Core\Base\Webservice;

class Statics extends Webservice {
            
    private $connector;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function get() {
        
       // $this->connector->setFilter();
        $statics = $this->connector->statics();
        $this->response->setData($statics)->setStatus(true)->out();
    }
   
}
