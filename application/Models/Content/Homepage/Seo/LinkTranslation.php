<?php

namespace Model\Content\Homepage\Seo;

use \Illuminate\Database\Eloquent\Model;

class LinkTranslation  extends Model{
    
    protected $hidden = ['id','text_id', 'deleted_at', 'updated_at', 'created_at'];
    protected $table = 'homepage_seo_link_translation';

}
