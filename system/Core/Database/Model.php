<?php

namespace Core\Database;

class Model {

    protected $connection;
    protected $table;
    protected $timeLog = false;
    protected $baseFields = '*';
    protected $where = array();
    protected $order = array();
    protected $searchWord = '';
    protected $linkType = '';
   // public $linkModel;
    public $incrementing = true;
    private $driver;

    public function __construct($table = '') {

        $this->driver    = \Drivers\Mysql::getInstance();
       // $this->linkModel =  new \Model\Link();

        if($table !== ''){
            $this->table = $table;
        }
    }

    public function getTable() {
        return $this->table;
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function setLinkType($type) {
        $this->linkType = $type;
    }

    public function select($column = '*') {
        $this->driver->select($column);
        return $this;
    }

    public function from($table = '') {
        if($table == ''){
           $table = $this->table;
        }
        $this->driver->from($table);
        return $this;
    }

    public function limit($start= 0,$page = 0) {
        $this->driver->limit($start,$page);
        return $this;
    }

    public function sort($field,$type = 'ASC') {
        $this->driver->orderBy($field,$type);
        return $this;
    }

    public function result() {
        return $this->driver->result();
    }

    public function row($column = '') {
        return $this->driver->row($column);
    }

    public function where($param1,$param2='') {
        $this->driver->where($param1,$param2);
        return $this;
    }

    public function insert($tbl,$arr) {
        return $this->driver->insert($tbl, $arr);
    }

    public function update($table, $updateArr, $whereArr, $limit = 1) {
        return $this->driver->update($table, $updateArr, $whereArr, $limit);
    }

    public function delete($table,$whereArr) {
        return $this->driver->delete($table, $whereArr);
    }

    public function sql($sql) {
        return $this->driver->sql($sql);
    }

    public function getQuery() {
        return $this->driver->getQuery();
    }

    public function setSearchWord($word,$column='title') {
        $this->searchWord =  ' AND '.$column.' LIKE "'.$word.'%" ';
    }

    public function get($limit = 0 , $offset = false) {

        $fields = isset($this->where['id']) ? '*' : $this->baseFields;
        $sql = 'SELECT '.$fields.' FROM '.$this->table;
        $sql.= $this->getWhereStr();

        if(count($this->order) == 0 ){
            $sql.= ' ORDER BY id DESC';
        }else{
            $sql.= ' ORDER BY '.$this->order['column'].' '.$this->order['direction'];
        }

        if($offset !== false && $limit > 0){
            $sql.= ' LIMIT '.$offset.','.$limit;
        }else if($limit > 0 ){
            $sql.= ' LIMIT '.$limit;
        }

        $this->sql($sql);
        $this->baseFields = '*';

        return $this;
    }

    public function total() {
        $this->baseFields = ' COUNT(id) AS total ';
        return $this;
    }

    public function getWhereStr() {

        $whereStr = ' WHERE 1=1 ';
        foreach($this->where as $k => $v) {
            $whereStr.= ' AND '.$k.' = "'.$v.'" ';
        }

        if(!empty($this->searchWord)){
            $whereStr.= $this->searchWord;
        }

        return $whereStr;
    }

    public function er($column,$value,$operator = '=') {

        $sql = '';

        switch($operator){

            case  '=' :
                $sql = ' AND `'.$column.'` '.$operator.' "'. $value.'" ';
                break;

            case 'in' :
                $sql = ' AND `'.$column.'` IN ('. implode(',',$value).')';
                break;

        }

        return $sql;
    }

    public function getById($id = 0 ) {

        if((int)$id == 0){
            return false;
        }

        $sql = 'SELECT * FROM '.$this->table.' WHERE id='.$id;
        $this->sql($sql);
        return $this;
    }

    public function insertRecord($arr) {

        if($this->timeLog){
            $arr['created_at']  = isset($arr['created_at'])  ? $arr['created_at']  : time();
        }

        $insert  = $this->insert($this->table, $arr);
        if($insert !== false) {
            return $insert;
        }

        return false;
    }

    public function updateRecord($arr,$id) {

        if($this->timeLog){
            $arr['updated_at'] = isset($arr['updated_at']) ? $arr['updated_at'] : time();
        }

        $update  = $this->update($this->table, $arr, array('id' => $id));
        if($update !== false) {
            return true;
        }
        return false;
    }

    public function deleteRecord($items = 0) {

        if($items === 0){
            return false;
        }

        $items = is_array($items) ? $items : [$items];

        foreach($items as $item){

            if(empty($this->linkType)){
                $this->delete($this->table, array('id' => $item));
            }else{
                $record = $this->select('id,seo_url')->from($this->table)->where('id', $item)->row();
                $state  = $this->delete($this->table, array('id' => $item));
                if(isset($record['seo_url']) && trim($record['seo_url'])!==''){
                    //$this->linkModel->delete($record['seo_url'], $record['id']);
                }
            }

        }

        return $state;
    }

    public function __set($name, $value) {
        $this->{$name} = $value;
        $this->where[$name] = $value;
    }

    public function setOrder($order) {
        $this->order = $order;
    }


}
