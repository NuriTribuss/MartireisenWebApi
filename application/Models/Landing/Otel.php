<?php

namespace Model\Landing;

use \Illuminate\Database\Eloquent\Model;

class Otel  extends Model{

    protected $table = 'landing__otel';
   
    public function translate() {
        return $this->hasOne('\Model\Landing\OtelTranslation');
    }
    
}
