<?php

namespace Core\Structure;

use Illuminate\Database\Capsule\Manager as DB;

class  Category {
    
    private $closure    = NULL;
    private $table      = NULL;
    private $entity     = NULL;
    private $language   = null;
    
    public    $langType = 0;
    public    $linkType = '';
    
    /* multi menu category */
    public    $menuId   = 0;
    protected $softDelete = false;
    
   // use \Model\Traits\Media;
    
    public function __construct($table = '') {
        
        if($table !== ''){
            $this->setTable($table);
        }
    }
    
    function setLanguage($language){
        $this->language = $language;
    }
    
    function getTable() {
        return $this->table;
    }

    function setTable($table) {
        $this->table = $table;
        $this->closure = new Closure($this->table.'_closure');
    }
    
    public function setEntity(\Illuminate\Database\Eloquent\Model $entity) {
        $this->entity = $entity;
        $this->setTable($this->entity->getTable());
    }
    
    public function add($arr) {
        
        $parent = isset($arr['parent']) ? $arr['parent'] : $this->getRoot();
        $arr['parent'] = $parent;
        if($this->menuId > 0){
            $arr['menu_id'] = $this->menuId;
        } 
        
        $this->entity->fill($arr);
        $this->entity->save();
        $this->entity->code = 'C'.$this->entity->id;
        $this->entity->save();
        
        if($this->entity->id !== false && (int)$this->entity->id  > 0) {
            $this->closure->insertNode((int)$parent,(int)$this->entity->id );
        }     
        return $this->entity->id ;
    }
    
    public function update($arr,$id) {
        
        $oldData = $this->getNodeById($id); 
        $update  = $this->db->update($this->getTable(), $arr, array('id' => $id),1);
        if($update !== false) {
            if(isset($arr['parent']) && (int)$oldData['parent'] !== (int)$arr['parent']) {
                $this->move($id, (int)$arr['parent']);
            }
            return true;
        }
        return false;
    }
    
    public function delete($linkDelete = true) {
        
        
        $childs = $this->getChilds($this->entity->id,false);
       // $this->closure->deleteNode($id);
        foreach($childs as $child) {
            
            DB::table($this->closure->getTable())->where('ancestor',   $child->id)->delete();
            DB::table($this->closure->getTable())->where('descendant', $child->id)->delete();
            DB::table($this->getTable())->where('id', $child->id)->delete();
       
         /*   if($linkDelete){
                $this->deleteImage($child['id']);
                $this->linkModel->delete($child['seo_url'],$child['id']);
            }*/
        }
        
        return true;
        
    }
    
    public function softDelete($id) {
        
        $childs = $this->getChilds($id,false);
        foreach($childs as $child) {
            $this->db->update($this->getTable(),array('is_deleted' => 1), array('id' => $child['id']));
        }
    }
    
    public function move($category,$node = 0) {
        
        // current data
        $data   = $this->getNodeById($category);
        $parent = $this->getNodeById($data['parent']);
        
        // not neccesary update
        if((int)$data['parent'] === (int)$node ){
            return true;
        }

        $update = $this->db->update($this->getTable(), array('parent' => $node), array('id' => $data['id']));
        if($update !== false) {
            $this->closure->ancestor   = $parent['id'];
            $this->closure->descendant = $data['id'];
            $this->closure->moveNodeTo($node);
            return true;
        }
        return false;
    }
    
    public function getRoot() {
        return 0;
        //$root = $this->db->sql('SELECT id FROM '.$this->getTable().' WHERE parent = 0')->row('id');
    }
    
    public function getParents($id) {
        
        if(intval($id) <=0 ){
            return false;
        }
        
        $menuWhere = $this->menuId > 0 ? $this->getTable().'.`menu_id` = '.$this->menuId.'  AND ' : '';
        
        $query =  'SELECT '.$this->getTable().'.* FROM '.$this->closure->getTable().'
                LEFT JOIN '.$this->getTable().' ON '.$this->closure->getTable().'.ancestor = '.$this->getTable().'.id
                WHERE '.$menuWhere.$this->closure->getTable().'.`descendant` = '.$id.'
                ORDER BY '.$this->getTable().'.id ASC';
        
        return DB::select($query);
        
    }
    
    public function getParent($id) {
        return $this->db->sql('SELECT id FROM '.$this->getTable().' WHERE id = '.$id)->row('id');
    }
    
    public function getChilds($id,$tree = true) {
        
        $menuWhere = $this->menuId > 0 ? $this->getTable().'.`menu_id` = '.$this->menuId.'  AND ' : '';

        if($tree === false) {
            $query =  'SELECT '.$this->getTable().'.* FROM '.$this->closure->getTable().'
                LEFT JOIN '.$this->getTable().' ON '.$this->closure->getTable().'.descendant = '.$this->getTable().'.id
                WHERE '.$menuWhere.$this->closure->getTable().'.`ancestor` = '.$id.'
                ORDER BY '.$this->getTable().'.id ASC';
            return DB::select($query);
        }
        return $this->getTree($id);
    }

    public function getTree($root = 0 , $active = NULL){
        
        if($this->table === NULL || $this->closure === NULL) {
            return false;
        }
        
        $query = 'SELECT '.$this->getTable().'.* FROM '.$this->getTable()
                .' JOIN '.$this->closure->getTable().' ON '.$this->getTable().'.id = '.$this->closure->getTable().'.descendant ';
        
        $query.= ' WHERE 1=1 ';
        
        if($this->menuId > 0){
            $query.= 'AND '. $this->getTable().'.`menu_id` = '.$this->menuId;
        }
        
        if($root !== 0) {
            $query.= ' AND '.$this->closure->getTable().'.ancestor ='.$root;
        }
        
        if($active !== NULL) {
            $query.= ' AND '.$this->getTable().'.active ='.(int)$active;
        }
        
        $query.= ' ORDER BY sort_number ';
        $result =  DB::select($query);
        return $this->makeTree($result);
    }
    
    public function getNodeById($id) {
        
        if((int)$id <=0){
            return false;
        }
        
        $data    = DB::table($this->getTable())->where(['id'=>$id,])->first();     
        return $data;
    }
    
    public function getCategoryIds($catId) {
        
        $in             = [];
        $categoryData   = $this->getNodeById($catId);
        if($categoryData->has_children == 1){
            $categories = $this->getChilds($catId,false);
            foreach($categories as $cat){
                if($cat->has_children == 0) {
                   $in[] = $cat->id; 
                }
            }
            $in[] = $categoryData->id;
        }else{
            $in[] = $categoryData->id;
        }
        
        return $in;
    }
    
    public function hasChildren($id) {
        
        $data = $this->getChilds($id,false);
        return count($data) > 1 ? true : false;
        
    }
    
    private function makeTree($items){
        
    //    $model = new \Core\Database\Model();
    //    $model->setTable($this->table);
        
        $structure = array();
        foreach( $items as $row ) { 
            $row = (array)$row;
            
            try {
                $translate = DB::table($this->getTable().'_translation')->where(['category_id'=>$row['id'],'language' => ($this->language ? $this->language : 'de')])->first();
                $row['translate'] = (array)$translate;
                $row['title'] = $row['translate']['name'];
                $row['translate']['url'] = $row['translate']['url'].'/';
                $row['key']   = $row['id'];
                $row['value'] = $row['id'];
            }catch(\Exception $e){
                
            }
            
            $structure[ $row["id"] ] = $row ;
        }
        foreach( $structure as &$row ) { 
            if(isset($row["parent"]) && !is_null( $row["parent"] ) ) {
                $row['expanded'] = true;
                $structure[ $row["parent"] ]["children"][] = &$row;    
            }
        }
        if(isset($structure[0])) {
            return $structure[0]['children'];
        }
        return false;
    }
    
}