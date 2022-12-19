<?php

/*
 * 
 *  AKIN AT İÇİN
 */


namespace Helper;

class Replace {
    
    public static function to($str = ''){
        
        $from  = ['Martı Reısen','Martı Reisen','Marti Reisen','Martireisen','MartiReisen'];
        $to    = 'Akin Travel';
        
        $str   = str_replace($from,$to,$str);
        return $str;
        
    }
    
}