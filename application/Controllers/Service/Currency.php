<?php

namespace Application\Service;

class  Currency {

     public function change($currency) {

       // if(\Core\Translation\Language::isAvailable($language)) {
       \Model\User\Customer::setCurrency($currency);
          //  \Core\Session\Session::set('currency', $currency);
       // }
        \Core\Http\Redirect::back();
        return false;
    }
    
}