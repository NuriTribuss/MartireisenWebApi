<?php

namespace Application\Main\Landing;

use Application\Main\Landing\Base;

class Lastminute  extends Base{

    public function __construct() {
        parent::__construct();
        $this->view->prefix = 'lastminute';
        $this->lastMinute = true;
    }
    
    public function country($id) { 
        parent::country($id);
    }
    
    public function state($id) { 
        parent::state($id);
    }
    
    public function city($id) { 
        parent::city($id);
    }
    
    public function index($filter = '') { 
        
        $this->filterSession($filter);

        parent::index($filter);
    }
    
    public function ferne($filter = '') { 
        
        $this->filterSession($filter);
        $this->view->ferne = 1;
        parent::ferne($filter);
    }
    
    public function filterSession($filter) {
        parent::filterSession($filter);
        if($filter != 'eigene-anreise'){
            $_SESSION['landing']['type'] = '2';
        }

    }
    
}