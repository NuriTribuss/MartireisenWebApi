<?php

namespace Model\Content\Support;

use Model\Content\Support\Support;
use Model\Content\Support\SupportHierarchy;
use Model\View;

class SupportView extends View{

    
    public function __construct() {
        parent::__construct();
    }
   
    public function get($id) {
        
        $data = Support::with(['translate' => function($q) {
            $q->where('language', $this->language);
        }])->where('id',$id)->first();

        if($data == null){
            return null;
        }
        
        $hierarchy = SupportHierarchy::where(['support_id' => $data->id])->first();
        if($hierarchy != null){
            $data->category_id = $hierarchy->category_id; 
        }
    
        $record    = $data->toArray();
        return $record;
    }
    
}
