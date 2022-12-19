<?php

namespace Model\Link;

use Model\Link\LinkList;
use Model\Localization\Language;

class Link { 
    
    private $type = NULL;
    private $url  = NULL;
    private $language;
    
    public function __construct() { 
        $this->language = Language::where('is_default',1)->first()->code;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function setLanguage($language) {
        $this->language = $language;
    }
    
    public function setEmptyUrl() {
        $this->url = null;
    }
    
    public function setUrl($url , $name = '') {
        if(empty($url)){
            $url = $name;
        }
        
        $this->url = \Helper\Url::beautify($url);
    }
    
    public function getLanguage() {
        return $this->language;
    }
    
    public function getUrl() { 
        return $this->url;
    }
    
    public function exists($id = 0, $language = '') {
        
        $args = [
            'value' => $this->url,
        ];
      
        if(empty($language)) {
            $language = $this->language;
        }
       
        $record  = LinkList::where($args)->first();        
        if($record != NULL && $record->table_id != $id){
            return true;
        }
        
        if($record!= NULL && $record->locale != $language){
            return true;
        }
        
        return false;
        
    }
    
    public function save($opts) {
        
        $linklist =  new LinkList;
        $linklist->value       = $this->url;
        $linklist->type        = $this->type;
        $linklist->locale      = $this->language;
        
        if(isset($opts['route'])){
            $linklist->route       = $opts['route'].'/'.$opts['table_id'];
        }else{
            $linklist->route       = $this->type.'/detail/'.$opts['table_id'];
        }
        
        $linklist->table_id    = $opts['table_id'];
        $linklist->title       = '';
        $linklist->description = '';
        $linklist->keywords    = '';
        
        $data   = \Helper\Input::json();
        if(isset($data->meta)) {
            $linklist->title          = isset($data->meta->title)       ? $data->meta->title          : '';
            $linklist->description    = isset($data->meta->description) ? $data->meta->description    : '';
            $linklist->keywords       = isset($data->meta->keywords)    ? $data->meta->keywords       : '';
        }
        
        $linklist->save();
    }
    
    public function generate($record) {
        
        $link   = LinkList::where('value',$record->url)->first();
        
        if($link == null){
            $link = new LinkList();
            $link->value       =  $record->url;
            $link->type        =  $this->type;
            $link->locale      =  $this->language;
            $link->route       =  $this->type.'/detail/'.$record->id;
            $link->table_id    =  $record->id;
        }
        
        $link->title       =  $record->title;
        $link->description =  $record->description;
        $link->keywords    =  $record->keywords;
        $link->save();
    }
    
    public function getMeta($opts) {
        
        $args = [
            'type'     => $this->type,
            'table_id' => $opts['table_id'],
            'locale'   => $opts['language'] ? $opts['language'] : $this->language
        ];
        
        $record = LinkList::where($args)->first(['title','description','keywords']);
        if($record == null ){
            return ['title' => '' , 'description' => '', 'keywords' => ''];
        }
        return $record->toArray();
        
    }
    
    public function update($opts ,$upsert = false) {
        
        $args = [
            'type'      => $this->type,
            'table_id'  => $opts['table_id'],
            'locale'    => $this->language
        ];
        
       
        $record = LinkList::where($args)->first();
       
        if($record == NULL){
            if($upsert){
                return  $this->save($opts);
            }
            return false;
        }
        
        if($record->value != $this->url && $this->url != NULL){
            $record->value = $this->url;
        }
        
        $data   = \Helper\Input::json();
        
        if(isset($data->meta)) {
            $record->title          = isset($data->meta->title)       ? $data->meta->title          : $record->title;
            $record->description    = isset($data->meta->description) ? $data->meta->description    : $record->description;
            $record->keywords       = isset($data->meta->keywords)    ? $data->meta->keywords       : $record->keywords;
        }
        
        $record->save();
    }
    
    public function delete($arr) {
        $arr['type'] = $this->type;
        return LinkList::where($arr)->delete();
    }

    
    public function getByValue($value) {
        
        if(empty($value)){
            
            $homepage = array(
                'table_id'      => 1,
                'type'          => 'system',
                'value'         => '',
                'title'         => \Helper\Setting::get('seo_title'),
                'description'   => \Helper\Setting::get('seo_description'),
                'url'           => \Helper\Config::get('SITE_URL'),
                'keywords'      => '',
            );
            
            return $homepage;
        }
        
        $link = LinkList::where('value',$value)->first();
        
        if($link != NULL){
            return $link->toArray();
        }
        
        return false;
    }
}
