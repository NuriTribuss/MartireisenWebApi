window.addEventListener("load", function (event) {
    bindAll();
});

function bindAll() {
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
            hoveredInRange: '#67f6ee'
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
    var App = new Vue({

        el: '#app',

        data: {
            filter_destination_focused:false,
            loading: false,
            loader: {
                bookingCreate: false,
                bookingCheck: false
            },
            translate: [],
            limit: 20,
            moreBtn: true,
            step: 1,

            destinations: {
                states: [],
                hotels: [],
                favourites: [],
                clicked: true
            },

            defaults: {
                countries: [],
                states: [],
                active_country: '',
                active_state: ''
            },

            results: {},
            filters: [],
            filter: {

                sort: null,
                date: {
                    start: '',
                    end: '',
                },

                destination: {
                    type: '',
                    name: '',
                    code: ''
                },

                adults: 2,
                children: [],
                page: 1,
                duration: 7,
                //   star: 0,
                //   reviewRate: 0,
                holiday_type: '',
                property_types: [],
                // öğün planı
                meal_plans: [],
                locations: [],
                // yıldız
                stars: [],
                // puan
                scores: [],
                // halal meals
                feature_group_1: [],
                // drunk
                feature_group_2: [],
                feature_group_3: []

            },
            is_filter_render: true,
            current_attributes: [],
            hotel: {

            },

            features: [],

            offer: {},

            booking: {},

            bookingForm: {
                personal: {},
                traveller: [],
                children: [],
                booking: {},
                payment: {
                    method: 1
                },
                date: {},
                aggregment: false,
                halalbooking: 1,
                rate_plan_id: '',
                room_id: '',
                coupon: '',

            },

            hotelTab: 1,
            countries: [],
            hours: ['00:00', '04:00', '07:00', '10:00', '13:00', '16:00', '19:00', '22:00', '23:59'],

            mobile: {
                isMobile: false,
                popup: false,
            }

        },

        methods: {

            star: function (index) {
                this.filter.star = index;
                this.filterDesktopChange()
            },

            decrease: function (type) {

                if (type === 'adult') {
                    if (this.filter.adults == 1) {
                        return false;
                    }
                    this.filter.adults--;
                } else {
                    this.filter.children.pop();
                }
            },

            increase: function (type) {

                if (type === 'adult') {
                    if (this.filter.adults > 10) {
                        return false;
                    }
                    this.filter.adults++;
                } else {
                    if (this.filter.children.length < 4) {
                        this.filter.children.push({'jahre': 6, 'percent': 50});
                    }
                }

            },

            renderDate: function (date, seperator) {
                if (typeof seperator == 'undefined') {
                    seperator = '/';
                }
                if (date.trim().length == '') {
                    return date;
                }
                var k = date.split(seperator);
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
                if (this.filter.destination.type === 'state' && this.filter.destination.code != '') {
                    url = '/halal-booking/hotels?' + jQuery.param(this.filter);
                } else if (this.filter.destination.type === 'hotel' && this.filter.destination.code != '') {
                    url = '/halal-booking/hotel-offers?' + jQuery.param(this.filter);
                } else {
                    url = '/halal-booking/hotels?' + jQuery.param(this.filter);
                }

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

            search_offers: function (type, data, name) {

                if (typeof type !== 'undefined' && typeof data != 'undefined') {
                    this.filter.destination.type = type;
                    this.filter.destination.code = data;
                    this.filter.destination.name = name;
                }

                if (this.date_diff() == false) {
                    return false;
                }

                var url = this.makeUrl();

                //  console.log(this.filter);
                //  console.log(url);
                //  return false;
                location.href = url;

            },

            date_diff: function () {
                var diff = Math.abs(new Date(this.filter.date.end) - new Date(this.filter.date.start));
                diff = diff / (1000 * (24 * 60 * 60));
                if (isNaN(diff) == false && diff > 30) {
                    swal(Marti.Locale.get('common.warning'), Marti.Locale.get('halalbooking.max_day_error'));
                    return false;
                }
                return true;
            },

            select_departure: function (departure) {

                this.filter.departure = {
                    code: departure.code,
                    name: departure.name
                };

                this.mobile.popup = false;
            },

            select_destination: function (type, record) {

                if (type === 'hotel') {
                    this.filter.destination = {
                        name: record.label,
                        code: record.giataCode,
                        type: 'hotel'
                    };
                } else {
                    this.filter.destination = {
                        name: record.label || record.name,
                        code: record.code,
                        type: 'state'
                    };

                    if (typeof record.state_code !== 'undefined') {
                        this.filter.destination.type = '';
                    } else if (typeof record.country_id === 'undefined') {
                        this.filter.destination.type = 'region';
                    }
                }

                this.destinations.clicked = true;
                this.mobile.popup = false;

            },

            filter_destination: function () {

                var _this = this;

                if (timeout) {
                    clearTimeout(timeout);
                    timeout = null;
                }
                timeout = setTimeout(function () {
                    //$(".regions-group").removeClass('hidden');
                    //$(".hotels-group").removeClass('hidden');
                    _this.filter_results();
                }, 300);


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
                    _this.destinations.states = [];
                    return false;
                }

                // _this.loading = true;

                var options = {
                    shouldSort: true,
                    threshold: 0.2,
                    location: 0,
                    distance: 100,
                    maxPatternLength: 32,
                    minMatchCharLength: 1,
                    keys: [
                        "value",
                    ]
                };


                axios.get('/service/states/get/' + this.filter.destination.name + '?halal=1')
                        .then(function (response) {
                            var results = response.data.data;

                            results.sort(function (a, b) {
                                return b.sort - a.sort
                            });
                            _this.destinations.states = results.slice(0, 5);
                        });

                axios.get('/service/hotels/get/' + this.filter.destination.name + '?halal=1')
                        .then(function (response) {
                            options['threshold'] = 0.5;
                            var fuse = new Fuse(response.data.data, options);
                            var results = fuse.search(Marti.Tools.replaceTr(_this.filter.destination.name));

                            results.sort(function (a, b) {
                                return b.sort - a.sort
                            });
                            _this.destinations.hotels = results.slice(0, 15);
                            _this.loading = false;
                            // $("#mobile-input-destinations").focus();
                            // $("#mobile-input-destinations").select();
                        });
            },

            filter_attributes: function (key, index, value) {

                if (typeof this.filter[key] != 'undefined') {
                    let index = this.filter[key].indexOf(value);
                    if (index === -1) {
                        this.filter[key].push(value)
                    } else {
                        this.filter[key].splice(index, 1);
                    }
                }
                this.filterDesktopChange();
            },

            removeFilterAttribute: function (group, index, option) {
                this.filter_attributes(group, index, option)
            },

            filterDesktopChange: function () {
                this.filterRender();
                if (!this.mobile.isMobile) {
                    this.loadHotels();
                }
            },

            filterRender: function () {
                this.is_filter_render = false;
                this.is_filter_render = true
            },

            removeAttribute() {
                for (let i = 0; i < this.filters.length; i++) {
                    this.filter[this.filters[i].code] = []
                }
                this.filterDesktopChange();
            },

            sortRegions: function (sort) {
                this.filter.sort = sort;
                this.loadRegions();
            },

            filterSortChange: function (sort) {
                this.filter.sort = sort
                this.sortHotels();
            },

            loadRegions: function () {

                var _this = this;
                this.loading = true;
                this.results = [];

                axios.get('/service/search/region?' + jQuery.param(this.filter)).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }
                    _this.results = response.data.data.response;
                    _this.loading = false;
                    setTimeout(function () {
                        const slider = new Swiper('.hotel-list-slider', {
                            spaceBetween: 10,
                            observer: true,
                            loop: true,
                            observeParents: true,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            }
                        });
                    });
                    Marti.Tools.collapse(0);
                });

            },

            sortHotels: function () {
                this.reset();
                this.loadHotels();
            },

            showMore: function () {
                this.filter.page = this.filter.page + 1;
                this.loadHotels(true)
            },

            reset: function () {
                this.filter.page = 1;
                this.filter.star = 0;
                //   this.filter.duration = 7;
                this.filter.reviewRate = 0;
                this.filter.attributes = [];
                this.filter.room = 0;
                this.filter.pansion = 0;
                this.moreBtn = true;
            },

            resetParam: function (param) {

                this.filter[param] = 0;
                this.loadHotels();
            },

            loadHotels: function (append) {

                var _this = this;
                this.loading = true;

                if (append !== true) {
                    this.results = [];
                    this.filter.page = 1;
                }

                if (this.defaults.active_state != '') {
                    this.filter.destination.code = this.defaults.active_state;
                    this.filter.destination.name = this.defaults.active_state;
                    this.filter.destination.type = 'state';
                } else if (this.defaults.active_country != '') {
                    this.filter.destination.name = this.defaults.active_country;
                    this.filter.destination.code = this.defaults.active_country;
                    this.filter.destination.type = 'region';
                }

                axios.get('/service/halal-booking/offers?' + jQuery.param(this.filter)).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }

                    var result = response.data.data;

                    if (typeof result.offers == 'undefined') {
                        _this.moreBtn = false;
                        _this.loading = false;
                        return;
                    }

                    if (append === true) {
                        _this.results.offers = _this.results.offers.concat(result.offers);
                    } else {
                        _this.results = result;
                    }

                    $('.property-score.property-score_medium.search-i--score')


                    _this.loading = false;
                });
            },

            isSelectedAttribute: function (type) {
                var index = this.filter.attributes.indexOf(type);
                return index > -1;
            },

            loadStates: function () {

                var _this = this;
                axios.get('/service/states/get-defaults/' + _this.defaults.active_country).then(function (response) {
                    _this.defaults.states = response.data.data;
                });

                _this.loadHotels();
            },

            loadHotelMap: function (hotel) {

                var _this = this;

                var opts = {
                    'gid': hotel.GID,
                    'goc': hotel.GOC,
                    'vc': hotel.VERANST || '1'
                }

                axios.get('/service/hotels/get-basic?' + jQuery.param(opts)).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }

                    var hotel = response.data.data;
                    //window.modal.open($("#mapModal"));
                    $("#mapModal").modal('show');

                    var myLatLng = {
                        lat: hotel.giataHotel.geoLocation.latitude,
                        lng: hotel.giataHotel.geoLocation.longitude
                    };
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
                });
            },

            loadHotelImage: function (hotel) {

                this.hotel = hotel;
                if (window.isMobile()) {
                    $("#imageModal").modal('show');
                    //@TODO Mobile modal?
                } else {
                    $("#imageModal").modal('show');
                }

                setTimeout(function () {

                    var galleryThumbs = new Swiper('.gallery-thumbs', {
                        spaceBetween: 10,
                        slidesPerView: 4,
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

            },

            imageModal: function (images) {

                var $pswp = $('.pswp')[0],
                        options = {
                            index: 0,
                            bgOpacity: 0.85,
                            modal: false,
                            showHideOpacity: true
                        };
                var container = [];
                if (images !== null && images !== null) {


                    for (var i = 0; i < images.length; i++) {
                        var item = {
                            src: images[i],
                        };
                        container.push(item);
                    }
                }

                var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                gallery.init();
            },

            loadHotelFeatures: function (gid) {
                var _this = this;
                axios.get('/service/halal-booking/get-hotel-features/' + gid).then((r) => {
                    _this.features = r.data.data;
                })
            },

            loadHotel: function (gid, detail, callback) {

                var _this = this;

                _this.loading = true;
                var opts = {
                    'gid': gid,
                }

                axios.get('/service/halal-booking/get-hotel?' + jQuery.param(this.filter)).then(function (response) {
                    if (response.data.status == false) {
                        swal('Warning', 'An Error Occured. Please Contact Website Owner', 'warning');
                        return false;
                    }
                    _this.hotel = response.data.data.place;
                    //_this.hotel['features'] = [];
                    _this.results.offers = response.data.data.groups;
                    _this.results.hotel = response.data.data.place;

                    _this.loading = false;

                    if (typeof callback == 'function') {
                        callback();
                    }

                    if (typeof detail !== 'undefined' && detail == false) {
                        return false;
                    }

                    _this.loadHotelFeatures(_this.hotel.id);

                    setTimeout(function () {

                        var hotelinfoSlider = new Swiper("#hotelinfoSlider", {
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
                                disableOnInteraction: false
                            },
                        });

                        const slider = new Swiper('.hotel-list-slider', {
                            spaceBetween: 10,
                            observer: true,
                            observeParents: true,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            }
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
                });
            },

            goBooking: function (data, index, subindex) {

                var params = '&room_id=' + data['offers'][index]['offers'][subindex].room.id + '&';
                params += 'rate_plan_id=' + data['offers'][index]['offers'][subindex].rate_plan.id + '&';
                params += 'gid=' + data['hotel']['id'];

                location.href = '/halal-booking/hotel-booking?' + jQuery.param(this.filter) + params;

            },

            checkBookingModal: function () {
                window.modal.open($("#offer-error"));
            },

            getBooking: function (ref) {

                var _this = this;
                var formData = new FormData();

                formData.append('REF', ref);
                formData.append('FILTER', JSON.stringify(window.Marti.filter));

                _this.loader.bookingCheck = true;
                axios.post('/service/search/booking-page', formData).then(function (response) {

                    _this.loader.bookingCheck = false;
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.is_invalid'), 'warning');

                        setTimeout(function () {
                            location.href = '/';
                        }, 1500);
                    }

                    _this.offer = response.data.data.response;
                    const slider = new Swiper('.hotel-list-slider', {
                        spaceBetween: 10,
                        observer: true,
                        observeParents: true,
                        loop: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        }
                    });
                    _this.getBookingParams();
                });
            },

            getBookingParams: function () {

                this.bookingForm.personal = this.bookingForm.personal || {};
                this.bookingForm.personal.name = Marti.Member.name;
                this.bookingForm.personal.surname = Marti.Member.surname;
                this.bookingForm.personal.email = Marti.Member.username;
                this.bookingForm.personal.country = 'OE';

                var k = this.booking.traveller;
                for (var i = 0; i < parseInt(k); i++) {
                    this.bookingForm.traveller.push({
                        'name': '',
                        'surname': '',
                        'birthday': '',
                        'gender': 1
                    });
                }

                var k = this.booking.children.length;
                for (var i = 0; i < parseInt(k); i++) {
                    this.bookingForm.children.push({
                        'name': '',
                        'surname': '',
                        'birthday': '',
                    });
                }

                this.bookingForm.date = this.filter.date;
            },

            book: function () {

                if (this.booking == null) {
                    return false;
                }

                this.bookingForm['hotel'] = {
                    'giata': this.hotel.id,
                    'name': this.hotel.name,
                };
                this.bookingForm['booking'] = this.booking.data;


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
                        }
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $('#' + errors[0].key).offset().top - 170
                        }, 500);


                        //  swal(Marti.Locale.get('common.warning'),response.data.message);

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

            openReview: function (id) {

                const url = 'https://tr.halalbooking.com/get/reviews/p/' + id;
                const html = '<iframe src="' + url + '" style="width:100%;height:100%;border:none;" id="reviewIframe"></iframe>';
                $("#reviewModal .iframe-area").html(html);
                $("#reviewModal").modal('show');
                $("#reviewIframe").on("load", function () {
                    let head = $("#reviewIframe").contents().find("head");
                    let css = '<style> .header,.footer-container ,page-header--container { display:none; }</style>';
                    $(head).append(css);

                });
                // window.mobileOpen("#mobile-review");
            },

            loadCountries: function () {

                var _this = this;
                axios.get('/service/countries/get-defaults?t=' + (new Date().getTime())).then(function (response) {
                    _this.countries = response.data.data;
                });
            },

            getCountryByCode: function (code) {

                for (var i = 0; i < this.countries.length; i++) {
                    var el = this.countries[i];
                    if (el.code === code) {
                        return el.name;
                    }
                }

                return '';
            },

            getCountryFilterByCode: function (code, countries) {

                for (var i = 0; i < countries.length; i++) {
                    var el = countries[i];

                    if (el.halalbooking_code === code) {
                        return el.name;
                    }
                }

                return '';
            },

            loadFilters: function (cb) {

                var _this = this;
                axios.get('/service/halal-booking/filters').then(function (response) {
                    _this.filters = response.data.data;

                    _this.filters.forEach(function (item) {
                        _this.filter[item.code] = [];
                    });

                    if (typeof cb === 'function') {
                        cb();
                    }
                });
            },

            localeCountry: function (record) {

                var str = record.name;

                switch (Marti.Member.language) {
                    case 'tr':
                        str = record.name_tr;
                        break;

                    case 'en' :
                        str = record.name;
                        break;

                    default :
                        str = record.name_de;
                }

                return str;
            }


        },

        watch: {

            /* Çocukların yaşları değiştiğinde, percent ayarlaması */
            'filter.children': {
                handler: function () {
                    var min = 0;
                    var max = 17;
                    for (var i = 0; i < this.filter.children.length; i++) {
                        this.filter.children[i].percent = (100 / (max - min) * this.filter.children[i].jahre) - (100 / (max - min) * min);
                    }
                }, deep: true,
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

            // 'filter': {
            //     handler: function () {
            //         var min = 0;
            //         var max = 12;
            //         for (var i = 0; i < this.filter.children.length; i++) {
            //             this.filter.children[i].percent = (100 / (max - min) * this.filter.children[i].jahre) - (100 / (max - min) * min);
            //         }
            //     }, deep: true
            // },


        },

        computed: {

            filterActive: function () {

                var isActive = this.filter.star > 0 ||
                        this.filter.reviewRate > 0 ||
                        this.filter.room > 0 ||
                        this.filter.pansion > 0;

                return false;
            },
            filter_count: function () {

                let filters = ['property_types', 'meal_plans', 'locations', 'stars', 'scores', 'feature_group_1', 'feature_group_2', 'feature_group_3'];
                let el = 0;
                for (let i = 0; i < filters.length; i++) {
                    el += this.filter[filters[i]].length;
                }
                return el;
            }
        },

        created: function () {

            this.translate = Marti.Locale.all();
            this.mobile.isMobile = window.isMobile();

            var _this = this;

            /*   axios.get('/service/states/favourites').then(function (response) {
             _this.destinations.favourites = response.data.data;
             });  */

            if (typeof window.Marti.filter != 'undefined') {
                var page = window.Marti.filter.params;
                delete window.Marti.filter.params;
                this.filter = window.Marti.filter;
                this.reset();
            }

            switch (page) {

                case 'halal-booking/hotels' :

                    axios.get('/service/countries/get-defaults').then(function (response) {
                        _this.defaults.countries = response.data.data;
                        _this.defaults.active_state = '';

                    });
                    this.loadFilters();
                    this.loadHotels();

                    this.step = 2;
                    break;

                case 'halal-booking/hotel-offers' :

                    this.loadHotel(this.filter.destination.code);
                    if (!this.filter.sort || this.filter.sort == '') {
                        this.filter.sort = 'PRICE';
                    }
                    //  this.loadHotelOffers();
                    this.step = 3;
                    break;

                case 'halal-booking/hotel-booking' :

                    var _this = this;

                    this.loadHotel(window.Marti.filter.gid, false, function () {

                        var bookingObj = null;

                        for (var i = 0; i < _this.results['offers'].length; i++) {
                            for (var j = 0; j < _this.results['offers'][i]['offers'].length; j++) {
                                var el = _this.results['offers'][i]['offers'][j];
                                if (el.rate_plan.id == _this.filter.rate_plan_id && el.room.id == _this.filter.room_id) {
                                    bookingObj = {
                                        data: el,
                                        groups: _this.results['offers'][i].group
                                    };
                                    _this.bookingForm.rate_plan_id = el.rate_plan.id;
                                    _this.bookingForm.room_id = el.room.id;
                                }
                            }
                        }

                        if (bookingObj === null) {
                            swal(Marti.Locale.get('warning'), 'Offer Error');
                            setTimeout(function () {
                                location.href = '/';
                            }, 2000);
                            return false;
                        }

                        var groups = bookingObj.groups.split(',');
                        var childrens = groups.slice(1);

                        _this.booking = {
                            'children': childrens,
                            'traveller': groups[0],
                            'price': bookingObj.data.price,
                            'data': bookingObj.data

                        };

                        _this.getBookingParams();
                    });


                    this.loadCountries();
                    this.step = 4;
                    break;

                default :
                    break;
            }


        },

        updated: function () {
            $('.input input,.input select').on('change', function () {
                var id = $(this).attr('id');
                $('#' + id + '_message').hide();
            });
        },

        components: {
            VueSlider: window['vue-slider-component'],
            HotelLoader: window.contentLoaders.HotelLoader,
            HotelOfferLoader: window.contentLoaders.HotelOfferLoader,
        }
    });
}