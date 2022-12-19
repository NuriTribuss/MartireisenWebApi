<?php

namespace Model\Design\Menu;

use \Illuminate\Database\Eloquent\Model;

class CategoryTranslation  extends Model{
    
    protected $hidden = ['id','category_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'menu__list_category_translation';

}
