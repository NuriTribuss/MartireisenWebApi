<?php

namespace Model;

use \Illuminate\Database\Eloquent\Model;

class Setting  extends Model{

    protected $table = 'settings';

    public function set($key,$val){

        $old     = \Helper\Setting::get($key);
        $update  = \Helper\Setting::set($key, $val);

        return $update;
    }
}
