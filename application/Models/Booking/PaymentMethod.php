<?php

namespace Model\Booking;

use \Illuminate\Database\Eloquent\Model;

class PaymentMethod  extends Model {

    protected $table = 'payment_methods';

    public function translate() {
        return $this->hasOne('\Model\Booking\PaymentMethodTranslation','payment_id','id');
    }
}
