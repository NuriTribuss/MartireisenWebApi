<?php

namespace Model\Mail;

class Template {

    private $params;
    private $langParams;
    private $path;

    public function __construct() {

        $this->params       = $this->flush();
        $this->langParams   = [];
        $this->path         = PATH.'/themes/mail/';

    }

    public function assign($p1,$p2 = NULL) {

        if(is_array($p1)){
            $this->params = array_merge($this->params,$p1);
        }else{
            array_push($this->params,array($p1 => $p2));
        }
        
      
    }

     public function assignLang($p1,$p2 = NULL) {
        if(is_array($p1)){
            $this->langParams = array_merge($this->langParams,$p1);
        }else{
            array_push($this->langParams,array($p1 => $p2));
        }
    }

    private function replace($content) {
        
        foreach($this->params as $key => $value) {
            if(!is_array($value)){
               $content = str_replace('{{'.$key.'}}', $value, $content);
            }
        }
        
        foreach($this->langParams as $key => $value) {
            $content = str_replace('{#'.$key.'#}', $value, $content);
        }
        
     
      //  $this->replaceFor();
        
        return $content;
    }
    
    public function run($tpl) {
        
        $content = \Helper\Setting::get($tpl); //ile_get_contents($this->path.$tpl.'.php');
        $body    = $this->replace($content);

        return $body;
    }

    public function fetch($tpl) {

        $content = file_get_contents($this->path.$tpl.'.php');
        $body    = $this->replace($content);

        return $body;
    }

    public function flush() {

        $url = \Helper\Config::get('SITE_URL');
        
        return  array(
            'url'       => $url,
            'logo'      => $url.'/'.\Helper\Setting::get('logo'),
            'slogan'    => 'Traumreise mit Bestpreis Garantie!',
            'address'   => \Helper\Setting::get('address'),
            'phone'     => \Helper\Setting::get('phone'),
            'copyright'     => \Helper\Setting::get('copyright'),
            'facebook'  => \Helper\Setting::get('facebook'),
            'twitter'   => \Helper\Setting::get('twitter'),
            'instagram' => \Helper\Setting::get('instagram'),
            'youtube'  => \Helper\Setting::get('youtube'),
            'generator' => 'Marti Reisen',
        );

    }
    
    public function getParams() {
        return $this->params;
    }
    
    public function getLangParams() {
        return $this->langParams;
    }

}
