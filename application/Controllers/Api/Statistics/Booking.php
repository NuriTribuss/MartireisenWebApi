<?php

namespace Application\Api\Statistics;

use Core\Base\Webservice;
use Model\Booking\Booking as Model;

class Booking extends Webservice {

    use Helper;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get() {
        
        $arr = $this->dateArr();
        $return = [];
        foreach($arr as  $item){
            $return[] = $this->getDaily(['date' => $item]);
        }
        
        $this->response->setData($return)->setStatus(true)->out();
    }

    public function summary($param = 'today') {
        
        if(!in_array($param, ['today','week','month','year'])){
            $this->response->out();
        }
        $date = $this->date($param);
        $data = $this->getSummary(['date' => $date]);
        
        $this->response->setData($data)->setStatus(true)->out();
    }
    
    public function getSummary($params) {
        
        try {
            
            $totalAmount = Model::where('created_at','>=', $params['date'])->get()->sum('amount');
            $totalSales  = Model::where('created_at','>=', $params['date'])->get()->count();

            $data = [
                'total_sales'  => $totalSales,
                'total_record' => $totalSales,
                'total_amount' => $totalAmount,
                'date'         => date('d.m.Y', strtotime($params['date']))

            ];
            
            return $data;
            
            
        } catch (Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }
        
    }
    
    public function getDaily($params) {
        
        try {
            
            $totalAmount = Model::whereDate('created_at','=', $params['date'])->get()->sum('amount');
            $totalSales  = Model::whereDate('created_at','=', $params['date'])->get()->count();

            $data = [
                'total_sales'  => $totalSales,
                'total_record' => $totalSales,
                'total_amount' => $totalAmount,
                'date'         => date('d.m.Y', strtotime($params['date']))
            ];
            
            return $data;
            
            
        } catch (Exception $e) {
            $this->response->setMessage($e->getMessage())->http(400);
        }
    }
    
    public function activity() {
        
        $orders = Model::orderBy('id','DESC')->skip(0)->limit(5)->get()->toArray();
        foreach($orders as $index =>  $o){
            $orders[$index]['products'] = \Model\Ecommerce\Order\OrderProduct::where(['order_id' => $o['id']])->get()->toArray();
        }
        
        $this->response->setData($orders)->setStatus(true)->out();

    }
    
}
