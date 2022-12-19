<?php

namespace Model\Landing;

use \Illuminate\Database\Eloquent\Model;

class Footer  extends Model{

    protected $table = 'landing__footer';
   
    public function translate() {
        return $this->hasOne('\Model\Landing\FooterTranslation');
    }
    
}
