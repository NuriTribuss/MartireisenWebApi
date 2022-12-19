<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Block\All;
use Model\Block\Favourite;

class Block extends Service{
    
    
    public function __construct() {
        
        $opts = ['cache' => true,'max-age' => 3600];
        parent::__construct($opts);
        $this->dbCache->setTimeout(60*60*12);
    }

    public function getWeekBlocks() {
        
        $this->dbCache->setKey('weekblocks');
        $data = $this->dbCache->pull();
        if($data == false){ 
            
            try {
                $blockModel = new All();
                $data       = $blockModel->getWeekBlocks();
                $this->dbCache->put($data);
            }catch(\Exception $e){
                $data = [];
            }
            
        }        
        
        $this->response->setData($data)->setStatus(true)->out();
    }
    
    public function getFavourites() {
        
        $this->dbCache->setKey('favourites');
        $data = $this->dbCache->pull();
        
        if($data == false){
            $data  = Favourite::where(['is_active' => 1])->skip(0)->take(5)->orderBy('id','desc')->get();
            $data  = $data->toArray();
            foreach($data as $index => $d){
                $data[$index]['name_sef'] = \Helper\Url::beautify($d['name']); 
            }
            $this->dbCache->put($data);
        }        
        
        $this->response->setData($data)->setStatus(true)->out();
    }
    
    public function getTopOffers() {
        
        $this->dbCache->setKey('topoffers');
        $data = $this->dbCache->pull();
        if($data == false){
            $blockModel = new All();
            $data       = $blockModel->getTopOffers();
            $this->dbCache->put($data);
        }        
        
        $this->response->setData($data)->setStatus(true)->out();
    }
    
    public function getTopRegions() {
        
        $this->dbCache->setKey('topregions');
        $data = $this->dbCache->pull();
        
        if($data == false){
            $blockModel = new All();
            $data       = $blockModel->getTopRegions();
            $this->dbCache->put($data);
            
        }
        
        $this->response->setData($data)->setStatus(true)->out();
    }
        
}
