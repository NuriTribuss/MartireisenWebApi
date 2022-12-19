<?php

namespace Core\Migration;;

class MysqlGrammar {
      
    public function compileTableExists(){
        return 'select * from information_schema.tables where table_schema =:db and table_name =:table';
    }
    
    public function compileColumnListing(){
        return 'select * from information_schema.columns where table_schema = :db and table_name = :table';
    }
    
    public function compileColumnType(){
        return 'select * from information_schema.columns where column_name =:column and table_schema = :db and table_name = :table';
    }

}