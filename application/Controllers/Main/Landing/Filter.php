<?php

namespace Application\Main\Landing;

use Application\Main\Landing\Base;

class Filter  extends Base {

    public function __construct() {
        parent::__construct();
    }
    
    public function get($country = 0 , $filter) { 
        
        $this->view->prefix = $filter;      
        if($country == 0 ){
            if($filter == 'fernreisen'){
                return parent::ferne();
            }
            if($filter == 'topurlaub'){
                return parent::topurlaub();
            }
            if($filter == 'billigurlaub'){
                return parent::billigurlaub();
            }
            return parent::index();
        }
        
        $this->filterSession($filter);
        parent::country($country);
    }
    
    public function getState($state = 0 , $filter) { 
        $this->view->prefix = $filter;
        $this->filterSession($filter);
        parent::state($state);
    }
    
    public function getCity($city = 0 , $filter) { 
        $this->view->prefix = $filter;
        $this->filterSession($filter);
        parent::city($city);
    }
    

}
