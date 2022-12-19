<?php

namespace Model\Landing;

use \Illuminate\Database\Eloquent\Model;

class Base  extends Model{

    protected $table = 'landing__base';
   
    public function translate() {
        return $this->hasOne('\Model\Landing\BaseTranslation');
    }
    
}
