<?php

namespace Application\Api\Marketing;

use Core\Base\Webservice;
use Helper\Excel;
use Model\Campaign\Affilate as Model;
use Model\Link\LinkList as Link;
use Model\Region\HalalHotel;
use Model\Tour\Tour;

class Affilatelink extends Webservice {

    public function __construct() {
        parent::__construct();
    }

    public function get() {

        try{
            $model = $this->build(Link::whereRaw('1 = 1'));
            $model = $model->where('type','affilatelink');
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

    public function excel(){
        $data = $this->build(Model::whereRaw('1 = 1'))->orderBy('id','DESC')->get()->toArray();
        $excel = new Excel();
        $excel->data = $data;
        $excel->excel();
    }


    public function store() {

        $data = \Helper\Input::json();

        $this->validation->validate([
            'seo_url' => 'required',
            'route' => 'required'
        ]);

        $link = Link::where(array('table_id' => -1 , 'type' => 'affilatelink' , 'value' => $data->seo_url))->first();
        $Otherlink = Link::where('table_id','!=',-1)->where('type','!=','affilatelink')->where('value',$data->seo_url)->first();

        if($Otherlink != null){
            $this->response->setStatus(false)->setMessage('Seo url in other types is exist!')->out();
        }

        if($link === NULL){
            $link = new Link;
        }

        $data->seo_url = str_replace(" ","-",$data->seo_url);


        $link->value       = $data->seo_url;
        $link->table_id    = -1;

        $link->type             = 'affilatelink';
        $link->route            = $data->route;
        $link->redirect_value   = $data->route;
        $link->locale           = 'de';

        $link->title       = $data->seo_url;
        $link->keywords    = '';
        $link->description = '';

        $link->save();

        $this->response->setStatus(true)->setData(['inserted' => $link->id])->out();

    }

    public function show($id = 0) {

        if(empty((int)$id)){
            $this->response->out();
        }

        $return = NULL;
        $code = Link::find($id);
        if($code != NULL){
            $return = $code->toArray();
            $this->response->setStatus(true)->setData($return)->out();

        }

        $this->response->out();

    }

    public function destroy($id = 0) {

        $record = Link::find($id);
        if($record == NULL){
            $this->response->setMessage('Record Not Found')->out();
        }

        $record->delete();
        Link::where(['id' => $id, 'type'=>'affilatelink','table_id'=>-1])->delete();

        $this->response->setStatus(true)->out();
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
