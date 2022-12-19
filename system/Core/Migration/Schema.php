<?php

namespace Core\Migration;

use Core\Migration\MysqlGrammar;
use Core\Migration\Logger;

class Schema {
  
    protected $connection;
    protected $grammar;
    protected $resolver;
    protected $tablePrefix = '';
    protected $db;
    
    public $logger;
    
    public function __construct(){
        
        $this->db         = \Helper\Config::get('DB');
        $this->connection = \Drivers\Mysql::getInstance();
        
        $this->grammar    = new MysqlGrammar();
        $this->logger     = new Logger();

    }
  
    public function hasTable($table){
        
        $table = $this->tablePrefix.$table;
        $arr   = array('db' => $this->db,'table' => $table);
        return count($this->connection->sql($this->grammar->compileTableExists())->params($arr)->row()) > 0;
    }
  
    public function hasColumn($table, $column){
        return in_array(
            strtolower($column), array_map('strtolower', $this->getColumns($table))
        );
    }
   
    public function hasColumns($table, array $columns){
        
        $tableColumns = array_map('strtolower', $this->getColumns($table));
        foreach ($columns as $column) {
            if (! in_array(strtolower($column), $tableColumns)) {
                return false;
            }
        }
        return true;
    }
    
    public function getColumn($table, $column){
        
        $table   = $this->tablePrefix.$table;
        $arr     = array('column' => $column, 'db' => $this->db,'table' => $table );
        
        $result =$this->connection->sql($this->grammar->compileColumnType())->params($arr)->row();
        if($result == ''){
            return new \stdClass;
        }
        
        return (object)$result;
    }
    
    public function getColumns($table){
        
        $table  = $this->tablePrefix.$table;
        $arr    = array('db' => $this->db,'table' => $table);
        $result =$this->connection->sql($this->grammar->compileColumnListing())->params($arr)->result();
        if(count($result) == 0){
            return array();
        }
        
        return array_values(array_column($result, 'COLUMN_NAME'));
    }
  
    public function create($table){
        
        if(!isset($table->name) || !isset($table->columns)){
            return false;
        }
        
        $columns = '';
        $tableKeys = array();
        foreach($table->columns as $column){
            if (isset($column->columnKeys) && count($column->columnKeys) > 0) {
                foreach ($column->columnKeys AS $columnKey) {
                    $tableKeys[$columnKey->keyName][] = [
                        'keyName'=>$columnKey->keyName,
                        'nonUnique'=>$columnKey->nonUnique,
                        'indexType'=>$columnKey->indexType,
                        'columnName'=>$column->name
                    ];
                }
            }
            $columns.= $this->buildColumnStr($column).',';
        }

        $keyString = '';
        foreach ($tableKeys AS $tableKey) {
            $isUnique = $tableKey[0]['nonUnique'] == '0' ? ' UNIQUE ' : '';
            $indexType = $tableKey[0]['indexType'] == 'FULLTEXT'?' FULLTEXT ':'';
            $keyString .= ' , '.$isUnique . $indexType. " KEY `".$tableKey[0]['keyName']."`( ";
            foreach ($tableKey AS $index => $k) {
                $keyString .= '`'.$k['columnName'].'` ,';
            }
            $keyString = substr($keyString, 0, strlen($keyString) - 1);
            $keyString .=')';
        }

        $sql = 'CREATE TABLE `'.$table->name.'` ('. rtrim($columns,','). $keyString.' ) ENGINE=MyISAM DEFAULT CHARSET=utf8;' ;

        try{
            
            $query = $this->connection->prepare($sql);
            $result = $query->execute();
            if($result == true){
                $this->logger->log($table->name.' table created');
                return true;
            }
            
            return false;
            
        }catch(\PDOException $e){
            $this->logger->log($sql);
            $this->logger->log($e->getMessage());
            return false;
        }
        
    }
    
    public function addColumn($table,$column,$beforeColumn = '') {
        
        if(!isset($table) || !isset($column)){
            return false;
        }
        
        $str = $this->buildColumnStr($column);
        if($str == false){
            return false;
        }
        
        $sql = 'ALTER TABLE `'.$table.'` ADD '.$str;
        if ($beforeColumn != "") {
            $sql.= ' AFTER `'.$beforeColumn->name.'`';
        }
        try{
            $query = $this->connection->prepare($sql);
            $result = $query->execute();
            if($result == true){
                $this->logger->log($column->name.' column added  on '.$table);
                return true;
            }
            return false;
            
        }catch(\PDOException $e){
            $this->logger->log($sql);
            $this->logger->log($e->getMessage());
            return false;
        }
    }
    
    public function changeColumn($table,$column) {

        if(!isset($table) || !isset($column)){
            return false;
        }

        $str = $this->buildColumnStr($column);
        if($str == false){
            return false;
        }

        $sql = 'ALTER TABLE `'.$table.'` CHANGE `'.$column->name.'`'.$str;

        try{
            $query = $this->connection->prepare($sql);
            $result = $query->execute();
            if($result == true){
                $this->logger->log($column->name.' column changed on '.$table.'. Query : '.$str);
                return true;
            }
            return false;

        }catch(\PDOException $e){

            $this->logger->log($sql);
            $this->logger->log($e->getMessage());

            return false;
        }
    }

    public function removeColumn($table,$column) {

        if(!isset($table) || !isset($column)){
            return false;
        }


        $sql = 'ALTER TABLE `'.$table.'` DROP COLUMN `'.$column.'`';

        try{
            $query = $this->connection->prepare($sql);
            $result = $query->execute();
            if($result == true){
                $this->logger->log($column.' column removed on '.$table . '. Query : '. $sql);
                return true;
            }
            return false;

        }catch(\PDOException $e){

            $this->logger->log($sql);
            $this->logger->log($e->getMessage());

            return false;
        }
    }

    public function buildColumnStr($column) {
        
        if(!isset($column->name) || !isset($column->type)){
            return false;
        }
        
        $column->type = strtolower($column->type);
        $str = ' `'.$column->name.'` '.$column->type;
        
        if(!in_array($column->type,array('text','date','double','timestamp')) && $column->length != ''){
            $str.=  '('.$column->length.')';
        }

        if (isset($column->null) && $column->null == true) {
            $str.= '  NULL ';
        }else{
            $str.= '  NOT NULL ';
        }

        if($column->name == 'id' || @$column->inc == true){
            $str.= ' AUTO_INCREMENT ';
        }
        
        if($column->name == 'id' || @$column->primary == true){
            $str.= ' PRIMARY KEY ';
        }
        
        if(isset($column->comment) && $column->comment !== ''){
            $str.= ' COMMENT \''.$column->comment.'\'';
        }
        
        if(isset($column->default) && $column->default !== ''){
            if (($column->type == 'timestamp' || $column->type == 'datetime') && $column->default == 'CURRENT_TIMESTAMP') {
                $str.= ' DEFAULT '.$column->default;
            } else {
                $str.= ' DEFAULT \''.$column->default.'\'';
            }
        }
        
        return $str;
        
    }

    public function setConnection($connection){
        $this->connection = $connection;
        return $this;
    }
    
    public function getDb() {
        return $this->db;
    }

    public function setDb($db) {
        $this->db = $db;
    }

}