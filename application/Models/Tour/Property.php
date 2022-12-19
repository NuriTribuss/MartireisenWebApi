<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class Property  extends Model {
    
    protected $table = 'tours__properties';
    public $timestamps = false;
    
    public function translate() {
        return $this->hasOne('\Model\Tour\PropertyTranslation','property_id','id');
    }


}
