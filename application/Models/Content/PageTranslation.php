<?php

namespace Model\Content;

use \Illuminate\Database\Eloquent\Model;

class PageTranslation  extends Model{
    
    protected $hidden = ['id','model_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'content__page_translation';

}
