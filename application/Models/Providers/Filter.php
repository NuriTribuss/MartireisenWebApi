<?php

namespace Model\Providers;

class Filter {    
       
    /*
     *  Travel Type
     */
    public $type        = null;
    public $productSubType = null;
    public $adults      = null;
    public $children    = null;
    public $category    = null;
    public $rating      = null;
    public $locationList  = null;
    public $regionList    = null;
    public $countryList  = null;
    public $giataIdList   = null;
    public $minCategory = null;
    public $minRecommendation = null;
    public $minBoardType = null;
    public $roomTypeList = null;
    public $keywordList = null;
    public $locatedList = null;
    public $transferList = null;
    public $navigation = '1,10';
    public $departureAirportList = null;
    public $tourOperatorList = null;
    public $filterNoPictures = false;
    public $flightDirectness = false;
    public $sortBy = null;
    public $sortDir = null;
    public $maxPricePerPerson = null;
    
    public $date        = [
        'from' => null,
        'to'   => null
    ];

    function __construct() {
        
    }
    
    function getType() {
        return $this->type;
    }

    function getAdults() {
        return $this->adults;
    }

    function getChildren() {
        return $this->children;
    }

    function getCategory() {
        return $this->category;
    }

    function getRating() {
        return $this->rating;
    }

    function getDate() {
        
        $this->date['from']     =  $this->date['from'] ??   strtotime('+7 days');
        $this->date['to']       =  $this->date['to'] ??  strtotime('+30 days');
        $this->date['duration'] =  $this->date['duration'] ??  "7";
        return $this->date;
    }

    function setType($type) {
        $mapping = [
            '2' => 'pauschal',
            '3' => 'hotelonly'
        ];
        
        $this->type = $mapping[$type];
    }

    function setAdults($adults) {
        $this->adults = $adults;
    }

    function setChildren($children) {
        $this->children = $children;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setRating($rating) {
        $this->rating = $rating;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function getLocationList() {
        return $this->locationList;
    }

    function setLocationList($value) {
        $this->locationList = $value;
    }
    
    function getRegionList() {
        return $this->regionList;
    }

    function setRegionList($regionList) {
        $this->regionList = $regionList;
    }
    
    function getGiataIdList() {
        return $this->giataIdList;
    }

    function setGiataIdList($giataIdList) {
        $this->giataIdList = $giataIdList;
    }

    function getMinCategory() {
        return $this->minCategory;
    }

    function setMinCategory($value) {
        $this->minCategory = $value;
    }
    
    function getMinRecommendation() {
        return $this->minRecommendation;
    }

    function setMinRecommendation($minRecommendation) {
        $this->minRecommendation = $minRecommendation;
    }

    function getMinBoardType() {
        return $this->minBoardType;
    }

    function getRoomTypeList() {
        return $this->roomTypeList;
    }

    function setMinBoardType($minBoardType) {
        $this->minBoardType = $minBoardType;
    }

    function setRoomTypeList($roomTypeList) {
        $this->roomTypeList = $roomTypeList;
    }
    
    function getDepartureAirportList() {
        return $this->departureAirportList;
    }

    function setDepartureAirportList($departureAirportList) {
        $this->departureAirportList = $departureAirportList;
    }
    
    function getSortBy() {
        return $this->sortBy;
    }

    function setSortBy($sortBy) {
        $this->sortBy = $sortBy;
    }

    function getSortDir() {
        return $this->sortDir;
    }

    function setSortDir($sortDir) {
        $this->sortDir = $sortDir;
    }
    
    function getTourOperatorList() {
        return $this->tourOperatorList;
    }

    function setTourOperatorList($tourOperatorList) {
        $this->tourOperatorList = $tourOperatorList;
    }
    
    function getNavigation() {
        return $this->navigation;
    }

    function setNavigation($navigation) {
        $this->navigation = $navigation;
    }
    
    function getFilterNoPictures() {
        return $this->filterNoPictures;
    }

    function setFilterNoPictures($filterNoPictures) {
        $this->filterNoPictures = $filterNoPictures;
    }

    function getKeywordList() {
        return $this->keywordList;
    }

    function setKeywordList($keywordList) {
        $this->keywordList = $keywordList;
    }
    
    function getLocatedList() {
        return $this->locatedList;
    }

    function setLocatedList($locatedList) {
        $this->locatedList = $locatedList;
    }

    function getTransferList() {
        return $this->transferList;
    }

    function setTransferList($transferList) {
        $this->transferList = $transferList;
    }
    
    function getFlightDirectness() {
        return $this->flightDirectness;
    }

    function setFlightDirectness($flightDirectness) {
        $this->flightDirectness = $flightDirectness;
    }

    function getCountryList() {
        return $this->countryList;
    }

    function setCountryList($countryList) {
        $this->countryList = $countryList;
    }

    function getProductSubType() {
        return $this->productSubType;
    }

    function setProductSubType($productSubType) {
        $this->productSubType = $productSubType;
    }

    function getMaxPricePerPerson() {
        return $this->maxPricePerPerson;
    }

    function setMaxPricePerPerson($maxPricePerPerson) {
        $this->maxPricePerPerson = $maxPricePerPerson;
    }

}
