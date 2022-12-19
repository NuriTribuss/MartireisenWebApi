<?php

namespace Application\Api\Booking\Tour;

use Core\Base\Webservice;
use Model\Tour\Video as Model;

class Video extends Webservice {
    
    public $tourId;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
            $this->limit = 20;
            $model = $this->build(Model::where(['tour_id' => $this->tourId]));
            $pagination = [
                'total' => $model->count(),
                'page'  => \Helper\Input::get('page',1)
            ];
            
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->skip($skip)->take($this->limit)->get();
        
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data->toArray())->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }    
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $record = Model::find($id);
        
        if($record != NULL){
            
            $return    = $record->toArray();
            $this->response->setStatus(true)->setData($return)->out();
        }               
        
        $this->response->out();

    }
    
    public function store() {
        
        $data = \Helper\Input::json();
        
        $video              = new Model();
        $video->tour_id     = $this->tourId;
        $video->embed       = $data->embed;
       
        $video->save();
        $this->response->setStatus(true)->setData(['id' => $video->id])->out();
    }
    
    public function update($id = 0) {
       
        echo __METHOD__;
        
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
    
}