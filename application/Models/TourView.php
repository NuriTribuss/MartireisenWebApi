<?php

namespace Model;

use Model\Tour\Plan;
use Model\Tour\PlanTranslation;
use Model\Tour\Image;
use Model\Tour\Video;
use Model\Tour\Period;
use Model\Tour\Tour;
use Model\Tour\TourTranslation;
use Model\Tour\Property;
use Model\Tour\TourProperty;
use Model\Tour\PropertyTranslation;
use Model\Tour\Station;
use Model\Tour\Type;

class TourView {
    
    
    private $dbCache;
    private $language;
    
    public function __construct() {
        
        $this->language = User\Customer::getLanguage();
    }
    
    public function get($id) {
        
        $this->dbCache = new \Core\Cache\DbCache('db/tour/'.(int)$id);
        $this->dbCache->setTimeout(300);
        
        $key  = 'tour_'.$id.'_';
        $this->dbCache->setKey($key);
        $data = $this->dbCache->pull(); 
        $data = false;
        if($data != false) {
            return $data;
        }
        $tour = Tour::find($id);
        if($tour == null){
            return false;
        }
        $tour = $tour->toArray();
        $tour['images']  = Image::where('tour_id',$id)->get()->toArray();
        
        
        $translate  = TourTranslation::where('tour_id',$id)->where('language', $this->language)->first();
        if($translate != null) {
            $tour['title'] = $translate->name;
            $tour['seo_url'] = $translate->url;
            $tour['content'] = $translate->content;
            $tour['agreegment'] = $translate->agreegment;
        }
        
        $tour['videos']  = Video::where('tour_id',$id)->get()->toArray();

        $tour['periods'] = Period::where('tour_id',$id)->where('start_date','>=',time())->orderBy('start_date','ASC')->get()->toArray();
        $tour['plans']   = $this->getPlan($id);
        
        
        $properties = TourProperty::where(['is_active' => 1 , 'tour_id' => $id])->get();
        
        if($properties != NULL){
            $properties = $properties->toArray();
            foreach($properties as $key =>  $property){
                $title = PropertyTranslation::where('property_id',$property['property_id'])->where('language', $this->language)->first();
                $properties[$key]['title'] = $title->name;
                $properties[$key]['is_static'] = 0; //$title->is_static;
            }
        }else{
            $properties = [];
        }
        
        foreach($tour['periods'] as &$period){
            $period['stations'] = Station::where('period_id',$period['id'])->orderBy('sort_number', 'asc')->get()->toArray();
            $period['start_date_pretty'] = date('d.m.Y',$period['start_date']);
            $period['end_date_pretty'] = date('d.m.Y',$period['end_date']);
        }
        
        $tour['period']     = $this->getPeriod($tour['periods']);
        $tour['price']      = $tour['period']['stations'][0]['price'];
        $tour['base_price'] = $tour['is_discounted'] == 1 ? (($tour['price'] / 100) * 115) : 0;
        $tour['properties'] = $properties;      
        $tour['type']       = $this->getType($tour['type']);
        
        $this->dbCache->put($tour);
        return $tour;
    }
    
    public function getPlan($tour_id) {
        
        $data   = Plan::with(['translate' => function($q) {
            $q->where('language',$this->language);
        }])->where('tour_id',$tour_id)->skip(0)->take(10)->get();
        
        foreach($data as $i=> $d){
            $data[$i]->title   = $d->translate->name;
            $data[$i]->content = $d->translate->content;
        }
        
        return $data->toArray();
    }
    
    public function getSummary($opts) {
        
        $tour = $this->get($opts['tour_id']);
        $key    = array_search($opts['period_id'], array_column($tour['periods'], 'id'));
        $period = $tour['periods'][$key];
        
        if(empty($period)){
            return false;
        }
        
        $key    = array_search($opts['station_id'], array_column($period['stations'], 'id'));
        $station = $period['stations'][$key];
        
        if(empty($station)){
            return false;
        }
        
        $childPrice = $station['child_price'] >  0 ? $station['child_price'] : $station['price'];
        $total = (floatval($station['price']) * (int)$opts['adult'] )+((int)$opts['children']*$childPrice);
        
        $summary = array(
            'tour'      => $tour,
            'period'    => $period,
            'station'   => $station,
            'adult'     => $opts['adult'],
            'children'  => $opts['children'],
            'bus_payment' =>  $period['start_date'] <= (time() + (60*60*24*1)),
            'total' => $total
        );
        
        return $summary;
    }
    
    public function getPeriod($periods) {
        
        $diff   = 0;
        $activePeriod = [];
        
        foreach($periods as $period){
            if($period['start_date'] < time()){
                continue;
            }
            
            $tmp = $period['start_date'] - time();
            if($diff == 0 || $tmp < $diff){
                $activePeriod = $period;
                $diff = $tmp;
            }
        }
        
        return $activePeriod;
    }
    
    public function getType($type) {
        
        $type = explode(';', $type);
        if(count($type) < 0 ){
            return '';
        }
        
        $return  = '';
        $results = Type::whereIn('code', $type)->get();
        foreach($results as $result){
            $translate = \Model\Tour\TypeTranslation::where(['language' => $this->language , 'type_id' => $result->id])->first();
            $return.= $translate->name.',';
        }
        
        return rtrim($return,',');
    }
    
    public function deleteCacheById($id) {
        
        $file = new \Core\Storage\File();
        $file->setPath(\Helper\Config::get('CACHE_DIR','/cache/').'db/tour/'.(int)$id);
        return $file->delete();
    }
}