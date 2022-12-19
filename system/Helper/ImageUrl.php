<?php


namespace Helper;

class ImageUrl {

    public static function getSmall($record){
        return preg_replace('/\/([0-9]+)\//', '/$1/small/', $record['image']);
    }
    
    public static function getMedium($record){
        return preg_replace('/\/([0-9]+)\//', '/$1/medium/', $record['image']);
    }
    
    public static function getLarge($record){
        return preg_replace('/\/([0-9]+)\//', '/$1/large/', $record['image']);
    }
    
}