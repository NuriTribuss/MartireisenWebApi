<?php

namespace Helper;

class Image {

    private $uploader;
    
    public $resize = false;
    public $max_file_size = 1024 * 1024 * 4; // 4 MB
    public $allowed = array( 'image/*');

    public function __construct() {
        
    }


    public function upload($target = '') {

        if(empty($target)){
            return false;
        }
        
        $return = [
            'status'  => false,
            'message' => '',
            'path'    => ''
        ];
                
        $dir = PATH.$target;
        
        $handle = new  \Core\Upload\Upload($_FILES['file']);
        
        $handle->mime_check     = true;
        $handle->file_max_size  = $this->max_file_size; 
        $handle->allowed        = $this->allowed;
        
        if ($handle->uploaded) {
            
            $imageName = Input::generateRandomString();
            $handle->file_new_name_body   = $imageName;
            $handle->process($dir);
            
            if ($handle->processed) {
                $return['status'] = true;
                $return['path']    = $handle->file_dst_path . $handle->file_dst_name;
                $return['file']    = $handle->file_dst_name;
                
                if($this->resize){
                    
                    $handle->image_resize     = true;
                    $handle->image_ratio_y    = true;
                    $handle->file_new_name_body   = $imageName;
                    $handle->image_x = 300;
                    $handle->jpeg_quality  = 100;
                    $handle->Process($dir.'/small/' );
                    
                    $handle->jpeg_quality  = 100;
                    $handle->image_resize     = true;
                    $handle->image_ratio_y    = true;
                    $handle->file_new_name_body   = $imageName;
                    $handle->image_x = 800;
                    $handle->Process($dir.'/medium/' );
                    
                }
                
                $handle->clean();
            } else {
                $return['message'] = $handle->error;
            }
        }else{
            $return['message'] = 'File not found';
        }
        
        return $return;
    }
    
    public static function getUrl($source){
        
        $return = array(
            'original' => '',
            'medium' => '',
            'small'  => ''
        );
        
        if(empty($source)){
            return $return;
        }
        
        $explode = explode('/', $source);
        $removed = array_pop($explode);
        $path    = implode('/',$explode);
        
        $url  = \Helper\Config::get('SITE_URL');
        $sub  = \Helper\Config::get('SITE_PATH');
        
        $return = array(
            'original' =>  $url.$sub.$source,
            'medium'   =>  $url.$sub.$path.'/medium/'.$removed,
            'small'    =>  $url.$sub.$path.'/small/'.$removed,
        );
        
        return $return;
    }

}
