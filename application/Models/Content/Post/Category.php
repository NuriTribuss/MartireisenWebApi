<?php

namespace Model\Content\Post;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

use Model\Content\Post\PostHierarchy;

class Category  extends Model{
    
    use SoftDeletes;

    protected $table = 'content__post_category';
    protected $guarded = [];
    protected $hidden = array('deleted_at');
    
    protected $casts = [
        'id'            => 'int',
        'active'        => 'int',
        'sort_number'   => 'int',
        'has_children'  => 'int'
    ];
        
    public function translate() {
        return $this->hasOne('\Model\Content\Post\CategoryTranslation');
    }

    public static function getItems($categoryId , $limit = 50){
        
        $catEntity = new \Core\Structure\Category();
        $catEntity->setTable('content__post_category');
        
        $categories =  $catEntity->getCategoryIds($categoryId);
        
        $data =  PostHierarchy::whereIn('category_id' , $categories)->offset(0)->limit($limit)->get()->toArray();
        
        $ids = array_values(array_column($data, 'post_id'));
        return $ids;
    }
}
