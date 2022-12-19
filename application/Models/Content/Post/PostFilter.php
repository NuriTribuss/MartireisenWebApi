<?php

namespace Model\Content\Post;

use Model\Content\Post\Category;
use Model\Content\Post\Post;

class PostFilter {
    
    public $limit = 10;
    
    public function __construct() {
        ;
    }
    
    public function filter() {
        
        if((int) $this->categoryId > 0 ){
            $ids = Category::getItems($this->categoryId, $this->limit);
        }
        
        $records = Post::where('active',1)->skip(0)->take($this->limit)->get()->toArray();
        $ids     = array_values(array_column($records, 'id'));
        return $ids;
        
    }
    
    public function run() {
        
        return $this->filter();
    }
}