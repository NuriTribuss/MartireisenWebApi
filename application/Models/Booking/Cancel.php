<?php

namespace Model\Booking;

use Model\Tour\Period;

class Cancel{

    public function __construct() {
        ;
    }
    
    public function change($booking) {
        
        switch($booking->source){
            case 'Tour':
                $status = $this->tour($booking);
                break;
        }
      
        return $status;
    }
    
    public function tour($booking) {
        
        $bookingTravellers = (int)$booking->adult_count + (int)$booking->children_count;
        
        $period = Period::find($booking->period_id);
        if($period == null){
            return false;
        }
        
        $period->available_count = $period->available_count + $bookingTravellers;
        if($period->available_count > $period->max_count) {
            return false;
        }
        
        $period->save();
        
        return true;
        
    }
}
