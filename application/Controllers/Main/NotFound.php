<?php

namespace Application\Main;

use Core\Base\Application;

class NotFound  extends Application{

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        header("HTTP/1.0 404 Not Found");

        $this->header();
        $this->template->fetch('404.tpl',[]);
        $this->footer();

    }

}
