<?php

namespace Application\Service;

class  Language {

    public function loadJs($str,$isWeb = 0) {

        header('content-type:application/javascript');
        $sections = explode('-', $str);
        $secArr = [];
        foreach($sections as $s){
            if($s !== '') {
                $secArr[] = mb_strtoupper($s);
            }
        }

        $return = array();
        
        if($isWeb == 1){
            \Core\App::setType('web');
        }
        
        $file = \Core\Translation\Language::getFile();
        if($file === false || count($secArr) === 0 ){
            echo 'Marti.Locale.set([]);';
            die();
        }

        $parsed =  parse_ini_file($file,true);
        foreach($secArr as $s){
            if(isset($parsed[$s])){
                $return = array_merge($return,$parsed[$s]);
            }
        }

        echo 'Marti.Locale.set('. json_encode($return).');';
    }

     public function change($language) {
        header("X-Robots-Tag: noindex, nofollow", true);

        if(\Core\Translation\Language::isAvailable($language)) {
            \Core\Session\Session::set('language', $language);
            \Core\Session\Session::set('customer_language', $language);
        }        
       
        \Core\Http\Redirect::back();
        return false;
    }
}