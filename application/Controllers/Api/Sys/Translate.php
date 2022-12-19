<?php

namespace Application\Api\Sys;

use Core\Base\Webservice;
use Model\Localization\Language as Model;
use Model\Localization\LanguageManagement;

class Translate extends Webservice {

    protected $isPublic = false;
    
    public $languageId;

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
        $language = Model::find($this->languageId);
                
        $model    = new LanguageManagement();
        $model->language = $language->code;
        $model->type     = 'web';

        try {
            
            $baseArr   =  $model->getBaseFileContent();
            $customArr =  $model->getCustomFileContent();

            $data = [];
            $keys = array_keys($baseArr);
            
            foreach($keys as $key){
                
                $q = array_keys($baseArr[$key]);
                $h = [];
                
                foreach($q as $t){
                    $h[] = array('key' => $t , 'value' => $customArr[$key][$t] == null ? $baseArr[$key][$t] : $customArr[$key][$t]);
                }
                
                $data[] = array(
                    'key'   => $key,
                    'data'  => $h
                );
            }
            $this->response->setStatus(true)->setMeta([])->setData($data)->out();
        } catch (\Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    public function update($id = 0) {
      
        $data     = \Helper\Input::json();
        $language = Model::find($this->languageId);
        
        $model           = new LanguageManagement();
        $model->language = $language->code;
        $model->type     = 'web';
        
        if(!is_array($data) || count($data) == 0){
            $this->response->setMessage('Request Body Invalid')->http(400)->out();
        }
        
        foreach($data as $d){
            
            if(empty($d->key) || empty($d->data) || count($d->data) === 0){
                 $this->response->setMessage('Request Body Invalid')->http(400)->out();
            }
            
            foreach($d->data as $e){
                if(!isset($e->key)){
                   $this->response->setMessage('Request Body Invalid')->http(400)->out();
                }
            }
        }      
       
       // $model->type = $type;
        $model->saveCustomFileContent($data);

        $this->response->setStatus(true)->out();
    }
    
    public function show($id = 0) {
        echo __METHOD__;
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
 
}
