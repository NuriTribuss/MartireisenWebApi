<?php


namespace Helper;

class Security {

    public static function captcha(){
        
        $post =  array(
            'secret'    => Config::get('SECRET_KEY'),
            'response'  => Input::post('response'),
        );
        
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        
        $response = json_decode($return);
      
        return $response->success;
        
    }

   

}