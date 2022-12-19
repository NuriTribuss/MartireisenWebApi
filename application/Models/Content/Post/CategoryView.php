<?php

namespace Model\Content\Post;

use Model\Content\Post\Category;
use Model\View;

class CategoryView  extends View {

    
    public function __construct() {
        parent::__construct();
    }
   
    public function get($id) {
        
        $data = Category::with(['translate' => function($q) {
            $q->where('language', $this->language);
        }])->where('id',$id)->first();
        
        if($data == null){
            return null;
        }
        
        $category   = $data->toArray();
        return $category;
    }
}
