<?php

namespace Application\Main;

use Core\Base\Application;

class Html  extends Application{

    public function __construct() {
        parent::__construct();
    }
    
    public function review($id=0) {
        
        $this->header();
        $this->template->fetch('review.tpl',[]);
        $this->footer();
        
    }
    
}