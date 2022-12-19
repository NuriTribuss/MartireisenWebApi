<?php

namespace Model\User;

use Core\Session\Session;

class Admin {

    protected static $_instance;
    protected static $prefix = 'admin_';

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
        return self::get('firstname').' '.self::get('lastname');
    }
    
    public static function getLanguage(){
        return self::get('language');
    }
}