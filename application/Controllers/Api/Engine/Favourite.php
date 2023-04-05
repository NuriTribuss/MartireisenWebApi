<?php

namespace Application\Api\Engine;

use Core\Base\Service;
use Model\Block\Favourite as Model;

class Favourite extends Service {

    public function __construct() {
        parent::__construct();
    }

    public function get() {
        try{

            $model = Model::whereRaw('1 = 1');

            $data   = $model->get()->toArray();

            $this->response->setStatus(true)->setData($data)->out();

        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage())->http(400);
        }

        $this->response->out();
    }
}
