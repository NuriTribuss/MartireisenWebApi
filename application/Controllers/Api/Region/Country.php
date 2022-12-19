<?php

namespace Application\Api\Region;

use Core\Base\Webservice;
use Model\Region\Defaults\Country as Model; 

class Country extends Webservice {

    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
            
            $model = $this->build(Model::whereRaw('1 = 1'));
            
            $pagination = [
                'page'  => \Helper\Input::get('page',1)
            ];
            
            $skip   = $pagination['page'] == 1 ? 0 : (($pagination['page'] -1) * $this->limit);
            $data   = $model->skip($skip)->take($this->limit)->get();
            $pagination['total'] = $model->count();
            
            $this->response->setStatus(true)->setMeta($this->paginate($pagination))->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
    
   
}
