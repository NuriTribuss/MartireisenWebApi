<?php

namespace Model\Region;

use \Illuminate\Database\Eloquent\Model;

class City  extends Model{

    protected $table    = 'region_cities';
    protected $fillable = array('name', 'code','state_code','state_name');

    public $timestamps = false;


}
