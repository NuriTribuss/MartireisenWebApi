<?php

namespace Model\Content;

use \Illuminate\Database\Eloquent\Model as EloquentModel;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Page  extends EloquentModel{

    use SoftDeletes;
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
    ];

    protected $table = 'content__page';
    protected $hidden = array('deleted_at');

    public function translate() {
        return $this->hasOne('\Model\Content\PageTranslation');
    }
    
}
