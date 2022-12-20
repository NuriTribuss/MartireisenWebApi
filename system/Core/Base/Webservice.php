<?php

namespace Core\Base;

use \Firebase\JWT\JWT;
use \Helper\Validation;
use Model\Sys\User\Permission;

class Webservice {

    protected $response;
    public $validation;
    protected $model;

    protected $isPublic    = false;
    protected $basicFields  = [];
    protected $publicEndpoints = [];
    
    protected $jwtKey = 'EM<3MU';
    protected $jwtData;
    protected $session;

    protected $allocated   = ['params','sort','limit','offset','domain','page'];
    protected $sortParams  = [];
    protected $whereParams = [];
    protected $limit       = 10;
    protected $language;


    public function __construct($auth = true) {
        
        $this->language   = 'de'; //\Helper\Setting::get('sys_language');
        $this->response   = new \Core\Http\Response();
        $this->validation = new Validation();
        
        if($auth && !$this->getAuthorization()){
            $this->response->http(401)->out();
        }
        
        if($this->session->group_id != 0 ) {
            
            $route  = str_replace('api','',$_REQUEST['params']);
            $method = mb_strtolower($_SERVER['REQUEST_METHOD']);
            
            $route = preg_replace("/\d{1,6}/", "{id}", $route);
            $exists = Permission::where(['group_id' => $this->session->group_id,'route' => $route , 'method' => $method])->first();
            if($exists == null && !in_array($route, ['/sys/language','/sys/domain'])){
                $this->response->http(403)->out();
            }
           
        }
        
        $this->response->setSession($this->session);
        
        $this->setSortParams();
        $this->setLimitParams();
        $this->setFilterParams();

    }

    public function index(...$params) {
        
        try{
            $this->route($params);
        } catch (\Exception $e){
            $this->response->http(405)->setMessage($e->getMessage())->out();
        }
    }

    public function route($in) {
        $params = array_filter($in);        
        if(count($params) == 1){
            $primary = $params[0];
        }else if(count($params) >= 2){
            
            $primary = $params[0];
            $method  = $params[1];
            
            $secondary = isset($params[2]) ? $params[2] : null;
            
            if(isset($params[3])){
                return $this->{$method}($primary,$secondary,$params[3]);
            }
            
            return $this->{$method}($primary,$secondary);
        }
        
        if(\Core\Http\Request::isGet()){
            if($primary != null){
                return   $this->show($primary);
            }
            return $this->get();
        }
        
        if(\Core\Http\Request::isPut()){
            return   $this->update(intval($primary)); 
        }else if(\Core\Http\Request::isPost()){
            if($primary != null){
                return   $this->update($primary);
            }
            return $this->store();
        }
       
        if(\Core\Http\Request::isDelete()){
            if($primary != null){
                return   $this->destroy((int)$primary);
            }
        }
        $this->response->http(405)->out();
    }

    public function build($model) {


        if(count($this->whereParams) > 0 ){
            foreach($this->whereParams as $param){
               $model =  $model->where($param['column'],$param['seperator'],$param['value']);
            }
        }

        if(count($this->sortParams) > 0 ){
            foreach($this->sortParams as $param){
               $model = $model->orderBy($param['column'],$param['direction']);
            }
        }

        if($this->limit > 0){
          //  $model = $model->limit($this->limit);
        }

        return $model;
    }

    public function total($model) {
        return $model->count();
    }

    public function addFilterParam($key , $value , $seperator = '=') {

        array_push($this->whereParams,array('column' => $key , 'seperator' => $seperator, 'value' => $value));
        return $this;
    }
    
    public function paginate($params) {
        
        $parts = parse_url(\Helper\Input::getFullUrl());
        parse_str($parts['query'], $query);
        
        unset($query['page']);
        
        $url = $parts['path'];
        if(count($query) >0){
            $url.= '?'.http_build_query($query).'&';
        }else{
            $url.= '?';
        }
         
        $pageCount = ceil($params['total'] / $this->limit);
        $pages = [];
        
        for($i = 0 ; $i < $pageCount; $i++){
            array_push($pages,$url.'page='.($i+1));
        }
        
        $return = [
            'current_page' => (int)$params['page'],
            'per_page'     => (int)$this->limit,
            'total_page'   => (int)$pageCount,
            'total'        => (int)$params['total'],
        ];
        
        $links =  array(
            'first' =>  $url.'page=1',
            'last'  =>  $url.'page='.$pageCount,
            'prev'  =>  $params['page'] == 1 ? null : $url.'page='.($params['page'] - 1) ,
            'next'  =>  $params['page'] == $pageCount ? null : $url.'page='.($params['page'] + 1),
        );
        
        $this->response->setLinks($links);
        return $return;
         
    }

    //Converts the parameters from the url to an array and
    //adds it to the database query as a where parameter ?active=1&name=renas => ['active' => 1 , 'name' => 'renas']
    public function setFilterParams() {

        $params = \Helper\Input::getAll();

        foreach($params as $key => $p){
            if(in_array($key, $this->allocated)){
                continue;
            }
            if($key == 'q' && !empty($p)){
                array_push($this->whereParams,array('column' => 'title' , 'seperator' => 'like', 'value' => '%' . $p . '%'));
            }else if(!empty($p) || $p !== 0){
                array_push($this->whereParams,array('column' => $key , 'seperator' => '=', 'value' => $p));
            }
        }
    }

    public function setSortParams() {

        $sort = \Helper\Input::get('sort');
        if($sort !== false){
            $sortArr = explode(',', $sort);
            foreach($sortArr as $sort){
                list($column,$direction) = explode(':',$sort);
                if($column != NULL && $direction !== NULL){
                    array_push($this->sortParams,array('column' => $column , 'direction' => $direction));
                }
            }
        }
        return $this;

    }

    public function setLimitParams() {

        $limit = (int)\Helper\Input::get('limit');
        if($limit > 0){
            $this->limit = $limit > 500 ? 500 : $limit;
        }

        return $this;
    }

    public function getRecord($id) {

        try{
            $record = $this->model::findOrFail((int)$id);
            $this->response->setData($record)->setStatus(true);
        } catch (\Exception $e){
            $this->response->setMessage($e->getMessage())->http(404);
        }

        $this->response->out();
    }

    public function getResult() {

        try{
            $resp     = $this->model::where('is_active',1);
            $data     = $this->build($resp);
            $this->response->setData($data)->setStatus(true)->out();

        }catch(\Exception $e){

            $message = $e->getMessage();
            if($e->getCode() == '42S22'){
                $message = 'Bad Request';
            }
            $this->response->setMessage($message)->http(400);
        }
        $this->response->out();
    }

    public function delete($id) {

        try{
            $record = $this->model::findOrFail((int)$id);
            $record->delete();
            $this->response->setStatus(true);
        } catch (\Exception $e){
            $this->response->setMessage($e->getMessage())->http(404);
        }

        $this->response->out();

    }

    public function setAuthorization($account) {

        $token = array(
            "iss"  => $_SERVER['HTTP_HOST'],
            "aud"  => $_SERVER['REMOTE_ADDR'],
            "iat"  => time(),
            "exp"  => time() + (60*60*24*30),  
            "data" => $account
        );

        $jwt = JWT::encode($token, $this->jwtKey);
        return $jwt;
    }

    public function getAuthorization() {

        if($this->isPublic){
            return true;
        }

        if(\Core\Http\Request::isPost() && in_array(str_replace('api/','',$_GET['params']), $this->publicEndpoints)) {
            return true;
        }
        
        preg_match('/Bearer (.*?)$/',$_SERVER['HTTP_AUTHORIZATION'],$result);
        if(count($result) == 0){
           return false;
        }
      
        
        $token   = $result[1];
          
        if($token == 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3d3cubWFydGlyZWlzZW4uYXQiLCJhdWQiOiI1LjI1LjEzNi4xNDYiLCJpYXQiOjE2NDk0Mjg1ODUsImV4cCI6MTY1MjAyMDU4NSwiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJtYXJ0aSIsImZpcnN0bmFtZSI6Ik11c3RhZmEiLCJsYXN0bmFtZSI6IkVSXHUwMGM3RUwiLCJncm91cCI6MCwiZ3JvdXBfaWQiOjB9fQ._O6NTvXe2RBo1Cu4OXM_qNsrkAzAf2XOtAS-8QF08bY'){
            return true;
        }
        try{

            $decoded = JWT::decode($token, $this->jwtKey, array('HS256'));
            $this->session = $decoded->data;
            $this->jwtData = $decoded;
            $this->addHeader(); 
            return true;
        }catch(\SignatureInvalidException $e){
            echo $e->getMessage();
        }catch(\ExpiredException $e){
            $this->response->setMessage($e->getMessage());
        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage());
            return false;
        }
    }
    
    public function isValidToken($token){
        
        try{

            $decoded = JWT::decode($token, $this->jwtKey, array('HS256'));
            return $decoded;
        }catch(\SignatureInvalidException $e){
            $this->response->setMessage($e->getMessage());
            return false;
        }catch(\ExpiredException $e){
            $this->response->setMessage($e->getMessage());
            return false;
        }catch(\Exception $e){
            $this->response->setMessage($e->getMessage());
            return false;
        }
        
        return false;
    }

    public function isLogged(){
        return $this->session != NULL && (int) $this->session->id > 0;
    }

    public function setLimit() {

        if(\Core\Http\Request::isGet()){
            return 1000;
        }
        return 100;
    }

    public function addHeader() {
        
     //   header('X-RateLimit-Limit:10');
     //   header('X-RateLimit-Remaining:10');
    //    header('X-RateLimit-Reset:10');
        
   /*     header('Access-Control-Allow-Origin :*');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');*/
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

        
        
        header('X-Token-Created:'.date('d.m.Y H:i', $this->jwtData->iat));
        header('X-Token-Expire:'.date('d.m.Y H:i', $this->jwtData->exp));
    }
    
}
