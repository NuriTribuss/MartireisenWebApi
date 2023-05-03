<?php

namespace Model\Booking;

use \Illuminate\Database\Eloquent\Model;
use Model\Sys\User\User;

class Notes  extends Model {

    protected $table = 'booking_notes';

    public function user() {
        return $this->belongsTo(User::class);
    }
}
