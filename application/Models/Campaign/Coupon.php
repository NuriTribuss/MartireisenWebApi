<?php

namespace Model\Campaign;

use \Illuminate\Database\Eloquent\Model;

class Coupon  extends Model {

    protected $table = 'discount_coupons';
    
    const PERCENT = 1;
    const VALUE   = 2;
    
    public function calculate($code,$total = 0) {
        
        if($total == 0){
            return false;
        }
        
        $coupon = Coupon::where('code',$code)->first();
      
        if($coupon == NULL){
            return false;
        }
        
        $coupon = $coupon->toArray();
        
        if(isset($coupon['id']) && $coupon['is_active'] == 1 && $coupon['start_time'] < time() && $coupon['end_time']  > time() && $coupon['min_amount'] <= $total){
            
            if($coupon['discount_type'] == self::PERCENT){
                
                $value    = $coupon['value'] > 100 ? 100 : $coupon['value'];
                $discount = $total * ($value / 100);
                return $discount;
                
            }elseif($coupon['discount_type'] == self::VALUE){
                
                $value    = $coupon['value'] > $total ? $total : $coupon['value'];
                $discount = $total - $value;
                return $discount;
                
            }
            
        }
        return false;
    }

    
}
