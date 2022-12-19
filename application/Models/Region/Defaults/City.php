<?php

namespace Model\Region\Defaults;

use \Illuminate\Database\Eloquent\Model;

class City  extends Model{

    protected $table    = 'cities';
    protected $fillable = array('name', 'code','country_code');

    public $timestamps = false;


}
