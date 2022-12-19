<?php

namespace Model\Content\Support;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;


class Support  extends Model{

    use SoftDeletes;

    protected $table = 'supportcenter';
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
    ];
        
    public function translate() {
        return $this->hasOne('\Model\Content\Support\SupportTranslation');
    }
   
}
