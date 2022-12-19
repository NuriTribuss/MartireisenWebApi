<?php

namespace Model\Localization;

class Translate  {

    private $path;
    
    public function __construct() {
        $this->path = PATH.'/data/translate/';
    }
    
    public function set($key = '',$type = '',$language = '',$value) {
        
        if(empty($key) || empty($type || empty($language))){
            return false;
        }
        
        $this->createFolder($this->path.$language.'/'.$type.'/');
        $file = $this->path.$language.'/'.$type.'/'.$key.'.txt';
        
        return file_put_contents($file, $value);
        
    }
    
    public function get($key,$type,$language,$default) {
        
        $file = $this->path.$language.'/'.$type.'/'.$key.'.txt';
        
        if(!file_exists($file)){
            return $default;
        }
        
        $content = file_get_contents($file);
        if($content === false || empty($content)){
            return $default;
        }
        
        return $content;
        
    }
    
    public function createFolder($path) {
        
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }
        
        return true;
    }

}
