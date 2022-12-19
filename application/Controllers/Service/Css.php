<?php

namespace Application\Service;

class  Css {

    public function load() {

        header('content-type:text/css');
        header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60*24*7))); // 1 hour

        echo \Helper\Setting::get('custom_css');
    }
    
    public function compress() {
        
        header('content-type:text/css');
        header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60*24*7))); // 1 hour

        
        $arr = [
            PATH.'/themes/web/martireisen/assets/css/custom/bootstrap.min.css',
            PATH.'/themes/web/martireisen/assets/css/custom/animate.min.css',
            PATH.'/themes/web/martireisen/assets/css/custom/mmenu.css',
            PATH.'/themes/web/martireisen/assets/js/owl-carousel/assets/owl.carousel.min.css',
            PATH.'/themes/web/martireisen/assets/js/owl-carousel/assets/owl.theme.default.css',
        ];
        
        $return = '';
        foreach($arr as $a){
            $return.= file_get_contents($a).PHP_EOL;
        }
        echo $return;
    }
    
    public function modules() {
        
        header('content-type:text/css');
        header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60 *24*7))); // 1 hour

        $arr = [
            PATH.'/themes/web/martireisen/assets/css/custom/vue-airbnb-style-datepicker.min.css',
            PATH.'/themes/web/martireisen/assets/css/custom/animate.min.css',
        ];
        
        $return = '';
        foreach($arr as $a){
            $return.= file_get_contents($a).PHP_EOL;
        }
        echo $return;
    }
    
    

}