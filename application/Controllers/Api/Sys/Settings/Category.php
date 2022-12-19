<?php

namespace Application\Api\Sys\Settings;

use Core\Base\Webservice;
use Model\Sys\Settings\Category as Model;

class Category extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $data   = Model::where('active',1)->get()->toArray();
            $this->response->setStatus(true)->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    public function update($id = 0) {
        echo __METHOD__;
    }
    
    public function show($id = 0) {
        echo __METHOD__;
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
}
