<?php

namespace Model\User;

use Core\Session\Session;

class Customer {

    protected static $_instance;
    protected static $prefix = 'customer_';

    public static function getInstance() {
        static $initialized = FALSE;

        if ( ! $initialized) {
            self::$_instance = new User;
            $initialized = TRUE;
        }

        return self::$_instance;
    }

    public function __set($name, $value) {
        Session::set(self::$prefix.$name, $value);
    }

    public function __get($name) {
        return Session::get(self::$prefix.$name);
    }

    public function __callStatic($name,$argv) {

        $key = self::$prefix.$argv[0];
        if($name === 'get'){
            return Session::get($key);
        }elseif($name === 'set'){
            return Session::set($key, $argv[1]);
        }
    }

    public static function logout(){

        foreach(Session::all() as  $k => $s){
            if(strpos($k, self::$prefix) !== false) {
                Session::clear($k);
            }
        }
        return true;
    }

    public static function getFullName(){
        return self::get('name').' '.self::get('surname');
    }
    
    public static function isLogged(){
        return (int)self::get('id') > 0;
    }
    
    public static function getId(){
        return (int)self::get('id');
    }
    
    public static function getCurrency(){
        $currency = self::get('currency');
        return ($currency == NULL ? 'EUR' : $currency);
    }
    
    public static function getLanguage(){
        $language = self::get('language');
        return ($language == NULL ? 'de' : $language);
    }
    
    public static function setCurrency($currency){
        return self::set('currency',$currency);
    }
    
    public static function setLanguage($language){
        Session::set('language', $language);
        return self::set('language',$language);
    }
    
    public static function getAll(){
        
        $arr  = [];
        $keys = array_keys($_SESSION);
        
        foreach($keys as $index => $key){
            if(strpos($key,self::$prefix) !== false ||  $key = 'language'){
                $newIndex = str_replace(self::$prefix, '', $key);
                $arr[$newIndex]  = $_SESSION[$key];
            }
        }
        
        return $arr;
    }
}