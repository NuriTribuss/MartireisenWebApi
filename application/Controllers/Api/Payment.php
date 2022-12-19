<?php

namespace Application\Api;

use Core\Base\Webservice;
use Model\Booking\PaymentMethod as Model;
use Model\Booking\PaymentMethodTranslation as PaymentTranslation;
use Model\Booking\Credential;

class Payment extends Webservice {

    protected $isPublic = false;

    public function __construct() {
        parent::__construct();
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
        echo __METHOD__;
    }
    
    public function update($id = 0) {
        
        $data   = \Helper\Input::json();
       
        $record = Model::find($id);
        if($record == NULL){
            $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->sort_number = isset($data->sort_number) ? (int)$data->sort_number : $record->sort_number;
        $record->is_active   = isset($data->is_active)   ? (int)$data->is_active   : $record->is_active;
        $record->save();
        
        $paymentTranslation = PaymentTranslation::where(['payment_id' => $id ,'language' => $this->language])->first();
        
        if($paymentTranslation == NULL){
            $paymentTranslation = new PaymentTranslation();
            $paymentTranslation->payment_id = $record->id;
            $paymentTranslation->language = $data->language;
        }
        
        $paymentTranslation->title                       = isset($data->title) ? $data->title :  $paymentTranslation->title;
        $paymentTranslation->description                = isset($data->description) ? $data->description :  $paymentTranslation->description;

        $paymentTranslation->save();
        
        if(isset($data->credential)){
            $arr = (array)$data->credential;
            foreach($arr as $k => $a){
                
                $credential = Credential::where(['payment_id' => $id , 'field' => $k ])->first();
                if($credential != null){
                   $credential->value = $a;
                   $credential->save(); 
                }
                
            }
        }
        
        $this->response->setStatus(true)->out();

    }
    
    public function translate($methodId = 0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'title'     => 'required',
            'language' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = Model::find($methodId);
        
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        if(strlen($data->language) != 2 ){
             $this->response->setMessage('Language Not Found')->out();
        }
     
        $paymentTranslation = PaymentTranslation::where(['payment_id' => $methodId ,'language' => $data->language])->first();
        
        if($paymentTranslation == NULL){
            $paymentTranslation = new PaymentTranslation();
            $paymentTranslation->payment_id = $record->id;
            $paymentTranslation->language = $data->language;
        }
        
        $paymentTranslation->title                      = isset($data->title) ? $data->title :  $paymentTranslation->title;
        $paymentTranslation->description                = isset($data->description) ? $data->description :  $paymentTranslation->description;
        $paymentTranslation->save();
                
        $this->response->setStatus(true)->out();
    }
    
    public function show($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
            $this->response->setMessage('Record Not Found')->out();
        }
        
        $credential = Credential::where('payment_id',$record->id)->get();
       
        $return = $record->toArray();
        $return['translate'] = $this->getLanguageContent($id);
        $return['credential'] = [];
        foreach($credential as $c){
            $return['credential'][$c->field] = $c->value;
        }
        $this->response->setStatus(true)->setData($return)->out();

    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
    
    public function getLanguageContent($id) {
        
        $return = [];
        $languages = \Model\Localization\Language::all();
        
        foreach($languages as $language){
            
            $add        = array('language' => $language->code , 'title' => '', 'description' => '' , 'default' => $language->code == $this->language ? 1 : 0);
            $translate  = PaymentTranslation::where(['payment_id' => $id , 'language' => $language->code])->first();
            if($translate!= NULL) {
                $add['title']                       = $translate->title;
                $add['description']                 = $translate->description;
            }

            array_push($return,$add);
        }
        
        return $return;        
    }
}
