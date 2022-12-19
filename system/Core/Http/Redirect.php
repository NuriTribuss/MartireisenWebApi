<?php
namespace Core\Http;


class Redirect {

    public static function go($url,$time=0) {
        if(strpos($url, 'store/')) {
            $url= str_replace('store/',ADMIN_URI.'/',$url);
        }
        if (!headers_sent()) {
            header('Refresh:'.$time.'; url='.$url);
            exit;
        }

        echo '<meta http-equiv="refresh" content="'.$time.'; url='.$url.'">';
        
        die();
    }
    
    public static function back(){
        
        if(\Helper\Config::get('APP_URL').$_SERVER['REQUEST_URI'] === $_SERVER['HTTP_REFERER'] && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo '<pre>';
            debug_print_backtrace();
            echo '<pre>';
            die('Recursive redirect error.Please check backtrace Redirect::back method');
        }else{
            self::go($_SERVER["HTTP_REFERER"]);
        }
        
    }
    
}