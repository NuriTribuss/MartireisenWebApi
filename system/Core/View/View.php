<?php

namespace Core\View;

class View { 
    
    private $path;
    private $dir = '';
    public  $template;
    
    function __construct() {
        $this->path = PATH;
    }
    
    public function getPath() {
        return $this->path;
    }
    
    public function setPath($path) {
        $this->path = $path;
        $this->dir  = str_replace(PATH , '', $this->path);
    }
    
    public function getDir() {
        return $this->dir;
    }
}
