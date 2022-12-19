<?php

namespace Application\Main\Content;

use Core\Base\Application;
use Model\Content\Page as Model;
use Model\Content\Branch;

class Page  extends Application{

    public function __construct() {
        parent::__construct();
    }

    public function detail($id) {
        
        try{
            
            $data   = Model::with(['translate' => function($q) {
                $q->where('language', $this->language);
            }])->where(['id' =>$id])->first();

            
            if($data->template !== 'page-blank'){
                $this->header();
            }
            
           
            if(\Helper\Config::getDomain() == 'akin.at'){
                $data->translate->name     = $data->translate->name_a;
                $data->translate->content  = $data->translate->content_a;
                $data->translate->summary  = $data->translate->summary_a;
            }
            
            $assign = [
                'page' => $data->toArray()
            ];
            if($data->template == 'page-contact') {
                $assign['branchs'] = Branch::where('active',1)->where('domain', $this->domain)->orderBy('sort_number','ASC')->get()->toArray();
            }
            
            $this->template->fetch('page/'.$data->template.'.tpl',$assign);
            
            if($data->template !== 'page-blank'){
                $this->footer();
            }

        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }

}
