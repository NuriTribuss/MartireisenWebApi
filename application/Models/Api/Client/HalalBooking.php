<?php

namespace Model\Api\Client;

use Model\Region\Defaults\Country;
use Model\Region\Defaults\State;
use Carbon\Carbon;

class HalalBooking {

    private $endPoint = 'https://{{locale}}.halalbooking.com/api/v2/';
    private $botPoint = 'https://{{locale}}.halalbooking.com/';
    //private $defaultLanguage = 'DE';
    //private $allowedLanguage = ['DE','EN','TR','FR','HU','CZ','DK','NL','PL','SL'];
    private $header = [];
    private $params;
    private $isTest = true;
    private $hotelId = '';

    public function __construct() {
        $this->isTest  = \Helper\Config::get('TEST_MODE') == 1;
        $this->endPoint = str_replace('{{locale}}', \Core\Translation\Language::getLanguage(), $this->endPoint);
        $this->botPoint = str_replace('{{locale}}', \Core\Translation\Language::getLanguage(), $this->botPoint);
    }

    public function setHeaders() {

        $this->header = array(
            "accept: application/json",
            "authorization: Basic " . base64_encode(\Helper\Config::get('HALALBOOKING_USERNAME') . ':' . \Helper\Config::get('HALALBOOKING_PASSWORD')),
            "cache-control: no-cache",
        );
    }

    public function setGroups($data) {

        if (empty($data['adults'])) {
            return 2;
        }

        $groups = $data['adults'];
        foreach ($data['children'] as $children) {
            $groups .= ',' . $children['jahre'];
        }
        return $groups;
    }

    public function setParams($data) {

        $params = array(
            'currency' => \Model\User\Customer::getCurrency(),
            'checkin' => !empty($data['date']['start']) ? $data['date']['start'] : Carbon::now()->format('Y-m-d'),
            'checkout' => !empty($data['date']['end']) ? $data['date']['end'] : Carbon::now()->addWeek()->format('Y-m-d'),
            'groups' => $this->setGroups($data),
            'holiday_type' => !empty($data['holiday_type']) ? $data['holiday_type'] : 'all'
        );

        if (isset($data['page'])) {
            $params['page'] = $data['page'];
        }

        if ($data['destination']['type'] == 'region') {

            $state = Country::where('id', $data['destination']['code'])->first();
            if ($state !== NULL) {
                $params['location'] = $state->halalbooking_term;
            }
        } else if (!$data['destination']['type'] == 'state') {

            $state = State::where('id', $data['destination']['code'])->first();
            if ($state !== NULL) {
                $params['location'] = $state->name;
            }
        } else if (!empty($data['destination']['name'])) {
            $params['location'] = ucfirst($data['destination']['name']);
        }

        if ($params['location'] == 'United Arab Emirates') {
            $params['location'] = 'Dubai';
        }


        if (!empty($data['destination']['code']) && $data['destination']['type'] == 'hotel') {
            $this->hotelId = $data['destination']['code'];
        }
        if (!empty($data['hotel']['giata'])) {
            $this->hotelId = $data['hotel']['giata'];
        }
        $gid = \Helper\Input::get('gid', 0);
        if ($gid > 0) {
            $this->hotelId = $gid;
        }

        $this->params = http_build_query($params);
        return $this;
    }

    public function setParamsBot($data) {
        
        $params = [
            'sort' => 'recommended_position-asc',
            'property_types' => [],
            'meal_plans' => [],
            'stars' => [],
            'scores' => [],
            'feature_group_1' => [],
            'feature_group_2' => [],
            'feature_group_3' => [],
            'locations' => [],
            'location_id' => '',
            'page' => 1,
            'checkin' => !empty($data['date']['start']) ? $data['date']['start'] : Carbon::now()->format('Y-m-d'),
            'checkout' => !empty($data['date']['end']) ? $data['date']['end'] : Carbon::now()->addWeek()->format('Y-m-d'),
            'adults' => (int) $data['adults'],
            'children' => isset($data['children']) ? $data['children'] : []
        ];
        

        if (!empty($data['destination']['code'])) {
            $params['location_id'] = $data['destination']['code'];
        }

        if (!empty($data['meal_plans']) && count($data['meal_plans']) > 0) {
            $params['meal_plans'] = $data['meal_plans'];
        }
        
        if (!empty($data['locations']) && count($data['locations']) > 0) {
            $params['locations'] = $data['locations'];
        }

        if (!empty($data['property_types']) && count($data['property_types']) > 0) {
            $params['property_types'] = $data['property_types'];
        }

        if (!empty($data['scores']) && count($data['scores']) > 0) {
            $params['scores'] = $data['scores'];
        }

        if (!empty($data['stars']) && count($data['stars']) > 0) {
            $params['stars'] = $data['stars'];
        }

        if (!empty($data['feature_group_1']) && count($data['feature_group_1']) > 0) {
            $params['feature_group_1'] = $data['feature_group_1'];
        }

        if (!empty($data['feature_group_2']) && count($data['feature_group_2']) > 0) {
            $params['feature_group_2'] = $data['feature_group_2'];
        }
        
        if (!empty($data['feature_group_3']) && count($data['feature_group_3']) > 0) {
            $params['feature_group_3'] = $data['feature_group_3'];
        }

        if (!empty($data['page'])) {
            $params['page'] = $data['page'];
        }
        
        if (!empty($data['sort'])) {
            $params['sort'] = $data['sort'];
        }
        
        $this->params = ($params);
        return $this;
    }

    public function offersBot() {

        $this->header = array(
            "accept: application/transit+json",
            "content-type: application/json"
        );
        
        if(is_array($this->params['locations']) && count($this->param['locations']) > 0){
            $locations = $this->param['locations'];
        }
     
        $params = [
            'locations' => isset($this->params['locations']) && count($this->params['locations']) > 0 ? $this->params['locations']: $this->params['location_id'],
            'property_types' => $this->params['property_types'],
            // öğün planı
            'meal_plans' => $this->params['meal_plans'],
            // yıldız
            'stars' => $this->params['stars'],
            // puan
            'scores' => $this->params['scores'],
            // halal meals
            'feature_group_1' => $this->params['feature_group_1'],
            // drunk
            'feature_group_2' => $this->params['feature_group_2'],
            'feature_group_3' => $this->params['feature_group_3']
        ];

        $params = preg_replace('/(%5B)\d+(%5D=)/i', '$1$2', http_build_query($params));
        $url = $this->botPoint . 'search/filters?' . $params;

        $res = $this->request($url);
        $ids    = $res[4][1];
        $counts = $res[2][1];
        
        $filterCounts = $this->getFilterData($counts);

        $url = $this->botPoint . 'places';
        
        $payload = [
            'place_ids' => $ids,
            'sort' => $this->params['sort'],
         //   'location_id' => $this->params['location_id'],
            'page' => $this->params['page'],
            'groups' => [$this->setGroups($this->params)],
            'variant' => 'html',
            'checkin' => $this->params['checkin'],
            'checkout' => $this->params['checkout'],
        ];
        
        if(empty($payload['place_ids'] )){
            unset($payload['place_ids']);
        }
        
        if(empty($payload['location_id'] )){
            unset($payload['location_id']);
        }
        
        $result = [];
        if(count($ids) > 0 || !isset($payload['place_ids'])){
             $result = $this->request($url, 'POST', json_encode($payload));
        }
       
        $return = [
            'payload' => $payload,
            'counts' => $filterCounts,
            'total_results' => count($ids),
            'offers' => []
        ];
        
        if($result[2] == 'No offers found'){
            $result = [];
        }
        
        foreach ($result as $k) {
            $hotelData = $this->getHotelData($k);
            if($hotelData['min_price'] > 0){
                $return['offers'][] = $hotelData;
            }
           // $return['offers'][] = $this->getHotelData($k);
        }

        return $return;
    }

    public function getHotelData($data) {

        require_once PATH . '/system/simple_html_dom.php';

        $k = $data[2];

        $html = str_get_html($k);

        $locs = (string) $html->find('.search-i-location', 0)->plaintext;
        $locs = explode(',', $locs);

        $priceM = (string) $html->find('.rateplan--price--value', 0)->plaintext;
        $price = (int) mb_substr(str_replace('.', '', $priceM), 0, -2);
        
        $starArr = [];
        $starArr[5] = ($html->find('.search-i-stars_5', 0)) ? 1 : 0;
        $starArr[4] = ($html->find('.search-i-stars_4', 0)) ? 1 : 0;
        $starArr[3] = ($html->find('.search-i-stars_3', 0)) ? 1 : 0;
        $starArr[2] = ($html->find('.search-i-stars_2', 0)) ? 1 : 0;
        
        $star = 1;
        foreach($starArr as $k => $a){
            if($a == 1){
                $star = $k;
                break;
            }
        }
      
        $hotel = [
            'place' => [
                'id' => $data[10],
                'photo' => (string) $html->find('img', 0)->{'data-src'},
                'photos' => [(string) $html->find('img', 0)->{'data-src'}],
                'name' => htmlspecialchars_decode((string) $html->find('.search-i-title', 0)->plaintext,ENT_QUOTES),
                'location' => [
                    'name' => (trim($locs[0])),
                    'subregion' => trim($locs[1]),
                    'country' => trim($locs[2])
                ],
                'stars' =>  $star,
                'score' =>  (string) $html->find('.aggregate-score',0)->innertext
            ],
            'min_price' => $price,
            'quantity' => 0
        ];

        return $hotel;
    }
    
    public function getFilterData($data){
        $tmp = '';
        $index = '';
        $return = [];
        foreach($data as $d){
            
            $prefix = $d[4];
            if($prefix != null && strlen($prefix) > 6){
                $tmp = str_replace(['~:','-'],['','_'],$prefix);
                $index = $d[2];
            }else if($prefix != null){
                $index = $d[2];
            }
            
            if($prefix == null){
                $return[$tmp][$index] = $d;
            }
            
        }
        
        return $return;
    }

    public function offers() {

        return $this->offersBot();

        $url = $this->endPoint . 'places?' . $this->params;

        $this->setHeaders();
        return $this->request($url);
    }

    public function hotel() {

        $url = $this->endPoint . 'places/' . ($this->hotelId) . '?' . $this->params;
        $this->setHeaders();
        return $this->request($url);
    }
    
    public function getHotelFeatures($id) {
        
        $url = $this->botPoint . 'hotelxx/p/'.$id;
        $this->header = [];
        $content = $this->request($url, 'GET',null,true);
        
        require_once PATH . '/system/simple_html_dom.php';
        $html = str_get_html($content);
        
        $return = [];
        
        foreach($html->find('.place-halal-features-group') as $key => $element){
            $return[$key] = ['title' => $element->find('.place-info--subtitle',0)->plaintext , 'children' => []];
            foreach($element->find('.place-info-list') as $subElement){
                $return[$key]['children'][] = $subElement->plaintext;
            }
        }
        
        return $return;
    }

    public function createBooking($data) {

        $groups = count($data['traveller']);

        $params = array(
            "test" => $this->isTest,
            "title" => 'Mr',
            "first_name" => $data['personal']['name'],
            "last_name" => $data['personal']['surname'],
            "email" => \Helper\Config::get('HALALBOOKING_MAIL'), //$data['personal']['email'] ,
            "phone" => \Helper\Config::get('HALALBOOKING_PHONE'), //$data['personal']['phone'] ,
            "notes" => "", // "Baby cot required",
            "country_code" => $data['personal']['country'],
            "stages_attributes" => [
                array(
                    "checkin_on" => $data['date']['start'],
                    "checkout_on" => $data['date']['end'],
                    "place_id" => $data['hotel']['giata'],
                    "accommodations" => [
                        array(
                            "group" => (string) $groups,
                            "room_id" => $data['room_id'],
                            "rate_plan_id" => $data['rate_plan_id']
                        )
                    ]
                )
            ],
            "payment_attributes" => [
                "currency" => \Model\User\Customer::getCurrency()
            ]
        );

        // json app
        $url = $this->endPoint . 'bookings';

        array_push($this->header, 'content-type: application/json');
        return $this->request($url, 'POST', json_encode($params));
    }

    public function search($term) {
        $data = $this->request($this->botPoint . 'search/destinations?term=' . $term, 'GET');
        if (isset($data->results)) {
            return $data->results;
        }
        return [];
    }

    public function request($url, $method = 'GET', $data = NULL , $raw = false) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $this->header
        ));

        if ($data != NULL) {
            //  curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if($raw){
            return $response;
        }
        return json_decode($response);
    }

}
