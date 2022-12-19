<?php

namespace Core\Scheduled;

use Core\Migration\Logger;
use Model\Region\Hotel;
use Model\Region\Country;

use \Model\Link;

class Sitemap {
  
    protected $connection;
    public $logger;
    public $file;
    public $url;
    public $counter = 0;
    
    public function __construct(){
        
        $this->logger     = new Logger();
        $this->file       = PATH.'/sitemap.xml';
        $this->url        = \Helper\Config::get('SITE_URL');
        
        
        if(!is_dir(PATH.'/sitemap')){
            mkdir(PATH.'/sitemap',0755,true);
        }
    }
    
    public function run(){
        
        ini_set('memory_limit', '-1');
        
        $types = [
            ['key' => 'pages' , 'freq' => 'monthly' , 'priority' => '0.5'],
            ['key' => 'pauschalreisen' , 'freq' => 'weekly' , 'priority' => '0.8'],
            ['key' => 'urlaub' ,         'freq' => 'weekly' , 'priority' => '0.8'],
            ['key' => 'lastminute' ,     'freq' => 'weekly' , 'priority' => '0.8'],
            ['key' => 'hotels' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'halal-hotels' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'eigene-anreise' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'familienhotels' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'fernreisen' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'wellnesshotels' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'sports-aktivurlaub' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'all-inclusive' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'kurzurlaub' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'strandhotels' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'erwachsenenhotels' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            ['key' => 'urlaub-mit-hund' ,     'freq' => 'weekly' , 'priority' => '0.5']  ,
            ['key' => 'tour' ,     'freq' => 'weekly' , 'priority' => '0.5'],
            
        ];
        
        $regions = 'AG,BU,FR,GF,GI,IO,IT,KA,KB,KD,KR,MA,ML,MO,PO,SA,SP,TH,TR,TU,VO,ZY';
        $regions = explode(',', $regions);
        
        foreach($regions as $r){
            
            $reg = Country::where('code',$r)->first();
            if($reg != null) {
                array_push($types,  ['key' => 'hotel-'.\Helper\Url::beautify($reg->name) ,  'code' => $r,  'freq' => 'monthly' , 'priority' => '0.5']);
            }
            if($r == 'IT'){
                array_push($types,  ['key' => 'hotel-'.\Helper\Url::beautify($reg->name).'2', 'start' => 50000, 'code' => $r,  'freq' => 'monthly' , 'priority' => '0.5']);
            }
            
        }      
        
        foreach($types as $t){
            $content = $this->links($t);
            $this->generate( PATH.'/sitemap/'.$t['key'].'.xml', $content);
        }
        
        $this->generate(PATH.'/sitemap.xml', $this->rowIndex($types),true);

    }
    
    public function generate($file,$data,$index = false) {
        
        header("Content-type: text/xml");

        $content = $index ? $this->headerIndex() : $this->header();
        $content.= $data;
        $content.= $index ? $this->footerIndex() : $this->footer();
        
        file_put_contents($file, $content);
        
        if (preg_match('/home\/(.*?)\/public_html/', __DIR__, $match) == 1) {
            $user = $match[1];
        }else{
            $user = $_SERVER['USER'];
        }
        
        chown($file, $user);
        chgrp($file, 'nobody');
        chmod($file,0777);
        
        echo $this->counter.' links generated successfull'.PHP_EOL;
        
    }
    
    public function links($t) {
        
        $content = '';
        $links   = [];
        
        switch($t['key']){
            case 'tour':
                $links   = Link::where('type', 'like', 'tour')->get()->toArray();
                break;
            case 'halal-hotels':
                $links   = Link::where('type', 'like', 'halalhotels%')->get()->toArray();
                break;
             case 'pages':
                $links   = Link::where('type', 'like', 'content/page')->get()->toArray();
                break;
             case 'hotels':
                $links   = Link::where('type', 'like', 'landing_hotel%')->get()->toArray();
                break;
            default  :
                if(strpos($t['key'], 'hotel-') !== false){
                    $start = isset($t['start']) ? $t['start'] : 0;
                    $hotels = Hotel::where('regionCode',$t['code'])->skip($start)->take(50000)->get();
                    foreach($hotels as $h){
                        array_push($links,['locale' => 'de', 'updated_at' => date('Y-m-d H:i:s'),'value' => 'hotel/'.\Helper\Url::beautify($h->value).'_hid_'.$h->giataCode]);
                    }
                }else{
                    $links   = Link::where('value', 'like', '' . $t['key'] . '%')->get()->toArray();
                }
                break;
        }
        
        if($t['key'] == 'urlaub'){
            $content.= ' <url>
                <loc>'.$this->url.'</loc>
                <priority>1</priority>
            </url>';
        }
        foreach($links as $link) {
            
            if($link['locale'] != 'de' && $link['type'] != 'tour'){ 
                continue;
            }
            
            $content.= $this->row($link,$t['priority']);
            $this->counter++;
        }
        
       
        return $content;
        
    }
    
    public function rowIndex($data) {
        
        $content = '';
        
        foreach($data as $d){
            $content.= '<!-- '.$d['key'].'-->  
                        <sitemap>
                            <loc>'.$this->url.'/sitemap/'.$d['key'].'.xml</loc>
                            <lastmod>'.date('Y-m-d').'</lastmod>
                         </sitemap>';
        }
        
        return $content;
    }
    
    public function row($data,$priority) {
        
        $str = '
        <url>
            <loc>'.$this->url.'/'.$data['value'].'/</loc>
            <lastmod>'.date('Y-m-d',strtotime($data['updated_at'])).'</lastmod>
            <priority>'.$priority.'</priority>
        </url>';
        
        return $str;
    }
    
    public function header() {
        
        return '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:xhtml="http://www.w3.org/1999/xhtml" > ';;

    }
    
    public function headerIndex() {
        return '<?xml version="1.0" encoding="UTF-8"?>
            <sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
            xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    }
    
    public function footerIndex() {
        return "</sitemapindex>";
    }
    
    public function footer() {
        
        return PHP_EOL.'</urlset>';
    }

}