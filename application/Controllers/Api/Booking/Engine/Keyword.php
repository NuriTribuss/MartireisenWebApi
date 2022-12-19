<?php

namespace Application\Api\Booking\Engine;

use Core\Base\Webservice;
use Elasticsearch\ClientBuilder;

class Keyword extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
           try {

            $client = ClientBuilder::create()->build();
            $params = [
                'index' => 'states',
                'type' => 'states',
                'body' => [
                    'from' => 0,
                    'size' => 1000,
                    'query' => [
                        "match_all" => [
                            '_name' => '',
                        ],
                    ],
                    'sort' => [
                        '_id' => 'desc'
                    ]
                ]
            ];



            $response = $client->search($params);
            $result = $response['hits']['hits'];
        } catch (\Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }
        
        $country_code   = \Helper\Input::get('country_code','');
        $state_code     = \Helper\Input::get('state_code','');

        $start          = \Helper\Input::get('start', 0);
        $length         = \Helper\Input::get('length', 20);

        $where = array();

        $data = $result;
        $total = count($result);
        
        if(!empty($country_code) && empty($state_code)){
             foreach($data as $index => $d){
               
                if($country_code != $d['_source']['country_code']){
                    unset($data[$index]);
                }
            }
        }
        
        if(!empty($state_code)){
             foreach($data as $index => $d){
               
                if($state_code != $d['_source']['state_code']){
                    unset($data[$index]);
                }
            }
        }
       
        $pagination = array(
            'total' => $total,
            'page' => 1,
        );
       
        $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData(array_values($data))->out();
    }
    
    public function store() {
        echo __METHOD__;
    }
    
    public function update($id = 0) {
       
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'code' => 'required',
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
        
        $record->code           = isset($data->code) ? (string)$data->code: $record->code;
        $record->name           = isset($data->name) ? (string)$data->name :$record->name;
        $record->is_active      = isset($data->is_active) ? (int)$data->is_active : $record->is_active;
        $record->save();
        
        $this->response->setStatus(true)->out();
    }
    
    public function show($id = 0) {
        echo __METHOD__;
    }
    
    public function destroy($id = 0) {
        echo __METHOD__;
    }     
}
