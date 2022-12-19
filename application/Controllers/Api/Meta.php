<?php

namespace Application\Api;

use Core\Base\Webservice;
use Model\Link\LinkList;
//use Model\Sys\User\Access;

class Meta extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function fetch() {
        
        $value = \Helper\Input::get('q','');
        $link    = new LinkList();
        $record  = $link->findByValue($value);
        $this->response->setData($record)->setStatus(true)->out();
    }
    
}
