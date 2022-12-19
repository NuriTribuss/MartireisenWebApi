<?php

namespace Helper;

class Cache {
    
    private $path;
    private $file;
    private $life = '120' ;
    
    function __construct() {
        $this->path = Config::get('CACHE_PATH');
    }
    
    function getFilename() {
        return $this->file;
    }

    function setFilename($file) {
        $this->file = $this->path.$file;
        
    }    
    
    public function start() {
        ob_start();
    }
    
    public function run($content) {
        
        if($this->exists() === false || time() - filemtime($this->file) >=$this->life ) {
            $this->put($content);
        }
        return $this->get();
    }
    
    public function put($content) {
        return file_put_contents($this->file, $content);
    }
    
    public function get() {
        return file_get_contents($this->file);
    }
    
    public function delete() {
        if(file_exists($this->file)) {
            return unlink($this->file);
        }
        return false;
    }
    
    public function exists() {
        return file_exists($this->file);
    }
}