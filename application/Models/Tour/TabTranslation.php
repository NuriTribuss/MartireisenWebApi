<?php

namespace Model\Tour;

use \Illuminate\Database\Eloquent\Model;

class TabTranslation  extends Model{
    
    protected $hidden = ['id','tab_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'tours__tab_translation';

}
