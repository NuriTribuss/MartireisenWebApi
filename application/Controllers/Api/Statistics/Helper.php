<?php

namespace Application\Api\Statistics;

trait Helper {
    
    public function date($param) {
        
        $return = date('Y-m-d 00:00:00');
        
        switch($param){
            case 'today': 
                $return =  date('Y-m-d 00:00:00');  
                break;
                
            case 'week' :
                $d = date('l');
                if($d == 'Monday'){
                   $return =  date('Y-m-d 00:00:00');
                }else{
                   $return =  date('Y-m-d 00:00:00',strtotime( "previous monday" ));
                }
                break;
                
            case 'month' :
                $return =  date('Y-m-01 00:00:00');
                break;
            
            case 'year' :
                $return =  date('Y-01-01 00:00:00');
                break;
        }
        
        
        return $return;
    }
    
    public function dateArr($day = 7) {
        
        $first = date('Y-m-d', strtotime('-'.$day.' days'));
        $last  = date('Y-m-d');
        
        return $this->date_range($first, $last);
    }
    
    public function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {
        
        $dates = array();
        $current = strtotime($first);
        $last    = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

}