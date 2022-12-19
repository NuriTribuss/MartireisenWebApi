<?php

/*
 *  Kolay Kullanım İçin Yardımcı Fonksiyonlar İçerir
 *  11.09.2018
 */


function _lang($key = '',$print = false ){
    if($print){
        return  Core\Translation\Language::get($key);
    }
    echo Core\Translation\Language::get($key);
}

function theme_dir($print = false) {

    $theme        = \Helper\Setting::get('theme');
    $activeTheme  = $theme == false ? 'default' : $theme;

    $val =  '/themes/web/'.$activeTheme.'/';

    if($print){
        return $val;
    }
    echo $val;

}

function day_calculate($start,$end){
    
    $now = $end;  // or your date as well
    $your_date =$start;
    $datediff = $now - $your_date;

    return  round($datediff / (60 * 60 * 24));
}

function shipper_dir($print = false) {

    $val =  '/themes/shipper/';
    if($print){
        return $val;
    }
    echo $val;

}

function employer_dir($print = false) {

    $val =  '/themes/employer/';
    if($print){
        return $val;
    }
    echo $val;

}


function admin_dir($print = false) {

    $val =  '/themes/admin/ubold/';
    if($print){
        return $val;
    }
    echo $val;

}

function admin_url($prefix = '' , $print = false) {

    $val = '/'.\Helper\Config::get('ADMIN_URI').'/'.$prefix;
    if($print){
        return $val;
    }
    echo $val;
}

function admin($key,$print = false){

    $val = Model\User\Admin::get($key);
    if($print){
        return $val;
    }
    echo $val;
}


function ShellSortAsc($my_array, $filter){
    $x = round(count($my_array) / 2);
    while ($x > 0) {
        for ($i = $x; $i < count($my_array); $i++) {
            $temp = $my_array[$i];
            $j = $i;
            while ($j >= $x && (((int)$my_array[$j - $x]["ZIEL"][0][$filter]) > ((int)$temp["ZIEL"][0][$filter]))) {
                $my_array[$j] = $my_array[$j - $x];
                $j -= $x;
            }
            $my_array[$j] = $temp;
        }
        $x = round($x / 2.2);
    }
    return $my_array;
}

function ShellSortDesc($my_array, $filter){
    $x = round(count($my_array) / 2);
    while ($x > 0) {
        for ($i = $x; $i < count($my_array); $i++) {
            $temp = $my_array[$i];
            $j = $i;
            while ($j >= $x && (((int)$my_array[$j - $x]["ZIEL"][0][$filter]) < ((int)$temp["ZIEL"][0][$filter]))) {
                $my_array[$j] = $my_array[$j - $x];
                $j -= $x;
            }
            $my_array[$j] = $temp;
        }
        $x = round($x / 2.2);
    }
    return $my_array;
}
