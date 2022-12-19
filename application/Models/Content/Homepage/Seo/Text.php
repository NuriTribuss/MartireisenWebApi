<?php

namespace Model\Content\Homepage\Seo;

use \Illuminate\Database\Eloquent\Model as EloquentModel;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Text  extends EloquentModel{

    use SoftDeletes;
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
    ];

    protected $table = 'homepage_seo_text';
    protected $hidden = array('deleted_at');

    public function translate() {
        return $this->hasOne('\Model\Content\Homepage\Seo\TextTranslation');
    }
    
}
