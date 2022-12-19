<?php

namespace Core\Cache;

use Core\Cache\Cache;

class FileCache extends Cache  {

    private $subDirectory = 'file';

    public function __construct() {

        parent::__construct($this->subDirectory);
        
        $this->file =  str_replace('/','_',\Core\App::$route == '' ? 'homepage' : \Core\App::$route); 
        
        if(\Helper\Input::get('q',false) != false ){
            $this->active = false;
        }
    }

    public function createFile() {

        $baseParams = '__lang__'.\Model\User\Customer::getLanguage().'__currency__'.\Model\User\Customer::getCurrency();

        $cache_file = $this->dir.$this->file.$baseParams.'.txt';
        return $cache_file;
    }

    public function pull() {
       
        if($this->active == false){
            return false;
        }

        $cache_file = $this->createFile();

        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - $this->timeout ))) {
            $content =  file_get_contents($cache_file);

            if(!empty($content)){
                $this->cached = true;
                echo '<!-- CACHE -->'.PHP_EOL;
                echo $content;
                exit();
            }

        }

        return false;
    }

    public function put() {
        if($this->active == false){
            return false;
        }

        if($this->cached == false){

            $cache_file = $this->createFile();
            $content    = ob_get_contents();
            return file_put_contents($cache_file, $content, LOCK_EX);
        }

    }


}