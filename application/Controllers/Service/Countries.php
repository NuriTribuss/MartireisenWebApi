<?php

namespace Application\Service;

use Model\Region\Country;
use Model\Region\Defaults\Country as CountryDefault;

class Countries extends \Core\Base\Service{

    public function __construct() {
        $opts = ['cache' => true,'max-age' => 3600];
        parent::__construct($opts);
    }

    public function get() {
        
        $this->dbCache->setKey('countries');
        $data = $this->dbCache->pull();
        
        if($data == false){
            $data = Country::where(array('is_active' => 1))->orderBy('name','ASC')->limit(500)->get();
            $this->dbCache->put($data);
        }        
        
        $this->response->setData($data)->setStatus(true)->out();

    }
    
    public function getDefaults() {
        
        $language =  \Core\Translation\Language::getLanguage();
       
        $this->dbCache->setKey('countries_default');
        $data = $this->dbCache->pull();
        
        if($data == false){
            $data = CountryDefault::where(array('flag' => 1))->orderBy('sort_number','ASC')->orderBy('name','ASC')->limit(500)->get();
            foreach($data as $index => $d){
                $data[$index]->code = $d->iso2;
                
                switch($language){
                    case 'tr' :
                        $data[$index]->name = $d->name_tr;
                        break;
                    case 'de' :
                        $data[$index]->name = $d->name_de;
                        break;
                    default:
                        $data[$index]->name = $d->name;
                        break;
                }
            }
            $this->dbCache->put($data);
        }        
        
        $this->response->setData($data)->setStatus(true)->out();

    }   

}
