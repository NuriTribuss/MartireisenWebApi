<?php

namespace Model\Landing;

use \Illuminate\Database\Eloquent\Model;

class Zone  extends Model{

    protected $table = 'landing__zone';
   
    public function translate() {
        return $this->hasOne('\Model\Landing\ZoneTranslation');
    }
    
}
