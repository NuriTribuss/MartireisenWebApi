<?php

namespace Application\Main;

use Core\Base\Application;

class Newsletter  extends Application{

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->header();
        $this->template->fetch('newsletter.tpl',[]);
        $this->footer();
    }
}