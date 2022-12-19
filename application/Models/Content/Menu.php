<?php

namespace Model\Content;

use Model\Localization\Translate;
use Model\Content\FooterGroup;
use Model\Content\Footer;
use Model\Link;

class Menu  {

    public function get() {
        
        $groups     = FooterGroup::orderBy('id','ASC')->get()->toArray();
        $return     = array();
        $translate  = new Translate;
        
        foreach($groups as $key => $value){
            
            $return[$key]['children'] = Footer::where('group_id',$value['id'])->where('is_active',1)->orderBy('sort_number','ASC')->get()->toArray();
            $return[$key]['title']    = $value['title'];
            
            foreach($return[$key]['children']  as &$el){
                
                $el['title'] = $translate->get($el['id'], 'footerlinks', \Core\Translation\Language::getLanguage(), $el['title']);
                // page
                if($el['type'] == 2){
                    $record = Link::where(array('type' => 'page','table_relation' => $el['type_table_id'],'locale' => \Core\Translation\Language::getLanguage()))->first();
                    if($record !== NULL){
                        $el['link'] = '/'.$record->value;
                    }
                }
            }
            
        }
        
        return $return;
    }

}