<?php

namespace Core\Base;

class Controller {
    
    public $view;
    public $response;
    
    function __construct() {
        
        $this->view     = new \Core\View\PHP();
        $this->response = new \Core\Http\Response(); 
        
    }
    
}

