<?php

namespace Application\Api\Content\Post;

use Core\Base\Webservice;

use Model\Content\Post\Post as Model;
use Model\Content\Post\PostTranslation;
use Model\Content\Post\PostHierarchy;
use Model\Localization\Language;
use Model\Content\Post\Category;
use Model\Link\Link;

class Post extends Webservice {

    private   $linkModel = null;

    public function __construct() {
        parent::__construct();
        
        $this->linkModel = new Link();
        $this->linkModel->setType('content/post');
    }
    
    public function get() {
        
         try{
             
            $model = $this->build(Model::whereRaw('1 = 1'));
            
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->with(['translate' => function($q) {
                $q->where('language',$this->language);
            }])->skip($skip)->take($this->limit)->get();
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function store() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'       => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $this->linkModel->setUrl($data->url,$data->name);
        
        $language = $this->linkModel->getLanguage();
        
        if($this->linkModel->exists()){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record = new Model;
        $record->sort_number  = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active       = isset($data->active) ? (int)$data->active : 1;        

        $record->save();
        $record->code = 'MP'.$record->id;
        $record->save();
        
        
        // category
        if(is_array($data->categories) && count($data->categories) > 0 ){
            
            foreach($data->categories as $category){
                $find = Category::find($category);
                if($find == NULL){
                    continue;
                }
                $hierarchy = new PostHierarchy();
                $hierarchy->post_id  = $record->id;
                $hierarchy->category_id = $category;
                $hierarchy->save();
            }
            
        }
        
        $postTranslation = new PostTranslation();
        $postTranslation->language     = $language;
        $postTranslation->post_id      = $record->id;
        $postTranslation->name         = $data->name;
        $postTranslation->summary      = (string)$data->summary;
        $postTranslation->content      = (string)$data->content;
        $postTranslation->url          = $this->linkModel->getUrl();
        $postTranslation->save();
        
        $this->linkModel->save(['table_id' => $record->id]);

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    public function update($id = 0) {
        
               
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'       => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        if((int)$data->id > 0 ){
            $id = $data->id;
        }
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(!empty($data->url)){
            $this->linkModel->setUrl($data->url,$data->name);
        }
        
        $language = $this->linkModel->getLanguage();
        
        if($this->linkModel->exists($id)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $record->sort_number  = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;
        $record->active       = isset($data->active) ? (int)$data->active : $record->active;
        $record->save();
        
         // category
        if(is_array($data->categories) && count($data->categories) > 0 ){
            
            $hierarchies = PostHierarchy::where(['post_id' => $record->id])->get();
            if($hierarchies == NULL){
                $hierarchies = [];
            }else{
                $hierarchies = array_column($hierarchies->toArray() , 'category_id');
            }
            
            foreach($data->categories as $category){
                
                $find = Category::find($category);
                if($find == NULL || in_array($category, $hierarchies)){
                    continue;
                }
                
                $hierarchy = new PostHierarchy();
                $hierarchy->post_id  = $record->id;
                $hierarchy->category_id = $category;
                $hierarchy->save();
            }
            
            foreach($hierarchies as $hierarchy){
                if(!in_array($hierarchy, $data->categories)){
                    PostHierarchy::where(['post_id' => $record->id , 'category_id' => $hierarchy])->delete();
                }
            }
        }
        
        
        $postTranslation = PostTranslation::where(['post_id' => $id,'language' => $language])->first();
        if($postTranslation == NULL){
            $postTranslation = new PostTranslation();
            $postTranslation->post_id = $record->id;
        }
        
        $postTranslation->language = $language;
        $postTranslation->name     = isset($data->name) ? $data->name :  $postTranslation->name;
        $postTranslation->summary  = isset($data->summary) ? $data->summary :  (string)$postTranslation->summary;
        $postTranslation->content  = isset($data->content) ? $data->content :  $postTranslation->content;
        $postTranslation->url      = $this->linkModel->getUrl() == NULL ? $postTranslation->url : $this->linkModel->getUrl();
        $postTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id]);

        $this->response->setStatus(true)->out();
    }
    
    public function translate($postId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($postId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
        
        $this->linkModel->setLanguage($data->language);
        $this->linkModel->setUrl($data->url,$data->name);
        
        if($this->linkModel->exists($postId,$data->language)){
            $this->response->http(400)->setMessage('This Link is aldready exists')->out();
        }
        
        $postTranslation = PostTranslation::where(['post_id' => $postId,'language' => $data->language])->first();
        
        if($postTranslation == NULL){
            $postTranslation = new PostTranslation();
            $postTranslation->post_id = $record->id;
            $postTranslation->language = $data->language;
        }
        
        $postTranslation->name        = isset($data->name) ? $data->name :  $postTranslation->name;
        $postTranslation->content     = isset($data->content) ? $data->content :  $postTranslation->content;
        $postTranslation->summary     = isset($data->summary) ? $data->summary :  $postTranslation->summary;

        $postTranslation->url      = $this->linkModel->getUrl() == NULL ? $postTranslation->url : $this->linkModel->getUrl();
        $postTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id], true);
        $this->response->setStatus(true)->out();
        
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $post  = Model::find($id);
        
        if($post != NULL){
            
            $return = $post->toArray();
            $return['categories'] = array_column(PostHierarchy::where(['post_id' => $id])->get()->toArray() , 'category_id');
            $return['translate']  = $this->getLanguageContent($post->id);
            $this->response->setStatus(true)->setData($return)->out();
        }
        
        $this->response->out();
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        
        $this->linkModel->delete(['table_id' => $id]);
        PostTranslation::where('post_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }  
    
     // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '','summary' => '', 'content' => '','url' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = PostTranslation::where(['post_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['name']        = $translate->name;
                $add['url']         = $translate->url;
                $add['summary']     = $translate->summary;
                $add['content']     = $translate->content;
            }
            $add['meta']    = $this->linkModel->getMeta(['table_id' => $id , 'language' => $language->code]);
            array_push($return,$add);
        }
        
        return $return;        
    }
    
}
