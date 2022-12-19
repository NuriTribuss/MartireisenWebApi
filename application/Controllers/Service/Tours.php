<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Tour\Tour;
use Model\TourView;
use Model\Tour\Station;

use Illuminate\Database\Capsule\Manager as DB;

class Tours extends Service {

    public function __construct() {
        parent::__construct();
    }
    
    public function states() {
        
        $results = DB::select('select destination from tours WHERE active = 1 GROUP BY destination');
        $data = array_column($results, 'destination');
        $data = array_filter($data);
        
        
        $this->response->setData($data)->setStatus(true)->out();
    }
    
    public function periods() {
        
        date_default_timezone_set('Europe/Istanbul');

        $return = [];
        $results = DB::select('select  start_date from tours__periods WHERE start_date > '.time() .' GROUP BY start_date ORDER BY start_date ');
        foreach($results as $key => $item){
            $return[] = date('d.m.Y',$item->start_date);
        }
        $this->response->setData($return)->setStatus(true)->out();
    }
    
    public function stations() {
        
        $stations = Station::orderBy('station')->get();
        $stationArr = [];
        
        foreach($stations as $station){
            
            $period = \Model\Tour\Period::where('id',$station->period_id)->first();
            if($period == null || $period->start_date < time()){
                continue;
            }
            if(!in_array($station->station, $stationArr)){
                array_push($stationArr,$station->station);
            }
        }
        
        foreach ($stationArr as $key => &$e){
            if($e == 'Wien') {
                array_unshift($stationArr,$e);
                unset($stationArr[$key]);
            }
            $e = trim($e);
        } 
        
        
        
        $stationArr = array_values(array_unique($stationArr));
        $this->response->setData($stationArr)->setStatus(true)->out();
    }
    
    public function create() {
        
        $post = \Helper\Input::json();

        $tour = array(
            'tour_id'           => $post->tour_id,
            'period_id'         => $post->period->id,
            'station_id'        => $post->station_id,
            'adult'             => $post->adult,
            'children'          => $post->children
        );
        
        $tourView = new TourView();
        $summary = $tourView->getSummary($tour);
        
        $free = $summary['period']['available_count'];
        $travellers = $tour['adult']+ $tour['children'];
        
        if($travellers > $free){
            $this->response->out();
        }
        
        \Core\Session\Session::set('booking_tour', $tour);
        $this->response->setStatus(true)->out();
        
    }
    
    public function getSummary() { 
        
        $bookingObj = \Core\Session\Session::get('booking_tour');
        if($bookingObj == null) {
            $this->response->out();
        }
        
        $tourView = new TourView();
        $summary = $tourView->getSummary($bookingObj);
        
        
        $this->response->setData($summary)->setStatus(true)->out();
    }
}
