<?php

namespace Model\Content\Post;

use \Illuminate\Database\Eloquent\Model;

class CategoryTranslation  extends Model{
    
    protected $hidden = ['id','category_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'content__post_category_translation';

}
