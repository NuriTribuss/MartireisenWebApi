<?php
    
namespace Model\Api\Client;

use GuzzleHttp\Client;

Class Travelit extends Api {

    public $api_url = '';
    public $api_secure_url;
    public $api_gate;

    public $lang = "";
    public $isBookingPage = false;

    /** Travel It auth.
     * &CFG=[CFG] parameter
     */
    private $cfg;

    /** Travel It booking auth.
     * &CFG=[CFG] parameter
     */
    private $secure_cfg;

    /** Travel It auth.
     * &XPWP=[XPWP] parameter
     */
    private $xpwp;

    /**
     * IP-address of the client.
     * &IP=[IP] parameter
     */
    private $ip;

    /** Journey type.
     * &SF=[SF] parameter
     * &SF=3 = accommodation only
     * &SF=1 = Flight only
     * &SF=10 = Oneway-Flights
     * &SF=2 = package offers
     * &SF=20 = package offers "city destinations"
     * &SF=30 = accommodation only "city destinations"
     */
    public $sf;

    
    /** Earliest date of departure.
     * &VON=[VON] parameter
     *
     * Two way you can sent
     *
     * 1. Earliest departure with a static date
     * VON=2015-08-12(YYYY-MM-DD) OR VON=150812 (YYMMDD)
     *
     * 2.Earliest departure with a relative date
     * VON=1 (earliest departure tomorrow (today +1))
     * VON=28 (earliest departure in 4 weeks  (today +28))
     */
    private $von;

    /** Latest return date.
     * &BIS=[BIS] parameter
     *
     * Two way you can sent
     *
     * 1. Return date with a static date:
     * VON=2015-09-10(YYYY-MM-DD) OR VON=150910 (YYMMDD)
     *
     * 2. Return date with relative date:
     * VON=31 (latest return in one month (today +31))
     * VON=49 (latest return in 7 weeks  (today +49))
     */
    private $bis;

    /** Minimum duration.
     * &LMIN=[LMIN] parameter
     * Sets the minimum duration in days.
     * All search requests will generally work without these parameters,
     * but will respond with any results.
     */
    private $lmin;

    /** Maximum duration.
     * &LMAX=[LMAX] parameter
     * Sets the maximum duration in days. Muss be greater than LMIN.
     * All search requests will generally work without these parameters,
     * but will respond with any results.
     */
    private $lmax;

    /** Optional parameter AGENT
     * &AGENT=[agent] parameter
     * Using the optional parameter AGENT booking orders can be directly related to
     * a specific affiliate or a marketing campaign
     * The parameter AGENT can contain alphanumeric values up to 20 characters.
     */
    private $agent;

    /**
     * Options for request
     * @var array
     */
    private $options = [];

    /**
     * Default options for quick request
     * @var array
     */
    private $default_options = [];

    /**
     * TravelitApi constructor.
     * @param $secure
     */
    public function __construct($secure = false) {
        
        $this->api_url              = \Helper\Config::get('TRAVELIT_API_URL');
        $this->api_aflights_url     = \Helper\Config::get('TRAVELIT_API_ALTERNATIVE_FLIGHTS_URL');
        $this->api_secure_url       = \Helper\Config::get('TRAVELIT_API_BOOK_URL');
        $this->api_tc_url           = \Helper\Config::get('TRAVELIT_API_TERMS_AND_CONDITIONS_URL');
        $this->cfg                  = $secure == false ? \Helper\Config::get('TRAVELIT_CFG') : \Helper\Config::get('TRAVELIT_SECURE_CFG');
        $this->xpwp                 = \Helper\Config::get('TRAVELIT_XPWP');
        
        $this->api_gate = new Client(['base_uri' => $secure == false ? $this->api_url : $this->api_secure_url]);
        
        $this->options = [
            'SF'=>'2',
            'RA'=>'1',
            'VON'=>date('ymd' , strtotime('+20 days')),
            'BIS'=>date('ymd',strtotime('+50 days')),
            'LMIN'=>'7',
            'LMAX'=>'10',
           // 'CUR' => 'CHF'
        ];

    }
    
    // endpoint traffics.de için
    public function endpoint($endpoint = '') {
        
    }
    
    public function isBookingPage() {
        return $this->isBookingPage;
    }
    
    public function getOptions() {
        return $this->options;
    }
    
    public function setParams($key,$value) {
        $this->options[$key] = $value;
    }
    
    public function resetParam($key) {
        unset($this->options[$key]);
    }
    
    public function setType($type) {
        $this->options['SF'] = $type;
    }
    
    public function setAdults($value) {
        $this->options['RA'] = $value;
    }
    
    public function setChildren($children) {
        foreach($children as $key =>  $child){
            $child = (array)$child;
            $this->options['KA'.($key+1)] = $child['jahre'];
        }
    }
    
    public function setDate($opts) {
        $this->options['VON'] =  date('ymd',$opts['start']);
        $this->options['BIS'] =  date('ymd',$opts['end']);
    }
    
    public function setCity($city) {
        
        $this->options['MGRP'] = 1;
        $this->options['OFI'] = $city;
    }
    
    public function setCoordinate($coordinate) {
        $this->options['MGRP'] = 1;
        $this->options['GEOCOORD'] = $coordinate.',10000';
    }
 
    public function setState($state) {
        
        $this->options['MGRP'] = 1;
        $this->options['ZIEL'] = $state;
    }
    
    public function setRegion($region) {
        $this->options['REGION'] = $region;
    }
    
    
    public function setHotel($gid) {
        
        $this->options['MGRP'] = 1;
        $this->options['GID'] = $gid;        
    }
    
    public function setDuration($duration) {
        
        if($duration < 0){
            unset($this->options['LMIN']);
            unset($this->options['LMAX']);
        }
        $explode = explode('-', $duration);
        if(isset($explode[0])){
            $this->options['LMIN'] = (int)$explode[0];
        }
        if(isset($explode[1])){
            $this->options['LMAX'] = (int)$explode[1];
        }else{
            $this->options['LMAX'] = (int)$duration +1;
        }
        
    }
    
    public function setDeparture($code) {
        $this->options['RW'] = $code;
    }
    
    public function setOperators($code) {
        $this->options['VC'] = $code;
    }
    
    public function setStar($star) {
        $this->options['ST'] = (int)$star;
    }
    
    public function setReview($rate) {
        $this->options['MINRECOMMRATE'] = (int)$rate;
    }
    
    public function setRoom($room) {
        $this->options['ZA'] = $room;
    }
    
    public function setPansion($pansion) {
        $pansion = $pansion == 5 ? 6 : $pansion;
        $this->options['VA'] = $pansion;
    }
    
    public function setTransfer($transfer) {
        $this->options['MT'] = $transfer;
    }
    
    public function setSeaView($transfer) {
        $this->options['SEAVIEW'] = $transfer;
    }
    
    public function setGlobalTypes($types) {
        $this->options['GT'] = implode(',', $types);
    }
    
    public function setTravelTypes($hexCode) {
        $this->options['ATOR'] = $hexCode;
    }
    
    public function setDepMaxTimeFlt($param = '') {
        $this->options['DEPMAXTIMEFLT'] = $param;
    }

    public function setPriceMax($param = '') {
        $this->options['PMAX'] = $param;
    }
    
    public function setDepMinTimeFlt($param = '') {
        $this->options['DEPMINTIMEFLT'] = $param;
    }

    public function setRetMaxTimeFlt($param = '') {
        $this->options['RETMAXTIMEFLT'] = $param;
    }

    public function setRetMinTimeFlt($param = '') {
        $this->options['RETMINTIMEFLT'] = $param;
    }

    public function setLanguage($lang){
        $this->lang = $lang;
        return $this;
    }
    
    public function setCurrency($cur) {
        $this->options['CUR'] = $cur;
         $this->options['WKZ'] = $cur;
    }
    
    public function setLimit($limit = 30) {
        $this->options['TPS'] = $limit;
        return $this;
    }
    
    public function setGiata($giataArr) {
        $this->options['HOTLIST'] = implode(',', $giataArr);
    }

    public function queryBuilder($merge = true) {
        if($merge == false){
            return $this->options;
        }
        return array_merge(['CFG'=>$this->cfg, 'XPWP'=>$this->xpwp, 'LANG'=>$this->lang], $this->options);
    }

    /**
     * Get the results.
     * @return string
     */
    public function getResults() {          
        
        return (string)$this->api_gate->request('GET', '', [
            'query' => $this->queryBuilder()
        ])->getBody();
    }

    /**
     * Convert result to xml data.
     * @return object
     */
    public function toXml() {
        $resp = $this->getResults();
        $resp = str_replace('<br />','',$resp);
        $xml = simplexml_load_string($resp);        
        return $xml;
    }

    /**
     *  Get results.
     * @return object
     */
    public function toJson() {
        $k = json_encode($this->toXml());
        return $k;
    }
    
    public function toArray() {
        $c =  json_decode($this->toJson(),true);
        return $c;
    }
    /**
     * This function help the merge extra option values
     * @param $extra_options
     * @return $this
     */
    public function mergeWithOptions($extra_options) {
        $this->options = array_merge(count($this->options) > 0 ? $this->options : $this->default_options,
            array_merge(...$extra_options)
        );
        return $this;
    }

    /**
     * Prepare the country array for request
     * @param $countries
     * @return array
     */
    public function prepareCountriesForRequest($countries) {
        return count($countries) > 0 ? ['REGION' => implode('/',$countries)] : [];
    }

    /**
     * Prepare the cities array for request
     * @param $cities
     * @return array
     */
    public function prepareCitiesForRequest($cities) {
        return count($cities) > 0 ? ['ZIEL' => implode('/',$cities)] : [];
    }

    /**
     * Set the pagination for requests
     * @param $limit
     * @param $offest
     * @return $this
     * TPOS => hotel termine sayfalama
     * POS => Hotel sayfalama
     */
    public function setPagination($limit, $offest = 1, $tpos = 'POS') {

        $this->mergeWithOptions([['APS' => $limit,$tpos  => $offest]]);

        return $this;
    }

    /**
     * Filter for narrowing the search via Cities
     * Notice: Also we can use SO instead of OFI
     * @param $city_id
     * @return $this
     */
    public function filterWithCityId($city_id) {
        $this->mergeWithOptions([['OFI' => $city_id]]);

        return $this;
    }

    /**
     * Get all offers, don't check is it bookable or not
     *
     * @param bool $on_request
     * @return $this
     */
    public function getAllOffers($on_request = false) {
        $this->mergeWithOptions([['AV' => $on_request == false ? 0 : 2]]);

        return $this;
    }

    /**
     * Get bookable offers, you don't need to use every time this function,
     * api is default get only bookable
     *
     * @return $this
     */
    public function getBookableOffers() {
        $this->mergeWithOptions([['AV' => 3]]);

        return $this;
    }

    /**
     * Searching hotels in a certain radius
     *
     * @param $latitude (example: 36.8969)
     * @param $longitude (example: 30.7133)
     * @param $radius_meters
     * @return $this
     */
    public function searchHotelsInCertainRadius(string $latitude, string $longitude, string $radius_meters) {
        $radius_location_area = [$latitude, $longitude, $radius_meters];
        $this->mergeWithOptions([['GEOCOORD' => implode(',',$radius_location_area)]]);

        return $this;
    }

    /**
     * Request for region page
     *
     * @param array $countries
     * @param array $cities
     * @param string $short_by (PRICE, NAME, TOP)
     * @return mixed
     */
    public function searchDestinations($countries = [], $cities = [], $short_by = null) {
        $extra_options = [
            $this->prepareCountriesForRequest($countries),
            $this->prepareCitiesForRequest($cities),
            is_null($short_by) ? [] : ['RSORT' => $short_by]
        ];
        $this->mergeWithOptions($extra_options);

        return $this;
    }

    /**
     * Get the offer page
     * Parameter MGRP you can manipulate the grouping of the offers per hotel.
     * $mgrp = 0 "grouped", $mgrp = 1 "ungrouped" and $mgrp = 2 "partially grouped"
     * $short_by (PRICE, GPRICE, VA, NAME, ORT, CAT, RATING, RECOMRATE, RECOMAMT )
     *
     * @param int $mgrp
     * @param array $cities
     * @param null $short_by
     * @param null $departure
     * @param null $arrival
     * @return object
     */
    public function groupedOfferPage($mgrp = 1, $cities = [], $short_by = null, $departure = null, $arrival = null) {
        $extra_options = [
            ['MGRP' => $mgrp],
            $this->prepareCitiesForRequest($cities),
            is_null($short_by) ? [] : ['HSORT' => $short_by],
            ['APTD' => $arrival],
            ['RW' => $departure],
        ];
        $this->mergeWithOptions($extra_options);

        return $this;
    }

    /**
     * Search flights with destination airport.
     *
     * $destination_airport is string if you want to send more airport please use array.
     * @param $destination_airport
     * @return $this
     */
    public function searchFlightsWithDestinationAirport($destination_airport) {
        $this->default_options['SF'] = 1;
        $extra_options = [
            ['ZIEL' => is_array($destination_airport) ? implode(',', $destination_airport) : $destination_airport]
        ];
        $this->mergeWithOptions($extra_options);

        return $this;
    }

    /**
     *  Call-up the grouped hotel page
     *
     * @param $gid
     * @param $city
     * @param int $mgrp
     * @param int $offset
     * @param null $short_by
     * @param null $arrival
     * @return $this
     */
    public function groupedHotelPage($gid, $city, $mgrp = 1, $offset = 1, $short_by = null, $departure = null, $arrival = null) {
        $extra_options = [
            ['GID' => $gid],
            ['MGRP' => $mgrp],
            ['TPOS' => $offset],
            ['ZIEL' => is_array($city) ? implode('/', $city) : $city],
            ['APTD' => $arrival],
            ['RW' => $departure],
            is_null($short_by) ? [] : ['TSORT' => $short_by]
        ];
        $this->mergeWithOptions($extra_options);

        return $this;
    }

    /**
     * Get alternative flights. Notice: Every parameter you have single hotel page.
     *
     * @param $gid
     * @param $source
     * @param $aptz
     * @param $versant
     * @param $ref
     * @param $sf
     * @param $datum
     * @param $rrtag
     * @param $adults
     * @return $this
     */
    public function alternativeFlights($gid, $source, $aptz, $versant, $ref, $sf, $datum, $rrtag, $adults) {
        $this->api_gate = new Client(['base_uri' => $this->api_aflights_url]);
        $this->options = [
            'SOURCE' => $source,
            'SF' => $sf,
            'VON' => $datum,
            'BIS' => $rrtag,
            'ZIEL' => $aptz,
            'HOTEL' => $gid,
            'VC' => $versant,
            'RA' => $adults,
            'BOOK' => $ref,
        ];

        return $this;
    }
    
    public function flightCheck($ref) {
        
        $client = new Client();
        try{
            $flightCheck = $client->post("http://flugzeiten.travel-it.com/FlugzeitenParser?cfg=".$this->cfg."&ref=".$ref, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
            ]);

            $flightCheck = simplexml_load_string($flightCheck->getBody()->getContents());
            $flightCheck = json_decode(json_encode($flightCheck), true);

            if($flightCheck['STATUS'] == 1){
                if(($flightCheck['FLIGHT_IN']['FLIGHT'][0] == NULL)) {
                    if(is_null($flightCheck['FLIGHT_IN']['FLIGHT'])){
                        $flightCheck['FLIGHT_IN']['FLIGHT'] = [];
                    }else{
                        $flightCheck['FLIGHT_IN']['FLIGHT'] = [$flightCheck['FLIGHT_IN']['FLIGHT']];
                    }
                }
                if(($flightCheck['FLIGHT_OUT']['FLIGHT'][0] == NULL)) {
                    if(is_null($flightCheck['FLIGHT_OUT']['FLIGHT'])){
                        $flightCheck['FLIGHT_OUT']['FLIGHT'] = [];
                    }else{
                        $flightCheck['FLIGHT_OUT']['FLIGHT'] = [$flightCheck['FLIGHT_OUT']['FLIGHT']];
                    }
                }
            }
            
            return $flightCheck;
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    
    public function getInsuranceInfo($data) {
        
        $client = new Client();
        
        $insuranceCheck = $client->get("http://addonservice.travel-it.com/OTAGetInsurance/getBaResponse?json=".  json_encode($data), [
            'headers' => [
               // 'Accept' => 'application/json',
                //'Content-type' => 'application/json',
            ],
        ]);
        
        $response = json_decode($insuranceCheck->getBody()->getContents(),true);
        if($response['ResponseData']['isError'] != 0){
            return false;
        }
        
        
        return $response['ResponseData']['InsurancePlans'];
    }
    
     


    /**
     * Get the booking page
     *
     * @param $gid
     * @param $ref
     * @param $city
     * @param int $mgrp
     * @return $this
     */
    public function bookingPage($gid, $ref, $city, $mgrp = 1) {
        
        unset($this->options['VC']);
        
        $this->api_gate = new Client(['base_uri' => $this->api_secure_url]);
        $this->cfg      = \Helper\Config::get('TRAVELIT_SECURE_CFG');
        
        $extra_options = [
            ['GID' => $gid],
            ['MGRP' => $mgrp],
            ['ZIEL' => is_array($city) ? implode('/', $city) : $city],
            ['BOOK' => $ref],
            ['LANG' => $this->lang]
        ];
        $this->mergeWithOptions($extra_options);
        return $this->toArray();
    }

    /**
     * Get the tour operator terms and conditions
     *
     * VC=[VERANST], DATUM=[YYYY-MM-DD], RART=[REISEART]
     * @param $vc
     * @param $rart
     * @param $datum
     * @return $this
     */
    public function tourOperatorTermsAndConditions ($vc, $datum, $rart = 'RART' ) {
        $this->api_gate = new Client(['base_uri' => $this->api_tc_url]);
        $extra_options = [
            ['VC' => $vc],
            ['RART' => $rart],
            ['DATUM' => $datum]
        ];
        $this->mergeWithOptions($extra_options);

        return $this;
    }

    /**
     * Booking confirmation method
     *
     * @param $gid
     * @param $ref
     * @param $mgrp
     * @param $vgnr , the webbooking order number (from page BOOK) example: 612274191
     * @param $agb
     * @param $kbm
     * @param $gp
     * @param $t_sobo
     * @param $r_anr , gender H, D
     * @param $r_name
     * @param $r_vname
     * @param $r_strasse
     * @param $r_plz
     * @param $r_ort
     * @param $r_land
     * @param $r_tel1
     * @param $r_email
     * @param $bem
     * @param $paymode , “1“ for payment by credit card or „2“ for payment debit with bank account number,
     * @param string $destination_airport_code ,
     * @param array $persons [["name" => "Ugur", "vname" => "CELIK", "alter" => "28", "anr" => "H"],["name" => "Diana", "vname" => "CELIK", "alter" => "22", "anr" => "D"]]
     *
     * @param array $insurance = []
     *
     * Needed infos returning from getInsurance method  Todo:: Ask Why they not get Cvc info in xml ???
     * $insurance['insurance_company'] Two option can end ERV or ELV , example: ERV
     * $insurance['insurance_company_name'] Full name of insurance company
     * $insurance['offerName'] getInsurance method contain offerName
     * $insurance['organizer'] example: XYZ (Indicator of the tour operator, ITS) already set inside getInsurance method
     * $insurance['amount'] getInsurance method contain amount
     * $insurance['isInsured'] getInsurance method contain isInsured (maybe ? just set it 1)
     *
     * @param array $payment_info = []
     *
     * $payment_info['credit_card_type'] = “MC“ for MasterCard, „VI“ for Visa, „AM“ for Amex
     * $payment_info['credit_card_month'] Month in format MM for valid until
     * $payment_info['credit_card_year'] Year in format YY for valid until
     * $payment_info['credit_card_number']
     * $payment_info['credit_card_cvc']
     * $payment_info['swift_code']
     * $payment_info['iban']
     * $payment_info['german_bank_name']
     * $payment_info['german_bank_code']
     * $payment_info['german_bank_account_number']
     * $payment_info['currency'] = EUR
     *
     * @param array $rentacar []
     *
     * $rentacar['provider_code'] (Code rental car provider) example: SCA1
     * $rentacar['provider_name'] (Name rental car provider) example: Sunny Cars
     * $rentacar['dropoff_type'] (type of pickup-location for rental car "AIRPORT", "STATION", "SPECIAL") example: AIRPORT
     * $rentacar['region_id'] (Code of rentalcar station) example: F1KNITB974
     * $rentacar['station_name'] (Name of rentalcar station) example: Son San Juan Aeropuerto, Palma de Mallorca
     * $rentacar['class'] (Code of rentalcar class) example: sca1_5wki_46_w3w
     * $rentacar['product_name'] (Name of rentalcar class) example: Hyundai i10 /AC/2dr
     * $rentacar['start_date'] (Rental start date ) example: 2018-11-21
     * $rentacar['end_date'] (Rental end date ) example: 2018-11-27
     * $rentacar['start_time'] (Rental start time minute and second) example: 1245
     * $rentacar['end_time'] (Rental end time minute and second) example: 1500
     * $rentacar['driver_gender'] , example: H
     * $rentacar['driver_surname'], example: Michael
     * $rentacar['driver_name'],  example: Mustermann
     * $rentacar['driver_age'], example: 30
     * $rentacar['price'], example: 77.0
     *
     * @param array $prices[]
     * $prices['travel_service_total'], total price for the main travel service for all, example: 765
     * $prices['travel_charge'], fee for chosen payment method, example: 08.00
     * $prices['travel_total'], total costs for main travel service, example: 773.00
     *
     *
     * @param $total_price, total costs for main travel service, all fees and all additional services example: 773
     *
     * @param string $language
     * @return $this
     */
    public function createBooking ($data, $isTest  = true) {
        
        $this->api_gate = new Client(['base_uri' => $this->api_secure_url]);
        $this->cfg      = \Helper\Config::get('TRAVELIT_SECURE_CFG');
        
        $paymode  = 10;
        $isSoft   = 1;
        $birthday = date('dmy',strtotime($data['personal']['birthday']));

        $extra_options = [
            ['GID'          => $data['booking']['ACCOMMODATION']['GID']],
         //   ['MGRP'         => $mgrp],
         //   ['ZIEL'         => $destination_airport_code],
            ['BOOK'         => $data['ref']],
            ['VGNR'         => $data['booking']['VGNR']],
            ['AGB'             => 1],
            ['ALLDATA_CHECKED' => 1],
            ['FORMSHEET_NOTED' => 1],
            ['KBM'          => count($data['children'])],
            ['GP'           => $data['booking']['GPREIS']],
            ['T_SOBO'       => $isSoft],
            ['R_ANR'        => $birthday],
            ['R_NAME'       => $isTest ? 'travel-IT' : $data['personal']['name']],
            ['R_VNAME'      => $isTest ? 'travel-IT' : $data['personal']['surname']],
            ['R_STRASSE'    => $data['personal']['address']],
            ['R_PLZ'        => $data['personal']['state']],
            ['R_ORT'        => $isTest ? 'Teststadt' : $data['personal']['city']],
            ['R_LAND'       => $data['personal']['country']],
            ['R_TEL1'       => $data['personal']['phone']],
            ['R_EMAIL'      => $data['personal']['email']],
            ['BEM'          => $isTest ? 'Testbuchung' : ''],
            ['PAYMODE'      => $paymode],
        ];

        $birthdays = [];
        
        $counter = 0;
        foreach ($data['traveller'] as $key => $person) {
            $counter  = $key + 1;
            $birthday = date('dmy',strtotime($person['birthday']));
            array_push($extra_options,["P{$counter}_NAME"  =>  $person['name']]);
            array_push($extra_options,["P{$counter}_VNAME" =>  $person['surname']]);
            array_push($extra_options,["P{$counter}_ALTER" =>  $birthday]);
            array_push($extra_options,["P{$counter}_ANR"   =>  $person['gender'] == 1 ? 'H' : 'D']);
            $birthdays[] = $birthday;
        }
        
        $counter++;
        
        foreach ($data['children'] as $key => $person) {
            $birthday = date('dmy',strtotime($person['birthday']));
            array_push($extra_options,["P{$counter}_NAME"  =>  $person['name']]);
            array_push($extra_options,["P{$counter}_VNAME" =>  $person['surname']]);
            array_push($extra_options,["P{$counter}_ALTER" =>  $birthday]);
            array_push($extra_options,["P{$counter}_ANR"   =>  'H' ]);
            $birthdays[] = $birthday;
            $counter++;
        }

        $birthdays     = implode(' ', $birthdays);
        $insurance_xml = '';
        
      /*  if(count($insurance) > 0) {
            $insurance_xml = '<VS><VS_EMAIL>'.$r_email.'</VS_EMAIL><VS_ANBIETER>'.$insurance['insurance_company'].'</VS_ANBIETER><VS_ANBIETERNAME>'.$insurance['insurance_company_name'].'</VS_ANBIETERNAME><VS_TARIFNAME>'.$insurance['offerName'].'</VS_TARIFNAME><VS_PRODUCTCODE>'.$insurance['code'].'</VS_PRODUCTCODE><VS_BIRTHDATES>'.$birthdays.'</VS_BIRTHDATES><VS_VON>'.$this->options["VON"].'</VS_VON><VS_BIS>'.$this->options["BIS"].'</VS_BIS><VS_VERANSTALTER>'.$insurance['organizer'].'</VS_VERANSTALTER><VS_GPRICE>'.$insurance['amount'].'</VS_GPRICE><VS_INSURED_PERS>'.$insurance['isInsured'].'</VS_INSURED_PERS><VS_DEST>'.$destination_airport_code.'</VS_DEST><VS_AGB>1</VS_AGB>';
            $insurance_xml .= '<LSKTO>'.$payment_info['german_bank_account_number'].'</LSKTO><LSBLZ>'.$payment_info['german_bank_code'].'</LSBLZ><LSBANK>'.$payment_info['german_bank_name'].'</LSBANK><LSIBAN>'.$payment_info['iban'].'</LSIBAN><LSSWIFT>'.$payment_info['swift_code'].'</LSSWIFT><CCTYP>'.$payment_info['credit_card_type'].'</CCTYP><CCNR>'.$payment_info['credit_card_number'].'</CCNR><CCMM>'.$payment_info['credit_card_month'].'</CCMM><CCYY>'.$payment_info['credit_card_year'].'</CCYY><PAYMODE>'.$paymode.'</PAYMODE></VS>';
        }*/

        $rentacar_xml = '';
       /* if(count($rentacar) > 0) {
            $rentacar_xml = '<MW2><MW_ANBIETER>' . $rentacar['provider_code'] . '</MW_ANBIETER><MW_ANBIETERNAME>' . $rentacar['provider_name'] . '</MW_ANBIETERNAME><MW_DROPOFFTYPE>' . $rentacar['dropoff_type'] . '</MW_DROPOFFTYPE><MW_REGIONID>' . $rentacar['region_id'] . '</MW_REGIONID><MW_STATION>' . $rentacar['station_name'] . '</MW_STATION><MW_KLASSE>' . $rentacar['class'] . '</MW_KLASSE><MW_PRODUCTNAME>' . $rentacar['product_name'] . '</MW_PRODUCTNAME><MW_VON>' . $rentacar['start_date'] . '</MW_VON><MW_BIS>' . $rentacar['end_date'] . '</MW_BIS><MW_ZEIT_VON>' . $rentacar['start_time'] . '</MW_ZEIT_VON><MW_ZEIT_BIS>' . $rentacar['end_time'] . '</MW_ZEIT_BIS><MW_ANREDE>' . $rentacar['driver_gender'] . '</MW_ANREDE><MW_VORNAME>' . $rentacar['driver_surname'] . '</MW_VORNAME><MW_NACHNAME>' . $rentacar['driver_name'] . '</MW_NACHNAME><MW_ALTER>' . $rentacar['driver_age'] . '</MW_ALTER><MW_EMAIL>' . $r_email . '</MW_EMAIL><MW_AGB>1</MW_AGB><MW_GPRICE>' . $rentacar['price'] . '</MW_GPRICE>';
            $rentacar_xml .= '<PAYMODE>' . $paymode . '</PAYMODE><LSBANK>' . $payment_info['german_bank_name'] . '</LSBANK><LSIBAN>' . $payment_info['iban'] . '</LSIBAN><LSSWIFT>' . $payment_info['swift_code'] . '</LSSWIFT><CCVENDOR>' . $payment_info['credit_card_type'] . '</CCVENDOR><CCNR>' . $payment_info['credit_card_number'] . '</CCNR><CCMM>' . $payment_info['credit_card_month'] . '</CCMM><CCYY>' . $payment_info['credit_card_year'] . '</CCYY><CCCVC>' . $payment_info['credit_card_cvc'] . '</CCCVC><CURRENCY>' . $payment_info['currency'] . '</CURRENCY><MW_LANGUAGE>' . $language . '</MW_LANGUAGE><SPECIAL_DESCRIPTION></SPECIAL_DESCRIPTION><SPECIAL_STREET></SPECIAL_STREET><SPECIAL_ZIPCODE></SPECIAL_ZIPCODE><SPECIAL_CITY></SPECIAL_CITY><SPECIAL_COUNTRY></SPECIAL_COUNTRY></MW2>';
        }*/

        $prices = '<REISE><REISE_GPRICE>'.$data['booking']['GPREIS'].'</REISE_GPRICE><REISE_CHARGE>0</REISE_CHARGE><REISE_TOTAL>'.$data['booking']['GPREIS'].'</REISE_TOTAL></REISE>';
        $total_price = '<TOTAL><TOTAL_GPRICE>'.$data['booking']['GPREIS'].'</TOTAL_GPRICE></TOTAL>';

        $xml_book = '<ZUSATZ>';
        $xml_book .= $insurance_xml.$rentacar_xml.$prices.$total_price;
        $xml_book .= '<ZUSATZ>';

        array_merge($extra_options,["XML_BOOK" => $xml_book]);
        
        //var_dump($extra_options);
        
        $this->mergeWithOptions($extra_options);
        return $this->toArray();
    }

}
