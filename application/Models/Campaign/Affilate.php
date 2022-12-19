<?php

namespace Model\Campaign;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Affilate  extends Model {
    
    use SoftDeletes;

    protected $table = 'affilates';

}
