<?php

namespace Core\Structure;
use Illuminate\Database\Capsule\Manager as DB;

class Closure {
    
    private $table;
    private $db;
    private $depthColumn      = 'depth';
    private $ancestorColumn   = 'ancestor';
    private $descendantColumn = 'descendant';
    
    public $ancestor;
    public $descendant;
    
    public function __construct($table = '' ) {
        
        if($table !== '') {
            $this->table = $table;
        }
    }
    
    function getTable() {
        return $this->table;
    }
 
    function setTable($table) {
        $this->table = $table;
    }
    
    public function insertNode($ancestorId, $descendantId)
    {
      
        if(!is_int($descendantId) || !is_int($descendantId)) {
            return false;
        }
        
        $query = "
            INSERT INTO {$this->table} ({$this->ancestorColumn}, {$this->descendantColumn}, {$this->depthColumn})
            SELECT tbl.{$this->ancestorColumn}, {$descendantId}, tbl.{$this->depthColumn}+1
            FROM {$this->table} AS tbl
            WHERE tbl.{$this->descendantColumn} = {$ancestorId}
            UNION ALL
            SELECT {$descendantId}, {$descendantId}, 0
        ";
       
        $obj = DB::insert($query);
        return $obj;
        
    }
    

    public function moveNodeTo($ancestorId = null)
    {
        $thisAncestorId   = $this->ancestor;
        $thisDescendantId = $this->descendant;
        
        if (!is_null($ancestorId) && $thisAncestorId === $ancestorId) {
            return;
        }
        $this->unbindRelationships();

        if (is_null($ancestorId)) {
            return;
        }
        $query = "
            INSERT INTO {$this->table} ({$this->ancestorColumn}, {$this->descendantColumn}, {$this->depthColumn})
            SELECT supertbl.{$this->ancestorColumn}, subtbl.{$this->descendantColumn}, supertbl.{$this->depthColumn}+subtbl.{$this->depthColumn}+1
            FROM {$this->table} as supertbl
            CROSS JOIN {$this->table} as subtbl
            WHERE supertbl.{$this->descendantColumn} = {$ancestorId}
            AND subtbl.{$this->ancestorColumn} = {$thisDescendantId}
        ";
        $obj = DB::insert($query);
        return $obj;
    }
    
    protected function unbindRelationships()
    {
       
        $descendant = $this->descendant;
        
        $query = "
            DELETE FROM {$this->table}
            WHERE {$this->descendantColumn} IN (
              SELECT d FROM (
                SELECT {$this->descendantColumn} as d FROM {$this->table}
                WHERE {$this->ancestorColumn} = {$descendant}
              ) as dct
            )
            AND {$this->ancestorColumn} IN (
              SELECT a FROM (
                SELECT {$this->ancestorColumn} AS a FROM {$this->table}
                WHERE {$this->descendantColumn} = {$descendant}
                AND {$this->ancestorColumn} <> {$descendant}
              ) as ct
            )
        ";
        $obj = DB::delete($query);
        return $obj;
        
    }

}