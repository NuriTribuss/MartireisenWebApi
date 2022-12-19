<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model as EloquentModel;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Tab  extends EloquentModel {

    use SoftDeletes;
    
    protected $table = 'tours__tab';
    protected $hidden = array('deleted_at');

    public function translate() {
        return $this->hasOne('\Model\Tour\TabTranslation');
    }
    
}
