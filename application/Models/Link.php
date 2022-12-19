<?php

namespace Model;

use \Illuminate\Database\Eloquent\Model;

class Link  extends Model{

    protected $table = 'links';
    protected $guarded = ['id'];

    public function check($value = '' , $opts = array()){

        if(empty($value)){
            return false;
        }

        $where = array('value' => $value);

        $data = self::where($where)->first();

        if($data === NULL){
            return true;
        }

        $record = $data->toArray();

        if(isset($opts['table_id']) &&  (int)$record['id'] > 0 && $record['table_id'] === $opts['table_id']){
            return true;
        }

        return (int)$record['id'] > 0 ? false : true;

    }
    
    public function getAlternates($record) {
        
        $alt = self::select('value','locale')->where(['route' => $record['route']])->get();
        $return = [];
        
        if(count($alt) > 0 ){
            $alternates = $alt->toArray();
            foreach($alternates as $a){
                $a['value'] = rtrim($a['value'],'/');
                $return[$a['locale']] = $a['value'].'/'; 
            }
            if($record['table_id'] == 1){
                $return['de'] = '';
            }
            $record['alternates'] = $return;
        }
        
        return $record;
    }
    
    public function getHome() {
        return  [
            'route' => 'index/index',
            'locale' => 'de',
            'table_id' => 1,
            
        ];
    }

    public function findByValue($value) {
        
        $dbCache = new \Core\Cache\DbCache('db/routes');
        
        $key = strip_tags($value);
        if(empty($key)){
            return false;
        }
        $value = str_replace(' ','%20',$value);
        $dbCache->setKey($key);
        $data = $dbCache->pull();
        
        if($data == false){
            
            $data = self::where(array('value' => $value))->first();
            if($data !== NULL){
                $data = $data->toArray();
                $dbCache->put($data);
                return $data;
            }else{
                $data = self::where(array('route' => $value))->first();
                if($data === null){
                    return false;
                }
                
                $data = $data->toArray();
                $dbCache->put($data);
                return $data;
                
            }
        }else{
            return $data;
        }
        
        return false;
    }

}
