<?php

namespace Model\Design\Menu;

use \Illuminate\Database\Eloquent\Model;

class Menu  extends Model{

    protected $table = 'menu__list';
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
    ];
    
    public function translate() {
        return $this->hasOne('\Model\Design\Menu\MenuTranslation');
    }
   
}
