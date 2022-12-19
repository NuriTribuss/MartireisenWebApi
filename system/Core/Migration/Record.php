<?php

namespace Core\Migration;

use Core\Migration\MysqlGrammar;
use Core\Migration\Logger;

class Record {
  
    protected $connection;
    protected $grammar;
    protected $resolver;
    protected $table = '';
    protected $db;
    
    public $logger;
    
    public function __construct(){
        
        $this->db         = \Helper\Config::get('DB');
        $this->connection = \Drivers\Mysql::getInstance();
        
        $this->grammar    = new MysqlGrammar();
        $this->logger     = new Logger();

    }   
    
    public function getDb() {
        return $this->db;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
    }
    
    public function get($condition) {
        
        try{
            $record = $this->connection->select('*')->from($this->table)->where($condition)->row();
            return $record;
        }catch(\PDOException $e){
            $this->logger->log('Record -> get() -> '.$e->getMessage());
            return false;
        }
        
    }
    
    public function create($arr) {
       
        try{
            $record = $this->connection->insert($this->table, $arr);
            return $record;
        }catch(\PDOException $e){
            $this->logger->log('Record -> insert() -> '.$e->getMessage());
            return false;
        }
    }
    
    public function update($arr,$whereArr) {
        
        try{
            $record = $this->connection->update($this->table, $arr,$whereArr);
            return $record;
        }catch(\PDOException $e){
            $this->logger->log('Record -> update() -> '.$e->getMessage());
            return false;
        }
    }

}