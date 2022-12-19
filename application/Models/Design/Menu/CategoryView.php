<?php

namespace Model\Design\Menu;

use Model\View;
use Model\Design\Menu\MenuTranslation;

class CategoryView  extends View {

    public function __construct() {
        parent::__construct();
    }
   
    public function get($menuId) {
        
        $structure = new \Core\Structure\Category();
        $structure->setTable('menu__list_category');
        $structure->menuId = $menuId;
        $structure->setLanguage($this->language);
        
        $tree      = $structure->getTree(0,1);
        
        $from  = ['Martı Reısen','Martı Reisen','Marti Reisen','Martireisen','MartiReisen'];
        $to    = 'Akin Travel';
        $url  = \Helper\Config::getDomain();
        
        
        $parent = MenuTranslation::where(['language' => $this->language,'menu_id' => $menuId])->first();
        foreach($tree as $index => $t){
            
            if($t['type'] != 0){
                $data = $this->getByType($t);
                $tree[$index]['translate'] = array(
                    'name' => empty($t['translate']['name']) ? $data['name'] : $t['translate']['name'],
                    'url'  => '/'.$data['url'].'/',
                );
                
                if($url === 'akin.at'){
                    $tree[$index]['translate']['name'] = str_replace($from,$to,$tree[$index]['translate']['name']);
                }
                
            }
        }
        
        $return = [
            'children' => $tree,
            'data'     => $parent ? $parent->toArray() : []
        ];
        
        return $return;
    }  
    
    public function getByType($record) {
        
        if($record['type'] == 0 ){
            return false;
        }
        
        $return = null;
        
        switch($record['type']){
            
            case '1':
                $return   = \Model\Content\PageTranslation::select('name','url')->where(['language' => $this->language,'page_id' => $record['type_table_id']])->first();
                if($return == NULL && $this->language != $this->defaultLanguage){
                    $return = \Model\Content\PageTranslation::select('name','url')->where(['language' => $this->defaultLanguage,'page_id' => $record['type_table_id']])->first();
                }
                break;
            
            case '2':
                $return   = \Model\Ecommerce\Catalog\CategoryTranslation::select('name','url')->where(['language' => $this->language,'category_id' => $record['type_table_id']])->first();
                if($return == NULL && $this->language != $this->defaultLanguage){
                    $return = \Model\Ecommerce\Catalog\CategoryTranslation::select('name','url')->where(['language' => $this->defaultLanguage,'category_id' => $record['type_table_id']])->first();
                }
                break;
               
            
            case '3';
                $return   = \Model\Ecommerce\Catalog\ProductTranslation::select('name','url')->where(['language' => $this->language,'product_id' => $record['type_table_id']])->first();
                if($return == NULL && $this->language != $this->defaultLanguage){
                    $return = \Model\Ecommerce\Catalog\ProductTranslation::select('name','url')->where(['language' => $this->defaultLanguage,'product_id' => $record['type_table_id']])->first();
                }
                break;
            
            case '255':
                $return = \Model\Link\LinkList::select('value as url')->where(['type' => 'system' , 'language' => $this->language,'table_id' => $record['type_table_id']])->first();
                if($return == NULL && $this->language != $this->defaultLanguage){
                    $return = \Model\Link\LinkList::select('value as url')->where(['language' => $this->defaultLanguage,'table_id' => $record['type_table_id']])->first();
                }
        }
        
        if($return != NULL){
            return $return->toArray();
        }
        
        return $return;
        
    }
    
    public function getOptions() {
        
         $types = [
            [
                'key'    => 'external',
                'value'  => '0',
                'api'    => '',
                'column' => '',
                'label_column' => ''
            ],
            [
                'key'    => 'page',
                'value'  => '1',
                'api'    => '/content/page?limit=200',
                'column' => 'id',
                'label_column' => 'translate.name'

            ],
          /*  [
                'key'    => 'product_category',
                'value'  => '2',
                'api'    => '/ecommerce/catalog/category?limit=200',
                'column' => 'id',
                'label_column' => 'translate.name'

            ],
            [
                'key'    => 'product',
                'value'  => '3',
                'api'    => '/ecommerce/catalog/product?limit=200',
                'column' => 'id',
                'label_column' => 'translate.name'

            ],*/
            [
                'key'    => 'system',
                'value'  => '255',
                'api'    => '/sys/link?type=system&limit=200',
                'column' => 'table_id',
                'label_column' => 'value'

            ]
        ];
         
        return $types;
         
    }
}
