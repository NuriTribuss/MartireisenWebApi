<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Region\Airport;
use Model\Region\Departure;
use Model\Localization\Translate;

class  Airports extends Service{

    public function __construct() {
        $opts = ['cache' => true,'max-age' => 3600];
        parent::__construct($opts);
    }

    public function get() {

        $this->dbCache->setKey('airports');
        $result = $this->dbCache->pull();

        if($result == false){
            
            $result    = [];
            $translate = new Translate();
            $language  = \Core\Translation\Language::getLanguage();

            $departures = Departure::where(['is_active' => 1])->orderBy('sort_number','asc')->get();

            foreach($departures as $key => $departure){

                $items = Airport::where(['is_active' => 1 , 'country_code' => $departure->code])->orderBy('sort_number','asc')->get();

                $result[$key] = array(
                    'name'  => $translate->get($departure->code, 'DepartureTitle', $language , $departure->name),
                    'code'  => $departure->code,
                    'items' =>  $items != NULL ? $items->toArray() : []
                );

                foreach($result[$key]['items'] as &$item){
                    $item['name'] = $translate->get($item['code'], 'AirportTitle', $language , $item['name']);
                }
            }
            $this->dbCache->put($result);
        }

        $this->response->setData($result)->setStatus(true)->out();

    }
}
