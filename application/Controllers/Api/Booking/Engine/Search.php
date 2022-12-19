<?php

namespace Application\Api\Booking\Engine;

use Core\Base\Webservice;
use Elasticsearch\ClientBuilder;

class Search extends Webservice {

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
            var_dump($e->getMessage());
        }
        
        $country_code = \Helper\Input::get('country_code','');
        $state_code = \Helper\Input::get('state_code','');
        $type = \Helper\Input::get('type','');
        $start = \Helper\Input::get('start', 0);
        $length = \Helper\Input::get('length', 20);

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
        
        if(!empty($type)){
             foreach($data as $index => $d){
               
                if($type != $d['_source']['type']){
                    unset($data[$index]);
                }
            }
        }
       
        $response = array(
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => array_values($data)
        );
       

        $this->response->isRaw()->setData($response)->out();
        
    }
    
    public function store() {
        die();
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'code' => 'required',
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;        
        $record->code           = $data->code;
        $record->name           = isset($data->name) ? (string)$data->name : '';
        $record->is_active      = isset($data->is_active) ? (int)$data->is_active : 1;
        
        $record->save();
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
    }

    
    public function update($id = 0) {
         
        $data = \Helper\Input::json();
       
        $this->validation->validate([
            '_id'                   => 'required',
            'keywords'              => 'required',
            'traffics_code'         => 'required',
            'name'                  => 'required',
            'type'                  => 'required',
            
        ]);
            
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'states',
            'id' => $data->_id,
            'body' => [
                'doc' => [
                    'keywords' => explode(',', $data->keywords),
                    'name'     => $data->name,
                    'traffics_code' => $data->traffics_code,
                    'type' => $data->type,
                    //'code'     => $code
                ]
            ]
        ];
      
        $response = $client->update($params);
        $this->response->setStatus(true)->out();
        
      
    }
    
    public function show($id = 0) {
        
        if(empty((int)$id)){
            $this->response->out();
        }
        
        $return = NULL;
        $code = Model::find($id);
        if($code != NULL){
            $return = $code->toArray();
            $this->response->setStatus(true)->setData($return)->out();

        }
        
        $this->response->out();

    }
   
}
