<?php

namespace Application\Main\Landing;

use Application\Main\Landing\Base;

class Pauschalreisen  extends Base{
        
    public function __construct() {
        parent::__construct();
        $this->view->prefix = 'pauschalreisen';
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
        $_SESSION['landing']['type'] = '2';

        parent::index($filter);
    }
    
}