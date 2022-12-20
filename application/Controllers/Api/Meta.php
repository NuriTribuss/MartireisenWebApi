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
        if($record['type'] == 'affilate') {
		parse_str(str_replace('/search/hotel-offers?','',$record['redirect_value']), $arr);
		$record['params'] = json_encode($arr);
		$record['hotel'] = $arr['destination'];
	}
        $this->response->setData($record)->setStatus(true)->out();
    }
    
}
