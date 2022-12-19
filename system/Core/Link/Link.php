<?php

namespace Core\Link;
 
class Link {
    
    private $db;
    private $value;
    private $table = 'links';
    public $where = array();
    private $sql = '';

    
    function __construct() {
        $this->db = \Drivers\Mysql::getInstance();
    }
    
    function getValue() {
        return $this->value;
    }

    function setValue($value) {
        $this->value = $value;
    }   
    
    public function get($start = 0 , $length = 100) {
        
        $fields = '*';
        $sql = 'SELECT '.$fields.' FROM '.$this->table;
        
        $sql.= $this->getWhereStr();
        
        if(strpos($sql, 'link_language') == false){
             $sql.= ' AND link_language = "tr"';
        }
       
        $sql.= ' ORDER BY link_id DESC';
        $sql.= ' LIMIT '.$start.','.$length;
        $this->sql = $sql;
        return $this;
        
    }
    
    public function total() {
        return $this->db->sql('SELECT COUNT(*) AS total FROM '.$this->table.' WHERE 1=1  AND link_language = "tr" ')->row('total');
    }
    
    public function row(){
        
        $return = $this->db->sql($this->sql)->row();
        $this->sql = '';
        $this->where = array();
        return $return;
    }
    
    public function result() {
        
        $return = $this->db->sql($this->sql)->result();
        $this->where = array();
        $this->sql = '';
        return $return;
    }
   
    public function exists($value = '') {
        
        if($value === ''){
            $value = $this->value;
        }
        
        if(trim($value === '')) {
            return false;
        }
        
        $query = $this->db->sql('SELECT * FROM links WHERE link_value = :value')->params('value',$value)->row();
        if(count($query) === 0 ){
            return true;
        }
        return false;
    }
    
    public function insert($arr) {
        
        $check = $this->exists($arr['link_value']);
        if($check !== false) {
            $arr['link_title']     = isset($arr['link_title'])     ? $arr['link_title'] : '';
            $arr['link_type']     = isset($arr['link_type'])     ? $arr['link_type'] : 'Other';
            $arr['link_language'] = isset($arr['link_language']) ? $arr['link_language'] : 'tr';
            $arr['link_created_time'] = isset($arr['link_created_time']) ? $arr['link_created_time'] : time();
            return  $this->db->insert($this->table,$arr);
        }
        return false;
    }
    
    public function update($arr,$id) {
        
        $check = true;
        if(isset($arr['link_value'])){
            $check = $this->exists($arr['link_value']);
        }
        
        if(isset($arr['link_id'])){
            unset($arr['link_id']);
        }
       // var_dump($arr);
        //var_dump(array('link_table_id' => $id , 'link_language' => (isset($arr['link_language']) ? $arr['link_language'] : 'tr')));
        if($check !== false) {
            return $this->db->update($this->table, $arr, array('link_table_id' => $id ,'link_type' => $arr['link_type'] , 'link_language' => (isset($arr['link_language']) ? $arr['link_language'] : 'tr')));
        }
        return false;
    }
    
    public function updateRecord($table,$arr,$where) {
        return $this->db->update($table,$arr,$where);
    }
    
    public function delete($value) {
        
        $record = $this->getByValue($value);         
        return $this->db->delete($this->table, array('link_route' => $record['link_route']));
    }
    
    public function getByValue($url) {  
        $query = $this->db->sql('SELECT * FROM links WHERE link_value=:value')->params('value',$url)->row();
        return $query;
    }
    
    public function getById($id) {  
        $query = $this->db->sql('SELECT * FROM links WHERE link_id=:value')->params('value',$id)->row();
        return $query;
    }
    
    public function getByRoute($route) {  
        $query = $this->db->sql('SELECT * FROM links WHERE link_route=:value')->params('value',$route)->result();
        return $query;
    }
    
      
    public function getWhereStr() {
        
        $whereStr = ' WHERE 1=1 ';
        foreach($this->where as $k => $v) {
            $whereStr.= ' AND '.$k.' = "'.$v.'" ';
        }
        return $whereStr;
    }
}