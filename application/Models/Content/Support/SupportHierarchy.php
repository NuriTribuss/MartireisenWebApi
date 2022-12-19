<?php

namespace Model\Content\Support;

use \Illuminate\Database\Eloquent\Model;

class SupportHierarchy  extends Model{

    protected $table = 'supportcenter_hierarchy';
    public $timestamps = false;
    
    protected $casts = [
        'id'            => 'int',
        'support_id'    => 'int',
        'category_id'   => 'int',
    ];
   
}
