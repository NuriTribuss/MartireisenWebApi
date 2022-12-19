<?php

namespace Core\Storage;

use Core\Base\Model;
use Core\Storage\Mysql;

class DbStorage extends Mysql {
    
    private $table;
    
    public function __construct(){
        parent::__construct();
    }

    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function find($opts) {

        if(!is_array($opts)){
            $opts = array('id' => $opts);
        }        
        return $this->select()->from($this->table)->where($opts)->row();
        
    } 
    
    public function findAll($opts = array()) {
        
        if(!is_array($opts)){
            $opts = array('id' => $opts);
        }        
        if(count($opts) === 0){
            
            return $this->select()->from($this->table)->result();
        }
        return $this->select()->from($this->table)->where($opts)->result();
        
    }

    public function delete($opts = NULL) {
        
        if($opts == NULL){
            return false;
        }
        if( !is_array($opts)){
            $opts = array('id' => $opts);
        }   
        return $this->delete($this->table, $opts);
    }

    public function save(Model $object) {
        
        if ($object->getId() ==  0) {
            
            $values =  $object->toArray();
            $insert =  $this->insert($this->table, $values);
            
            if($insert !== false){
                $object->setId($insert);
                return $object;
            }
            return false;
             
        }
        
        $values = $object->toArray();
        
        $opts   = array('id' => $object->getId());
        $update = $this->update($this->table, $values , $opts);
        
        if($update !== false){
            return $object;
        }
        return false;

    }
    
    public function query($query) {
        return $this->sql($query)->result();
    }


}