<?php

namespace Core\Cache;

class RedisCache {
    
    private $node;
    private $language = '';
    private static $instance = null;

    public static function getInstance(){
        
        if (self::$instance === null) {
            self::$instance = new RedisCache();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->node = \Helper\RedisCache::getInstance();
    }
    
    public function setLanguage($language) {
        $this->language = $language;
    }
    
    public function set($key,$value){
        if(!empty($this->language)){
            $key .= '_lang_'.$this->language;
        }
        return $this->node->set($key,$value);
    }
    
    public function get($key){
        if(!empty($this->language)){
            $key .= '_lang_'.$this->language;
        }
        return $this->node->get($key);
    }

    public function getArr($key){
        
        if(!empty($this->language)){
            $key .= '_lang_'.$this->language;
        }
        
        $val =  $this->node->get($key);
        if($val === false){
            return $val;
        }
        return json_decode($val,true);
    }
    
    public function setArr($key,$value){
        
        if(!empty($this->language)){
            $key .= '_lang_'.$this->language;
        }
        
        if(is_array($value)){
            $value = json_encode($value);
        }
        return $this->node->set($key,$value);
    }
    
    public function clear() {
        return $this->node->flushAll();
    }
    
}