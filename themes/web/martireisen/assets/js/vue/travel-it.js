

window.addEventListener("load", function (event) {
    bindAll();
});

function bindAll() {
    Vue.config.devtools = true;


    var timeout;
    var dateEls = {
        days: [],
        daysShort: [],
        months: []
    }
    for (var i = 1; i < 8; i++) {
        dateEls.days.push(Marti.Locale.get('day.' + i));
        dateEls.daysShort.push(Marti.Locale.get('day.' + i).substr(0, 3));
    }
    for (var i = 1; i < 13; i++) {
        dateEls.months.push(Marti.Locale.get('month.' + i));
    }

    Vue.use(window.AirbnbStyleDatepicker, {
        colors: {
            selected: '#ff9700',
            inRange: '#fdb245',
            selectedText: '#fff',
            text: '#565a5c',
            inRangeBorder: '#fff',
            disabled: '#fff',
            hoveredInRange: '#67f6ee',
        },
        days: dateEls.days,
        daysShort: dateEls.daysShort,
        monthNames: dateEls.months,
        texts: {
            apply: Marti.Locale.get('search.take'),
            cancel: Marti.Locale.get('user.cancel'),
            keyboardShortcuts: 'Keyboard Shortcuts',
        },
    });

    window.App = new Vue({

        el: '#app',

        data: {
            filter_destination_focused:false,
            Marti: null,
            loading: false,
            loader: {
                bookingCreate: false,
                bookingCheck: true,
                offers: false,
            },
            is_filter_render: true,

            translate: [],
            limit: 25,
            moreBtn: true,
            step: 1,
            facilityList : [],
            is_duration_changed : false,
            catalogData : '',
            is_option_available : true,

            destinations: {
                locations: [],
                regions : [],
                countries : [],
                hotels: [],
                favourites: [],
                populars: [],
                clicked: true
            },

            results: {},

            sortLocal: {
                column: '',
                direction: 'asc'
            },
            current_filters: [],
            filter_counter: 0,
            filter: {
                sf: 2,
                sort: null,

                date: {
                    start: '',
                    end: '',
                },
                departure: {
                    code: '',
                    name: ''
                },
                destination: {
                    type: '',
                    name: '',
                    code: ''
                },
                flight: {
                    departure: ['00:00', '23:59'],
                    arrival: ['00:00', '23:59']
                },
                adults: 2,
                children: [],
                page: 1,
                duration: 7,
                //  star  : 0,
                //   reviewRate : 0,
                //  priceStart : 0,
                //  priceEnd : 10000,
                attributes: [],
                travel_type: '',
                operators: [],
                
                directness : '',
                //    room : 0,
                //   pansion : 0,
                //  seaview : 0,
                // transfer :0,

            },

            departures: {
                results: [],
                clicked: true,
                query: '',

            },

            hotel: {},

            offer: {},

            selectedOffer: {},

            booking: {},

            bookingForm: {
                personal: {},
                traveller: [],
                children: [],
                booking: {},
                payment: {
                    method: 1
                },
                coupon: '',
                aggregment: false,
                traveller_first: true,

            },

            hotelTab: 1,
            operators: [],
            countries: [],
            hours: ['00:00', '04:00', '07:00', '10:00', '13:00', '16:00', '19:00', '22:00', '23:59'],

            mobile: {
                isMobile: false,
                popup: false,
            },

            member: Marti.Member || {},
        },

        methods: {
            filterSetValue: function (prop, value, is_hotel_load_open, is_append) {
                this.filter[prop] = value;
                if (is_hotel_load_open) {
                    this.loadHotels(is_append);
                }
            },
            
            filterDesktopChange: function () {
                this.filterRender();
                if (!this.mobile.isMobile) {
                    this.loadHotels();
                }
            },
            
            filterRender: function () {
                this.is_filter_render = true
            },
            
            star: function (index) {
                this.filter.star = index;
                this.filterDesktopChange()
            },

            review: function (rate) {
                this.filter.reviewRate = rate;
                this.filterDesktopChange()
            },

            decrease: function (type) {
                if (type === 'adult') {
                    if (this.filter.adults == 1) {
                        return false;
                    }
                    this.filter.adults--;
                    this.filterSetValue('adult', this.filter.adults, false)
                } else {
                    this.filter.children.pop();
                    this.filterSetValue('children', this.filter.children, false)
                }
            },

            increase: function (type) {

                if (type === 'adult') {
                    if (this.filter.adults > 10) {
                        return false;
                    }
                    this.filter.adults++;
                    this.filterSetValue('adult', this.filter.adults, false)
                } else {
                    if (this.filter.children.length < 4) {
                        this.filter.children.push({'jahre': 6, 'percent': 50});
                        this.filterSetValue('children', this.filter.children, false)
                    }
                }

            },

            renderDate: function (date) {
                if (date.trim().length == '') {
                    return date;
                }
                var k = date.split('/');
                var r = k[1] + '/' + k[0] + '/' + k[2];
                if (k.length == 1) {
                    k = date.split('-');
                    r = k[2] + '/' + k[1] + '/' + k[0];
                }
                if (typeof r == 'undefined') {
                    return '';
                }
                return r;
            },

            focus: function (type) {

                $("[id^='mobile-']").removeClass('active');

                if (this.mobile.isMobile) {
                    if ("activeElement" in document)
                        document.activeElement.blur();
                    $("#mobile-" + type).addClass('active');

                    $("#mobile-input-" + type).focus();
                }

                if (typeof this[type] !== 'undefined') {
                    this[type].clicked = false;
                    this.mobile.popup = true;
                }
            },

            makeUrl: function () {

                var url = '';
                if (['state','location','region','country'].indexOf(this.filter.destination.type) > -1 && this.filter.destination.code != '') {
                    url = '/search/hotels?' + jQuery.param(this.filter);
                } else if (this.filter.destination.type === 'hotel' && this.filter.destination.code != '') {

                    var source = this.filter.destination.source;
                    switch (source) {
                        case 'HalalBooking':
                            url = '/halal-booking/hotel-offers?' + jQuery.param(this.filter);
                            break;

                        default :
                            url = '/search/hotel-offers?' + jQuery.param(this.filter);
                            break;
                    }

                } else {
                    url = '/search/region?' + jQuery.param(this.filter);
                }

                return url;

            },
            
            makeTourUrl(){
               let url = ' /tour/search?station=&destination=&start_date='+this.filter.date.start;
               return url;
            },

            highlight: function (str) {

                if (this.filter.destination.name.trim().length == 0) {
                    return str;
                }

                return str.replace(new RegExp(this.filter.destination.name, "gi"), match => {
                    return '<span class="highlightText">' + match + '</span>';
                });

            },

            search_offers: function (type, data, veranst) {
               
                if (typeof type !== 'undefined' && typeof data != 'undefined') {
                    this.filter.destination.type = type;
                    this.filter.destination.code = data.code || data;
                    this.filter.destination.name = data.name || '';
                }
                
               
                if(this.filter.sf == 5){
                    var url = this.makeTourUrl();
                }else{
                    var url = this.makeUrl();
                }
                if (typeof veranst != 'undefined') {
                    url += '&vc=' + veranst;
                }

                // if(type == 'hotel'){
                //      window.open(url);
                //  }else{
                location.href = url;
                //   }

                return false;

            },

            select_departure: function (departure) {
                
                var codes = this.filter.departure.code.split(',');
                if(codes[0] === '' && codes.length === 1){
                    codes  = [];
                }
                if(codes.indexOf(departure.code) > -1 ){
                    let index = codes.indexOf(departure.code);
                    codes.splice(index,1);
                }else{
                    codes.push(departure.code);
                }
                this.filter.departure.code = codes.join(',');
                this.filter.departure.name = codes.join(',');
                
                this.mobile.popup = false;
                this.departures.clicked = true;
               // $('.search-box-item').removeClass('active');
            },
            
            has_departure : function( departure){
                
                var codes = this.filter.departure.code.split(',');
                if(codes[0] === '' && codes.length === 1){
                    codes  = [];
                }
                if(codes.indexOf(departure.code) > -1 ){
                    return true;
                }
                return false;
            },

            select_destination: function (type, record) {

                if (type === 'hotel') {
                    this.filter.destination = {
                        name: record.name,
                        code: record.code,
                        type: 'hotel'
                    };
                } else {
                    this.filter.destination = {
                        name: record.name || record.name,
                        code: record.traffics_code ? record.traffics_code : record.code,
                        type: record.type || 'region'
                    };
                    
                }

                this.filter.destination.source = record.source;
                this.destinations.clicked = true;
                this.mobile.popup = false;

            },

            filter_destination: function () {
                
                this.destinations.clicked = false;
                var _this = this;

                if (timeout) {
                    clearTimeout(timeout);
                    timeout = null;
                }
                timeout = setTimeout(function () {
                    //$(".regions-group").removeClass('hidden');
                    //$(".hotels-group").removeClass('hidden');
                    _this.filter_results();
                }, 500);


            },

            filter_operator: function (code) {

                var index = this.filter.operators.indexOf(code);
                if (index > -1) {
                    delete this.filter.operators[index];
                } else {
                    this.filter.operators.push(code);
                }

                this.filter.page = 1;
                this.loadHotelOffers();
            },

            filter_check: function (param1, param2) {
                if (Array.isArray(param2)) {
                    return param2.indexOf(param1) > -1;
                }
                return param1 == param2;
            },

            filter_results: function () {

                var _this = this;

                if (this.filter.destination.name.length < 2) {
                    _this.destinations.hotels = [];
                    _this.destinations.locations = [];
                    _this.destinations.countries = [];
                    _this.destinations.regions = [];
                    return false;
                }

                // _this.loading = true;

                var formData = new FormData;
                formData.append('q', this.filter.destination.name);
                formData.append('type', (this.filter.sf === '2' ? 'pauschal' : 'hotelonly' ));

                axios.post('/service/engine/search/get', formData)
                        .then(function (response) {
                            let hotelList    = response.data.data.response.giataHotelList;
                         //   _this.destinations.locations = locationList;
                            _this.destinations.hotels = hotelList;
                        //    _this.destinations.countries = response.data.data.response.countryList;
                          //  _this.destinations.regions = response.data.data.response.regionList;
                            //Array.isArray(response.data.data) ? response.data.data.slice(0, 5) : [];
                });
                axios.post('/service/engine/search/suggest', formData)
                        .then(function (response) {
                            _this.destinations.locations = response.data.data;
                });

             /*   axios.post('/service/hotels/get/', formData)
                        .then(function (response) {

                            _this.destinations.hotels = Array.isArray(response.data.data) ? response.data.data.slice(0, 15) : [];
                            _this.loading = false;
                            // $("#mobile-input-destinations").focus();
                            // $("#mobile-input-destinations").select();
                        }); */
            },

            filter_airports: function () {

                var query = this.departures.query;
                var tmp = this.departures.result;

            },

            filter_global_types: function (type) {
                var index = this.filter.attributes.indexOf(type);
                if (index > -1) {
                    this.filter.attributes.splice(index, 1);
                } else {
                    this.filter.attributes.push(type);
                }
                this.filterDesktopChange()
            },

            isSelectedAttribute: function (type) {
                var index = this.filter.attributes.indexOf(type);
                return index > -1;
            },

            filter_travel_types: function (hex) {

                if (this.filter.travel_type === '') {
                    this.filter.travel_type = hex;
                } else {
                    this.filter.travel_type = '';
                }

                this.filterDesktopChange()
            },

            sortRegions: function (column) {

                if (this.sortLocal.column === column) {
                    this.sortLocal.direction = this.sortLocal.direction == 'desc' ? 'asc' : 'desc';
                }

                this.sortLocal.column = column;
                this.results.REGION.sort((a, b) => ((this.sortLocal.direction == 'asc' ? (a.avg[column] > b.avg[column]) : (a.avg[column] < b.avg[column])) ? 1 : -1));

                for (var i = 0; i < this.results.REGION.length; i++) {
                    if (Array.isArray(this.results.REGION[i].ZIEL) == false) {
                        continue;
                    }
                    var sorted = this.results.REGION[i].ZIEL.slice(0).sort((a, b) => ((this.sortLocal.direction == 'asc' ? (a[column] > b[column]) : (a[column] < b[column])) ? 1 : -1));
                    var k = this.results.REGION[i];
                    k['ZIEL'] = sorted;
                    Vue.set(App.results.REGION, i, k);

                }

            },

            setCoupon: function () {

                var _this = this;
                this.loading = true;

                if (this.bookingForm.coupon.trim() == '') {
                    swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.coupon_code_empty'), 'warning');
                    return false;
                }

                axios.get('/service/booking/set-discount/' + this.bookingForm.coupon + '/' + this.offer.price).then(function (response) {

                    if (response.data.status == false) {
                        swal(Marti.Locale.get('common.warning'), response.data.message, 'warning');
                        return false;
                    }
                    _this.offer.discount = response.data.data.discount.toFixed(2);
                    _this.offer.price_display = response.data.data.price;
                    _this.offer.price_base = response.data.data.price_base;

                    swal(Marti.Locale.get('common.success'), response.data.message, 'success');

                    _this.loading = false;
                });

            },
            
            loadStatics(){
                var _this = this;
                axios.get('/service/engine/statics/facility').then(function (response) {

                    if (response.data.status == false) {
                        swal(Marti.Locale.get('common.warning'), response.data.message, 'warning');
                        return false;
                    }
                    _this.facilityList = response.data;
                });
            },

            filterSortChange: function (sort) {
                this.filter.sort = sort;
                this.filterSetValue('sort', sort, false)
                this.sortHotels();
            },

            sortHotels: function () {
                this.reset();
                this.loadHotels();
            },

            showMore: function () {
                this.filter.page = this.filter.page + 1;
                this.filterSetValue('page', this.filter.page, false, false)
                this.loadHotels(true)
            },

            showMoreOffer: function () {
                this.filter.page = this.filter.page + 1;
                this.filterSetValue('page', this.filter.page)
                this.loadHotelOffers(true)
            },

            reset: function () {
                this.filter.page = 1;
                this.filter.star = 0;
                //   this.filter.duration = 7;
                this.filter.reviewRate = 0;
             //   this.filter.attributes = [];
                this.filter.travel_type = '';
                this.filter.room = 0;
                this.filter.pansion = 0;
                this.filter.operators = [];
                this.filter.transfer = 0;
                this.filter.seaview = 0;
                this.current_filters = [];
                this.moreBtn = true;
            },

            resetParam: function (param) {
                switch (param) {
                    case 'sf':
                        this.filter.sf = 2;
                        break;
                    case 'date':
                        this.filter = {
                            start: '',
                            end: '',
                        }
                        break;
                    case 'sort':
                        this.filter.sort = null;
                        break;
                    case 'deperture':
                        this.filter.departure = {
                            code: '',
                            name: ''
                        }
                        break;
                    case 'destination':
                        this.filter.destination = {
                            type: '',
                            name: '',
                            code: ''
                        };
                        break;
                    case 'flight':
                        this.filter.flight = {
                            departure: ['00:00', '23:59'],
                            arrival: ['00:00', '23:59']
                        };
                        break;
                    case 'adults':
                        this.filter.adults = 2;
                        break;
                    case 'page':
                        this.filter.page = 1;
                        break;
                    case 'star':
                        this.filter.star = 0;
                        break;
                        
                    case 'reviewRate' : 
                        this.filter.reviewRate = 0;
                        break;
                    case 'duration':
                        this.filter.duration = 7;
                        break;
                    case 'attributes':
                        this.filter.attributes = [];
                        break;
                    case 'travel_type':
                        this.filter.travel_type = '';
                        break;
                    case 'operators':
                        this.filter.operators = [];
                        break;
                    case 'room':
                        this.filter.room = 0;
                        break;
                    case 'pansion':
                        this.filter.pansion = 0;
                        break;
                    case 'transfer':
                        this.filter.transfer = 0;
                        break;
                    case 'seaview':
                        this.filter.seaview = 0;
                        break;

                    case 'city':
                        this.filter.city = 0;
                        break;
                }
                // this.filter[param] = 0;
                this.loadHotels();
            },

            loadHotels: function (append) {
                if(this.step === 1){
                    this.loadRegions();
                    return false;
                }
                this.filter_counter = this.filter_count();
               

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
                    
                    _this.is_duration_changed =  response.data.data.duration;
                    if (append === true) {
                        _this.results.hotelList = _this.results.hotelList.concat(result.hotelList);
                    } else {
                        _this.results = result;
                        _this.loadCallback();
                    }
                    
                    setTimeout(function () {
                        const slider = new Swiper('.hotel-list-slider', {
                            spaceBetween: 10,
                            observer: true,
                            observeParents: true,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            }
                        });
                    });
                    
                    $("#modalFilters").modal('hide');

                    _this.loading = false;
                });
            },
            
            loadCallback(){
                
                var productData = [];
                for (var i = 0; i < this.results.hotelList.length; i++) {

                    if (i > 20) {
                        break;
                    }
                    
                    let hotel = this.results.hotelList[i];
                    
                    productData.push({
                        'id': hotel.giata.hotelId,
                        'name': hotel.name,
                        'brand': hotel.tourOperator.code,
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
                
                window.FBConversion.search(productData,this.filter.destination.name);
                
              
            },

            sortOffers: function () {
                this.loadHotelOffers();
            },

            filterSortOfferChange: function (sort) {
                this.filter.sort = sort;
                this.loadHotelOffers();
            },

            loadHotelOffers: function (append) {

                var _this = this;
                this.loader.offers = true;

                if (append !== true) {
                    this.results = [];
                }
                

                axios.post('/service/engine/offer/get',this.filter).then(function (response) {
                    
                    let obj = {
                        'eventCategory': 'Enhanced Ecommerce',
                        'eventAction': 'Browse',
                        'eventLabel': 'Product View',
                        'ecommerce': {
                            'currencyCode': 'EUR', //  Para Birimi
                            'impressions': [{
                                'id': _this.hotel.giata.hotelId,
                                'name': _this.hotel.name,
                                'brand': '',
                                'category': _this.hotel.location.name,
                                'list_position': 0,
                                'price' : 0
                            }],
                        },
                        'event': 'eec.detail' //  Event Adı
                    };
                
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        dataLayer.push(obj);
                        return false;
                    }

                    var result = response.data.data.response;

                    if (typeof result.offerList == 'undefined') {
                        swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        _this.moreBtn = false;
                        _this.loader.offers = false;
                        dataLayer.push(obj);
                        return;
                    }

                    if (append === true) {
                        _this.results.offerList = _this.results.offerList.concat(result.offerList);
                    } else {
                        _this.results = result;
                        _this.operators = result.tourOperatorList;
                    }
                    
                    
                    if(_this.results.offerList.length > 0 ){
                        obj['ecommerce']['impressions'][0]['price'] = _this.results.offerList[0].personPrice.value; 
                        dataLayer.push(obj);
                        window.FBConversion.product(_this.hotel);
                    }

                    _this.loader.offers = false;
                    
                    setTimeout(function () {
                        _this.checkBooking(_this.results.offerList[0], 0);
                    }, 600);


                });
            },

            loadHotelMap: function (id, operator) {
                
                $("#mapModal").modal('show');
                var myLatLng = {lat: parseFloat(this.hotel.location.latitude), lng: parseFloat(this.hotel.location.longitude)};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: myLatLng,
                    fullscreenControl: false,
                });

                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Hello World!'
                });
            },

            loadHotelImage: function (item) {

                var _this = this;
                
                var opts = {
                    'operators': [item.tourOperator.code] || []
                }
                _this.loading = true;
                axios.post('/service/engine/hotel/detail/'+item.giata.hotelId,opts).then(function (response) {
                    _this.loading = false;
                    if (response.data.status == false || response.data.data.response.hotel ==  null) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }

                    _this.hotel = response.data.data.response.hotel;
                    $("#imageModal").modal('show');
                    //    window.modal.open($("#imageModal"));

                    setTimeout(function () {

                        var galleryThumbs = new Swiper('.gallery-thumbs', {
                            spaceBetween: 10,
                            slidesPerView: _this.mobile.isMobile ? 2 : 4,
                            freeMode: true,
                            watchSlidesVisibility: true,
                            watchSlidesProgress: true,
                        });

                        var galleryTop = new Swiper('.gallery-top', {
                            spaceBetween: 10,
                            observer: true,
                            observeParents: true,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            thumbs: {
                                swiper: galleryThumbs
                            }
                        });
                    }, 400);

                });

            },
            
            loadOperatorContent(code){
                var opts = {
                    'operators': [code]
                };
                var _this = this;
                axios.post('/service/engine/hotel/detail/'+this.hotel.giata.hotelId,opts).then(function (response) {
                    if (response.data.status == false) {
                       
                    }else{
                        let data = response.data.data;
                        if(data.response.hotel == null){
                            _this.catalogData = '';
                        }else{
                            _this.catalogData = data.response.hotel.catalogData.html;
                        }
                    }
                });

            },

            loadHotel: function (gid, detail,callback) {

                var _this = this;

                _this.loading = true;
                var opts = {
                    'operators': [this.filter.vc] || ['FTI'],
                }

                axios.post('/service/engine/hotel/detail/'+gid,opts).then(function (response) {
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.hotel_error'), 'warning');
                        setTimeout(function(){
                            location.href= '/';
                        },1500);
                        return false;
                    }

                    _this.hotel = response.data.data.response.hotel;
                    _this.loading = false;

                    if (typeof detail !== 'undefined' && detail == false) {
                        return false;
                    }
                    
                    _this.catalogData = _this.hotel.catalogData.html;
                    
                    if(typeof callback == 'function'){
                        callback();
                    }
                    

                    setTimeout(function () {

                        window.hotelinfoSlider = new Swiper("#hotelinfoSlider", {
                            slidesPerGroup: 1,
                            slidesPerView: 1,
                            effect: "fade",
                            fadeEffect: {
                                crossFade: true
                            },
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            autoplay: {
                                delay: 3000,
                                // disableOnInteraction: false
                            },
                        });

                        var hotelinfoSliderThumbnails = new Swiper("#hotelinfoSliderThumbnails", {
                            spaceBetween: 5,
                            slidesPerGroup: 1,
                            slidesPerView: 4,
                            centeredSlides: true,
                            touchRatio: 0.5,
                            slideToClickedSlide: true
                        });

                        hotelinfoSlider.controller.control = hotelinfoSliderThumbnails;
                        hotelinfoSliderThumbnails.controller.control = hotelinfoSlider;

                    }, 400);

                    if (typeof window.loadHotelCallback == 'function') {
                        window.loadHotelCallback(_this.hotel);
                    }
                    
                  
                
                });
            },

            imageModal: function () {

                var $pswp = $('.pswp')[0],
                        options = {
                            index: 0,
                            bgOpacity: 0.85,
                            modal: false,
                            showHideOpacity: true
                        };
                var container = [];
                if (this.hotel !== null && this.hotel.images !== null) {
                    var images = this.hotel.images;
                    
                    for (var i = 0; i < images.length; i++) {
                        var item = {
                            src: images[i].url,
                            w: images[i].width,
                            h: 500,
                            title: images[i].name
                        };
                        container.push(item);
                    }
                }

                var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                gallery.init();
            },

            loadOperators: function () {

                var _this = this;
                this.operators = [];

                axios.get('/service/operators/get').then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }
                    _this.operators = response.data.data;
                });

            },

            checkBooking: function (termin, index, br) {

                if (index - 1 >= 0)  {
                    $('.js-mobile-result-list-item-' + (index - 1)).removeClass('is-active')
                }

                $('.js-mobile-result-list-item-' + index).addClass('is-active')

                var el = document.getElementById('offer_detail_' + index);
                if (el) {
                    el.disabled = true;
                    $('#offer_detail_' + index).css('display', 'block');
                }

                var _this = this;

                $("#pricesCollapse" + index).css('max-height', 'none');
                this.filter['code'] = termin.code;
                axios.post('/service/engine/offer/check-offer/',this.filter).then(function (response) { 

                    var a = _this.results.offerList[index];
                    if (typeof response.data.data.response.error != 'undefined') {
                        $("#pricesCollapse" + index).css('max-height', '0px');
                    }else{
                        br = true;
                    }

                    a['book'] = response.data.data.response;

                    Vue.set(App.results.offerList, index, a);              
                    $('#offer_detail_' + index).css('display', 'none');
                    _this.selectedOffer = a;
                    if(_this.results.offerList.length > 1 && br != true &&  index === 0) {
                        _this.checkBooking(_this.results.offerList[1], 1,true);
                    }
                });
            },

            checkBookingModal: function () {
                if (this.mobile.isMobile) {
                    mobileModOpen("#mobile-offer-error");
                } else {
                    $("#offer-error").modal('show');
                }
            },

            getBookingUrl(book, code) {
                
                var url = '/search/hotel-booking?';
                let travellerCount = this.travellerCount( book.travellerList);
                let params = {
                    'adults': travellerCount.adult,
                    'ref': code,
                    'children': this.filter.children,
                    'gid' : this.hotel.giata.hotelId
                };

                url += jQuery.param(params);

                return url;
            },
            
            getBooking: function (ref) {

                var _this = this;
                var formData = new FormData();
                let filter = window.Marti.filter;

                formData.append('code', ref);
                formData.append('GID', filter.gid);
                formData.append('CITY', filter.city);
                formData.append('FILTER', JSON.stringify(window.Marti.filter));
                this.filter['code'] = ref;
                axios.post('/service/engine/offer/check-offer/',this.filter).then(function (response) {

                    _this.loader.bookingCheck = false;
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.is_invalid'), 'warning');

                        setTimeout(function () {
                            //   location.href = '/';
                        }, 1500);
                    }

                    _this.offer = response.data.data.response;
                    _this.getBookingParams(); 
                    _this.bookingPageCallback();
                });
                
                axios.post('/service/engine/offer/check-offer/option',this.filter).then(function (response) {

                    //_this.loader.bookingCheck = false;
                    var data = response.data.data.response;
                    if(data.statusCode != 'OK'){ 
                        _this.is_option_available = false;
                    }
                });
            },
            
            bookingPageCallback(){
                
                let data = {
                    'name'            : this.offer.commonOffer.hotelOffer.hotel.name,
                    'id'              : this.offer.commonOffer.hotelOffer.hotel.giata.hotelId,
                    'price'           : parseFloat(this.offer.commonOffer.totalPrice.value).toFixed(2),
                    'brand'           : this.offer.commonOffer.tourOperator.name,
                    'category'        : this.offer.commonOffer.hotelOffer.hotel.location.name,
                    'variant1'        : this.offer.commonOffer.hotelOffer.boardType.name,
                    'duration'        : this.offer.commonOffer.hotelOffer.travelDate.duration + ' Days',
                    'room_type'       : this.offer.commonOffer.hotelOffer.roomType.name,
                    'adult'           : Marti.filter.adults,
                    'children'        : Marti.filter.children.length,
                    /*'checkin_date' : this.offer.commonOffer.hotelOffer.start_date,*/
                    'departure_date'  : this.offer.commonOffer.hotelOffer.travelDate.fromDate,
                };
                
                dataLayer.push({
                    'event': 'checkout',
                    'ecommerce': {
                      'checkout': {
                        'actionField': {'step': 1},
                        'products': [data]
                     }
                   },
                   
                });
                
                window.FBConversion.checkout(data);
            },

            getBookingParams: function () {
                var _this = this;
                this.bookingForm.personal = this.bookingForm.personal || {};
                this.bookingForm.personal.name = Marti.Member.name;
                this.bookingForm.personal.surname = Marti.Member.surname;
                this.bookingForm.personal.email = Marti.Member.username;
                this.bookingForm.personal.gender = 0;
                this.bookingForm.personal.country = 'OE';
                //  $("[name='reg_land']").parent().parent().find('.selectbox-mega-button-text').html('Österreich');

                let travellerCount = this.travellerCount( this.offer.travellerList);
                for (var i = 0; i < parseInt(travellerCount.adult); i++) {
                    this.bookingForm.traveller.push({
                        'name': '',
                        'surname': '',
                        'birthday': '',
                        'gender': ''
                    });
                }

                for (var i = 0; i < parseInt(travellerCount.children); i++) {
                    this.bookingForm.children.push({
                        'name': '',
                        'surname': '',
                        'birthday': '',
                    });
                }
                
                axios.get('/service/booking/init').then(function (response) {
                    if(response.data.status){
                        let data = response.data.data;
                        _this.bookingForm = data;
                    }
                    
                });
            },

            book: function () {

                if (this.booking == null) {
                    return false;
                }
                $(".checkbox-default-text").removeClass("text-danger");
                /* if(!$("#aggregment").is(':checked')){
                 $(".checkbox-default-text").addClass("text-danger");
                 $('html, body').animate({
                 scrollTop: $("#aggregment").offset().top
                 }, 2000);
                 return false;
                 }*/


                this.bookingForm['operator'] = this.offer.commonOffer.tourOperator.code;
                this.bookingForm['hotel'] = {
                    'giata': this.hotel.giata.hotelId,
                    'name': this.hotel.giata.hotelName,
                };
                this.bookingForm['booking'] = this.offer.commonOffer.serviceOffer;
                this.bookingForm['type'] = this.offer.type;

                var _this = this;
                _this.loader.bookingCreate = true;

                axios.post('/service/booking/create', this.bookingForm).then(function (response) {
                    _this.loader.bookingCreate = false;

                    if (response.data.status === false) {

                        var errors = response.data.data;
                        if (Array.isArray(errors) == false) {
                            swal(Marti.Locale.get('warning'), response.data.message);
                            return false;
                        }

                        for (var i = 0; i < errors.length; i++) {
                            var domMsg = $('#' + errors[i].key + '_message');
                            $(domMsg).show();

                            if (errors[i].key === 'aggregment') {
                             //   $('#' + errors[i].key).parent().find(".checkbox-default-text").addClass("text-danger");
                            }
                        }
                            
                        if ($('#' + errors[0].key).length > 0) {
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $('#' + errors[0].key).offset().top - 170
                            }, 500);
                        }


                        return false;
                    } else {
                        var result = response.data.data;

                        if (typeof result.url !== 'undefined') {
                            window.location.href = result.url;
                        } else {
                            window.location.href = '/booking/complete';
                        }
                    }
                });

            },
            
            travellerCount(travellerList) {
                let obj = {
                    adult : 0,
                    children : 0,
                };
                for(var i = 0; i < travellerList.length; i++){
                    if(travellerList[i].type === 'H') {
                        obj.adult++;
                    }else{
                        obj.children++;
                    }
                }
                return obj;
            },

            openReview: function (id) {
                var url = 'https://review.holidaycheck.com/de/travel-it/' + id;
                var html = '<iframe src="' + url + '" style="width:100%;height:100%;border:none;"></iframe>';
                $("body").addClass("modal-open");
                if (this.mobile.isMobile) {
                    $("#mobile-review .iframe-area").html(html);
                    mobileModOpen("#mobile-review");
                } else {
                    $("#reviewModal .iframe-area").html(html);
                    $("#reviewModal").modal('show');
                }
            },

            openOperator: function (vc, id) {
                var url = 'https://hic3.travel-it.com/hotelinfocenter3-frontend/#/giata/hotel?cfg=155&vc=' + vc + '&gid=' + id;
                var html = '<iframe src="' + url + '" style="width:100%;height:100%;border:none;"></iframe>';
                $("body").addClass("modal-open");
                if (this.mobile.isMobile) {
                    $("#mobile-offer-info .iframe-area").html(html);
                    mobileModOpen("#mobile-offer-info");
                } else {
                    $("#offer-info .iframe-area").html(html);
                    $("#offer-info").modal('show');
                }
            },

            loadCountries: function () {

                var _this = this;
                axios.get('/service/countries/get-defaults?t=' + (new Date().getTime())).then(function (response) {
                    _this.countries = response.data.data;
                });
            },

            getCountryByCode: function (code) {
                console.log("test");
                for (var i = 0; i < this.countries.length; i++) {
                    var el = this.countries[i];
                    
                    if (el.code === code) {
                        return el.name;
                    }
                }

                return '';
            },

            getCityByCode: function (id) {
                if (this.results.locationList && typeof this.results.locationList[0] == 'undefined') {
                    return '';
                }
                if (Array.isArray(this.results.locationList) == false) {
                    return '';
                }
                for (var i = 0; i < this.results.locationList.length; i++) {
                    var el = this.results.locationList[i];
                    if (el.code === id) {
                        return el.name;
                    }
                }

                return '';
            },

            filter_count: function () {

                var el = 0;
                el = this.filter.star && this.filter.star > 0 ? el + 1 : el;
                el = this.filter.reviewRate && this.filter.reviewRate > 0 ? el + 1 : el;
                el = this.filter.room && this.filter.pansion > 0 ? el + 1 : el;
                el = this.filter.pansion && this.filter.pansion > 0 ? el + 1 : el;
                el = this.filter.city && this.filter.city > 0 ? el + 1 : el;

                return el;
            },
            
            checkFirstTraveller(){
                
                if (this.bookingForm.traveller_first === true) {
                    
                    this.bookingForm.traveller[0].name = this.bookingForm.personal.name;
                    this.bookingForm.traveller[0].surname = this.bookingForm.personal.surname;
                    this.bookingForm.traveller[0].gender = this.bookingForm.personal.gender;
                }
            },
            toHour(time){
                
                if(!time) {
                    return '-';
                }
                
                let hour = time / 60;
                hour     = Math.floor(hour);
                let min  = time - (hour*60);
                
                return hour  +'h '+min+' m';
            },
            loadRegions: function () {

                var _this = this;
                this.loading = true;
                this.results = [];

                axios.post('/service/engine/region/get',this.filter).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }
                    _this.results = response.data.data.response;
                    _this.loading = false;
                });

            },

        },

        watch: {

            /* Çocukların yaşları değiştiğinde, percent ayarlaması */
            'filter.children': {
                handler: function () {
                    const min = 0;
                    const max = 17;
                    if (this.filter.children) {
                        for (var i = 0; i < this.filter.children.length; i++) {
                            this.filter.children[i].percent = ((100 / (max - min) * this.filter.children[i].jahre) - (100 / (max - min) * min)).toFixed(2);
                        }
                        this.filterSetValue('children', this.filter.children, false, false)
                    }

                }, deep: true
            },

            'filter.flight': {
                handler: function (a, b) {
                    if (window.Marti.page === 'hotel-detail' && typeof this.results.offerList !== 'undefined' && this.results.offerList.length > 0) {
                        this.loadHotelOffers();
                    }
                }, deep: true
            },

            'mobile.popup': {
                handler: function (a, b) {
                    if (this.mobile.popup && window.isMobile()) {
                        $("body").addClass('modal-open');
                    } else {
                        $("body").removeClass('modal-open');
                    }
                }, deep: true
            },

            'bookingForm.traveller_first': {
                handler: function (a, b) {

                    if (this.bookingForm.traveller_first === true) {
                        this.bookingForm.traveller[0] = {
                            name: this.bookingForm.personal.name || '',
                            surname: this.bookingForm.personal.surname || '',
                            gender: this.bookingForm.personal.gender || '',
                            birthday: this.bookingForm.personal.birthday || ''
                        }
                    }

                }, deep: true
            },
            
            
           /* 'bookingForm.payment.method': {
                handler: function (a, b) {
                    
                    let mapping = ['','Überweisung','Sofort','Kreditkarte'];
                    dataLayer.push({
                        'event': 'checkout',
                        'ecommerce': {
                          'checkout': {
                            'actionField': {'step': 2 , 'option' : mapping[a]},
                            'products': [{
                              'name'            : this.offer.hotel_info.name,
                              'id'              : this.offer.hotel_info.id,
                              'price'           : parseFloat(this.offer.price).toFixed(2),
                              'brand'           : this.offer.operator.name,
                              'category'        : this.offer.hotel_info.city.name,
                              'variant1'        : this.offer.board,
                              'duration'        : this.offer.day + ' Days',
                              'room_type'       : this.offer.room_type,
                              'adult'           : Marti.filter.adults,
                              'children'        : Marti.filter.children.length,
                              'departure_date'  : this.offer.start_date,
                              'departure_name'  : this.offer.departure_name,
                              'package_type'    : this.offer.reise_art,
                           }]
                         }
                       },

                    });

                }, deep: true
            },*/
            
        },

        computed: {

            filterActive: function () {

                var isActive = this.filter.star > 0 ||
                        this.filter.reviewRate > 0 ||
                        this.filter.room > 0 ||
                        this.filter.pansion > 0;

                return false;
            },
            
        },

        created: function () {

            this.Marti = Marti;
            this.translate = Marti.Locale.all();
            this.mobile.isMobile = window.isMobile();

            var _this = this;

            if (window.Marti.page != 'booking') {

                axios.get('/service/airports/get').then(function (response) {
                    _this.departures.results = response.data.data;
                    if(_this.filter.departure.code != ''){
                        console.log("tee");
                    }
                });

                axios.get('/service/states/favourites').then(function (response) {
                    _this.destinations.favourites = response.data.data;
                });
            }
            if (typeof window.Marti.filter != 'undefined') {

                var page = window.Marti.filter.params;
                delete window.Marti.filter.params;
                this.filter = window.Marti.filter;
                
                this.reset();
             
                switch (page) {

                    case 'search/region' :
                        this.step = 1;
                        this.loadRegions();
                        break;

                    case 'search/hotels' :
                        this.step = 2;
                        this.loadHotels();
                        this.loadStatics();
                        break;

                    case 'search/hotel-offers' :
                        this.step = 3;
                        this.loadHotel(this.filter.destination.code,true,function(){
                             _this.loadHotelOffers();
                        });
                       
                        if (!this.filter.sort || this.filter.sort == '') {
                            this.filter.sort = 'PRICE';
                        }
                       
                        break;

                    case 'search/hotel-booking' :
                        this.step = 4;  
                        this.getBooking(window.Marti.filter.ref);
                        this.loadHotel(window.Marti.filter.gid, false,);
                        this.loadCountries();
                        this.booking = window.Marti.booking;
                        
                        break;
                    default :
                        this.step = 2;
                        this.loadHotels();
                       
                        break;
                }
            }
            
            
        },

        updated: function () {
            $('.input input,.input select, .radio input').on('change', function () {
                var id = $(this).attr('id');
                $('#' + id + '_message').hide();
            });
            
            if(this.bookingForm.personal.birthday){
                
            }
            
        },

        components: {
            VueSlider: window['vue-slider-component'], 
            HotelLoader: window.contentLoaders.HotelLoader,
            HotelOfferLoader: window.contentLoaders.HotelOfferLoader,
            ListLoader: window.contentLoaders.ListLoader,
            HotelLandingLoader: window.contentLoaders.HotelLandingLoader
        }
    });
}