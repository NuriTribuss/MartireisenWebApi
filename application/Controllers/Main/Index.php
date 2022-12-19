<?php

namespace Application\Main;

use Core\Base\Application;
use Model\Content\Post\Post;
use Model\Content\Homepage\Seo\Text;
use Model\Content\Homepage\Seo\Link;

class Index  extends Application{

    public function __construct() {
        parent::__construct();
    }

    public function index() {
      
        
        $posts   = Post::with(['translate' => function($q) {
            $q->where('language', $this->language);
        }])->skip(0)->take(3)->get();
              
        $blocks   = Text::with(['translate' => function($q) {
            $q->where('language',$this->language);
        }])->skip(0)->take(5)->get()->toArray();
                
        $url  = \Helper\Config::getDomain();
        foreach ($blocks as $key => &$b){
            $b['translate']['content'] = $url == 'akin.at' ? \Helper\Replace::to($b['translate']['content']) : $b['translate']['content'];
        }
                
        
        $links   = Link::with(['translate' => function($q) {
            $q->where('language',$this->language);
        }])->orderBy('sort_number','ASC')->orderBy('id','ASC')->get()->toArray();
       
        foreach ($links as $key => &$b){
            $b['translate']['url'] = $b['translate']['url'].'/';
        }
        
        $this->view->blog_posts  = $posts;
        $this->view->block_texts = $blocks;
        $this->view->block_links = $links;
        
        $this->view->page = 'home';
        $this->header();
        $this->view->render('index');
        $this->footer();
    }

}
