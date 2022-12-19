<?php

namespace Application\Main\Content;

use Core\Base\Application;
use Model\Content\Support\SupportView;

class Support  extends Application{

    public function __construct() { 
        parent::__construct();
    }
    
    public function index() {
        
        $this->header();
        
        $this->footer();
    }

    public function detail($id) {
      
        try{
           
            $view = new SupportView();
            $data = $view->get($id);
            $related = [];
           
            if($data['category_id'] > 0 ){
                $relateds = \Model\Content\Support\Category::getItems($data['category_id']);
                foreach($relateds as $r){
                    $related[] = $view->get($r);
                }
            }
            
            $this->header();
            $this->template->fetch('support/support-detail.tpl',['support' => $data , 'related' => $related]);
            $this->footer();

        }catch(\Exception $e){

        }

    }

}
