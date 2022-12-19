<?php

namespace Core\Cache;

abstract class Cache  {
    
    protected $dir;
    protected $file;
    protected $cached = false;
    protected $active = true;
    protected $timeout = 60; 
    
    public function __construct($subDirectory = '') {
        
        $this->dir = PATH.\Helper\Config::get('CACHE_DIR','/cache/');
        
        if(!empty($subDirectory)){
            $this->dir.=$subDirectory.'/';
        }
        
        if(!file_exists($this->dir)) {
            mkdir($this->dir, 0755, true);
        }
                
    }
    
    public function setActive($active) {
        $this->active = $active;
    }
    
    public function setTimeout($timeout) {
        $this->timeout = $timeout;
    }
    

}

