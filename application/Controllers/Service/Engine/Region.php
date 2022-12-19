<?php

namespace Application\Service\Engine;

use Model\Providers\Connector;
use Core\Base\Service;

class Region extends Service {
            
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
