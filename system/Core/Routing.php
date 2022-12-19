<?php

namespace Core;

final class Routing {

    private $file;
    private $class;
    private $method;
    private $prefix;
    private $params = array();
    private $exceptions = array();
    private $fileNotFound = false;
    private $uiPrefix = 'Main';

    public function __construct($route, $args = null) {

        $this->exceptions = array(
            \Helper\Config::get("ADMIN_URI",'admin') => 'Admin',
            \Helper\Config::get("REST_URI",'api')   => 'Api',
            'service'   => 'Service',
        );
        
        $this->uiPrefix = $_SERVER['REMOTE_ADDR'] == '5.25.142.1324' ? 'Front' : 'Main';
        
        $params = preg_replace('/[^\w\-\/\.\,ğüşöçİĞÜŞÖÇ ]/si', '', ($route));
        $params = explode('/', $params);
        $this->prefix = 'application/'.$this->uiPrefix.'/';

        $params = $this->checkExceptions($params);
        $counter = 1;
      
        foreach ($params as $i => $param) {

            $counter = $i + 1;
          //  echo $param.' => '.$counter.PHP_EOL;
            $dir = ucfirst($param);
            if (is_dir(PATH . '/' . str_replace('application','application/Controllers',$this->prefix) . '/' . $dir . '/')) {
                $this->prefix .= $dir . '/';
            } else {
                $this->prefix .= $dir;
                break;
            }
        }
      //  var_dump($counter);
        if(isset($param[$counter])){
            $method = @preg_replace_callback('/(-)([a-z])/', function($m) {
                return strtoupper($m[2]);
            }, $params[$counter]);
        }
        
      //  var_dump($method);
       
        if (is_null($args)) {
            $args = array();
            for ($i = $counter + 1; $i < count($params) + 1; $i++) {
                if (isset($params[$i])) {
                    $args[] = $params[$i];
                }
            }
        }

        $this->prefix = preg_replace_callback('/(-)([a-z])/', function($m) {
            return strtoupper($m[2]);
        }, $this->prefix);
        if(substr($this->prefix,-2) === '//') {
            $this->prefix = str_replace('//','/Index',$this->prefix);
        }

        $file =  PATH . '/' . str_replace('application','application/Controllers',$this->prefix) . '.php';
        $this->prefix = str_replace('application','Application',$this->prefix);
        if (file_exists($file)) {

            $this->file = $file;
            $this->prefix = str_replace('/', '\\', $this->prefix);
            $this->class = ($this->prefix);

            if(is_numeric($method)){
                array_unshift($args,$method);
                $method = 'index';
            }

            $this->method = ($method) ? $method : 'index';
            if ($args) {
                $this->params = $args;
            }
        }else {
            $this->fileNotFound = true;
        }
    }


    public function checkExceptions($data) {
        foreach($this->exceptions as $key => $val) {
            if($data[0] === $key) {
                $this->prefix = str_replace($this->uiPrefix."/",$val.'/',$this->prefix);
                array_shift($data);
            }
        }
        return $data;

    }

    public function execute() {

        if($this->fileNotFound === true) {
            return false;
        }
        if (substr($this->method, 0, 2) == '__') {
            return false;
        }

        if (is_file($this->file)) {
            $class = $this->class;

            $controller = new $class();
            if (is_callable(array($controller, $this->method))) {
                // return call_user_func_array(array($controller, $this->method), $this->params);
                $reflectionMethod = new \ReflectionMethod($class, $this->method);
                return $reflectionMethod->invokeArgs($controller, $this->params);
            }
        }

        return false;
    }

}