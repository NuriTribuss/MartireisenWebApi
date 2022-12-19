<?php


namespace Helper;

class Input {

    public static function get($name = '',$default=false){
        
        if($name == ''){
            return $_GET;
        }
        
        $input =  filter_input(INPUT_GET, $name);
        return $input === NULL ? $default : $input;
    }

    public static function post($name,$default=false,$arr  = false){

        if($arr === true) {
            $input =  filter_input(INPUT_POST, $name, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        }else {
            $input =  filter_input(INPUT_POST, $name);
        }
        return $input === NULL ? $default : $input;
    }

    public static function all($secure = false){

        if($secure){

            $data = $_POST;
            foreach($data as $key => $value){
                $data[$key] = htmlspecialchars($value);
            }

            return $data;
        }
        return filter_input_array(INPUT_REQUEST);
    }

    public static function json(){

        $input =  file_get_contents("php://input");
        $json  =  json_decode($input);

        if(json_last_error() !== JSON_ERROR_NONE){
            return false;
        }

        return $json;
    }

    public static function getAll(){
        return  $_GET;
    }

    public static function CsrfToken(){
        $token = substr(hash('sha256','tsoft'.rand(0,355).'2017'),0,16);
        Session::set('csrf-token', $token);
        return $token;
    }

    public static function getCsrfToken(){
        return Session::get('csrf-token');
    }
    
    public static function getRequestUrl(){
        return $_SERVER['REQUEST_URI'];
    }

    public static function getFullUrl() {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    public static function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function replaceTr($str){
        
        $before = array('ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ö', 'Ç'); // , '\'', '""'
        $after   = array('i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 'o', 'c'); // , '', ''
        
        return str_replace($before, $after, $str);

    }
    
    public static function isMobile(){
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}