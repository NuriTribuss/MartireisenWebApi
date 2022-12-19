<?php

namespace Core\Migration;

class Logger {
    
    private $path;
    
    public function __construct() {
        
        $this->path = PATH.'/data/log/Migration/';
        if(!is_dir($this->path)){
            mkdir($this->path,0777,true);
        }
    }
    
    public function log($text) {
        
        $message = date('d.m.Y H:i:s').' | ';
        $message.= $text;
                
        $file    = time().'.log';
        $write = file_put_contents($this->path.$file, $message.PHP_EOL,FILE_APPEND);
        
        echo $message.'<br>'.PHP_EOL;
        return $write;
    }
    
   
    
}