<?php

namespace Core\Cache;

use Core\Cache\Cache;

class DbCache extends Cache  {
    
    private $subDirectory = 'db';
    private $key;
    
    public function __construct($subDirectory = '') {
        
        if(!empty($subDirectory)){
            $this->setSubDirectory($subDirectory);
        }
        parent::__construct($this->subDirectory);
    }
    
    public function setSubDirectory($subDirectory) {
        $this->subDirectory = $subDirectory;
    }
    
    public function setKey($key) {
        $this->key = $key;
    }
    
    public function getFile() {
        
        $baseParams = '__lang__'.\Core\Translation\Language::getLanguage().'__';
        $baseParams .= '__curr__'.\Model\User\Customer::getCurrency().'__';

        $cache_file = $this->dir.$this->key.$baseParams.'.txt';
        return $cache_file;
    }

    public function pull() {

        if($this->active == false){
            return false;
        }

        $cache_file = $this->getFile();

        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - $this->timeout ))) {
            $content =  file_get_contents($cache_file);

            if(!empty($content)){
                $this->cached = true;
                return json_decode($content,true);
            }
        }

        return false;
    }

    public function put($content) {
        
        if($this->active == false){
            return false;
        }

        if($this->cached == false){

            $cache_file = $this->getFile();
            return file_put_contents($cache_file, json_encode($content), LOCK_EX);
        }

    }

}