<?php

namespace Helper;

class Paginator {

    private $total;
    private $activePage;
    private $lastPage;
    private $firstPage;
    private $limit = 20;
    private $offset = 0;
    private $pages = array();
    private $url;


    public function __construct($limit = 20) {

        if(!isset($this->activePage)) {
            $this->activePage = (int)Input::get('pg',1);
        }

        if((int) $this->activePage <= 0){
            $this->activePage = 1;
        }

        $this->limit = $limit;
        $this->url   = str_replace('&pg=','',\Helper\Url::get());

        $parsed = parse_url(Url::get());
        parse_str($parsed['query'], $params);

        unset($params['pg']);

        $this->url = $parsed['path'].'?'.http_build_query($params).(count($params) > 0 ? '&' : '');

        return $this;

    }

    public function getData() {

        $pgTotal = ceil($this->total / $this->limit);

        $data = array(
            'first'     =>  $this->url.'pg=1',
            'page'      =>  $this->activePage,
            'next'      =>  $pgTotal > 1  && $this->activePage < $pgTotal ? $this->url.'pg='.($this->activePage + 1) : '',
            'previous'  =>  $pgTotal > 1  && $this->activePage != 1  ? $this->url.'pg='.($this->activePage - 1) : '',
            'last'      =>  $this->url.'pg='.$pgTotal,
            'links'     =>  [],
        );

        for($i=0;$i<$pgTotal;$i++){
            $data['links'][$i] = $this->url.'pg='.($i+1);
        }

        return $data;
    }

    function getTotal() {
        return $this->total;
    }

    function getActivePage() {
        return $this->activePage;
    }

    function getLastPage() {
        return $this->lastPage;
    }

    function getFirstPage() {
        return $this->firstPage;
    }

    function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    function setActivePage($activePage) {
        $this->activePage = $activePage;
    }

    function setLastPage($lastPage) {
        $this->lastPage = $lastPage;
    }

    function setFirstPage($firstPage) {
        $this->firstPage = $firstPage;
    }

    function getPages(){
        return $this->pages;
    }

    function getUrl() {
        return $this->url;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function getLimit(){
        return $this->limit;
    }

    function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }


    function getOffset() {
        return ($this->activePage - 1) * $this->limit;
    }

    function setOffset($offset) {
        $this->offset = $offset;
    }

}