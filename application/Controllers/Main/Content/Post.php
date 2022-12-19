<?php

namespace Application\Main\Content;

use Core\Base\Application;
use Model\Content\Post\Post as Model;

class Post  extends Application {

    public function __construct() {
        parent::__construct();
    }

    public function detail($id) {
        try {
            
            $data   = Model::with(['translate' => function($q) {
                $q->where('language', $this->language);
            }])->where(['id' =>$id])->first();
                        
            $this->header();
            $this->template->fetch('post/post-detail.tpl',['post' => $data->toArray()]);
            $this->footer();

        }catch(\Exception $e){

        }
       
    }

}
