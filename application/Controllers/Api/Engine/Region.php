<?php

namespace Application\Api\Engine;

use Model\Providers\Connector;
use Core\Base\Webservice;

class Region extends Webservice {
            
    private $connector;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function get() {
        
        $this->connector->setFilter();
        $regions = $this->connector->regions();
        
        $this->response->setData($regions)->setStatus(true)->out();
    }
   
}
