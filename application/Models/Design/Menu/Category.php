<?php

namespace Model\Design\Menu;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Category  extends Model{
    
    use SoftDeletes;

    protected $table = 'menu__list_category';
    protected $guarded = [];
    protected $hidden = array('deleted_at');
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
        'has_children'  => 'int'
    ];
        
    public function translate() {
        return $this->hasOne('\Model\Design\Menu\CategoryTranslation');
    }
  
}
