<?php

namespace Model\Design\Menu;

use \Illuminate\Database\Eloquent\Model;

class MenuTranslation  extends Model{
    
    protected $hidden = ['id','menu_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'menu__list_translation';

}
