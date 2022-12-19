<?php

namespace Application\Api\Landing;

use Core\Base\Webservice;
use Model\Landing\Zone as Model; 
use Model\Landing\ZoneTranslation;
use Model\Localization\Language; 
use Model\Link\Link;

class Zone extends Webservice {

    private   $linkModel = null;

    public function __construct() {
        parent::__construct();
        $this->linkModel = new Link();
    }
    
    public function get() {
        
         try{
             
            $model = $this->build(Model::whereRaw('1 = 1'));
            
            $pagination = [
                'page'  => \Helper\Input::get('page',1)
            ];
            
            $language = \Helper\Input::get('language', $this->language);
            
            
            $skip                   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $pagination['total']    = $model->with('translate')->whereHas('translate' , $this->filterTranslate())->count();
            
            $data   = $model->with(['translate' => function($q) use($language) {
                $q->where('language',$language);
            }])->whereHas('translate' , $this->filterTranslate())->skip($skip)->take($this->limit)->get();
                      
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
    public function store() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $this->linkModel->setEmptyUrl();
        
        $language = $this->linkModel->getLanguage();
        
       // if($this->linkModel->exists()){
        //    $this->response->http(400)->setMessage('This Link is aldready exists')->out();
       // }
        
        $record = new Model;
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : 999;
        $record->active      = isset($data->active) ? (int)$data->active : 1;
        $record->related_ids = isset($data->related_ids) ? (string)$data->related_ids : '';
        $record->save();
        $record->code = 'PA'.$record->id;
        $record->save();
        
        $pageTranslation = new PageTranslation();
        $pageTranslation->language = $language;
        $pageTranslation->page_id = $record->id;
        $pageTranslation->name     = $data->name;
        $pageTranslation->content  = (string)$data->content;
       // $pageTranslation->url      = $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->save(['table_id' => $record->id]);

        $this->response->setStatus(true)->setData(['id' => $record->id , 'action' => 'insert'])->out();
    }
    
    
    public function update($id = 0) {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'title' => 'required',
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
        
        $this->linkModel->setType('landing_'.$record->type);

        if(!empty($data->url)){
            $this->linkModel->setEmptyUrl();
        }
        $language = $this->linkModel->getLanguage();
        
        //if($this->linkModel->exists($id)){
         //   $this->response->http(400)->setMessage('This Link is aldready exists')->out();
      //  }
        
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number :  $record->sort_number;
        $record->active      = isset($data->active) ? (int)$data->active : $record->active;
        $record->related_ids = isset($data->related_ids) ? (string)$data->related_ids : $record->related_ids;

        $record->save();
        
        
        $pageTranslation = ZoneTranslation::where(['zone_id' => $id,'language' => $language])->first();
        if($pageTranslation == NULL){
            $pageTranslation = new ZoneTranslation();
            $pageTranslation->zone_id = $record->id;
        }
        
        $pageTranslation->language          = $language;
        $pageTranslation->title             = isset($data->title) ? $data->title :  $pageTranslation->title;
        $pageTranslation->subtitle          = isset($data->subtitle) ? $data->subtitle :  $pageTranslation->subtitle;
        $pageTranslation->second_title      = isset($data->second_title) ? $data->second_title :  $pageTranslation->second_title;
        $pageTranslation->second_subtitle   = isset($data->second_subtitle) ? $data->second_subtitle :  $pageTranslation->second_subtitle;
        $pageTranslation->third_title       = isset($data->third_title) ? $data->third_title :  $pageTranslation->third_title;
        $pageTranslation->third_subtitle    = isset($data->third_subtitle) ? $data->third_subtitle :  $pageTranslation->third_subtitle;
        $pageTranslation->content           = isset($data->content) ? $data->content :  $pageTranslation->content;
     //   $pageTranslation->url               = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->code]);

        $this->response->setStatus(true)->out();
    }
    
    public function translate($pageId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'title'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($pageId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
        
        $this->linkModel->setType('landing_'.$record->type);
        $this->linkModel->setLanguage($data->language);
        $this->linkModel->setEmptyUrl();
        
       // if($this->linkModel->exists($pageId,$data->language)){
           // $this->response->http(400)->setMessage('This Link is aldready exists')->out();
      //  }
        
        $pageTranslation = ZoneTranslation::where(['zone_id' => $pageId,'language' => $data->language])->first();
        
        if($pageTranslation == NULL){
            $pageTranslation = new ZoneTranslation();
            $pageTranslation->zone_id = $record->id;
            $pageTranslation->language = $data->language;
        }
        
        $pageTranslation->title             = isset($data->title) ? $data->title :  $pageTranslation->title;
        $pageTranslation->subtitle          = isset($data->subtitle) ? $data->subtitle :  $pageTranslation->subtitle;
        $pageTranslation->second_title      = isset($data->second_title) ? $data->second_title :  $pageTranslation->second_title;
        $pageTranslation->second_subtitle   = isset($data->second_subtitle) ? $data->second_subtitle :  $pageTranslation->second_subtitle;
        $pageTranslation->third_title       = isset($data->third_title) ? $data->third_title :  $pageTranslation->third_title;
        $pageTranslation->third_subtitle    = isset($data->third_subtitle) ? $data->third_subtitle :  $pageTranslation->third_subtitle;
        $pageTranslation->content           = isset($data->content) ? $data->content :  $pageTranslation->content;
   //     $pageTranslation->url               = $this->linkModel->getUrl() == NULL ? $pageTranslation->url : $this->linkModel->getUrl();
        $pageTranslation->save();
        
        $this->linkModel->update(['table_id' => $record->id], true);
        $this->response->setStatus(true)->out();
        
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $page  = Model::find($id);
        
        if($page != NULL){
            
            $this->linkModel->setType('landing_'.$page->type);
            
            $return = $page->toArray();
            $return['translate'] = $this->getLanguageContent($page->id,$page->code,$page->type);
            $this->response->setStatus(true)->setData($return)->out();
        }
        
        $this->response->out();
    }
    
    public function fetch($type = '') {
        
        $data = \Helper\Input::json();
        
        $page  = Model::where('type',$type)->where('code',$data->table_id)->where('route',$data->route)->first();
       
        if($page != NULL){
            
            $parent = null;
            
            if($page->type == 'country'){
               $parent =  \Model\Region\Country::where('id',$page->code)->first();
            }else if($page->type == 'state') {
               $parent = \Model\Region\State::where('id',$page->code)->first();
            }
        
            $this->linkModel->setType('landing_'.$page->type);
            
            $return = $page->toArray();
            $return['translate'] = $this->getLanguageContent($page->id,$page->code,$parent);
            $return['zone_code'] = (string)$parent->traffics_code;
            $this->response->setStatus(true)->setData($return)->out();
        }
        
        $this->response->out();
    }
    
    public function replace($zone) {
       
        $data =  \Core\App::$linkData;
        $meta =  $this->view->meta;
                
        $data['title']       = str_replace('{#region_name#}',$zone['name'],$data['title']);
        $data['description'] = str_replace('{#region_name#}',$zone['name'],$data['description']);
        $data['keywords']    = str_replace('{#region_name#}',$zone['name'],$data['keywords']);
        $data['alternates']  = $meta['alternates'];
        
        $url  = \Helper\Config::getDomain();
        
        if($url == 'akin.at'){
            $data['title']       = \Helper\Replace::to($data['title']);
            $data['description'] = \Helper\Replace::to($data['description']);
            $data['keywords']    = \Helper\Replace::to($data['keywords']);
        }
          
        return $data;
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        $this->linkModel->setType('landing_'.$record->type);
        $this->linkModel->delete(['table_id' => $id]);
        
        ZoneTranslation::where('zone_id',$id)->delete();
        $this->response->setStatus(true)->out();
    }     
    
    public function filterTranslate() {
        
        $params   = $_GET;
        $language = $this->language;
        
        if(!empty($params['language'])){
            $language = $params['language'];
        }
        
        return function ($q) use ($params,$language){
            
            $q->where('language', $language);
            if(!empty($params['name'])){
                $q->where('title', 'LIKE','%'.$params['name'].'%');
            }
            if(!empty($params['url'])){
                $q->where('url', 'LIKE','%'.$params['url'].'%');
            }
            
       };
    }
    // LANGUAGE
    public function getLanguageContent($id,$code,$parent = null) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '', 'content' => '' ,'url' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = ZoneTranslation::where(['zone_id' => $id , 'language' => $language->code])->first();
            
            if($translate!= NULL) {
                $add['title']               = $translate->title;
                $add['subtitle']            = $translate->subtitle;
                $add['second_title']        = $translate->second_title;
                $add['second_subtitle']     = $translate->second_subtitle;
                $add['third_title']         = $translate->third_title;
                $add['third_subtitle']      = $translate->third_subtitle;
                $add['content']             = $translate->content;
                $add['url']                 = $translate->url;
            }
            
            if($parent !== null ) { 
                foreach(array_keys($add) as $key => $val){
                    $add[$val] =  str_replace('{#region_name#}',$parent->name,$add[$val]);
                }
            }
            $add['meta']    = $this->linkModel->getMeta(['table_id' => $code , 'language' => $language->code]);

            array_push($return,$add);
        }
        
        return $return;        
    }
}
