<?php

/*
 *     
        $p->property_id = $post->id;
        $p->tour_id = $tour_id;
        $p->is_active = $post->is_active;
        $p->is_free = $post->is_free;
        $p->price = $post->price;
        $p->save();
 */

namespace Application\Api\Booking\Tour;

use Core\Base\Webservice;
use Model\Tour\Property as Model;
use Model\Tour\TourProperty;
use Model\Tour\PropertyTranslation;
use Model\Localization\Language;

class Property extends Webservice {
    
    public $tourId;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
        
        $properties   = Model::with(['translate' => function($q) {
            $q->where('language',$this->language);
        }])->skip(0)->take(100)->get()->toArray();
        
        foreach($properties as $key =>  &$property){
            
            $property['is_active'] = 0;
            $property['is_free'] = 1;
            $property['price'] = 0;
            
            $record = TourProperty::where(['property_id' => $property['id'] , 'tour_id' => $this->tourId])->first();
            if($record != NULL && $record->is_active == 1){
                $property['is_active'] = $record->is_active;
                $property['is_free']   = $record->is_free;
                $property['price']     = $record->price;
            }
        }
       
        $this->response->setStatus(true)->setData($properties)->out();
    }    
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $record = Model::find($id);
        
        if($record != NULL){
            
            $return    = $record->toArray();
            $return['translate'] = $this->getLanguageContent($id);
            $this->response->setStatus(true)->setData($return)->out();
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
        
        $record = new Model;    
        $record->title             = isset($data->name) ? (string)$data->name : '';
        $record->save();
        
        $pageTranslation = new \Model\Tour\PropertyTranslation();
        $pageTranslation->language      = $this->language;
        $pageTranslation->property_id   = $record->id;
        $pageTranslation->name          = $data->name;
        $pageTranslation->save();
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }
    
    public function update($id = 0) {
       
        $data = \Helper\Input::json();
      
        $record = TourProperty::where(['tour_id' => $this->tourId , 'property_id' => $data->id])->first();
        if($record == NULL){
            $p = new TourProperty();
        }else{
            $p = $record;
        }
        $p->property_id = $data->id;
        $p->tour_id = $this->tourId;
        $p->is_active = $data->is_active;
        $p->is_free = $data->is_free;
        $p->price = $data->price;
        $p->save();
            
        $this->response->setStatus(true)->out();
    }
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        $this->response->setStatus(true)->out();
    }   
    
    public function translate($pageId =0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'name'     => 'required',
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
        
        $pageTranslation = PropertyTranslation::where(['property_id' => $pageId,'language' => $data->language])->first();
        
        if($pageTranslation == NULL){
            $pageTranslation = new PropertyTranslation();
            $pageTranslation->property_id   = $record->id;
            $pageTranslation->language      = $data->language;
        }
        
        $pageTranslation->name              = isset($data->name) ? $data->name :  $pageTranslation->name;
        $pageTranslation->save();
        
        $this->response->setStatus(true)->out();
        
    }
    
         // LANGUAGE
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'name' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = PropertyTranslation::where(['property_id' => $id , 'language' => $language->code])->first();
            
            if($translate!= NULL) {
                $add['name']     = $translate->name;
            }

            array_push($return,$add);
        }
        
        return $return;        
    }
}
