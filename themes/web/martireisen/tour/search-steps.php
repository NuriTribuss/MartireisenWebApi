<div id="search" class="pt-5 pb-5 p-md-5">
    <div class="container" id="tour-search">
        <div id="mobile-filter">
            <div class="mobile-container">
                <div class="search-tab-content mb-md-4">
                    <form action="/tour/search" method="GET">
                        <div class="search-tab-content-item active">
                            <div data-scroll-focus="root" class="search-box">
                                <div class="col-lg-3 p-0 ">
                                    <div data-esc="true" class="search-box-item left">
                                        <div class="search-box-item-button absearch">
                                            <div type="button" data-scroll-focus="true" class="button">
                                            <span class="search-box-item-button-icon">
                                                <i class="icon icon-search-arrival"></i>
                                            </span>
                                                <span class="search-box-item-button-text w-100">
                                                <select v-model="filter.station" name="station"
                                                        class="form-control w-100 border-0">
                                                    <option value='0'> <?php _lang('tour.station_select') ?></option>
                                                    <option v-for="station in stations">{{station}}</option> 
                                                </select>
                                            </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 p-0 ">
                                    <div data-esc="true" class="search-box-item left">
                                        <div class="search-box-item-button absearch">
                                            <div type="button" data-scroll-focus="true" class="button">
                                            <span class="search-box-item-button-icon">
                                                <i class="icon icon-search-arrival"></i>
                                            </span>
                                                <span class="search-box-item-button-text w-100">
                                                <select v-model="filter.destination" name="destination"
                                                        class="form-control w-100 border-0">
                                                    <option value='0'> <?php _lang('tour.rotate_and_city_select') ?></option>
                                                    <option v-for="target in targets">{{target}}</option> 
                                                </select>
                                            </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4  p-0 p-lg-2">
                                    <div data-esc="true" class="search-box-item left">
                                        <div class="search-box-item-button absearch">
                                            <div type="button" data-scroll-focus="true" class="button">
                                            <span class="search-box-item-button-icon">
                                                <i class="icon icon-search-arrival"></i>
                                            </span>
                                                <span class="search-box-item-button-text w-100">
                                                <select v-model="filter.start_date" name="start_date"
                                                        class="form-control w-100 border-0">
                                                    <option value='0'> <?php _lang('tour.date_select') ?></option>
                                                    <option v-for="period in periods">{{period}}</option> 
                                                </select>
                                            </span>
                                            </div>
                                        </div>

                                    </div>
                                  
                                </div>
                                <div class="search-box-col search-box-button-d mt-2 mt-lg-0">
                                    <div class="search-box-button">
                                        <button type="submit"
                                                class="button"> <?php _lang('tour.search_offers') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container">
    <!--
    <div id="steps d-none">
        <div class="container">
            <div class="steps">
                <a id="step-1" class="steps-item <?php echo $this->step >= 1 ? 'active' : '' ?>" href="" title="Steps">
                    <div class="steps-item-number">1</div>
                    <div class="steps-item-text"><span><?php _lang('tour.tour_list') ?></span></div>
                </a>
                <a id="step-2" class="steps-item <?php echo $this->step >= 2 ? 'active' : '' ?>" href="" title="Steps">
                    <div class="steps-item-number">2</div>
                    <div class="steps-item-text"><span><?php _lang('tour.tour_view') ?></span></div>

                </a>
                <a id="step-3" class="steps-item <?php echo $this->step >= 3 ? 'active' : '' ?>" href="" title="Steps">
                    <div class="steps-item-number">3</div>
                    <div class="steps-item-text"><span><?php _lang('tour.reservation') ?></span></div>

                </a>
                <a id="step-4" class="steps-item <?php echo $this->step >= 4 ? 'active' : '' ?>" href="" title="Steps">
                    <div class="steps-item-number">4</div>
                    <div class="steps-item-text"><span><?php _lang('tour.confirmation_page') ?> </span></div>

                </a>
            </div>
        </div>
    </div>-->
</div>
<script>
window.addEventListener("load", function (event) {

    var TourSearch = new Vue({

        el: '#tour-search',
        data: {
            booking: {},
            targets: [],
            periods: [],
            stations :[],
            query: '',
            filter: {
                destination: '0',
                start_date: '0',
                station : '0',
            }
        },
        methods: {},

        created: function () {

            var _this = this;
            axios.get('/service/tours/states').then(function (response) {
                _this.targets = response.data.data;
            });
            axios.get('/service/tours/periods').then(function (response) {
                _this.periods = response.data.data;
            });
            axios.get('/service/tours/stations').then(function (response) {
                _this.stations = response.data.data;
            });

            var url = new URL(window.location.href);

            var c = url.searchParams.get("destination");
            if (c != null && c != '') {
                this.filter.destination = c;
            } else {
                this.filter.destination = '0';
            }
            var c = url.searchParams.get("station");
            if (c != null && c != '') {
                this.filter.station = c;
            } else {
                this.filter.station = '0';
            }
            
            var c = url.searchParams.get("start_date");
            if (c != null && c != '') {
                this.filter.start_date = c;
            }

        }
    });
});

</script>
