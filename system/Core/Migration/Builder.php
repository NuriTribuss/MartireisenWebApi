<?php

namespace Core\Migration;

use Core\Migration\Schema;
use Core\Migration\SchemaPostgresql;
use Core\Migration\Record;

class Builder {

    public $path;
    public $schema;
    public $record;
    public $languages;
    public $charset ='utf8';
    public $hardReset = false;
    private $type = 'mysql';

    public function __construct() {

        $this->path      = PATH.'/resources/migrations/';


        $this->schema    = $this->type == 'mysql' ? new Schema() : new SchemaPostgresql();
        $this->record    = new Record();
        $this->languages = $this->getLanguages();
    }

    public function run($hardReset = false,$data = true) {

        $this->hardReset = $hardReset;
        $this->schema->logger->log('Migration is starting');

        $migrations = $this->getMigrations();

        $this->schema->logger->log('Structure migrations is processing ..');
        $migrations['structure'] = array_unique($migrations['structure']);

        foreach($migrations['structure'] as $migration){
            $this->runStructure($migration);
        }
        $this->schema->logger->log('Data migrations is processing ..');

        if($data == true){
            foreach($migrations['data'] as $migration){
                $this->runData($migration);
            }
        }


        $this->schema->logger->log('Migration completed');
    }

    public function getMigrations() {

        $migrations = array(
            'structure' => [],
            'data'      => [],
        );

        if (is_dir($this->path)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->path, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $file) {

                if(!$file->isDir() && strpos($file->getFileName(), '.structure.json') !== false) {
                     $migrations['structure'][] = $file->getFilename();
                }

                if(!$file->isDir() && strpos($file->getFileName(), '.data.json') !== false) {
                     $migrations['data'][] = $file->getFilename();
                }

            }
        }
        return $migrations;
    }

    public function getLanguages() {

        $langs  = array();
        $path   = PATH . '/resources/langs';

        foreach (new \DirectoryIterator($path) as $file) {

            if ($file->isDot()){
                continue;
            }

            if ($file->isDir()) {
                array_push($langs, $file->getFilename());
            }
        }
        return $langs;
    }

    public function parseMigration($file) {

        if(file_exists($this->path.$file)){
            $decode = json_decode(file_get_contents($this->path.$file));
            if(json_last_error() !== JSON_ERROR_NONE) {
                return false;
            }
            return $decode;
        }
        return false;
    }

    /*  runStructure
     *  Tablo yapısını kontrol eder
     *  Migration dosyasına göre tablo olusturma , sütun ekleme , sütun düzeltme işlerini yapar
     */

    public function runStructure($migration) {

        $object = $this->parseMigration($migration);
        if($object == false){
            $this->schema->logger->log($migration.' file not a valid json');
            return false;
        }
        if($object->type == 'table' && $object->name != ''){
            $this->runTable($object);
        }
        return true;

    }

    public function runTable($object) {

        if($this->schema->hasTable($object->name) == false){
            $this->schema->create($object);
            return true;
        }
        if ($this->type != 'mysql') {
            return true;
        }
        $remoteColumns =(object)$this->schema->getColumns($object->name);
        $localColumns = array();

        foreach($object->columns as $index => $column){
            array_push($localColumns, $column->name);
            /// add column
            if(!$this->schema->hasColumn($object->name, $column->name)){
                $this->schema->addColumn($object->name,$column,($index > -1 ? $object->columns[$index -1]:''));
            }
            // change column
            $remoteColumn = $this->schema->getColumn($object->name, $column->name);
            $columnType   = strtolower($column->type);

            if(isset($column->default) && $column->default != $remoteColumn->COLUMN_DEFAULT){
                $this->schema->changeColumn($object->name, $column);
            }

            if ($columnType == 'varchar') {

                $remoteColumnLength = preg_replace('/(\w+)\((.*?)\)/si', '$2',$remoteColumn->COLUMN_TYPE);
                if ((int)$column->length < (int)$remoteColumnLength) {
                    continue;
                }
            }


            if(isset($column->length) && !empty($column->length)){
                $columnType.= '('.$column->length.')';
            }

            if($columnType != $remoteColumn->COLUMN_TYPE){
                $this->schema->changeColumn($object->name, $column);
            }


        }


        if ($this->hardReset === true) {
            foreach (array_diff((array)$remoteColumns,(array)$localColumns) AS $column) {
                $this->schema->removeColumn($object->name, $column);
            }
        }

        return true;

    }

    /*
     *  runData
     *  Tablo verilerini kontrol eder
     *  Migration dosyasına göre tabloya yeni kayıt atar, kayıt günceller
     */

    public function runData($migration) {

        $object = $this->parseMigration($migration);
        if($object == false){
            $this->schema->logger->log($migration.' file not a valid json');
            return false;
        }

        if(!isset($object->keyColumn)){
            $this->schema->logger->log($migration.' file has not a key column');
            return false;
        }

        $langCheck = (isset($object->language) && $object->language == true);

        if($langCheck &&  !isset($object->langColumn)){
            $this->schema->logger->log($migration.' file has not a lang column');
            return false;
        }

        if($object->type == 'table' && $object->name != ''){
            return $this->runRecords($object);
        }

        return true;
    }

    public function runRecords($object) {

        $updateProcess = false;
        if(isset($object->update) && $object->update === true){
            $updateProcess = true;
        }

        if(!isset($object->data) || count($object->data) <= 0){
            return false;
        }

        $this->record->setTable($object->name);

        $langCheck = (isset($object->language) && $object->language == true);
        $condition = array();

        $added = 0;
        $updated = 0;

        foreach($object->data as $row){

            if($langCheck){
                $condition[$object->langColumn] = $row->{$object->langColumn};
            }

            $condition[$object->keyColumn] = $row->{$object->keyColumn};
            $record = $this->record->get($condition);

            if(isset($object->keyColumn) && !isset($record[$object->keyColumn])){

                $id = $this->record->create((array)$row);
                if((int)$id > 0){
                    $this->record->logger->log('`'.$row->{$object->keyColumn}.'` record created');
                    $added++;
                }else{
                    $this->record->logger->log($row->{$object->keyColumn}.' record can not created');
                }
                continue;
            }

            if(isset($record['id']) && $updateProcess == true){

                $status = $this->record->update((array)$row,$condition);
                if($status != false){
                   // $this->record->logger->log($row->{$object->keyColumn}.' record updated');
                    $updated++;
                }else{
                    $this->record->logger->log($row->{$object->keyColumn}.' record can not update');
                }
                continue;
            }

        }
        $this->record->logger->log($object->name.' => '.$added.' Added | '.$updated .' Updated');
    }

}
