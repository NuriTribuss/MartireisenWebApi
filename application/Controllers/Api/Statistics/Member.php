<?php

namespace Application\Api\Statistics;

use Core\Base\Webservice;
use Model\Customer\Customer as Model;

class Member extends Webservice {

    use Helper;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
    }
    
    public function summary($param = 'today') {
        
        if(!in_array($param, ['today','week','month','year'])){
            $this->response->out();
        }
        $date = $this->date($param);
        $this->getSummary(['date' => $date]);
    }
    
    public function getSummary($params) {
        
        try {
            
            //$totalAmount = Model::where('created_at','>=', $params['date'])->get()->sum('order_total');
            $totalSales  = Model::where('created_at','>=', $params['date'])->get()->count();

            $data = [
                'total_members'  => $totalSales,
                'total_record'   => $totalSales,
                'total_amount'   => '-',
                'date'         => date('d.m.Y', strtotime($params['date']))

            ];

            $this->response->setData($data)->setStatus(true)->out();
            
        } catch (Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }
        
    }
}
