<?php

namespace Core\Migration;

class Converter {
    
    public $table  = '';
    public $all    = false;
    public $isData = false;
    public $db;
    
    public function __construct() {
        $this->db = \Drivers\Mysql::getInstance();
    }
    
    public function output() {
        
        if($this->all == false && $this->table == ''){
            return false;
        }
        
        if($this->isData){
            return $this->convertData();
        }
        
        return $this->convertStruct();
        
    }
    
    public function convertStruct() {
        
        if($this->all){
            return $this->convertAll();
        }
        
        return $this->convertTable();
    }
    
    public function convertTable() {
        
        $data = $this->db->sql("SHOW FULL columns FROM `$this->table`")->result();

        $fullArr1 = array();
        $fullArr2 = array();

        foreach ($data as $d) {

            preg_match_all('/(.*)\(([\w\,\']*)/s', $d['Type'], $matches);

            $arr = array(
                'name' => trim($d['Field']),
                'type' => @$matches[1][0] ?: $d['Type'],
                'default' => $d['Default'],
                'null' => $d['Null'] == "YES" ? true : false,
                'length' => @$matches[2][0] ?: "",
                'comment' => $d['Comment']
            );


            $fullArr[] = $arr;
        }

        $result = array(
            'type' => 'table',
            'name' => $this->table,
            'columns' => $fullArr
        );

        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function convertAll() {
        
        $tables = $this->db->sql('SHOW TABLES')->result();
        
        foreach ($tables AS $table) {
            
            $table      = current($table);
            $data       = $this->db->sql("SHOW FULL COLUMNS FROM `$table`")->result();
            $keyColumns = $this->db->sql("SHOW KEYS FROM `$table`")->result();

            $fullArr = [];
            
            foreach ($data AS $columnIndex => $d) {
                
                preg_match_all('/(.*)\(([\w\,\']*)/s', $d['Type'], $matches);
                $type = explode('(', $d['Type'])[0];
                $typeLength = @explode('(', $d['Type'])[1];
                $typeLength = explode(')', $typeLength)[0];
                $arr = array(
                    'name' => trim($d['Field']),
                    'type' => $type,
                    'length' => $typeLength,
                    'comment' => str_replace(array('\'', '""'), '', $d['Comment'])
                );

                if (trim($d['Field']) != 'id') {
                    if ($d['Default'] != '') {
                        $arr['default'] = $d['Default'];
                    }
                    $arr['null'] = $d['Null'] == 'YES' ? true : false;
                }

                foreach ($keyColumns AS $keyColumn) {
                    if (trim($d['Field']) == $keyColumn['Column_name'] && $keyColumn['Key_name'] != 'PRIMARY') {
                        $arr['columnKeys'][] = [
                            'keyName' => $keyColumn['Key_name'],
                            'nonUnique' => $keyColumn['Non_unique'],
                            'indexType' => $keyColumn['Index_type'],
                        ];
                    }
                }

                array_push($fullArr, $arr);
            }
            $result = array(
                'type' => 'table',
                'name' => $table,
                'columns' => $fullArr
            );

            $a = file_put_contents(PATH.'/resources/migrations/' . $table . '.structure.json', json_encode($result, JSON_PRETTY_PRINT));
            if ($a != '') {
                echo $table . '.structure.json OK <br>';
            } else {
                echo $table . '.structure.json ERROR <br>';
            }
        }
    }
    
    public function convertData() {
                
        $dataset    = $this->db->sql("SELECT * FROM `$this->table`")->result();
        $keyColumn  = $this->db->sql("SHOW KEYS FROM `$this->table` WHERE Key_name = 'PRIMARY'")->result()[0]['Column_name'];
        
        $mapping = array(
            'settings' => 'key',
            'users'    => 'username',
        );
        
        if(isset($mapping[$this->table])){
            $keyColumn = $mapping[$this->table];
        }
        
        $arr = array(
            'type'=>'table',
            'name'=> $this->table,
            'keyColumn'=>$keyColumn,
            'update'=>false,
            'data'=>array()
        );

        foreach ($dataset AS $data) {
            
            $keys = array_keys($data);
            $values = array_values($data);
            $d = array();
            foreach ($keys AS $index => $key) {
                $d[$key] = $values[$index];
            }
            array_push($arr['data'], $d);
            
        }
        
        echo json_encode($arr, JSON_PRETTY_PRINT);
        $a = file_put_contents(PATH.'/resources/migrations/' . $this->table.'.data.json', json_encode($arr, JSON_PRETTY_PRINT));
        
        if ($a != '') {
            echo $this->table.'.data.json OK <br>';
        }else{
            echo $this->table.'.data.json ERROR <br>';
        }
         
        
    }
}
