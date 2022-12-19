<?php

namespace Model\Content\Post;

use \Illuminate\Database\Eloquent\Model;

class PostTranslation  extends Model{
    
    
    protected $hidden = ['id','post_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'content__post_translation';

}
