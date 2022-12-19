
window.addEventListener("load", function (event) {
    bindRegion();
});

function bindRegion() {

    window.RegionApp = new Vue({

        el: '#region-app',
        data: {
            filter_destination_focused:false,
            Marti : null,
            mobile : {
                isMobile:  false,
            },
            member  : Marti.Member || {},
            results : [],
            loading : false,
            step : 2,
            
            filter_counter: 0,
            is_filter_render : true,
            filterActive : true,
             destinations: {
                locations: [],
                regions : [],
                countries : [],
                hotels: [],
                favourites: [],
                populars: [],
                clicked: true
            },
            filter :{
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
                //    room : 0,
                //   pansion : 0,
                //  seaview : 0,
                // transfer :0,
            },
            sortLocal: {
                column: '',
                direction: 'asc'
            },
        },
        
        methods: {
            
            /* special */
            sortRegions: function (column) {

                if (this.sortLocal.column === column) {
                    this.sortLocal.direction = this.sortLocal.direction == 'desc' ? 'asc' : 'desc';
                }

                this.sortLocal.column = column;
                this.results.data.sort((a, b) => ((this.sortLocal.direction == 'asc' ? (a.avg[column] > b.avg[column]) : (a.avg[column] < b.avg[column])) ? 1 : -1));

                for (var i = 0; i < this.results.data.length; i++) {
                    if (Array.isArray(this.results.data[i].children) == false) {
                        continue;
                    }
                    var sorted = this.results.data[i].children.slice(0).sort((a, b) => ((this.sortLocal.direction == 'asc' ? (a[column] > b[column]) : (a[column] < b[column])) ? 1 : -1));
                    var k = this.results.data[i];
                    k['children'] = sorted;
                    Vue.set(RegionApp.results.data, i, k);

                }

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
                    
                    /*
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
                    Marti.Tools.collapse(0);*/
                });

            },
            
        
            search_offers: function (type, data, veranst) {

                if (typeof type !== 'undefined' && typeof data != 'undefined') {
                    this.filter.destination.type = type;
                    this.filter.destination.code = data.code;
                    this.filter.destination.name = data.name;
                }
              
                var url = '/search/hotels?' + jQuery.param(this.filter);
                if (typeof veranst != 'undefined') {
                    url += '&vc=' + veranst;
                }

                location.href = url;
                return false;

            },
            
            /* end special */
            filterRender: function () {
                this.is_filter_render = false;
                this.is_filter_render = true
            },
            
            filterDesktopChange: function () {
                this.filterRender();
                if (!this.mobile.isMobile) {
                  //  this.loadHotels();
                }
            },
            isSelectedAttribute: function (type) {
                var index = this.filter.attributes.indexOf(type);
                return index > -1;
            },
            star: function (index) {
                this.filter.star = index;
                this.filterDesktopChange()
            },

            review: function (rate) {
                this.filter.reviewRate = rate;
                this.filterDesktopChange()
            },
            
            /* tools */
            toHour(time){
                
                if(!time) {
                    return '-';
                }
                
                let hour = time / 60;
                hour     = Math.floor(hour);
                let min  = time - (hour*60);
                
                return hour  +'h '+min+' m';
            }
        },

        created() {
            this.Marti = Marti;

            if(Marti.page != 'region-results') {
                return false;
            }
            
            this.filter = Marti.filter;
            this.loadRegions();
            
            this.translate = Marti.Locale.all();
            this.mobile.isMobile = window.isMobile();

        }
    });
}