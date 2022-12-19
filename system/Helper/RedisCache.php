<?php

namespace Helper;

class RedisCache {
    
    private $redisObj = NULL;
    private static $instance = null;
    private static $timeout = 24; // hour
    
    function __construct() {
        
        $this->redisObj = new \Redis();
        $this->redisObj->connect(\Helper\Config::get('REDIS_HOST'), \Helper\Config::get('REDIS_PORT'));
        $this->redisObj->auth(\Helper\Config::get('REDIS_AUTH')); 
        
    }
    
    public static function getInstance(){
        
        if (self::$instance === null) {
            self::$instance = new RedisCache();
        }
        return self::$instance;
    }
    
    public function set($key,$value){
        $timeout = self::$timeout * 60 * 60;
        return $this->redisObj->set($key,$value,$timeout);
    }
    
    public function get($key){
        return $this->redisObj->get($key);
    }
    
    public function close() {
        return $this->redisObj->close();
    }
    
    public function exists($key) {
        return $this->redisObj->exists($key);
    }
    
    public function flushAll() {
        return $this->redisObj->flushAll();
    }
}