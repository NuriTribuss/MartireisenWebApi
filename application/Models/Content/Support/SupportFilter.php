<?php

namespace Model\Content\Support;

use Model\Content\Support\Category;
use Model\Content\Support\SupportTranslation;

class SupportFilter {
    
    public $limit = 10;
    
    public function __construct() {
        ;
    }
    
    public function filterCategory() {
        
        if((int) $this->categoryId > 0 ){
            $ids = Category::getItems($this->categoryId, $this->limit);
        }
        return $ids;
    }
    
    public function filterSearch($q) {
        
        $result = SupportTranslation::where('name','LIKE','%'.$q.'%')->get();
       
        if(empty($result)){
            return [];
        }
        
        return $result->toArray();
    }
    
    public function run() {
        return $this->filterCategory();
    }
    
    public function search($q = '') {
        if(empty($q)){
            return [];
        }
        return $this->filterSearch($q);
    }
}