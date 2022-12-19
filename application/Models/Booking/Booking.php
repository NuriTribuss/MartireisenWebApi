<?php

namespace Model\Booking;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Booking  extends Model {

    use SoftDeletes;
    
    protected $table = 'booking';

}
