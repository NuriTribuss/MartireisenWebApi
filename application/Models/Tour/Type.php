<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class Type  extends Model {
    
    protected $table = 'tours__types';
    
    public function translate() {
        return $this->hasOne('\Model\Tour\TypeTranslation','type_id','id');
    }

}
