<?php

namespace Application\Main;

use Core\Base\Application;
use Model\Content\Page;

class Profile  extends Application{

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        $pages = Page::all()->toArray();
        $this->header();
        $this->view->pages = $pages;
        $this->footer();
    }
}
