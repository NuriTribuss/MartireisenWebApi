<?php

namespace Helper;

class Header
{
    public static function get($header){
        if($_SERVER['HTTP_'.$header]) {
            return $_SERVER['HTTP_' . $header];
        }
        return null;
    }

    public static function language(){
        return self::get('X_REQUEST_LANGUAGE');
    }

}