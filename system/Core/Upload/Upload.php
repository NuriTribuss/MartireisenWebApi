<?php

/* 
* Upload
* 
* @date   28.Kas.2015
* @subpackage Controller
* @author     Mustafa ERCEL <mercel@mustafaercel.com>
 */

namespace Core\Upload;

use Core\Upload\UploadHandler;

class Upload  extends UploadHandler {
    
    public $handler;
    public $path;
    /*
     *  200 x 200  S
     *  400 x 400  M
     *  1024 x 1024 L
     *  Original  O
     */    
    function __construct($file) {
        
        parent::__construct($file);
        $this->path = rtrim(PATH.\Helper\Config::get('UPLOAD_DIR'),'/');
    }   
    
    public function upload($dir,$sub="") {
        
        if ($this->uploaded) {
            
            $this->process($this->path.'/' . $dir . '/'.$sub);
            
            if ($this->processed) {
                $url = $this->file_dst_path . $this->file_dst_name;
            } else {
                return false;
            }
            
            $this->image_resize         = true;
            $this->image_ratio_y        = true;
            
            $this->image_x              = 200;
            $this->process($this->path.'/' . $dir . '/small/');
            
            $this->image_resize         = true;
            $this->image_ratio_y        = true;
            $this->image_x              = 400;
            $this->process($this->path.'/' . $dir . '/medium/');
            
            $this->image_resize         = true;
            $this->image_ratio_y        = true;
            $this->image_x              = 1024;
            $this->process($this->path.'/' . $dir . '/large/');
            
            return str_replace(PATH,'',$url);
            
        }
        return false;
    }   
    
    /*
     *  TO DO 
     *  Multiupload Desteği 
     *  WaterMark  Desteği
     *  MIME Kontrol Desteği 
     *  Error Handling 
     */
    
   
}