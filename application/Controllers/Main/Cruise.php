<?php

namespace Application\Main;

use Core\Base\Application;

class Cruise  extends Application{

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->header();
        $this->template->fetch('cruise.tpl',[]);
        $this->footer();
        
    }
    
}