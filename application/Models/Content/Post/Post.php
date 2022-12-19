<?php

namespace Model\Content\Post;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;


class Post  extends Model{

    use SoftDeletes;

    protected $table = 'content__post';
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
    ];
        
    public function translate() {
        return $this->hasOne('\Model\Content\Post\PostTranslation');
    }
   
}
