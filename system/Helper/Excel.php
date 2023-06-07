<?php

namespace Helper;

class Excel
{
    public $data;

    private function cleanData($str)
    {
        if(gettype($str)!='string'){
            foreach ($str as $key=>$value){
                $str[$key]=$this->cleanData($value);
            }
        }else {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        return $str;
    }

    public function excel()
    {
        // return an Excel file data
        $flag = FALSE;
        foreach($this->data as $row) {
            $this->cleanData($row);
            if(!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = TRUE;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit;
    }

    public function excel_file(){
        // return an Excel file
        $filename = "website_data_" . rand(10000,99999999999) . ".xls";
        $this->set_headers($filename);
        $flag = FALSE;
        foreach($this->data as $row) {
            $this->cleanData($row);
            if(!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = TRUE;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
        exit;
    }

    private function set_headers($filename){
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header("Content-Type: application/vnd.ms-excel");
    }

}