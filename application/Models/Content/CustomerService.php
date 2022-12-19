<?php

namespace Model\Content;

use \Illuminate\Database\Eloquent\Model;
use Model\Localization\Language;

class CustomerService  extends Model{

    protected $table = 'customer_services';

    public function getVersions($relation) {

        $languages = Language::where(array())->get();
        $versions  = [];

        foreach($languages as $key => $language){

            $data = self::where(array('locale' => $language['code'] , 'relation' => $relation))->first();
            $versions[$key] = array(
                'title'     => $language['title'],
                'code'      => $language['code'],
                'relation'  => $relation,
                'data'  => $data == NULL ? [] : $data->toArray()
            );
        }
        
        return $versions;
    }

}
