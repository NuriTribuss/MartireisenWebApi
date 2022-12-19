<?php

namespace Model\Region;

use \Illuminate\Database\Eloquent\Model;

class State  extends Model{

    protected $table    = 'region_states';
    protected $fillable = array('name', 'code','country_code');

    public $timestamps = false;


}
