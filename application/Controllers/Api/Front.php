<?php

namespace Application\Api;

use Core\Base\Webservice;
//use Model\Sys\User\Access;

class Front extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function menu() {
        
        $categoryModel = new \Core\Structure\Category('menu__list_category');
        $categoryModel->menuId = 1;
        $categoryModel->setLanguage($this->language);
        $tree = $categoryModel->getTree(0,1);        
        $this->response->setData($tree)->setStatus(true)->out();
    }
    
}
