<?php

namespace Core\Http;

class Request{

    public static function isPost(){
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isGet(){
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    public static function isPut(){
        return $_SERVER['REQUEST_METHOD'] === 'PUT';
    }

    public static function isDelete(){
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    public static function isAjax() {
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            return false;
        }
        return true;
    }
}
