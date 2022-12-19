<?php

namespace Model\Api\Client;


class TravelitMapping {
    
    
    public function booking($book) {
        
        $data = array(
            'status' => false
        );
        
        if($book['PAGE'] == 'error'){
            $data['status'] = false;
        }
        
        return $book;
    }
    
    
}