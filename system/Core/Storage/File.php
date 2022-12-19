<?php

namespace Core\Storage;

/**
 *  File Operations
 *  Mustafa ERÇEL 
 *  > PHP 5.3
 */

class File {
     
    private $path;
    private $exceptions = array();
    
    public function __construct() {
        
        // bu klasördekiler silinemez..
        $this->exceptions = array(
            "System" , "Themes" , "Config"
        );
        $this->path = PATH;
    }
    
    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = PATH.'/'.$path;
    }
    
    public function get($src) {
        
        if(file_exists($src)) {
            return file_get_contents($src);
        }
        return false;
    }
    
    public function set($file,$data) {
        
        return file_put_contents($file, $data);
    }
    
    /*
     *  Dosya veya klasörü siler
     *  $io->setPath('Cache');  üzerinde calısacagımız klasör 
     *  $io->delete('cc'); Cache klasörü içindeki cc adlı klasör veya dosyayı siler..
     *  $io->delete('tr/en.conf'); Cache klasörü içindeki tr klasöründeki en.conf u siler
     *  $io->delete();  Cache klasörünü siler 
     */
    
    public function delete($path = '') {
        
        $path =  $path !== ''  ? $this->path.'/'.$path : $this->path;
       
        if (is_dir($path)) { 
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            
            foreach ($iterator as $file) {
                if ($file->isDir())  {
                    rmdir($file->getPathname());
                } else {
                    unlink($file->getPathname());
                }
            }
            rmdir($path);
        } else {
            unlink($path);
        }
    }
    
    /*
     *  Dosya veya klasör kopyalar
     *  $io->setPath('Cache');  üzerinde calısacagımız klasör 
     *  $io->delete('cc'); Cache klasörü içindeki cc adlı klasör veya dosyayı siler..
     *  $io->delete('tr/en.conf'); Cache klasörü içindeki tr klasöründeki en.conf u siler
     *  $io->delete();  Cache klasörünü siler 
     */
    
    public function copy($source,$dest) {
      
         if(!is_dir($dest)){
             mkdir($dest, 0755);
         }
         if (is_dir($source)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $file) {
                if ($file->isDir()) {
                    mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                } else {
                    copy($file, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                }
            }
        } else {
            copy($source, $dest);
        }
    }
    
    /*
     *  Dosya veya klasörün boyutunu alır 
     *  $io->setPath('Cache');  üzerinde calısacagımız klasör 
     *  $io->getSize();  Cache klasörünün boyutunu getirir
     *  $io->getSize('test.conf');  Cache klasörü içindeki test.conf un boyunutu getirir   
     */
    
    public function getSize($path = '') {
        
        $path =  $path !== ''  ? $this->path.'/'.$path : $this->path;
       
        $size = 0;
        if (is_dir($path)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            foreach ($iterator as $file) {
                $size += $file->getSize();
            }
        } else {
            $size = filesize($path);
        }

        return (int)$size;
        
    }
    
     /*
     *  Klasörün içeriğini
     *  $io->setPath('Cache');  üzerinde calısacagımız klasör 
     *  $io->getAll();  Cache klasörünün içeriğini getirir
     */
    
    public function getAll($path = '') {
        
        $path = $path !== '' ? $this->path.'/'.$path : $this->path;
       
        $item = [];
        if (is_dir($path)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            foreach ($iterator as $file) {
                $item[] = $file->getFilename();
            }
        }

        return $item;
        
    }
    
}