<?php

namespace Application\Service;

use Core\Base\Service;
use Model\Region\State;
use Model\Region\Defaults\State as StateDefault;
use Model\Region\Defaults\Country as RegionDefault;
use Model\Region\City as CityDefault;
use Elasticsearch\ClientBuilder;

/*
 *  Arama Algoritması
 */

class States extends Service {

    public function __construct() {

        parent::__construct();
    }

    public function get($term = '') {
        
        $term = empty($term) ? \Helper\Input::get('q') : $term;

        $halal = \Helper\Input::get('halal', 0);
        if ($halal == 0) {
            return $this->suggest($term);
        }

        return $this->suggestHalal($term);

        // kullanılmıyor
        $result = [];
        $resultC = [];
        $resultCi = [];

        $term = strip_tags($term);

        if (strlen($term) > 2) {

            $result = StateDefault::where('name', 'like', '%' . $term . '%')
                    ->limit(10)
                    ->get();

            if ($result !== NULL) {
                $result = $result->toArray();
            }

            foreach ($result as $key => $r) {
                $result[$key]['sort'] = 999;
                $result[$key]['label'] = $r['name'];
                $result[$key]['value'] = $r['name'];
            }

            $resultC = RegionDefault::where('halalbooking_term', 'like', '%' . $term . '%')->orWhere('name_de', 'like', '%' . $term . '%')->orWhere('name_tr', 'like', '%' . $term . '%')->orWhere('name', 'like', '%' . $term . '%')
                    ->limit(10)
                    ->get();

            if ($resultC !== NULL) {
                $resultC = $resultC->toArray();
            }

            foreach ($resultC as $key => $r) {
                $resultC[$key]['sort'] = 999;
                $resultC[$key]['label'] = $r['halalbooking_term'];
                $resultC[$key]['value'] = $r['halalbooking_term'];
            }
            $resultCi = CityDefault::where('name', 'like', $term . '%')
                    ->limit(10)
                    ->get();

            if ($resultCi !== NULL) {
                $resultCi = $resultCi->toArray();
            }

            foreach ($resultCi as $key => $r) {
                $resultCi[$key]['sort'] = 999;
                $resultCi[$key]['label'] = $r['name'];
                $resultCi[$key]['value'] = $r['name'];
            }
        }

        $this->response->setData(array_merge($resultC, $result, $resultCi))->setStatus(true)->out();
    }

    public function suggest($term) {

        if (empty($term)) {
            $term = \Helper\Input::post('q');
        }

        try {

            $client = ClientBuilder::create()->build();
            $params = [
                'index' => 'states',
                'type' => 'states',
                'body' => [
                    'query' => [
                        "match_phrase_prefix" => [
                            "keywords" => [
                                'query' => ($term),
                            /* 'fuzziness' => 1, */
                            ],
                        ]
                    ],
                ]
            ];
            
            $params2 = [
                'index' => 'states',
                'type' => 'states',
                'body' => [
                    'query' => [
                        "bool" => [
                            "should" => [                          
                                "match_phrase_prefix" => [
                                    'name' => [
                                        'query' => \Helper\Input::replaceTr($term),
                                    ] 
                                /* 'fuzziness' => 1, */
                                ],
                                "match_phrase_prefix" => [
                                    'keywords' => \Helper\Input::replaceTr($term),
                                /* 'fuzziness' => 1, */
                                ],
                            ]
                        ]
                    ],
                ]
            ];

            $response = $client->search($params);
            $result = $response['hits']['hits'];

            $output = [];
            foreach ($result as $key => $record) {
                $record = (object) $record['_source'];

                $output[$key] = array(
                    'sort' => 1,
                    'code' => $record->code,
                    'label' => $record->name,
                    'value' => $record->name,
                    'is_country' => (int) $record->is_country,
                    'is_city' => (int) $record->is_city
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $this->response->setData($output)->setStatus(true)->out();
    }

    public function suggestHalal($term) {

        $halalApi = new \Model\Api\Client\HalalBooking();
        $result = $halalApi->search($term);

        $output = [];
        foreach ($result as $key => $record) {
            
            if($record->{'search-type'} == 'property'){
                continue;
            }
            $output[$key] = array(
                'sort' => 1,
                'code' => $record->id,
                'label' => $record->name,
                'value' => $record->name,
                'is_country' => (int) $record->type == 'country',
                'is_city' => (int) $record->type == 'city',
                'count' =>  $record->properties-count,
                'raw' => $record
            );
        }
        
        $this->response->setData($output)->setStatus(true)->out();
        
    }

    public function favourites() {

        $this->dbCache->setKey('favourite_states');
        $data = $this->dbCache->pull();

        if ($data == false) {
            $data = State::where(array('is_favourite' => 1))->limit(10)->get();
            $this->dbCache->put($data);
        }

        $this->response->setData($data)->setStatus(true)->out();
    }

    public function populars() {

        $this->dbCache->setKey('popular_states');
        $data = $this->dbCache->pull();

        if ($data == false) {
            $data = State::where(array('is_popular' => 1))->limit(500)->get();
            $this->dbCache->put($data);
        }

        $this->response->setData($data)->setStatus(true)->out();
    }

    public function getDefaults($country_code = '') {

        if (empty($country_code)) {
            return false;
        }

        $this->dbCache->setKey('states_default' . $country_code);
        $data = $this->dbCache->pull();

        if ($data == false) {
            $data = StateDefault::where(array('country_id' => $country_code))->orderBy('name', 'ASC')->limit(500)->get();
            $this->dbCache->put($data);
        }

        $this->response->setData($data)->setStatus(true)->out();
    }

}
