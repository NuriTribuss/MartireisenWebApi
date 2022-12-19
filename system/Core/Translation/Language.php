<?php

namespace Core\Translation;

class Language {

    public static $content = NULL;
    public static $baseContent = NULL;
    public static $prefix = 'translate';

    public static function  getLanguage(){
        
        if(\Core\App::getType() == 'admin'){
            return isset($_SESSION['admin_language']) ? $_SESSION['admin_language'] : 'de';
        }
        
        if(!isset($_SESSION['language'])){
            $_SESSION['language'] = \Helper\Setting::get('language');

        }
        return $_SESSION['language'];
    }

    public static function getBaseFile(){

        $language    = self::getLanguage();
        $baseFile    = PATH.'/resources/langs/'.$language.'/'.\Core\App::getType().'/'.self::$prefix.'.ini';
        if(!file_exists($baseFile)) {
            return false;
        }
        return $baseFile;

    }

    public static function getFile(){

        $language    = self::getLanguage();
        $baseFile    = PATH.'/resources/langs/'.$language.'/'.\Core\App::getType().'/'.self::$prefix.'.ini';
        $customFile  = PATH.'/resources/langs/'.$language.'/'.\Core\App::getType().'/'.self::$prefix.'_user.ini';

        $filename = $customFile;

        if(!file_exists($customFile)) {
            $filename = $baseFile;
        }

        if(!file_exists($filename)) {
            return false;
        }
        return $filename;
    }

    public static function get($field,$default = '') {
        $file = self::getFile();
        if($file === false){
            return $default;
        }
        
        if(self::$content === NULL){
            self::$content     = parse_ini_file($file);
            self::$baseContent = parse_ini_file(self::getBaseFile());
        }
    
        if(self::$content === false || self::$baseContent == false) {
            return $default;
        }
        
        $e = isset(self::$content[$field]) ? self::$content[$field] : self::$baseContent[$field];
        
        $d = \Helper\Config::getDomain();
        if($d == 'akin.at'){
           $e = str_replace(['Marti Reisen' , 'Martireisen'],'Akin Travel',$e);
        }
        return $e;

    }

    public static function getSection($section = '' , $type = ''){

        if(empty($type)){
            $type = \Core\App::getType();
        }
        
        $language = self::getLanguage();
        $filename    = PATH.'/resources/langs/'.$language.'/'.$type.'/'.self::$prefix.'.ini';
        $customFile  = PATH.'/resources/langs/'.$language.'/'.$type.'/'.self::$prefix.'_user.ini';
        
        if(file_exists($customFile)) {
            $filename = $customFile;
        }
        
        if(!file_exists($filename)) {
            return array();
        }
        $arr = parse_ini_file($filename,true);
        if($arr === false) {
            return array();
        }
        return $arr[$section];
    }

    public static function isAvailable($language) {

        $filename = PATH.'/resources/langs/'.$language.'/'.\Core\App::getType().'/'.self::$prefix.'.ini';
        if(!file_exists($filename)) {
            return false;
        }
        return true;
    }

    public static function getAppCol($arr,$field) {
        $language = self::getLanguage();
        if($language !== 'tr') {
            return isset($arr[$field.'_'.$language]) ? $arr[$field.'_'.$language] : $arr[$field];
        }
        return $arr[$field];
    }

    public function load($arr,$type = '') {
        
        $params = array();
        foreach($arr as $section){
            $params = array_merge($params,self::getSection($section,$type));
        }
        if($params == NULL) {
            return [];
        }
        return $params;
    }

}