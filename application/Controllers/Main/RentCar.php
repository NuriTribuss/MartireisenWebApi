<?php

namespace Application\Main;

use Core\Base\Application;

class RentCar  extends Application{

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->header();
        $this->template->fetch('car.tpl',[]);
        $this->footer();
        
    }
    
}