window.addEventListener("load", function (event) {

     window.OtelPage = new Vue({

        el: '#hotel-app',
        data: {

            Marti: null ,
            loading: false,
            loader: {
                bookingCreate: false,
                bookingCheck: true,
                offers: false,
            },
            translate: [],
            limit: 25,
            offer : {
                pauschal : {},
                hotel : {}
            },
            hotelData : { images: []},
            filter: {

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
            },

            departures: {
                results: [],
                clicked: true,
                query: '',

            },
            hotel : {},
            member: Marti.Member || {},
        },

        methods: {
            
            makeUrl : function(sf){
                
                let filter = this.filter;
                filter['sf'] = sf;
                
                if(filter['sf'] == 2 && !this.offer.pauschal.code) {
                    return false;
                }
                if(filter['sf'] == 3 && !this.offer.hotel.code) {
                    return false;
                }
                delete filter['limit'];
                delete filter['flight'];
                let url = '/search/hotel-offers?'+jQuery.param(filter);
                window.open(url);
                
            },
            
            loadHotelOffers: function () {

                var _this = this;
                this.loader.offers = true;

                var filter = {
                    destination : {
                        type : 'hotel',
                        code : window.HOTEL_ID
                    },
                    sf : 2,
                    limit : 5,
                }
              
                console.log(filter);
                axios.post('/service/engine/offer/get',filter).then(function (response) {
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        return false;
                    }

                    var result = response.data.data.response;

                    if (typeof result.offerList == 'undefined') {
                        swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        _this.loader.offers = false;
                        return;
                    }
                    
                    if(result.offerList.length == 0){
                        _this.offer.pauschal['error'] = true;
                        return ;
                    }
                    
                    _this.offer.pauschal = result.offerList[0];
                    _this.loader.offers = false;

                });
            },
            
            loadHotelOffersHotel: function () {

                var _this = this;
                this.loader.offers = true;
                
                var filter = {
                    destination : {
                        type : 'hotel',
                        code : window.HOTEL_ID
                    },
                    sf : 3,
                    limit : 5,
                }

                
                axios.post('/service/engine/offer/get',filter).then(function (response) {
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        return false;
                    }

                    var result = response.data.data.response;

                    if (typeof result.offerList == 'undefined') {
                        swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        _this.moreBtn = false;
                        _this.loader.offers = false;
                        return;
                    }
                    
                    if(result.offerList.length == 0){
                        _this.offer.hotel['error'] = true;
                        return ;
                    }
                    
                    _this.loader.offers = false;
                    _this.offer.hotel = result.offerList[0];

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
                            title: images[i].name
                        };
                        container.push(item);
                    }
                }

                var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                gallery.init();
            },
            
            init(){
                
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
                    slidesPerView: 5,
                    touchRatio: 0.5,
                    slideToClickedSlide: true,
                });

                hotelinfoSlider.controller.control = hotelinfoSliderThumbnails;
                hotelinfoSliderThumbnails.controller.control = hotelinfoSlider;

                if (typeof window.loadHotelCallback == 'function') {
                    window.loadHotelCallback();
                }

                var myLatLng = LatLng;

                setTimeout(function () {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10,
                        center: myLatLng,
                        fullscreenControl: false,
                    });

                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: ''
                    });
                }, 500);
                
                
                $('#review iframe').attr('src',$('#review iframe').attr('data-src'));
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
            this.filter = window.Marti.filter;
            this.init();
            this.loadHotelOffers();
            this.loadHotelOffersHotel();
                       
        },

        updated: function () {

        },

        components: {
            HotelLoader: window.contentLoaders.HotelLoader,

        }
    });
    
    
    window.ReviewPage = new Vue({

        el: '#review-app',
        data: {
            reviews : [],
        },
        methods : {
            
            loadReviews: function () {

                var _this = this;
               
                axios.get('/service/engine/hotel/reviews/'+window.HOTEL_ID).then(function (response) {
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        return false;
                    }

                    var result = response.data.data.response.hotelReviewList;
                    _this.reviews = result;

                });
            },
            
        },
        
        created(){
           // this.loadReviews();
        }
    });
    
    window.WeatherApp = new Vue({

        el: '#weather-app',
        data: {
            weatherData : {},
        },
        methods : {
            
             loadWeather : function () {

                var _this = this;
              
                axios.get('/service/hotels/get-weather/'+LatLng.lat+'/'+LatLng.lng).then(function (response) {
                    if (response.data.status == false) {
                        swal(Marti.Locale.get('warning'), Marti.Locale.get('offer.no_result'), 'warning');
                        return false;
                    }
                    
                    _this.weatherData = response.data.data;

                });
            },
            
        },
        
        created(){
            this.loadWeather();
        }
    });
});