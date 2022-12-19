<?php

namespace Model\Content\Support;

use \Illuminate\Database\Eloquent\Model;

class CategoryTranslation  extends Model{
    
    protected $hidden = ['id','category_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'supportcenter_category_translation';

}
