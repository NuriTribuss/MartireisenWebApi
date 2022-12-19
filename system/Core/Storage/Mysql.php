<?php

namespace Core\Storage;

use PDO;

class Mysql extends PDO {

    private static $instance; 
    private $connection = null;
    private $query;
    private $paramsArr;
    private $error;
    private $selectStr;
    private $fromStr;
    private $whereStr;
    private $limitStr;
    private $orderByStr;

    function __construct() {
        $this->reset();
    }

    static public function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function reset() {
        
        $this->sqlStr = null;
        $this->query = null;
        $this->paramsArr = array();
        $this->error = null;

        $this->selectStr = '*';
        $this->fromStr = null;
        $this->whereStr = '';
        $this->limitStr = '';
        $this->orderByStr = '';
    }


    public function prepare($statement, $driver_options = array()) {
        
        $this->connect();
        return parent::prepare($statement, $driver_options);
    }

    public function connect() {
        
        if (null === $this->connection) {
            
            $host =  \Helper\Config::get("HOST");
            $user =  \Helper\Config::get("USER");
            $pass =  \Helper\Config::get("PASS");
            $db   =  \Helper\Config::get("DB");
            
            try {
                $dns = "mysql:host=" . $host . ";dbname=" . $db . ';charset=utf8';
                parent::__construct($dns, $user, $pass);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection = true;
                
            } catch (PDOException $e) {
                $this->errorHandler(false, true);
                die('Mysql Error..');
            }
        }
    }

    private function errorHandler($result, $notConnect = false) {

        if ($result == false) {

            $this->error = mysql_error();
            var_dump($this->error);

            return false;
        }
        return true;
    }

    private function runParams() {
        foreach ($this->paramsArr as $name => &$value) {
            switch (gettype($value)) {
                case 'integer':
                    $this->query->bindValue(':' . $name, $value, PDO::PARAM_INT);
                    break;
                default:
                    $this->query->bindValue(':' . $name, $value, PDO::PARAM_STR);
                    break;
            }
        }
    }
    
    public function getQuery() {
        return $this->query;
    }

    public function sql($sql) {
        $this->sqlStr = $sql;
        return $this;
    }

    public function params($params, $param2 = '') {
        if (gettype($params) == 'string') {
            $params = array($params => $param2);
        }

        $this->paramsArr = $params;
        return $this;
    }

    private function createSql() {
        
        if (!empty($this->fromStr)) {
            $this->sqlStr = 'Select ' . $this->selectStr . ' FROM ' .
                    $this->fromStr . ' ' . $this->whereStr . ' ' . $this->orderByStr . ' ' . $this->limitStr;
        } else if (!empty($this->limitStr) && strpos($this->sqlStr, 'LIMIT') === FALSE) {
            $this->sqlStr .= ' ' . $this->limitStr;
        }

        return $this->sqlStr;
    }

    public function row($field = '') {
        
        $this->limit(1);
        if(!empty($field)){
            $this->select($field);
        }
        $this->query = $this->prepare($this->createSql());
        $this->runParams();
        $this->query->execute();
        $r = $this->query->fetch(\PDO::FETCH_ASSOC);
        $this->reset();
        if (empty($r)) {
            return $field == '' ? array() : '';
        }
        return $field == '' ? $r : $r[$field];
    }

    public function result() {
        
        $this->query = $this->prepare($this->createSql());
        $this->runParams();
        $this->query->execute();
        $result = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        $this->reset();
        return $result;
    }

    public function doWhile($fn) {
        $this->query = $this->prepare($this->createSql());
        $this->runParams();
        $this->query->execute();

        while ($row = $this->query->fetch(\PDO::FETCH_ASSOC)) {
            $fn($row);
        }
        $this->reset();
    }

    public function select($select = '*') {
        $this->selectStr = preg_replace('/[^`\w,\*\.\(\)<> ]/si', '', $select); //izin verilen karakterler a-zA-Z0-9,*
        return $this;
    }

    public function from($table) {
        $this->fromStr = preg_replace('/\W/si', '', $table);
        return $this;
    }

    public function where($param1, $param2 = '') {
        
        $where = gettype($param1) == 'array' ? $param1 : array($param1 => $param2);
        $dizi = array();
        foreach ($where as $name => &$value) {
            $newParams['w_' . $name] = $value;
            $dizi[] = "$name=:w_$name";
        }
        $this->whereStr = 'WHERE ' . implode(' AND ', $dizi);
        $this->paramsArr = $newParams;
        return $this;
    }

    public function limit($start = 1, $perPage = 0) {
        
        $start = (int) $start;
        $perPage = (int) $perPage;
        $this->limitStr = $perPage > 0 ? "LIMIT $start,$perPage " : "LIMIT $start";
        return $this;
    }
    
    public function orderBy($param1, $param2 = ''){
        
        $arr = gettype($param1) == 'array' ? $param1 : array($param1 => $param2);
        $n = array();
        foreach($arr as $k => $v){
            $n[] = $k . ' ' . $v;
        }
        if(count($n) > 0){
            $this->orderByStr = ' ORDER BY ' . implode(' , ', $n);
        }
        return $this;
    }

    public function insert($tbl, $arr) {
        
        $columns = array();
        $values = array();
        foreach ($arr as $name => &$value) {
            $columns[] = '`' . $name . '`';
            $values[] = ':' . $name;
        }

        $tbl = preg_replace('/\W/si', '', $tbl);
        $columns = implode(',', $columns);
        $values = implode(',', $values);

        $arr2 = array();
        foreach ($arr as $a => $b) {
            $arr2[':' . $a] = $b;
        }
        
        $query = $this->prepare("INSERT INTO $tbl ($columns) VALUES ($values);");
        $query->execute($arr);
        $this->reset();
        
        return $this->lastInsertId();
    }

    public function update($table, $updateArr, $whereArr, $limit = 1) {
        
        $limit = (int) $limit;
        $table = preg_replace('/\W/si', '', $table);

        $set = array();
        foreach ($updateArr as $key => $val) {
            $set[] = " $key=:$key ";
            $this->paramsArr[$key] = $val;
        }
        $set = implode(',', $set);

        $where = array();
        foreach ($whereArr as $key => $val) {
            $where[] = "$key=:w_$key ";
            $this->paramsArr["w_$key"] = $val;
        }
        $where = implode(' AND ', $where);
        $sql = " UPDATE `$table` SET $set WHERE $where LIMIT $limit ";

        $this->query = $this->prepare($sql);
        $this->runParams();
        $r = $this->query->execute();
        $this->reset();
        return $r;
    }

    public function delete($table, $whereArr) {
        
        if (empty($whereArr)) {
            die('Tüm kayıtlar silinemez!!!');
        }

        $table = preg_replace('/\W/si', '', $table);
        $where = array();
        foreach ($whereArr as $key => $val) {
            $where[] = "$key=:w_$key ";
            $this->paramsArr["w_$key"] = $val;
        }
        $where = implode(' AND ', $where);
        $this->query = $this->prepare("DELETE FROM $table WHERE $where");
        $this->runParams();

        $r = $this->query->execute();
        $this->reset();
        return $r;
    }

    public function toString() {
        return $this->sqlStr;
    }

}
