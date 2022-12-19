<?php

namespace Model\Content\Post;

use \Illuminate\Database\Eloquent\Model;

class PostHierarchy  extends Model{

    protected $table = 'content__post_hierarchy';
    public $timestamps = false;
    
    protected $casts = [
        'id'            => 'int',
        'post_id'    => 'int',
        'category_id'   => 'int',
    ];
   
}
