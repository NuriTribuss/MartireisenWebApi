<?php

namespace Helper;

class Error {

    private $type;
    private $message;

    public function __construct() {

    }

    public function type($type) {
        $this->type = $type;
        return $this;
    }

    public function message($text) {
        $this->message = $text;
        return $this;
    }

    public function show() {

        ob_get_clean();
        $filename = PATH.'/themes/error.php';
        var_dump($this);
        $content  = file_get_contents($filename);
        $content = str_replace('{{WARNING}}', $this->type,$content);
        $content = str_replace('{{MESSAGE}}', $this->message,$content);

        echo $content;
        die();

    }

}
