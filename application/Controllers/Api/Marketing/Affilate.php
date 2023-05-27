<?php

namespace Application\Api\Marketing;

use Core\Base\Webservice;
use Model\Campaign\Affilate as Model;
use Model\Link\LinkList as Link;
use Model\Region\HalalHotel;
use Model\Tour\Tour;

class Affilate extends Webservice {

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
            $data   = $model->skip($skip)->take($this->limit)->orderBy('id','DESC')->get()->toArray();
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
        
    public function store() {
        
        $data = \Helper\Input::json();
        
        $this->validation->validate([
            'destination_type' => 'required',
            'seo_url'          => 'required'
        ]);
        
        if($this->validation->hasError()){
            $this->response->setErrors($this->validation->getErrors())->out();
        }
        
        $record = new Model;        
        $record->destination_type           = $data->destination_type;
        $record->destination_value          = isset($data->destination_value) ? $data->destination_value : '';
        $record->destination_name           = isset($data->destination_name) ? $data->destination_name : '';
        $record->departure_name             = isset($data->departure_name) ? (int)$data->departure_name : '';
        $record->departure_code             = isset($data->departure_code) ? (string)$data->departure_code : '';
        $record->date_start                 = isset($data->date_start) ? (string)$data->date_start : '';
        $record->date_end                   = isset($data->date_end) ? (string)$data->date_end : '';
        $record->adult                      = isset($data->adult) ? (string)$data->adult : '';
        $record->children                   = isset($data->children) ? (string)$data->children : '';

        $record->travel_type                = isset($data->travel_type) ? (string)$data->travel_type : '';
        $record->travel_api                 = isset($data->travel_api) ? (string)$data->travel_api : '';
        $record->seo_url                    = isset($data->seo_url) ? (string)$data->seo_url : '';
        $record->operators                  = isset($data->operators) ? (string)implode($data->operators,'/') : '';

        $record->is_active                  = 1;


        
        $record->save();
        $this->generate($record->toArray());
        
        $this->response->setStatus(true)->setData(['inserted' => $record->id])->out();
       
    }
    
    public function update($id = 0) {
       
       
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
    
    public function destroy($id = 0) {
        
        $record = Model::find($id);
        if($record == NULL){
             $this->response->setMessage('Record Not Found')->out();
        }
        
        $record->delete();
        Link::where(['type'=>'affilate','table_id'=>$record->id])->delete();

        $this->response->setStatus(true)->out();
    }     
    
    public function generate($param) {

        $link = Link::where(array('table_id' => $param['id'] , 'type' => 'affilate'))->first();

        if($link === NULL){
            $link = new Link;
        }

        $link->value       = $param['seo_url'];
        $link->table_id    = $param['id'];
        
        $link->type             = 'affilate';
        $link->route            = $this->makeRoute($param);
        $link->redirect_value   = $link->route;
        $link->locale           = 'de';
        
        $link->title       = $param['destination_name'];
        $link->keywords    = $param['destination_name'];
        $link->description = $param['destination_name'];


        return $link->save();

    }
    
    public function makeRoute($param) {
        
        if($param['travel_api'] == 'HalalBooking'){
            return $this->makeRouteHalal($param);
        }
        if($param['travel_api'] == 'Tour'){
            return $this->makeRouteTour($param);
        }
        $arr = array(
            'sf' => $param['travel_type'],
            'adults' => $param['adult'],
            'date' => array(
                'start' => empty($param['date_start']) ? \Carbon\Carbon::now()->addDay(7)->format('Y-m-d') : $param['date_start'],
                'end'   => empty($param['date_end'])   ? \Carbon\Carbon::now()->addMonth()->addDay(8)->format('Y-m-d') : $param['date_end'] 
            ),
            'departure' => array(
                'code' => $param['departure_code']
            ),
            'destination' => array(
                'name' => $param['destination_name'],
                'code' => $param['destination_value'],
                'type' => $param['destination_type'],
            ),

        );


        $end = strtotime($arr['date']['end']);
        $start = strtotime($arr['date']['start']);
        $datediff = $end - $start ;
        $arr['duration'] = intval(round($datediff / (60 * 60 * 24)));

        
        if((int)$param['children'] > 0 ){
            $arr['children'] = [];
            for($i = 0 ; $i < $param['children']; $i++){
                $arr['children'][] = [
                    'jahre' => 6,
                    'percent' => 35.29
                ];
            }
        }
        
        $prefix = '';
        
        switch($param['destination_type']){
            case "hotel":
                $prefix = '/search/hotel-offers';
                break;
            
            case "state" :
                $prefix = '/search/hotels';
                break;
            
            default : 
                $prefix = 'search/region';
                break;
        }
        
        $link = $prefix.'?'.http_build_query($arr);
        return $link;
    }
    
    public function makeRouteHalal($param) {

        $arr = array(
            'date' => array(
                'start' => empty($param['date_start']) ? \Carbon\Carbon::now()->addDay(7)->format('Y-m-d') : $param['date_start'],
                'end'   => empty($param['date_end'])   ? \Carbon\Carbon::now()->addMonth()->addDay(8)->format('Y-m-d') : $param['date_end']
            ),
            'destination' => array(
                'name' => $param['destination_name'],
                'code' => $param['destination_value'],
                'type' => $param['destination_type'],
            ),
            'adults' => $param['adult'],
        );
        
        $prefix = '/halal-booking/hotel-offers';
        $link = $prefix.'?'.http_build_query($arr);
        return $link;
    }
    public function makeRouteTour($param){
        $selectedTour = Tour::find($param['destination_value']);
        $arr = array(
            'date' => $param['date_start'],
        );

        $prefix = '/tour/' . $selectedTour->seo_url . '?tid=' . $selectedTour->id;
        $link = $prefix.'&'.http_build_query($arr);
        return $link;
    }
    
    public function searchHotel ($param) {
        
        $opts = \Helper\Input::json();
        if($opts->api == 'TravelIT') {
            $traffics = new \Model\Api\Client\Traffics();
            $result = $traffics->searchHotel($param);
        }else if($opts->api == 'HalalBooking'){
            $query = HalalHotel::where('name','LIKE','%'.$param.'%')->get()->toArray(); 
            foreach($query as $index => $item){
                $query[$index]['location'] = [
                    'name' => $item['region']
                ];
            }
            $result = [
                'giataHotelList' => $query
            ];
        }
       
        $this->response->setData($result)->setStatus(true)->out();
        
    }
}
