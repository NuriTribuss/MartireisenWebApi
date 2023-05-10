<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class Station  extends Model {
    
    protected $table = 'tours__stations';
    public $timestamps = false;

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

}
