
window.addEventListener("load", function (event) {
    
    Vue.use(VueLazyload, {
        loading: '/themes/web/martireisen/assets/img/image-loader.svg',
    });

    var BestHotels = new Vue({
        el: '#top-hotels',
        data: {
            activeIndex: 0,
            loading: false,
            results: {
            },
        },
        methods: {
        },
        mounted: function () {
            //console.log('_test');
        },
        updated: function () {

            for (var i = 0; i < this.results.length; i++) {
                new Swiper('#top-swiper-' + i, {
                    slidesPerView: 3,
                    spaceBetween: 20,
                    loop: false,
                    autoplay: {
                        delay: 6000,
                        disableOnInteraction: false
                    },
                    breakpoints: {
                        // when window width is <= X px
                        991: {
                            slidesPerGroup: 2,
                            slidesPerView: 2
                        },
                        575: {
                            slidesPerGroup: 1,
                            slidesPerView: 1
                        }
                    }
                });
            }
        },
        created: function () {

            var _this = this;
            _this.loading = true;

            axios.get('/service/block/get-week-blocks?l=' + Marti.Member.language).then(function (response) {
                _this.results = response.data.data;
                _this.loading = false;
            });

        },
    });

    var BestRegions = new Vue({
        el: '#best-hotels',
        data: {
            activeIndex: 0,
            loading: false,
            results: {
            },
            favouriteResults: {

            },
        },
        methods: {
            bestFiveFav: function () {
                return this.favouriteResults.length > 5 ? this.favouriteResults.slice(0, 5) : this.favouriteResults;
            },

            bestFiveReg: function () {
                return this.results.length > 5 ? this.results.slice(0, 5) : this.results;
            }

        },
        created: function () {
            var _this = this;
            _this.loading = true;
            axios.get('/service/block/get-top-regions').then(function (response) {
                _this.results = response.data.data;
                _this.loading = false;

            });

            axios.get('/service/block/get-favourites').then(function (response) {
                _this.favouriteResults = response.data.data;
            });

        },

    });
});
