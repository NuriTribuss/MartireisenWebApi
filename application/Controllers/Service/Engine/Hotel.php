<?php

namespace Application\Service\Engine;

use Model\Providers\Connector;
use Core\Base\Service;

class Hotel extends Service {
            
    private $connector;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function get() {
        
        $this->connector->setFilter();
        $regions = $this->connector->hotels();
        
        $this->response->setData($regions)->setStatus(true)->out();
    }
    
    public function top() {
        
        $this->connector->setFilter();
        $regions = $this->connector->hotels(true);
        
        $this->response->setData($regions)->setStatus(true)->out();
    }
    
    public function detail($id) {
        
        $this->connector->setFilter();
        $hotel = $this->connector->hotelDetail($id);
        
        $this->response->setData($hotel)->setStatus(true)->out();
    }
    
    public function reviews($id) {
        
        $reviews = $this->connector->reviews($id);
        $this->response->setData($reviews)->setStatus(true)->out();
    }
    
}
