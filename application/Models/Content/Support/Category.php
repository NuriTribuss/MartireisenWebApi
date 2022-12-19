<?php

namespace Model\Content\Support;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
use \Model\Content\Support\SupportHierarchy;

class Category  extends Model{
    
    use SoftDeletes;

    protected $table = 'supportcenter_category';
    protected $guarded = [];
    protected $hidden = array('deleted_at');
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
        'has_children'  => 'int'
    ];
        
    public function translate() {
        return $this->hasOne('\Model\Content\Support\CategoryTranslation');
    }
    
    public static function getItems($categoryId , $limit = 50){
        
        $catEntity = new \Core\Structure\Category();
        $catEntity->setTable('supportcenter_category');
        
        $categories =  $catEntity->getCategoryIds($categoryId);
        
        $data =  SupportHierarchy::whereIn('category_id' , $categories)->offset(0)->limit($limit)->get()->toArray();
        
        $ids = array_values(array_column($data, 'support_id'));
        return $ids;
    }
    
}
