<?php

namespace Model\Customer;

use \Illuminate\Database\Eloquent\Model;


class Customer  extends Model{

    protected $table = 'customers';
    
    public static function checkFields($data) {

        $required = array(
             'name' , 'surname' , 'username' , 'password'
        );
        

        foreach($required as $r){
            
            if(\Model\User\Customer::isLogged() && $r == 'password'){
                continue;
            }
            
            if(empty($data[$r])) {
                return $r;
            }
        }
        
        if(isset($data['username']) && !filter_var($data['username'],FILTER_VALIDATE_EMAIL)) {
            return 'username';
        }

        return true;
    }

}
