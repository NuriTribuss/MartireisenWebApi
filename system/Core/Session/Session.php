<?php

namespace Core\Session;

class Session {

    public static $redisStatus;
    public static $redis;
    public static $prefix;

    public static function init($redis = true) {

        if (session_status() == PHP_SESSION_NONE) {
            session_name('MRCSESSID');
            @session_start();
        }

        if (isset($_GET["session_id"])) {
            $ref = $_GET["ref"];
            
            if ($ref == substr(hash("sha512", $_GET["session_id"] . '159code951'), 0, 8)) {
                $_SESSION["redis_separator"] = $_GET["session_id"];
            } else {
                $_SESSION["redis_separator"] = session_id();
            }
        }

        if (!isset($_SESSION["redis_separator"])) {
            $_SESSION["redis_separator"] = session_id();
        }


        if (!class_exists('\Redis')) {
            $redis = false;
        }
        // :)
        $redis = false;
        
        if ($redis === true) {
            self::$prefix = ROOT_PATH . "_" . $_SESSION["redis_separator"] . '_';

            self::$redis = new \Redis;
            self::$redis->connect('localhost', 6379) or $redis = false;
        }

        self::$redisStatus = $redis;
    }

    public static function set($key, $value) {

        if (self::$redisStatus === true) {
            self::$redis->set(self::$prefix . $key, json_encode($value));
            return;
        }

        $_SESSION[$key] = $value;
        return;
    }

    public static function get($key) {

        if (self::$redisStatus === true) {
            if (isset($key)) {
                return json_decode(self::$redis->get(self::$prefix . $key), true);
            }
        }

        if (isset($key)) {
            return @$_SESSION[$key];
        }
    }
    
    public static function all(){
        return $_SESSION;
    }
    
    public static function regenerate(){
        return session_regenerate_id();
    }

    public static function pre() {

        if (self::$redisStatus === true) {
            $allKeys = self::$redis->keys(self::$prefix . "*");
            $session = array();

            foreach ($allKeys as $key) {
                $key = str_replace(self::$prefix, "", $key);
                $session[$key] = json_decode(self::$redis->get(self::$prefix . $key), true);
            }

            print_r($session);
            return;
        }

        print_r($_SESSION);
    }

    public static function clear($key) {

        if (self::$redisStatus === true) {
            self::$redis->delete(self::$prefix . $key);
            return;
        }

        unset($_SESSION[$key]);
    }
    

    public static function destroy() {
        if (self::$redisStatus === true) {
            $allKeys = self::$redis->keys(self::$prefix . "*");

            foreach ($allKeys as $key) {
                self::$redis->delete($key);
            }
            return;
        }

        session_destroy();
    }

}
