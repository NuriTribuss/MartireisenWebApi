<?php

namespace Model\Content\Support;

use \Illuminate\Database\Eloquent\Model;

class SupportTranslation  extends Model{
    
    
    protected $hidden = ['id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'supportcenter_translation';

}
