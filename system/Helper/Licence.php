<?php

namespace Helper;

class Licence {
    
    public static $licences;
    
    public static function load($file) {
        
        if(file_exists($file)) {
            self::$licences = parse_ini_file($file);          
        }else {
            self::$licences = NULL;
        }
      
    }
    
    public static function get($key,$default = 0){
        
        if(self::$licences == NULL) {
            return 1;
        }
        
        if(isset(self::$licences[$key]) && self::$licences[$key] !== '') {
            return self::$licences[$key];
        }
        return $default;
    }
    
    public static function getAll() {
        return self::$licences;
    }   
   
}