window.addEventListener("load", function (event) {

    var LandingPage = new Vue({

        el: '#landing',
        data: {

            Marti: null ,
            loading: false,
            relatedLoading : false,
            loader: {
                bookingCreate: false,
                bookingCheck: true,
                offers: false,
            },
            translate: [],
            limit: 25,
            moreBtn: true,
            step: 1,

            results: {

            },
            
            relatedResults: {},

            filter: {
                destination: {
                    type: '',
                    name: '',
                    code: ''
                },
                sf: 2,
                date: {
                    start: '',
                    end: '',
                },

                adults: 2,
                children: [],
                page: 1,
                duration: 7,
                sort : 'TOP',
                landing : true,
                productSubType  : 'all',
                star : 3
            },

            departures: {
                results: [],
                clicked: true,
                query: '',

            },
            member: Marti.Member || {},
            zone : {}
        },

        methods: {

            loadHotels: function (append) {

                var _this = this;
                this.loading = true;

                if (append !== true) {
                    this.results = [];
                }
                axios.post('/service/engine/hotel/get' , this.filter).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }

                    var result = response.data.data.response;

                    if (typeof result.hotelList == 'undefined') {
                        _this.moreBtn = false;
                        _this.loading = false;
                        return;
                    }
                    _this.results = result;
                    _this.loading = false;
                  //  _this.calculateCityPrice(result.cities)
                    _this.callback();
                });
            },
            
            loadRelatedHotels: function () {

                var _this = this;
                this.relatedLoading = true;
               
                axios.post('/service/engine/hotel/get' , {limit: 3 , page : 1 , destination : { code : window.RELATED_IDS,type : 'hotel'} , landing : true}).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }

                    var result = response.data.data.response;
                    _this.relatedResults = result;
                    _this.relatedLoading = false;
                });
            },

            calculateCityPrice: function (cities) {
                for (var i = 0; i < cities.length; i++) {
                    var n = cities[i]['@attributes'].NAME;
                    var d = $(".pri" + n);

                    if (d.length > 0) {
                        d.html(cities[i].MINPREIS);
                    }
                }
            },
            
            callback : function(){
                
                var productData = [];
                for (var i = 0; i < this.results.hotelList.length; i++) {

                    if (i > 20) {
                        break;
                    }
                    
                    let hotel = this.results.hotelList[i];
                    
                    productData.push({
                        'id': hotel.giata.hotelId,
                        'name': hotel.name,
                        'brand': hotel.tourOperator.name,
                        'category': hotel.location.name,
                        'list_position': (i + 1)
                    });

                }

                dataLayer.push({
                    'eventCategory': 'Enhanced Ecommerce',
                    'eventAction': 'Browse',
                    'eventLabel': 'Product Impressions',
                    'ecommerce': {
                        'currencyCode': 'EUR', //  Para Birimi
                        'impressions': productData,
                    },
                    'event': 'eec.impressionView' //  Event Adı
                });
              
            },
            
            openHotelPage(hotel) {
                window.location.href = '/hotel/' + hotel.name_sef + '?sf=2&adults=2&destination[type]=hotel&destination[name]=' + hotel.name + '&destination[code]=' + hotel.giata.hotelId;
            }


        },

        watch: {

        },

        computed: {

        },

        created: function () {

            this.Marti = Marti;
            this.translate = Marti.Locale.all();

            this.filter.limit = 7;
            this.filter.page = 1;
            // this.filter.destination = LandingFilter.destination;
            try {
                
                let zone  = JSON.parse(window.zoneData);
                let filterData  = JSON.parse(window.filterData);
                if(filterData) {
                    this.filter['keywordList'] = filterData.keywordList || [];
                    this.filter['productSubType'] = filterData.productSubType || 'all';
                    this.filter.sf = filterData.sf || this.filter.sf;
                }
                
                this.filter.destination = zone;
                this.loadHotels();
                
            }catch(e){
                console.log(e);
            }
            
            if(window.RELATED_IDS && window.RELATED_IDS != ''){
                this.loadRelatedHotels();
            }
            
            //this.filter.lastmin  = this.zone 
        },

        updated: function () {

        },

        components: {
            HotelLandingLoader: window.contentLoaders.HotelLandingLoader
        }
    });
});