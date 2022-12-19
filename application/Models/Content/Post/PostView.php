<?php

namespace Model\Content\Post;

use Model\Content\Post\Post;
use Model\View;

class PostView extends View{

    
    public function __construct() {
        parent::__construct();
    }
   
    public function get($id) {
        
        $data = Post::with(['translate' => function($q) {
            $q->where('language', $this->language);
        }])->where('id',$id)->first();
        
        if($data == null){
            return null;
        }
        
        $record   = $data->toArray();
      
        return $record;
    }
    
}
