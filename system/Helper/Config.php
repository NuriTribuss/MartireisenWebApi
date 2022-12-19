<?php

namespace Helper;

class Config {

    public static $settings;

    public static function load($file) {
        
        if(file_exists($file)) {
            self::$settings = parse_ini_file($file);

            if(self::$settings["DEBUG"]=="1" ) {
                self::setDevelopmentMode();
            }else{
                self::setProductionMode();
            }
        }else {
            $error = new Error;
            $error->type('warning')->message('Config file is not formatted')->show();
        }

    }

    public static function get($key,$default = ''){
        if($key == 'SITE_URL'){
            return self::getUrl();
        }
        if($key == 'SITE_DOMAIN'){
            return self::getDomain();
        }
        if(isset(self::$settings[$key]) && self::$settings[$key] !== '') {
            return self::$settings[$key];
        }
        return $default;
    }
    
    public static function getUrl(){
        
        $domain = @self::$settings['site_url'];
        if($domain == null){
            // insecurely
           $path = '';//Config::get('SITE_PATH');
           $domain = $_SERVER['HTTP_HOST'];
           self::$settings['site_url'] = $domain.$path;
        }
        
        return 'https://'.$domain;
    }
    
    public static function getDomain(){
        
        $domain = @self::$settings['site_domain'];
        if($domain == null){
            // insecurely
            $url = preg_replace('/^https?:\/\//si', '', trim($_SERVER['HTTP_HOST']));
            $url = explode('/',$url);
            $domain = preg_replace('/^www\./si', '', $url[0]);
            self::$settings['site_domain'] = $domain;
        }
        
        return $domain;
    }

    public static function getAll() {
        return self::$settings;
    }

    public static function getLicence($key) {

        $licencePath = ROOT_PATH.'/Licence/';
        return (int)file_get_contents($licencePath.$key.'.licence') === 1;
    }

    public static function setDevelopmentMode() {

        ini_set("display_errors",1);
        ini_set("display_startup_errors",1);
        error_reporting(-1);
        ini_set("log_errors",1);
    }

    public static function setProductionMode() {

        ini_set("display_errors",0);
        ini_set("display_startup_errors",0);
        error_reporting(E_ALL);
        ini_set("log_errors",1);
    }

    public static function debug() {

        error_reporting(E_ALL);
        ini_set("display_errors",1);
        ini_set("display_startup_errors",1);
    }


}