<?php


namespace Application\Api\Booking\Tour;

use Core\Base\Webservice;
use Model\Tour\Age as Model;

class Age extends Webservice { 
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
         try{
             
            $model = $this->build(Model::whereRaw('1=1'));
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
    
 
    
}
