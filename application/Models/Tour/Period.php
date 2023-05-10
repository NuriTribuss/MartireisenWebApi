<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class Period  extends Model {
    
    protected $table = 'tours__periods';

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

}
