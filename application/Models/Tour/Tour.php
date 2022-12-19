<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class Tour  extends Model {
    
    protected $table = 'tours';
    
    public function translate() {
        return $this->hasOne('\Model\Tour\TourTranslation','tour_id','id');
    }
}
