<?php

namespace Model\Localization;

class LanguageManagement {

    public $language   = 'de';
    public $defaultLanguage = 'de';
    public $type  = 'admin';
    public $prefix = 'translate';
    public $dir;

    public function __construct() {
        $this->dir =    PATH.'/resources/langs/';
    }

    public function getBaseFileContent() {


        if(empty($this->defaultLanguage)){
            return false;
        }

        if(preg_match('/[^A-z]+/', $this->defaultLanguage)){
            throw new \InvalidArgumentException($this->defaultLanguage.' is not valid param');
        }

        $file = $this->dir.$this->defaultLanguage.'/'.$this->type.'/'.$this->prefix.'.ini';

        if(!file_exists($file)){
            throw new \Exception($file.' File Not Found. Please contact your system admin');
        }

        return $this->parse($file);

    }

    public function getCustomFileContent() {

        if(empty($this->language)){
            return false;
        }

        if(preg_match('/[^A-z]+/', $this->language)){
            throw new \InvalidArgumentException($this->language.' is not valid param');
        }

        $file = $this->dir.$this->language.'/'.$this->type.'/'.$this->prefix.'_user.ini';

        if(!file_exists($file)){
            return $this->getBaseFileContent();
        }

        return $this->parse($file);

    }
 
    public function saveCustomFileContent($data) {
        $dir  = $this->dir.$this->language.'/'.$this->type.'/';
        if(!is_dir($dir)){
            mkdir($dir, 0755, true);
        }
        $file = $dir.$this->prefix.'_user.ini';
        $this->write_ini_file($data, $file);
        return true;

    }

    public function setDefault() {

        $file = $this->dir.$this->language.'/'.$this->type.'/'.$this->prefix.'_user.ini';
        if(file_exists($file)){
           return rename($file, str_replace('_user', '_user'.time(), $file));
        }
        return true;
    }

    public function parse($file) {

        $data = parse_ini_file($file,true);
        return $data;
    }

    public function write_ini_file($array, $file) {

        $res = array();
        foreach ($array as $val) {
            $res[] = "[$val->key]";
            foreach ($val->data as $sval) {
                $res[] = $sval->key .' = ' . (is_numeric($sval->value) ? $sval->value : '"'. addslashes($sval->value).'"');
            }
           // $res[] = $key.' = ' . (is_numeric($val) ? $val : '"'.addslashes($val).'"');
        }
        $this->safefilerewrite($file, implode("\r\n", $res));
    }

    public function safefilerewrite($fileName, $dataToSave) {

        if ($fp = fopen($fileName, 'w')) {
            $startTime = microtime(TRUE);
            do {
                $canWrite = flock($fp, LOCK_EX);
                if (!$canWrite)
                    usleep(round(rand(0, 100) * 1000));
            } while ((!$canWrite)and ( (microtime(TRUE) - $startTime) < 5));

            if ($canWrite) {
                fwrite($fp, $dataToSave);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }
}

