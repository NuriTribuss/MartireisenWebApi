<?php

namespace Application\Api\Engine;

use Model\Providers\Connector;
use Core\Base\Service;
use Model\Region\State;
use Elasticsearch\ClientBuilder;

class Search extends Service {
            
    private $connector;
    
    function __construct() {
        parent::__construct();
        $this->connector = new Connector();
    }
    
    public function get() {
        
        $data = \Helper\Input::json();
        $loc = \Helper\Input::post('loc',0);
        
        //$this->connector->setFilter($this->getFilter());
        $regions = $this->connector->completions($data->q,$data->type,$loc);
        
        $this->response->setData($regions)->setStatus(true)->out();
    }
    
    public function suggest($term = '') {

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
                    //'code' => $record->code,
                    'code' => $record->traffics_code,
                    'traffics_code' => $record->traffics_code,
                    'type' => $record->type,
                    'name' => $record->name,
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
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
    
}