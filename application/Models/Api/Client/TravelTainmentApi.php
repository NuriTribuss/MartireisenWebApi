<?php


namespace Model\Api\Client;

use GuzzleHttp\Client;


class TravelTainmentApi extends Api {

    /** Http digest username*/
    private $username;

    /** Http digest password*/
    private $password;

    /**
     * Is a parameter similar to the SessionID, which serves to assign several
     * RQ/RS to a communication workflow. This field can be freely used and
     * the TT-XML always mirrors its content.
     *
     * @var string
     */
    public $clientSessionID;

    /**
     * Language code this languages you can use:
     * ar-AE|ar-BH|ar-DZ|ar-EG|
     * ar-IQ|ar-JO|ar-KW|ar-LB|ar-LY|ar-MA|ar-OM|
     * ar-QA|ar-SA|ar-SY|ar-TN|ar-YE|de-AT|de-CH|
     * de-DE|de-LI|de-LU|en-AU|en-BZ|en-CA|en-CB|
     * en-GB|en-IE|en-IN|en-JM|en-MY|en-NZ|en-PH|
     * en-SG|en-TT|en-US|en-ZA|en-ZW|es-AR|es-BO|
     * es-CL|es-CO|es-CR|es-DO|es-EC|es-ES|es-GT|
     * es-HN|es-MX|es-NI|es-PA|es-PE|es-PR|es-PY|
     * esSV|es-UY|es-VE|fr-BE|fr-CA|fr-CH|fr-FR|fr-LU|
     * gd-IE|it-CH|it-IT|ms-BN|ms-MY|nl-BE|nl-NL|plPL|
     * pt-BR|pt-PT|ro-MO|ro-RO|ru-MO|ru-RU|svFI|sv-SE|
     * zh-CN|zh-HK|zh-MO|zh-TW
     *
     * @var string
     */
    public $languageCode;

    /**
     * This attribute contains a SessionID created by the TravelTainment
     * systems and should always be mirrored by the user of the TT-XML,
     * provided that a SessionID exists. At the moment this field is only
     * required for the booking process.
     *
     * Example: 1ec6764c-56da-40f4-8d71-e1cbb0b5f480
     *
     * @var string
     */
    public $sessionID;

    /**
     * Client Ip address
     *
     * @var string
     */
    public $clientIP;

    /**
     * The target has to be indicated to define the environment of the request.
     * Fake should be used for tests here and Production for live operations.
     *
     * @var string (Fake|Production|Test)
     */
    public $target;


    /**
     * If test true
     */
    public $isTest;

    /**
     * Is a parameter similar to the SessionID which serves to assign several
     * RQ/RS to a communication workflow. This field can be freely used and
     * the TT-XML always mirrors its content.
     *
     * @var string
     */
    public $trackingID;

    /** Customer Id*/
    public $cid;

    /** GuzzleHttp api gate */
    public $apiGate;

    /** Api url */
    public $apiUrl;

    /** Request url for post and receive data */
    public $apiRequestUrlSlug;

    /** Request xml body */
    public $requestXmlBody;

    /** Current Timestamp: Atom time */
    public $currentTimestamp;

    /** Expects a list with currency codes to receive respective price indications in the response.
     * Please set under .env file
     * Values:
     * AED|AFN|ALL|AMD|ANG| AOA|ARS|AUD|AWG|AZN|BAM|BBD|BDT| BGN|BHD|BIF|BMD|BND|BOB|BOV|BRL| BSD|BTN|BWP|BYR|BZD|CAD|CDF|CHE|CHF|
     * CHW|CLF|CLP|CNY|COP|COU|CRC|CUC| CUP|CVE|CZK|DJF|DKK|DOP|DZD|EGP|ERN| ETB|EUR|FJD|FKP|GBP|GEL|GHS|GIP|GMD| GNF|GTQ|GYD|HKD|
     * HNL|HRK|HTG|HUF| IDR|ILS|INR|IQD|IRR|ISK|JMD|JOD|JPY|KES| KGS|KHR|KMF|KPW|KRW|KWD|KYD|KZT| LAK|LBP|LKR|LRD|LSL|LTL|LVL|LYD|
     * MAD| MDL|MGA|MKD|MMK|MNT|MOP|MRO|MUR| MVR|MWK|MXN|MXV|MYR|MZN|NAD|NGN| NIO|NOK|NPR|NZD|OMR|PAB|PEN|PGK|PHP| PKR|PLN|PYG|QAR|
     * RON|RSD|RUB|RWF| SAR|SBD|SCR|SDG|SEK|SGD|SHP|SLL|SOS| SRD|STD|SYP|SZL|THB|TJS|TMT|TND|TOP| TRY|TTD|TWD|TZS|UAH|UGX|USD|USN|USS|
     * UYU|UZS|VEF|VND|VUV|WST|XAF|XAG| XAU|XBA|XBB|XBC|XBD|XCD|XDR|XFU| XOF|XPD|XPF|XPT|XTS|XXX|YER|ZAR|ZMK| ZWL
     */
    public $additionalCurrencies;

    /** Current currency in request
     * Please set under .env file
     * Values:
     * AED|AFN|ALL|AMD|ANG| AOA|ARS|AUD|AWG|AZN|BAM|BBD|BDT| BGN|BHD|BIF|BMD|BND|BOB|BOV|BRL| BSD|BTN|BWP|BYR|BZD|CAD|CDF|CHE|CHF|
     * CHW|CLF|CLP|CNY|COP|COU|CRC|CUC| CUP|CVE|CZK|DJF|DKK|DOP|DZD|EGP|ERN| ETB|EUR|FJD|FKP|GBP|GEL|GHS|GIP|GMD| GNF|GTQ|GYD|HKD|
     * HNL|HRK|HTG|HUF| IDR|ILS|INR|IQD|IRR|ISK|JMD|JOD|JPY|KES| KGS|KHR|KMF|KPW|KRW|KWD|KYD|KZT| LAK|LBP|LKR|LRD|LSL|LTL|LVL|LYD|
     * MAD| MDL|MGA|MKD|MMK|MNT|MOP|MRO|MUR| MVR|MWK|MXN|MXV|MYR|MZN|NAD|NGN| NIO|NOK|NPR|NZD|OMR|PAB|PEN|PGK|PHP| PKR|PLN|PYG|QAR|
     * RON|RSD|RUB|RWF| SAR|SBD|SCR|SDG|SEK|SGD|SHP|SLL|SOS| SRD|STD|SYP|SZL|THB|TJS|TMT|TND|TOP| TRY|TTD|TWD|TZS|UAH|UGX|USD|USN|USS|
     * UYU|UZS|VEF|VND|VUV|WST|XAF|XAG| XAU|XBA|XBB|XBC|XBD|XCD|XDR|XFU| XOF|XPD|XPF|XPT|XTS|XXX|YER|ZAR|ZMK| ZWL
     */
    public $currencyCode;

    /**
     * TravelTainmentApi constructor.
     * @param $productType string. Values: Package, Hotel, Flight, Holiday_Home, ShoppingCart, ThirdParty
     */
    public function __construct($productType)
    {
        if (!in_array($productType, ['Package', 'Hotel', 'Flight', 'Holiday_Home', 'ShoppingCart', 'ThirdParty'])) {
            die ('Plesee set correct product type');
        }

        $this->apiUrl   = \Helper\Config::get('TRAVELTAINMENT_API_TEST_URL');
        $this->username = \Helper\Config::get('TRAVELTAINMENT_USERNAME');
        $this->password = \Helper\Config::get('TRAVELTAINMENT_PASSWORD');

        $this->setGlobals();

        $this->apiGate = new Client(['base_uri' => $this->apiUrl]);
    }

    public function getResults() {
        // ToDo:: Make json
        $response =  $this->apiGate->request(
            'POST',
            $this->apiUrl.$this->apiRequestUrlSlug,
            [
                'headers' => ['Content-type' => 'text/xml; charset=UTF-8'],
                'auth' => [
                    $this->username,
                    $this->password,
                    'digest'
                ],
                'body' => $this->requestXmlBody,
            ]
        )->getBody()->getContents();

        return json_encode(simplexml_load_string($response));
    }

    public function setGlobals() {
        $this->additionalCurrencies = '';//env('TRAVELTAINMENT_API_Additional_Currencies');
        $this->currencyCode = 'EUR'; //env('TRAVELTAINMENT_API_Current_Currency');
        $this->currentTimestamp = gmdate(DATE_ATOM);
        $this->target = 'Fake';
        $this->isTest = 'true';
        $this->languageCode = 'de-DE';
        $this->trackingID = uniqid('TR-',false);
        $this->clientSessionID = session_id();//session()->getId();
        $this->sessionID =session_id();//session()->getId();
        $this->clientIP = $_SERVER['REMOTE_ADDR'];

    }


    /**
     * Available for: Package, Hotel, Flight, Holiday_Home
     *
     * @param null $cid
     * @return $this
     */
    public function searchEngineRegionTree($cid = null) {
        $this->apiRequestUrlSlug = 'RegionTree';
        $this->requestXmlBody = '<t:SearchEngineRegionTreeRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineRegionTreeRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'"/>';

        return $this;
    }


    /**
     *
     * Available for: Package, Hotel
     *
     *
     * @param string $departureAirportCountryCode :
     *
     * AD|AE|AF|AG|AI|AL|AM| AO|AQ|AR|AS|AT|AU|AW|AX|AZ|BA|BB|BD| BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BQ|BR|BS| BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK| CL|CM|CN|CO|CR|CU|CV|CW|CX|CY|CZ|DE|
     * DJ|DK|DM|DO|DZ|EC|EE|EG|EH|ER|ES|ET|FI| FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI| GL|GM|GN|GP|GQ|GR|GS|GT|GU|GW|GY|HK| HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS| IT|JE|JM|JO|JP|KE|
     * KG|KH|KI|KM|KN|KP|KR| KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV| LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX| MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR| NU|NZ|OM|PA|
     * PE|PF|PG|PH|PK|PL|PM|PN|PR| PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC| SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|SS|ST| SV|SX|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM| TN|TO|TR|TT|TV|TW|TZ|UA|UG|
     * UM|US|UY| UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|YE|YT| ZA|ZM|ZW
     *
     * @param string $departureDate
     * Example: "2019-03-02+02:00"
     * @param string $returnDate
     * Example: "2019-03-16+02:00"
     *
     *
     * @param array $travellerAges
     * Example: [54,46,5]
     *
     *
     * @param array $departureAirports
     * Example: ['FRA','DUS','CGN']
     *
     * @param int $minDays
     * @param int $maxDays
     *
     * @param int $resultsPerPage
     *
     * @param int $resultOffset
     *
     * @param string $order
     * Expects the indication of the sorting order. (Ascending or Descending)
     * Example: 'Ascending'
     *
     *
     * @param string $groupByRegion
     * Expects the indication if the results should be sorted by region groups. (false or true)
     * Example: 'false'
     *
     * @param string $postsorting
     * Expects the indication of the sorting criterion
     * Parameters :  AirTemperature|Alphabetic|FlightDuration|Price|WaterTemperature
     * Example = 'Alphabetic'
     *
     * @param $weightage
     * Weightage int: range=[0,100] (Weighting = Ağırlık)
     *
     * @param array $skipTourOperators
     *
     * @param array $limitTourOperators
     *
     * @return $this
     */
    public function searchEngineSimpleRegionList(string $departureAirportCountryCode, string $departureDate, string $returnDate, array $travellerAges, array $departureAirports, int $minDays, int $maxDays, int $resultsPerPage = 20, int $resultOffset = 0, string $order = 'Ascending', string $groupByRegion = 'false', string $postsorting = 'Alphabetic', $weightage = null, array $skipTourOperators = [], array $limitTourOperators = []) {
        $this->apiRequestUrlSlug    = 'SimpleRegionList';
        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedDepartureAirports  = $this->prepareDepartureAirports($departureAirports);

        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);

        $weightage = $this->prepareWeightAge($weightage);

        $this->requestXmlBody = '<t:SearchEngineSimpleRegionListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineSimpleRegionListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <DepartureAirportCountry>'.$departureAirportCountryCode.'</DepartureAirportCountry>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <DepartureAirportList'.$weightage.'>'.$preparedDepartureAirports.'</DepartureAirportList>
         <TravelDateSpan>
         <DepartureDate'.$weightage.'>'.$departureDate.'</DepartureDate>
         <ReturnDate'.$weightage.'>'.$returnDate.'</ReturnDate>
         </TravelDateSpan>
         <TravelDurationSpan'.$weightage.'>
         <MinDays>'.$minDays.'</MinDays>
         <MaxDays>'.$maxDays.'</MaxDays>
         </TravelDurationSpan>
         </Journey>
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
         <ResultOffset>'.$resultOffset.'</ResultOffset>
         <PostsortingSelection Order="'.$order.'" GroupByRegion="'.$groupByRegion.'">
         <Postsorting>'.$postsorting.'</Postsorting>
         </PostsortingSelection>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
         </Search>
         </t:SearchEngineSimpleRegionListRQ>';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel, Flight, Holiday_Home
     *
     * @param string $departureAirportCountryCode
     * @param string $departureDate
     * @param string $returnDate
     * @param array $travellerAges
     * @param array $departureAirports
     * @param int $minDays
     * @param int $maxDays
     * @param int $resultsPerPage
     * @param int $resultOffset
     * @param string $order
     * @param string $groupByRegion
     * @param string $postsorting
     * @param null $weightage
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @return $this
     */
    public function SearchEngineRegionList(string $departureAirportCountryCode, string $departureDate, string $returnDate, array $travellerAges, array $departureAirports, int $minDays, int $maxDays, int $resultsPerPage = 20, int $resultOffset = 0, string $order = 'Ascending', string $groupByRegion = 'false', string $postsorting = 'Alphabetic', $weightage = null, array $skipTourOperators = [], array $limitTourOperators = []) {

        $this->apiRequestUrlSlug    = 'RegionList';
        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedDepartureAirports  = $this->prepareDepartureAirports($departureAirports);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);


        $this->requestXmlBody = '<t:SearchEngineRegionListRQ
        xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineRegionListRQ"
        Timestamp="'.$this->currentTimestamp.'"
        Target="'.$this->target.'"
        LanguageCode="'.$this->languageCode.'"
        TrackingID="'.$this->trackingID.'"
        ClientSessionID="'.$this->clientSessionID.'"
        ClientIP="'.$this->clientIP.'">
        <Search>
        <Trip>
        <Journey>
        <DepartureAirportCountry>'.$departureAirportCountryCode.'</DepartureAirportCountry>
        <TravellerList>'.$preparedTravellerAges.'</TravellerList>
        <DepartureAirportList '.$weightage.'>'.$preparedDepartureAirports.'</DepartureAirportList>
        <TravelDateSpan>
        <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
        <ReturnDate '.$weightage.'>'.$returnDate.'</ReturnDate>
        </TravelDateSpan>
        <TravelDurationSpan '.$weightage.'>
        <MinDays>'.$minDays.'</MinDays>
        <MaxDays>'.$maxDays.'</MaxDays>
        </TravelDurationSpan>
        </Journey>
        '.$preparedTourOperatorFilter.'
        </Trip>
        <Options>
        <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
        <ResultOffset>'.$resultOffset.'</ResultOffset>
        <PostsortingSelection Order="'.$order.'" GroupByRegion="'.$groupByRegion.'">
        <Postsorting>'.$postsorting.'</Postsorting>
        </PostsortingSelection>
        <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
        </Options>
        </Search>
        </t:SearchEngineRegionListRQ>';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel
     *
     * $shorting  it is HotelListSortingType.
     * Available values: CATEGORY|CITY| DESTINATION|DURATION|EVALUATION| HOTELNAME|PERCENTAGEFIT|PRICE
     * Default: PERCENTAGEFIT
     *
     * $regionIDs it is Erwartet eine Liste von TopRegionsIDs (Expect a list of TopRegionsIDs).
     * In example they use: <RegionIDs>434</RegionIDs>
     *
     *
     * @param string $departureAirportCountryCode
     * @param string $departureDate
     * @param array $travellerAges
     * @param array $departureAirports
     * @param int $resultsPerPage
     * @param int $resultOffset
     * @param int $regionIDs
     * @param string $shorting
     * @param null $weightage
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @return $this
     */
    public function SearchEngineHotelList(string $departureAirportCountryCode, string $departureDate, array $travellerAges, array $departureAirports, int $regionIDs, int $resultsPerPage = 20, int $resultOffset = 0, string $shorting = 'PERCENTAGEFIT',$weightage = null, array $skipTourOperators = [], array $limitTourOperators = []) {
        $this->apiRequestUrlSlug = 'HotelList';
        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedDepartureAirports  = $this->prepareDepartureAirports($departureAirports);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);

        $this->requestXmlBody = '<t:SearchEngineHotelListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineHotelListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
        <Search>
         <Trip>
         <Journey>
         <DepartureAirportCountry>'.$departureAirportCountryCode.'</DepartureAirportCountry>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <DepartureAirportList '.$weightage.'>'.$preparedDepartureAirports.'</DepartureAirportList>
         <TravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         </TravelDateSpan>
         </Journey>
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
         <ResultOffset>'.$resultOffset.'</ResultOffset>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         <Sorting>'.$shorting.'</Sorting>
         </Options>
         </Search>
         <Selection>
         <RegionIDs>'.$regionIDs.'</RegionIDs>
         </Selection>
        </t:SearchEngineHotelListRQ>';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel
     *
     * $maxPrice: Expects the upper limit of the price span
     *
     * $minPrice: Expects the lower limit of the price span
     *
     * $additionalAttributes For internal use only
     * Example: AdditionalAttributes-11111
     *
     * $roomCode: (string) Contains the room code of the corresponding tour operator.
     *
     * $offerScope: All|Exclusive|Public
     *
     * $topRegionID: Erwartet eine Liste von TopRegionsIDs
     * List(positiveInteger): len=1-100
     * Example: 35
     *
     * $cityIDList: List of the cities id
     * Example = [56,62]
     *
     * $flightDuration : Contains the flight duration for the relevant segment.
     * Example: Longhaul|Midhaul|Shorthaul
     *
     * $category: ( _LOCAL_ int) range=[1,5] Expects the indication of the minimum hotel category
     * Example:3
     *
     * @param string $departureAirportCountryCode
     * @param string $departureDate
     * @param string $returnDate
     * @param array $travellerAges
     * @param array $departureAirports
     * @param int $maxPrice
     * @param int $minPrice
     * @param int $category
     * @param bool $topRegionID
     * @param array $preparedCityIDList
     * @param string $offerScope
     * @param null $weightage
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @param array $cityIDList
     * @param null $roomCode
     * @param null $additionalAttributes
     * @param null $flightDuration
     * @return $this
     */
    public function SearchEngineCityList(string $departureAirportCountryCode, string $departureDate, string $returnDate, array $travellerAges, array $departureAirports, int $maxPrice, int $minPrice, $category =3, $topRegionID = false, string $offerScope = 'All', $weightage = null, array $skipTourOperators = [], array $limitTourOperators = [], array $cityIDList = [], $roomCode = null, $additionalAttributes = null, $flightDuration = null) {
        $this->apiRequestUrlSlug = 'CityList';
        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedDepartureAirports  = $this->prepareDepartureAirports($departureAirports);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedAdditionalAttributes = $this->prepareAdditionalAttributes($additionalAttributes);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators, $roomCode);

        $preparedCityIDList = $this->prepareCityIDList($cityIDList, $topRegionID);

        $this->requestXmlBody = '<t:SearchEngineCityListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineCityListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <DepartureAirportCountry>'.$departureAirportCountryCode.'</DepartureAirportCountry>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <DepartureAirportList '.$weightage.'>'.$preparedDepartureAirports.'</DepartureAirportList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         <ReturnDate '.$weightage.'>'.$returnDate.'</ReturnDate>
         </ExactTravelDateSpan>
         <PriceSpan '.$weightage.'>
         <MaxPrice>'.$maxPrice.'</MaxPrice>
         <MinPrice>'.$minPrice.'</MinPrice>
         <CurrencyCode>'.$this->currencyCode.'</CurrencyCode>
         </PriceSpan>
         </Journey>
         <Hotel>
         <Category '.$weightage.'>'.$category.'</Category>
         '.$preparedAdditionalAttributes.'
         </Hotel>
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
         </Search>
         <Filter>
         <OfferScope>'.$offerScope.'</OfferScope>
         '.$preparedCityIDList.'
         <FlightDuration '.$weightage.'>'.$flightDuration.'</FlightDuration>
         </Filter>
        </t:SearchEngineCityListRQ>
        ';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel, Flight, Holiday_Home
     *
     *
     * $objectID: Contains an ID for the accommodation created by TravelTainment (former IFF code)
     *
     * $shorting  it is HotelListSortingType.
     * Available values: CATEGORY|CITY| DESTINATION|DURATION|EVALUATION| HOTELNAME|PERCENTAGEFIT|PRICE
     * Default: PERCENTAGEFIT
     *
     * @param string $departureAirportCountryCode
     * @param string $departureDate
     * @param array $travellerAges
     * @param array $departureAirports
     * @param int $resultsPerPage
     * @param int $resultOffset
     * @param string $shorting
     * @param null $weightage
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @param bool $objectId
     * @return $this
     */
    public function SearchEngineOfferList(string $departureAirportCountryCode, string $departureDate, array $travellerAges, array $departureAirports, int $resultsPerPage = 20, int $resultOffset = 0, string $shorting = 'PERCENTAGEFIT', $weightage = null, array $skipTourOperators = [], array $limitTourOperators = [], $objectId = false) {
        $this->apiRequestUrlSlug = 'OfferList';

        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedDepartureAirports  = $this->prepareDepartureAirports($departureAirports);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);

        $preparedObjectId = $this->prepareObjectId($objectId);


        $this->requestXmlBody = '<t:SearchEngineOfferListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineOfferListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <DepartureAirportCountry>'.$departureAirportCountryCode.'</DepartureAirportCountry>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <DepartureAirportList '.$weightage.'>'.$preparedDepartureAirports.'</DepartureAirportList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         </ExactTravelDateSpan>
         </Journey>
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
         <ResultOffset>'.$resultOffset.'</ResultOffset>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         <Sorting>'.$shorting.'</Sorting>
         </Options>
         </Search>
         '.$preparedObjectId.'
        </t:SearchEngineOfferListRQ>
        ';

        return $this;
    }

    /**
     *
     * Available for: Package, Holiday_Home
     *
     * $gridGroupList (array): Expects the required grouping criteria
     * Values: BOARD| DEPARTUREAIRPORT|DEPARTUREDAY| ROOM|TOUROPERATOR| TRAVELDURATION
     * Example: ['TRAVELDURATION','DEPARTUREAIRPORT']
     *
     * @param string $departureAirportCountryCode
     * @param string $departureDate
     * @param array $travellerAges
     * @param array $departureAirports
     * @param null $weightage
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @param bool $objectId
     * @param array $gridGroupList
     * @return $this
     */
    public function SearchEngineOfferGrid(string $departureAirportCountryCode, string $departureDate, array $travellerAges, array $departureAirports, $weightage = null, array $skipTourOperators = [], array $limitTourOperators = [], $objectId = false, array $gridGroupList = ['TRAVELDURATION', 'DEPARTUREAIRPORT']) {
        $this->apiRequestUrlSlug = 'OfferGrid';

        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedDepartureAirports  = $this->prepareDepartureAirports($departureAirports);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);

        $preparedObjectId = $this->prepareObjectId($objectId);
        $preparedGridGroupList = $this->prepareGridGroupList($gridGroupList);

        $this->requestXmlBody = '<t:SearchEngineOfferGridRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineOfferGridRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <DepartureAirportCountry>'.$departureAirportCountryCode.'</DepartureAirportCountry>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <DepartureAirportList '.$weightage.'>'.$preparedDepartureAirports.'</DepartureAirportList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         </ExactTravelDateSpan>
         </Journey>
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
         </Search>
         '.$preparedObjectId.'
         <GridGroupList>'.$preparedGridGroupList.'</GridGroupList>
        </t:SearchEngineOfferGridRQ>';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel, Flight, Holiday_Home
     *
     * @return $this
     */
    public function SearchEngineTourOperators() {
        $this->apiRequestUrlSlug = 'TourOperators';
        $this->requestXmlBody = '<t:SearchEngineTourOperatorsRQ
         xmlns:t="http://traveltainment.de/middleware/xml/SearchEngineTourOperatorsRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'"/>';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel, Flight
     *
     * @return $this
     */
    public function GetAlternativeFlightsList() {
        $this->apiRequestUrlSlug = 'GetAlternativeFlightsList';
        $this->requestXmlBody = '<t:GetAlternativeFlightsListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/GetAlternativeFlightsListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         SessionID="'.$this->sessionID.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
        </t:GetAlternativeFlightsListRQ>';

        return $this;
    }

    /**
     *
     * Available for: Package, Hotel, Flight, Holiday_Home
     *
     * @param $offerID
     * The OfferID is a temporary and unique ID which informs about the offer currently requested by the user. The OfferID can be taken from the search responses.
     * Example: 738_198BE0121443508E_0
     *
     * @param $travellers['travellerRef']
     * Reference ID of the traveller
     * Example: T01
     *
     * array param $travellers[1]['firstName'] ( Example : David)
     * array param $travellers[1]['middleName'] ( Example : Cesar)
     * array param $travellers[1]['lastName'] ( Example : Lee)
     * array param $travellers[1]['title'] ( Example : Dr.)
     * array param $travellers[1]['salutation'] ( Example : Mr.)
     * array param $travellers[1]['gender'] ( Example : MALE)
     * array param $travellers[1]['birthDate'] ( Example : 1960-03-10)
     * array param $travellers[1]['type'] ( Example : ADULT)   VALUES : ADULT|CHILD|INFANT
     * array param $travellers[1]['iDCardNumber'] ( Example : 108294472152)
     *
     * array param $travellers[1]['contact'][]
     * Example $travellers[1]['contact'][1] = [ '***locationType' => 'Work', '****techType' => 'Email', 'value' => 'dlee@kuehnenagel.com']
     * Another example $travellers[1]['contact'][2] = [ '***locationType' => 'Home', '****techType' => 'Mobile', 'value' => '02408-771092']
     * *** 'locationType' => Delivery|Home|Undefined|Work
     * **** 'techType' => Email|Fax|Mobile|SOS|Undefined| Voice|Webpage
     *
     *
     *
     *
     * @return $this
     */
    public function AvailabilityAndPriceCheck($offerID, array $travellers) {
        $this->apiRequestUrlSlug = 'AvailabilityAndPriceCheck';

        $preparedTravellerList = $this->prepareTravellerList($travellers);

        $this->requestXmlBody = '<t:AvailabilityAndPriceCheckRQ
         xmlns:t="http://traveltainment.de/middleware/xml/AvailabilityAndPriceCheckRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <OfferID>'.$offerID.'</OfferID>
         '.$preparedTravellerList.'
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
        </t:AvailabilityAndPriceCheckRQ>';

        return $this;
    }

    /**
     *
     * I think need to use book shopping cart OF try to you create book!! there is no example
     *
     * Available for: Package, Hotel, Flight
     *
     * @return $this
     */
    public function Book() {
        $this->apiRequestUrlSlug = 'Book';
        $this->requestXmlBody = '';

        return $this;
    }

    /**
     *
     * Available for: Holiday_Home
     *
     * $holidayHomeSearchCriteria Example:
     * $holidayHomeSearchCriteria['holidayHomeAttributes'][] = 'WashingMachine'
     * $holidayHomeSearchCriteria['category'] = 3
     * $holidayHomeSearchCriteria['holidayHomeType'] = 'HolidayFlat'
     * $holidayHomeSearchCriteria['roomCount'] = 4
     *
     * @param array $travellerAges
     * @param string $departureDate
     * @param string $returnDate
     * @param int $regionIDs
     * @param int $resultsPerPage
     * @param int $resultOffset
     * @param int $maxPrice
     * @param int $minPrice
     * @param array $holidayHomeSearchCriteria
     * @param null $weightage
     * @param string $order
     * @param string $groupByRegion
     * @param string $postsorting
     * @param string $shorting
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @return $this
     */
    public function HolidayHomeList(array $travellerAges, string $departureDate, string $returnDate, int $regionIDs, int $resultsPerPage = 20, int $resultOffset = 0, int $maxPrice, int $minPrice, array $holidayHomeSearchCriteria, $weightage = null, string $order = 'Ascending', string $groupByRegion = 'false', string $postsorting = 'Alphabetic', string $shorting = 'PERCENTAGEFIT', array $skipTourOperators = [], array $limitTourOperators = []) {
        $this->apiRequestUrlSlug = 'HolidayHomeList';

        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $preparedHolidayHomeSearchCriteria  = $this->prepareHolidayHomeSearchCriteria($holidayHomeSearchCriteria);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);



        $this->requestXmlBody = '<t:HolidayHomeListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/HolidayHomeListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         <ReturnDate '.$weightage.'>'.$returnDate.'</ReturnDate>
         </ExactTravelDateSpan>
         <PriceSpan '.$weightage.'>
         <MaxPrice>'.$maxPrice.'</MaxPrice>
         <MinPrice>'.$minPrice.'</MinPrice>
         <CurrencyCode>'.$this->currencyCode.'</CurrencyCode>
         </PriceSpan>
         </Journey>
         '.$preparedHolidayHomeSearchCriteria.'
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
         <ResultOffset>'.$resultOffset.'</ResultOffset>
         <PostsortingSelection Order="'.$order.'" GroupByRegion="'.$groupByRegion.'">
         <Postsorting>'.$postsorting.'</Postsorting>
         </PostsortingSelection>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         <Sorting>'.$shorting.'</Sorting>
         </Options>
         </Search>
         <Selection>
         <RegionIDs>'.$regionIDs.'</RegionIDs>
         </Selection>
        </t:HolidayHomeListRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/GetShoppingCart
     *
     * example $shoppingCartID = '4255T000X0';
     *
     * @param string $shoppingCartID
     *
     * @return TravelTainmentApi
     */
    public function GetShoppingCart(string $shoppingCartID) {

        $this->apiRequestUrlSlug = 'GetShoppingCart';
        $this->requestXmlBody = '<t:GetShoppingCartRQ
         xmlns:t="http://traveltainment.de/middleware/xml/GetShoppingCartRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <ShoppingCartID>'.$shoppingCartID.'</ShoppingCartID>
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
        </t:GetShoppingCartRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/GetAvailableOfferData
     *
     * @param $requestID
     * @param $transactionID
     *
     * @return TravelTainmentApi
     */
    public function GetAvailableOfferData($requestID, $transactionID) {

        $this->apiRequestUrlSlug = 'GetAvailableOfferData';
        $this->requestXmlBody = '<t:GetAvailableOfferDataRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <SessionID>'.$this->sessionID.'</SessionID>
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
        </t:GetAvailableOfferDataRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     * @param array $travellers ['travellerRef']
     * Reference ID of the traveller
     * Example: T01
     *
     * array param $travellers[1]['firstName'] ( Example : David)
     * array param $travellers[1]['middleName'] ( Example : Cesar)
     * array param $travellers[1]['lastName'] ( Example : Lee)
     * array param $travellers[1]['title'] ( Example : Dr.)
     * array param $travellers[1]['salutation'] ( Example : Mr.)
     * array param $travellers[1]['gender'] ( Example : MALE)
     * array param $travellers[1]['birthDate'] ( Example : 1960-03-10)
     * array param $travellers[1]['type'] ( Example : ADULT)   VALUES : ADULT|CHILD|INFANT
     * array param $travellers[1]['iDCardNumber'] ( Example : 108294472152)
     *
     * array param $travellers[1]['contact'][]
     * Example $travellers[1]['contact'][1] = [ '***locationType' => 'Work', '****techType' => 'Email', 'value' => 'dlee@kuehnenagel.com']
     * Another example $travellers[1]['contact'][2] = [ '***locationType' => 'Home', '****techType' => 'Mobile', 'value' => '02408-771092']
     * *** 'locationType' => Delivery|Home|Undefined|Work
     * **** 'techType' => Email|Fax|Mobile|SOS|Undefined| Voice|Webpage
     *
     *
     * $book variable example:
     *
     * $book['bookRequestID'] = BR-12345
     * $book['offerID'] = 738_198BE0121443508E_0
     * $book['bookingType'] = BookSoft
     * $book['paymentType'] = BankTransfer
     * $book['paymentTokenId'] = P1
     * $book['paymentToken'] = 10295480129502
     * $book['customerRemarks'] = As agreed upon in our telephone converstion.
     * $book['portalRemarks'] = P1_DIRECT
     *
     *
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/BookShoppingCart
     *
     * @param array $customerDetails LOOK prepareCustomerDetails function...
     * @param array $book
     * @return $this
     */
    public function BookShoppingCart(array $travellers, array $customerDetails, array $book) {

        $preparedTravellerList = $this->prepareTravellerList($travellers);
        $preparedCustomer = $this->prepareCustomerDetails($customerDetails);
        $preparedBookRequests = $this->prepareBookRequest($book);

        $this->apiRequestUrlSlug = 'BookShoppingCart';
        $this->requestXmlBody = '<t:BookShoppingCartRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="true" RequestID="RQ-12345" TransactionID="TID-12345" Language="'.$this->languageCode.'"/>
         <ClientIP>CDE</ClientIP>
         <SessionID>'.$this->clientSessionID.'</SessionID>
         '.$preparedTravellerList.'
         '.$preparedCustomer.'
         '.$preparedBookRequests.'
        </t:BookShoppingCartRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/FinalizeShoppingCart
     *
     * $shoppingCartID example = 4255T000X0
     *
     * @param string $shoppingCartID
     *
     * @return TravelTainmentApi
     */
    public function FinalizeShoppingCart(string $shoppingCartID) {

        $this->apiRequestUrlSlug = 'FinalizeShoppingCart';
        $this->requestXmlBody = '<t:FinalizeShoppingCartRQ
         xmlns:t="http://traveltainment.de/middleware/xml/FinalizeShoppingCartRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <ShoppingCartID>'.$shoppingCartID.'</ShoppingCartID>
        </t:FinalizeShoppingCartRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/GetTermsAndConditions
     *
     * @param $tourOperator   ( Example : XLTR)
     * @param $travelBeginDate ( Example : 2016-03-03+01:00)
     *
     * @return TravelTainmentApi
     */
    public function GetTermsAndConditions(string $tourOperator, string $travelBeginDate) {

        $this->apiRequestUrlSlug = 'GetTermsAndConditions';
        $this->requestXmlBody = '<t:GetTermsAndConditionsRQ
         xmlns:t="http://traveltainment.de/middleware/xml/GetTermsAndConditionsRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <TourOperator>'.$tourOperator.'</TourOperator>
         <TravelBeginDate>'.$travelBeginDate.'</TravelBeginDate>
        </t:GetTermsAndConditionsRQ>';

        return $this;
    }

    /**
     *
     * Available for: ThirdParty
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Search/CrossSelling/CarRentalLocations
     *
     *
     * @param string $requestID (Example: RQ-12345)
     *
     * @param string $transactionID (Example: TID-12345)
     *
     * @param $providerID  (Example: SCAR)
     *
     * @return TravelTainmentApi
     */
    public function GetCarRentalLocations(string $requestID, string $transactionID, $providerID) {

        $this->apiRequestUrlSlug = 'CarRentalLocations';
        $this->requestXmlBody = '<t:GetCarRentalLocationsRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <SessionID>'.$this->sessionID.'</SessionID>
         <ProviderID>'.$providerID.'</ProviderID>
        </t:GetCarRentalLocationsRQ>';

        return $this;
    }

    /**
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Search/CrossSelling/CarRentalOfferConditions
     *
     *
     *
     * Available for: ThirdParty
     *
     *
     * @param string $requestID (Example: RQ-12345)
     *
     * @param string $transactionID (Example: TID-12345)
     *
     * @param string $providerID (Example: SCAR)
     *
     * @param string $offerID (Example: 20282/151)
     *
     * @param $pickupStationCode (Example: 15601)
     *
     * @param $pickupDateTime (Example: 2015-11-13T13:00:00.000)
     *
     *
     * @return TravelTainmentApi
     */
    public function GetCarRentalOfferConditions(string $requestID, string $transactionID, string $providerID, string $offerID, string $pickupStationCode, string $pickupDateTime) {

        $this->apiRequestUrlSlug = 'CarRentalOfferConditions';
        $this->requestXmlBody = '<t:GetCarRentalOfferConditionsRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <ProviderID>'.$providerID.'</ProviderID>
         <OfferID>'.$offerID.'</OfferID>
         <Pickup>
         <PickupStationCode>'.$pickupStationCode.'</PickupStationCode>
         <PickupDateTime>'.$pickupDateTime.'</PickupDateTime>
         </Pickup>
        </t:GetCarRentalOfferConditionsRQ>
        ';

        return $this;
    }

    /**
     *
     * Available for: ThirdParty
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Search/CrossSelling/CarRentalStationDetails
     * @param string $requestID
     * @param string $transactionID
     * @param string $providerID
     * @param string $stationCode
     * @param string $pickupDateTime (Example: 2015-11-13T13:00:00.000)
     * @param string $returnDateTime (Example: 2015-11-13T18:00:00.000)
     * @param string $detailType (Example: Inclusives)
     * @return TravelTainmentApi
     */
    public function GetCarRentalStationDetails(string $requestID, string $transactionID, string $providerID, string $stationCode, string $pickupDateTime, string $returnDateTime, string $detailType) {

        $this->apiRequestUrlSlug = 'CarRentalStationDetails';
        $this->requestXmlBody = '<t:GetCarRentalStationDetailsRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <ProviderID>'.$providerID.'</ProviderID>
         <StationCode>'.$stationCode.'</StationCode>
         <PickupDateTime>'.$pickupDateTime.'</PickupDateTime>
         <ReturnDateTime>'.$returnDateTime.'</ReturnDateTime>
         <DetailType>'.$detailType.'</DetailType>
        </t:GetCarRentalStationDetailsRQ>';

        return $this;
    }

    /**
     *
     * Available for: ThirdParty
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Search/CrossSelling/CarRentalOfferList
     *
     * @param string $requestID
     * @param string $transactionID
     * @param string $providerID
     * @param string $vehicleClasses (Example: Economy)
     * @param string $availabilityStatus (Example: All)
     *
     * Examples for pickup
     * @param array $pickup
     * $pickup['dateTime'] = 2015-11-13T14:00:00+02:00
     * $pickup['locationCode'] = 15601
     *
     * Examples for return
     * @param array $return
     * $return['dateTime'] = 2015-11-13T19:00:00+02:00
     * $return['locationCode'] = 15601
     *
     * @return TravelTainmentApi
     */
    public function GetCarRentalOfferList(string $requestID, string $transactionID, string $providerID, string $vehicleClasses, string $availabilityStatus, array $pickup, array $return) {

        $this->apiRequestUrlSlug = 'CarRentalOfferList';
        $this->requestXmlBody = '<t:GetCarRentalOfferListRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <ProviderID>'.$providerID.'</ProviderID>
         <VehicleClasses>'.$vehicleClasses.'</VehicleClasses>
         <AvailabilityStatus>'.$availabilityStatus.'</AvailabilityStatus>
         <Pickup>
         <DateTime>'.$pickup['dateTime'].'</DateTime>
         <LocationCode>'.$pickup['locationCode'].'</LocationCode>
         </Pickup>
         <Return>
         <DateTime>'.$return['dateTime'].'</DateTime>
         <LocationCode>'.$return['locationCode'].'</LocationCode>
         </Return>
         <MaxOffers>4</MaxOffers>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
        </t:GetCarRentalOfferListRQ>';

        return $this;
    }

    /**
     *
     * Available for: ThirdParty
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Search/CrossSelling/InsuranceOfferList
     * @param string $requestID
     * @param string $transactionID
     * @param string $providerID
     * @return TravelTainmentApi
     */
    public function GetInsuranceOfferList(string $requestID, string $transactionID, string $providerID) {

        $this->apiRequestUrlSlug = 'InsuranceOfferList';
        $this->requestXmlBody = '<t:GetInsuranceOfferListRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <SessionID>'.$this->sessionID.'</SessionID>
         <ProviderID>'.$providerID.'</ProviderID>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
        </t:GetInsuranceOfferListRQ>';

        return $this;
    }

    /**
     *
     * Available for: ThirdParty
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Search/CrossSelling/TransferOfferList
     *
     * @param string $requestID
     * @param string $transactionID
     * @param string $providerID
     *
     * @return TravelTainmentApi
     */
    public function GetTransferOfferList(string $requestID, string $transactionID, string $providerID) {

        $this->apiRequestUrlSlug = 'TransferOfferList';
        $this->requestXmlBody = '<t:GetTransferOfferListRQ
         xmlns:t="http://www.traveltainment.de/ws/ttxml"
         Version="1.6">
         <RQ_Metadata IsTest="'.$this->isTest.'" RequestID="'.$requestID.'" TransactionID="'.$transactionID.'" Language="'.$this->languageCode.'"/>
         <SessionID>'.$this->sessionID.'</SessionID>
         <ProviderID>'.$providerID.'</ProviderID>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
        </t:GetTransferOfferListRQ>';

        return $this;
    }


    /**
     *
     * Available for: ShoppingCart
     *
     * !! Important notice maybe its addon fetch different with test.
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/GetAddon
     *
     * @param string $shoppingCartId (Example: 4255T000X0)
     * @param string $addonId(Example: 100025251)
     *
     * @return TravelTainmentApi
     */
    public function AddonGet(string $shoppingCartId, string $addonId) {

        $this->apiRequestUrlSlug = 'GetAddon';
        $this->requestXmlBody = '<t:AddonFetchRQ
         xmlns:t="http://traveltainment.de/middleware/gateway/AddonFetchRQ-1_0"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <ShoppingCartId>'.$shoppingCartId.'</ShoppingCartId>
         <AddonId>'.$addonId.'</AddonId>
        </t:AddonFetchRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     *
     * @param string $addonType
     * @param string $shoppingCartId
     * @param string $isChargeable
     * @param array $comments
     * @param array $params
     *
     *
     * Examples:
     *
     * FOR: $comments
     * $comments[1]['category']
     * $comments[1]['travelAgent']
     * $comments[1]['type']
     * $comments[1]['username']
     * $comments[1]['comment']
     *
     * $comments as $comment example:
     * $comment['category'] = Customer
     * $comment['travelAgent'] = ta/251
     * $comment['type'] = CallCenter
     * $comment['username'] = bermudas
     * $comment['comment'] = Client email and phone call.
     *
     *
     * FOR: $params
     * $params[1]['param_key']
     * $params[1]['param_value']
     * $params as $param example:
     * $param['param_key'] = addon_voucher
     * $param['param_value'] = XV-ABC-456-RTZ
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/InsertAddon
     *
     *
     * @return TravelTainmentApi
     */
    public function AddonInsert(string $addonType, string $shoppingCartId, string $isChargeable, array $comments, array $params) {

        $this->apiRequestUrlSlug = 'InsertAddon';

        $preparedParamList = $this->prepareParamList($params);
        $preparedCommentList = $this->prepareCommentList($comments);

        $this->requestXmlBody = '<t:AddonInsertRQ
         xmlns:t="http://traveltainment.de/middleware/gateway/AddonInsertRQ-1_0"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <AddonInfos>
         <AddonType>'.$addonType.'</AddonType>
         <ShoppingCartId>'.$shoppingCartId.'</ShoppingCartId>
         <CreationDate>'.$this->currentTimestamp.'</CreationDate>
         <Locale Code="'.$this->languageCode.'"/>
         <MiscInfos>
         <IsChargeable>'.$isChargeable.'</IsChargeable>
         </MiscInfos>
         </AddonInfos>
         '.$preparedCommentList.'
         '.$preparedParamList.'
        </t:AddonInsertRQ>';

        return $this;
    }

    /**
     *
     * Available for: ShoppingCart
     *
     * Url is different, not search.
     * Request URL: http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/Dispatcher?action=Booking/UpdateAddon
     *
     * @param string $addonId (Example: 100025251)
     *
     * @param string $shoppingCartId (Example: 4255T000X0)
     *
     * @param array $params
     *
     * $params[1]['param_key']
     * $params[1]['param_value']
     *
     * $param['param_key'] = addon_voucher
     * $param['param_value'] = XV-ABC-456-RTZ
     *
     * @param string $isChargeable (Example: false)
     *
     *
     * @return TravelTainmentApi
     */
    public function AddonUpdate(string $addonId, string $shoppingCartId, array $params, string $isChargeable = 'false') {

        $preparedParamList = $this->prepareParamList($params);

        $this->apiRequestUrlSlug = 'UpdateAddon';
        $this->requestXmlBody = '<t:AddonUpdateRQ
         xmlns:t="http://traveltainment.de/middleware/gateway/AddonUpdateRQ-1_0"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <AddonInfos>
         <AddonId>'.$addonId.'</AddonId>
         <ShoppingCartId>'.$shoppingCartId.'</ShoppingCartId>
         <MiscInfos>
         <IsChargeable>'.$isChargeable.'</IsChargeable>
         </MiscInfos>
         </AddonInfos>
         '.$preparedParamList.'
        </t:AddonUpdateRQ>';

        return $this;
    }


    // Test url= http://de-staging-ttxml.traveltainment.eu/TTXml-1.7/

    /**
     * $holidayHomeSearchCriteria['holidayHomeAttributes'][] = 'WashingMachine'
     * $holidayHomeSearchCriteria['category'] = 3
     * $holidayHomeSearchCriteria['holidayHomeType'] = 'HolidayFlat'
     * $holidayHomeSearchCriteria['roomCount'] = 4
     *
     * @param string $departureDate (Example: 2016-03-02+02:00)
     * @param string $returnDate (Example: 2016-03-16+02:00)
     * @param array $travellerAges
     * @param null $weightage
     * @param $maxPrice
     * @param $minPrice
     * @param array $holidayHomeSearchCriteria
     * @param $regionID (Example: 35)
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @param int $resultsPerPage
     * @param int $resultOffset
     * @param string $order
     * @param string $groupByRegion
     * @param string $postsorting
     * @param string $showSeparateAlternatives
     * @return $this
     */
    public function HolidayHomeRegionList(string $departureDate, string $returnDate, array $travellerAges , $weightage = null, $maxPrice, $minPrice , array $holidayHomeSearchCriteria, $regionID, array $skipTourOperators = [], array $limitTourOperators = [], int $resultsPerPage = 20, int $resultOffset = 0, string $order = 'Ascending', string $groupByRegion = 'false', string $postsorting = 'Alphabetic', string $showSeparateAlternatives = 'true') {
        $this->apiRequestUrlSlug = 'RegionList';

        $preparedTravellerAges = $this->prepareTravellerAges($travellerAges);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedHolidayHomeSearchCriteria  = $this->prepareHolidayHomeSearchCriteria($holidayHomeSearchCriteria);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);

        $this->requestXmlBody = '<t:HolidayHomeRegionListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/HolidayHomeRegionListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         <ReturnDate '.$weightage.'>'.$returnDate.'</ReturnDate>
         </ExactTravelDateSpan>
         <PriceSpan '.$weightage.'>
         <MaxPrice>'.$maxPrice.'</MaxPrice>
         <MinPrice>'.$minPrice.'</MinPrice>
         <CurrencyCode>'.$this->currencyCode.'</CurrencyCode>
         </PriceSpan>
         </Journey>
         '.$preparedHolidayHomeSearchCriteria.'
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
         <ResultOffset>'.$resultOffset.'</ResultOffset>
         <PostsortingSelection Order="'.$order.'" GroupByRegion="'.$groupByRegion.'">
         <Postsorting>'.$postsorting.'</Postsorting>
         </PostsortingSelection>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         <ShowSeparateAlternatives>'.$showSeparateAlternatives.'</ShowSeparateAlternatives>
         </Options>
         </Search>
         <Filter>
         <RegionID '.$weightage.'>'.$regionID.'</RegionID>
         </Filter>
        </t:HolidayHomeRegionListRQ>
        ';

        return $this;
    }

    public function HolidayHomeOfferList(string $departureDate, string $returnDate, array $travellerAges , $weightage = null, $maxPrice, $minPrice , array $holidayHomeSearchCriteria, $objectID, array $skipTourOperators = [], array $limitTourOperators = [], int $resultsPerPage = 20, int $resultOffset = 0, string $order = 'Ascending', string $groupByRegion = 'false', string $postsorting = 'Alphabetic', string $shorting = 'PERCENTAGEFIT') {

        $this->apiRequestUrlSlug = 'OfferList';

        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedHolidayHomeSearchCriteria  = $this->prepareHolidayHomeSearchCriteria($holidayHomeSearchCriteria);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);


        $this->requestXmlBody = '<t:HolidayHomeOfferListRQ
         xmlns:t="http://traveltainment.de/middleware/xml/HolidayHomeOfferListRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         <ReturnDate '.$weightage.'>'.$returnDate.'</ReturnDate>
         </ExactTravelDateSpan>
         <PriceSpan '.$weightage.'>
         <MaxPrice>'.$maxPrice.'</MaxPrice>
         <MinPrice>'.$minPrice.'</MinPrice>
         <CurrencyCode>'.$this->currencyCode.'</CurrencyCode>
         </PriceSpan>
         </Journey>
         '.$preparedHolidayHomeSearchCriteria.'
         '.$preparedTourOperatorFilter.'
         </Trip>
         <Options>
         <ResultsPerPage>'.$resultsPerPage.'</ResultsPerPage>
         <ResultOffset>'.$resultOffset.'</ResultOffset>
         <PostsortingSelection Order="'.$order.'" GroupByRegion="'.$groupByRegion.'">
         <Postsorting>'.$postsorting.'</Postsorting>
         </PostsortingSelection>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         <Sorting>'.$shorting.'</Sorting>
         </Options>
         </Search>
         <Selection>
         <ObjectID>'.$objectID.'</ObjectID>
         </Selection>
         </t:HolidayHomeOfferListRQ>';

        return $this;
    }


    public function HolidayHomeOfferGrid(string $departureDate, string $returnDate, array $travellerAges , $weightage = null, $maxPrice, $minPrice , array $holidayHomeSearchCriteria, $objectID, array $skipTourOperators = [], array $limitTourOperators = [], $gridGroupList = 'StayDuration') {

        $this->apiRequestUrlSlug = 'OfferGrid';

        $preparedTravellerAges      = $this->prepareTravellerAges($travellerAges);
        $weightage = $this->prepareWeightAge($weightage);
        $preparedHolidayHomeSearchCriteria  = $this->prepareHolidayHomeSearchCriteria($holidayHomeSearchCriteria);
        $preparedTourOperatorFilter = $this->prepareTourOperatorFilter($skipTourOperators, $limitTourOperators);


        $this->requestXmlBody = '<t:HolidayHomeOfferGridRQ
         xmlns:t="http://traveltainment.de/middleware/xml/HolidayHomeOfferGridRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <Search>
         <Trip>
         <Journey>
         <TravellerList>'.$preparedTravellerAges.'</TravellerList>
         <ExactTravelDateSpan>
         <DepartureDate '.$weightage.'>'.$departureDate.'</DepartureDate>
         <ReturnDate '.$weightage.'>'.$returnDate.'</ReturnDate>
         </ExactTravelDateSpan>
         <PriceSpan '.$weightage.'>
         <MaxPrice>'.$maxPrice.'</MaxPrice>
         <MinPrice>'.$minPrice.'</MinPrice>
         <CurrencyCode>'.$this->currencyCode.'</CurrencyCode>
         </PriceSpan>
         </Journey>
         '.$preparedHolidayHomeSearchCriteria.'
         '.$preparedTourOperatorFilter.'
         </Trip>
         </Search>
         <Selection>
         <ObjectID>'.$objectID.'</ObjectID>
         </Selection>
         <GridGroupList>'.$gridGroupList.'</GridGroupList>
        </t:HolidayHomeOfferGridRQ>';

        return $this;
    }

    /**
     * @param $offerID (Example: 801_046840000000D08E_0)
     * @param $travellerCount (Example: 3)
     * @return $this
     */
    public function HolidayHomeAvailabilityAndPriceCheck($offerID, $travellerCount) {

        $this->apiRequestUrlSlug = 'AvailabilityAndPriceCheck';
        $this->requestXmlBody = '<t:HolidayHomeAvailabilityAndPriceCheckRQ
         xmlns:t="http://traveltainment.de/middleware/xml/HolidayHomeAvailabilityAndPriceCheckRQ"
         Timestamp="'.$this->currentTimestamp.'"
         Target="'.$this->target.'"
         LanguageCode="'.$this->languageCode.'"
         TrackingID="'.$this->trackingID.'"
         ClientSessionID="'.$this->clientSessionID.'"
         ClientIP="'.$this->clientIP.'">
         <OfferID>'.$offerID.'</OfferID>
         <TravellerCount>'.$travellerCount.'</TravellerCount>
         <Options>
         <AdditionalCurrencies>'.$this->additionalCurrencies.'</AdditionalCurrencies>
         </Options>
        </t:HolidayHomeAvailabilityAndPriceCheckRQ>';

        return $this;
    }



    /** This functions not documented or test paged */
    public function GetCarRentalStations() {}
    public function GetParkingDetails() {}
    public function GetParkingOfferList() {}
    public function GetParkingTeaser() {}

    /** DEPRECATED */
    //public function HolidayHomeBook() {}

    public function AddonListInsert() {}
    public function AddonFetch() {}

    /**
     * @param array $travellerAges
     * @return string
     */
    private function prepareTravellerAges(array $travellerAges):string {
        return '<Traveller Age="'.implode('"/><Traveller Age="',$travellerAges).'"/>';
    }

    /**
     * @param array $departureAirports
     * @return string
     */
    public function prepareDepartureAirports(array $departureAirports): string
    {
        return '<Airport>' . implode('</Airport><Airport>', $departureAirports) . '</Airport>';
    }

    /**
     * @param $weightage
     * @return string
     */
    public function prepareWeightAge($weightage): string
    {
        return $weightage == null ? '' : ' Weightage="' . $weightage . '"';
    }

    /**
     *
     * @param array $skipTourOperators
     * @param array $limitTourOperators
     * @param null $roomCode
     * @return string
     */
    public function prepareTourOperatorFilter(array $skipTourOperators, array $limitTourOperators, $roomCode = null): string
    {
        $roomCode = is_null($roomCode) ? '' : '<RoomCode>'.$roomCode.'</RoomCode>';
        $skipTourOperators  = empty($skipTourOperators) ? '' : '<TourOperator><Skip><TourOperator>'.implode('</TourOperator><TourOperator>',$skipTourOperators).'</TourOperator></Skip>'.$roomCode.'</TourOperator>';
        $limitTourOperators = empty($limitTourOperators) ? '' : '<TourOperator><Limit><TourOperator>'.implode('</TourOperator><TourOperator>',$limitTourOperators).'</TourOperator></Limit>'.$roomCode.'</TourOperator>';

        return $skipTourOperators == '' ? $limitTourOperators : $skipTourOperators;
    }

    /**
     * @param $additionalAttributes
     * @return string
     */
    public function prepareAdditionalAttributes($additionalAttributes): string
    {
        return is_null($additionalAttributes) ? '' : '<AdditionalAttributes>'.$additionalAttributes.'</AdditionalAttributes>';
    }

    /**
     * @param $topRegionID
     * @param array $cityIDList
     * @return string
     */
    public function prepareCityIDList(array $cityIDList, $topRegionID = false): string
    {
        $topRegionID = $topRegionID ? ' TopRegionIDs="'.$topRegionID.'"' : '';
        if ($topRegionID != '' && empty($cityIDList)) {
            return '<CityIDList ' . $topRegionID . '></CityIDList>';
        }
        return empty($topRegionID) ? '' : '<CityIDList ' . $topRegionID . '><CityID>' . implode('</CityID><CityID>', $cityIDList) . '</CityID></CityIDList>';
    }

    /**
     * @param $objectId
     * @return string
     */
    public function prepareObjectId($objectId): string
    {
        return $objectId ? '<Selection><HotelSelection><ObjectID Type="IFF">' . $objectId . '</ObjectID></HotelSelection></Selection>' : '';
    }

    /**
     * @param array $gridGroupList
     * @return string
     */
    public function prepareGridGroupList(array $gridGroupList): string
    {
        return implode(' ', $gridGroupList);
    }



    /** @param $travellers['travellerRef']
     * Reference ID of the traveller
     * Example: T01
     *
     * array param $travellers[1]['firstName'] ( Example : David)
     * array param $travellers[1]['middleName'] ( Example : Cesar)
     * array param $travellers[1]['lastName'] ( Example : Lee)
     * array param $travellers[1]['title'] ( Example : Dr.)
     * array param $travellers[1]['salutation'] ( Example : Mr.)
     * array param $travellers[1]['gender'] ( Example : MALE)
     * array param $travellers[1]['birthDate'] ( Example : 1960-03-10)
     * array param $travellers[1]['type'] ( Example : ADULT)   VALUES : ADULT|CHILD|INFANT
     * array param $travellers[1]['iDCardNumber'] ( Example : 108294472152)
     *
     * array param $travellers[1]['contact']
     * Example $travellers[1]['contact'][] = [ '***locationType' => 'Work', '****techType' => 'Email', 'value' => 'dlee@kuehnenagel.com']
     * Another example $travellers[1]['contact'][] = [ '***locationType' => 'Home', '****techType' => 'Mobile', 'value' => '02408-771092']
     * *** 'locationType' => Delivery|Home|Undefined|Work
     * **** 'techType' => Email|Fax|Mobile|SOS|Undefined| Voice|Webpage
     *
     * @return string
     */
    public function prepareTravellerList (array $travellers): string {
        $prepareTravellersString = '<TravellerList>';

        foreach ($travellers as $traveller) {
            $prepareContactString = '';
            foreach ($travellers['contact'] as $contact) {
                $prepareContactString .= '<Contact LocationType="'.$contact['locationType'].'" TechType="'.$contact['techType'].'">'.$contact['value'].'</Contact>';
            }

            $prepareTravellersString = '
             <Traveller travellerRef="'.$traveller['travellerRef'].'">
             <PersonName>
             <FirstName>'.$traveller['firstName'].'</FirstName>
             <MiddleName>'.$traveller['middleName'].'</MiddleName>
             <LastName>'.$traveller['lastName'].'</LastName>
             <Title>'.$traveller['title'].'</Title>
             <Salutation>'.$traveller['salutation'].'</Salutation>
             </PersonName>
             <Gender>'.$traveller['gender'].'</Gender>
             <Contacts>
             '.$prepareContactString.'
             </Contacts>
             <BirthDate>'.$traveller['birthDate'].'</BirthDate>
             <Type>'.$traveller['type'].'</Type>
             <IDCardNumber>'.$traveller['iDCardNumber'].'</IDCardNumber>
             </Traveller>';
        }
        $prepareTravellersString .= '</TravellerList>';

        return $prepareTravellersString;
    }


    /** @param $customerDetails array
     * Reference ID of the traveller
     * Example: T01
     *
     * array param $customerDetails['firstName'] ( Example : David)
     * array param $customerDetails['middleName'] ( Example : Cesar)
     * array param $customerDetails['lastName'] ( Example : Lee)
     * array param $customerDetails['title'] ( Example : Dr.)
     * array param $customerDetails['salutation'] ( Example : Mr.)
     * array param $customerDetails['gender'] ( Example : MALE)
     * array param $customerDetails['birthDate'] ( Example : 1960-03-10)
     * array param $customerDetails['type'] ( Example : ADULT)   VALUES : ADULT|CHILD|INFANT
     * array param $customerDetails['iDCardNumber'] ( Example : 108294472152)
     *
     * array param $customerDetails['contact']
     * Example $customerDetails['contact'][] = [ '***locationType' => 'Work', '****techType' => 'Email', 'value' => 'dlee@kuehnenagel.com']
     * Another example $customerDetails['contact'][] = [ '***locationType' => 'Home', '****techType' => 'Mobile', 'value' => '+44 (0) 118 946 5893']
     * *** 'locationType' => Delivery|Home|Undefined|Work
     * **** 'techType' => Email|Fax|Mobile|SOS|Undefined| Voice|Webpage
     *
     * array param $customerDetails['addresses'][] = [
     *                                                  'status'        => 'Booking',
     *                                                  'locationType'  => 'Delivery',
     *                                                  'number'        => '12',
     *                                                  'appendix'      => 'A',
     *                                                  'streetNumber'  => '12',
     *                                                  'postalCode'    => '52146',
     *                                                  'cityName'      => 'Würselen',
     *                                                  'countryCode'   => 'DE',
     *                                                  'countryName'   => 'Deutschland',
     *                                               ]
     *
     * @return string
     */
    public function prepareCustomerDetails (array $customerDetails): string {
        $customerDetailsString = '<TravellerList>';

        $prepareContactString = '';
        foreach ($customerDetails['contact'] as $contact) {
            $prepareContactString .= '<Contact LocationType="'.$contact['locationType'].'" TechType="'.$contact['techType'].'">'.$contact['value'].'</Contact>';
        }

        $prepareAddressString = '';
        foreach ($customerDetails['addresses'] as $addresses) {
            $prepareAddressString .= '
                <Address Status="'.$addresses['status'].'" LocationType="'.$addresses['locationType'].'">
                <StreetNumber Number="'.$addresses['number'].'" Appendix="'.$addresses['appendix'].'">'.$addresses['streetNumber'].'</StreetNumber>
                <CityName PostalCode="'.$addresses['postalCode'].'">'.$addresses['cityName'].'</CityName>
                <CountryName Code="'.$addresses['countryCode'].'">'.$addresses['countryName'].'</CountryName>
                </Address>';
        }

        $customerDetailsString .= '<Customer>
         <PersonName>
         <FirstName>'.$customerDetails['firstName'].'</FirstName>
         <MiddleName>'.$customerDetails['middleName'].'</MiddleName>
         <LastName>'.$customerDetails['lastName'].'</LastName>
         <Title>'.$customerDetails['title'].'</Title>
         <Salutation>'.$customerDetails['salutation'].'</Salutation>
         </PersonName>
         <Gender>'.$customerDetails['gender'].'</Gender>
         <BirthDate>'.$customerDetails['birthDate'].'</BirthDate>
         <Contacts>
         '.$prepareContactString.'
         </Contacts>
         <Addresses>
         '.$prepareAddressString.'
         </Addresses>
         </Customer>';

        return $customerDetailsString;
    }

    /**
     *
     * $holidayHomeSearchCriteria['holidayHomeAttributes'][] = 'WashingMachine'
     * $holidayHomeSearchCriteria['category'] = 3
     * $holidayHomeSearchCriteria['holidayHomeType'] = 'HolidayFlat'
     * $holidayHomeSearchCriteria['roomCount'] = 4
     *
     * @param array $holidayHomeSearchCriteria
     * @return string
     */
    public function prepareHolidayHomeSearchCriteria (array $holidayHomeSearchCriteria): string {

        $holidayHomeAttributes = '';
        if(!empty($holidayHomeSearchCriteria['holidayHomeAttributes'])) {
            $holidayHomeAttributes = '<HolidayHomeAttributes><HolidayHomeAttribute>'.implode('</HolidayHomeAttribute><HolidayHomeAttribute>',$holidayHomeSearchCriteria['holidayHomeAttributes']).'</HolidayHomeAttribute></HolidayHomeAttributes>';
        }

        return '<HolidayHomeSearchCriteria>
                 <Category>'.$holidayHomeSearchCriteria['category'].'</Category>
                 <HolidayHomeType>'.$holidayHomeSearchCriteria['holidayHomeType'].'</HolidayHomeType>
                 <RoomCount>'.$holidayHomeSearchCriteria['roomCount'].'</RoomCount>
                 '.$holidayHomeAttributes.'
               </HolidayHomeSearchCriteria>';
    }

    /**
     *
     * $book variable example:
     *
     * $book['bookRequestID'] = BR-12345
     * $book['offerID'] = 738_198BE0121443508E_0
     * $book['bookingType'] = BookSoft
     * $book['paymentType'] = BankTransfer
     * $book['paymentTokenId'] = P1
     * $book['paymentToken'] = 10295480129502
     * $book['customerRemarks'] = As agreed upon in our telephone converstion.
     * $book['portalRemarks'] = P1_DIRECT
     *
     * @param array $book
     *
     * @return string
     */
    public function prepareBookRequest(array $book) :string {
        return '<BookRequests>
                 <BookTravelRequest BookRequestID="'.$book['bookRequestID'].'">
                 <OfferID>'.$book['offerID'].'</OfferID>
                 <BookingType>'.$book['bookingType'].'</BookingType>
                 <PaymentTokens>
                 <PaymentToken ID="'.$book['paymentTokenId'].'" PaymentType="'.$book['paymentType'].'">'.$book['paymentToken'].'</PaymentToken>
                 </PaymentTokens>
                 <CustomerRemarks>'.$book['customerRemarks'].'</CustomerRemarks>
                 <PortalRemarks>'.$book['portalRemarks'].'</PortalRemarks>
                 </BookTravelRequest>
               </BookRequests>';
    }

    /**
     *
     * @param array $params
     *
     * $params[1]['param_key']
     * $params[1]['param_value']
     *
     * $param['param_key'] = addon_voucher
     * $param['param_value'] = XV-ABC-456-RTZ
     *
     * @return string
     */
    public function prepareParamList (array $params) {
        $preparedParamListString = '<ParamList>';

        foreach ($params as $param) {
            $preparedParamListString .= '<Param Key="'.$param['param_key'].'">'.$param['param_value'].'</Param>';
        }
        $preparedParamListString .= '</ParamList>';

        return $preparedParamListString;
    }


    /**
     *
     * $comments[1]['category']
     * $comments[1]['travelAgent']
     * $comments[1]['type']
     * $comments[1]['username']
     * $comments[1]['comment']
     *
     * $comments as $comment example:
     * $comment['category'] = Customer
     * $comment['travelAgent'] = ta/251
     * $comment['type'] = CallCenter
     * $comment['username'] = bermudas
     * $comment['comment'] = Client email and phone call.
     *
     *
     * @param array $comments
     * @return string
     */
    public function prepareCommentList (array $comments) {
        $preparedParamListString = '<CommentList>';

        foreach ($comments as $comment) {
            $preparedParamListString .= '<Comment Category="'.$comment['category'].'" TravelAgent="'.$comment['travelAgent'].'" Type="'.$comment['type'].'" Date="'.$this->currentTimestamp.'" Username="'.$comment['username'].'">'.$comment['comment'].'</Comment>';
        }
        $preparedParamListString .= '</CommentList>';

        return $preparedParamListString;
    }
}
