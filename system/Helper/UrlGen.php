<?php

namespace Helper;

class UrlGen {
    
    public static function langUri($lang){
        
        if(isset(\Core\App::$linkData['alternates'][$lang])){
            return '/'.\Core\App::$linkData['alternates'][$lang];
        }
        
        return '/service/language/change/'.$lang;
    }
    
    public static function theme($template, $options = array()) {
        
        if(!isset($template->link)){
            return;
        }
        $type = $template->link['type'];
        
        if($type == 'landing_country'){
            return '-'.$template->country['seo_url'];
        }
        if($type == 'landing_state'){
            return '-'.$template->state['seo_url'];
        }
        if($type == 'landing_city'){
            return '-'.$template->city['seo_url'];
        }
        
        return '';
    }
    
    public static function loadMore($prefix,$zone){ 
        
        $on = $prefix == 'pauschalreisen' ||  $prefix == 'urlaub'  ? 'urlaub' : 'hotels';
        $url = http_build_query($_SESSION['landing']);
        return '/'.$on.'/'.$zone['seo_url'].'/?'.$url;
    }
    
    
    public static function filterLink($template,$zone){ 
        
        $reserved = [
            'lastminute/eigene-anreise',
            'lastminute/strandurlaub',
            'lastminute/all-inclusive',
            'pauschalreisen/all-inclusive',
            'urlaub/all-inclusive',
            'pauschalreisen/familienurlaub',
            'pauschalreisen/wellnesshotels',
            'lastminute/wellnesshotels',
            'lastminute/fernreisen'

        ];
        
        // url append / 
        $zone['seo_url'] = $zone['seo_url'].'/';
       
        $on = $template->prefix == 'pauschalreisen' ||  $template->prefix == 'urlaub'  ? 'urlaub' : 'hotels';
        if($template->zone['code'] == 'TR'  || $template->zone['country_code'] == 'TR'){
            return '/'.$template->prefix.'/'.$zone['seo_url'];
        }
        
        $tmp = $_SESSION['landing'];
        $tmp['destination'] = [
            'type' => 'state',
            'code' => $zone['code'],
            'name' => $zone['name']
        ];
        
        $request = ltrim($_SERVER['REQUEST_URI'],'/');
        
       // !in_array($request, $reserved);
        if(!isset($template->zone)){            
            if(!isset($_GET['priceMax']) && !isset($tmp['attributes'])  && !in_array($request, $reserved)){
                if($template->prefix == 'top urlaub') {
                    if($zone['code'] == 'TR') {
                        return '/pauschalreisen/'.$zone['seo_url'];
                    }
                }else{
                    if($template->prefix != 'billig urlaub') {
                        return '/'.$template->prefix.'/'.$zone['seo_url'];
                    }else{
                        $tmp['priceMax'] = 499;
                    }
                    
                }
                
            }
        }
        
        if(isset($_GET['priceMax'])){
            $tmp['priceMax'] = $_GET['priceMax'];
        }
        
        switch($request){
            case 'lastminute/all-inclusive':
                $tmp['sf'] = 2;
                break;
            case 'lastminute/eigene-anreise':
                $tmp['sf'] = 3;
                break;
            case 'lastminute/strandurlaub':
                $tmp['attributes'] = ['GT03-BEAC','GT03-DIBE'];
                break;
            
            case 'pauschalreisen/all-inclusive':
                $tmp['sf'] = 2;
                break;
            
            case 'lastminute/wellnesshotels':
                $tmp['sf'] = 2;
                //$tmp['attributes'] = ['GT03-CURE'];

                break;

            case 'pauschalreisen/familienurlaub':
                $tmp['sf'] = 2;
                $tmp['attributes'] = ['GT03-FAFR'];
                break;
            default:
              
                break;
        }
        
        $url = http_build_query($tmp);
        return '/'.$on.'/'.$zone['seo_url'].'?'.$url;
    }
    
    public static function filterText($prefix) {
        
        $prefix = str_replace('-',' ',$prefix);
        return  mb_convert_case(mb_strtolower($prefix), MB_CASE_TITLE, "UTF-8");     
    }
    
    public static function step($step,$active,$page = null){
       
        if($active == 1) {
            return '#';
        }
        
        $page = (string)$page;
        
        if($active == 2) {
            switch($step){
                case '1':
                    $step = '';
                    break;
                case '2':
                case '3':
                    $step = '#';
                    
                break;
            }
        }
        
        if($active == 3) {
            switch($step){
                case '1':
                    if(!empty($_SESSION['step'.$page][1])){
                        $step = $_SESSION['step'.$page][1];
                    }else{
                        $step = '/search/hotels';
                    }
                    break;
                case '2':
                    $step = '';
                    break;
                case '3':
                    $step = '#';
                    
                break;
            }
        }
        
        if($active == 4) {
            switch($step){
                case '1':
                    if(!empty($_SESSION['step'.$page][1])){
                        $step = $_SESSION['step'.$page][1];
                    }else{
                        $step = '/search/hotels';
                    }
                    break;
                case '2':
                    if(!empty($_SESSION['step'.$page][2])){
                        $step = $_SESSION['step'.$page][2];
                    }else{
                        $step = '/search/hotel-offers';
                    }
                    break;
                case '3':
                    $step = '';
                    
                break;
            }
        }
      
        return '#';
    }
}
?>