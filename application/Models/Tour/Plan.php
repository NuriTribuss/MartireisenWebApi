<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class Plan  extends Model {
    
    protected $table = 'tours__plans';
    public $timestamps = false;
    
    public function translate() {
        return $this->hasOne('\Model\Tour\PlanTranslation','plan_id','id');
    }

}
