<div id="app" v-cloak>

    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <a v-show="this.filter.sf == 2" href=""
                           title="<?php _lang('search.last_minute') ?>"><?php _lang('search.last_minute') ?></a>
                        <a v-show="this.filter.sf == 3" href=""
                           title="<?php _lang('search.only_hotel') ?>"><?php _lang('search.only_hotel') ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('search.results') ?></span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="summary" data-toggle="mobile-nav" data-href="#mobile-filter">
        <div class="container">
            <div class="summary-title"><strong>{{filter.destination.name}}</strong></div>
            <div class="summary-text">{{filter.adults}} <?php _lang('search.adult') ?>,
                {{filter.children.length}} <?php _lang('search.children') ?></div>
            <div class="summary-text">{{Marti.Tools.frontEndDateFormat(filter.date.start)}} -
                {{Marti.Tools.frontEndDateFormat(filter.date.end)}}
            </div>
            <div class="summary-icon">
                <i class="icon icon-summary-pencil"></i>
            </div>
        </div>
    </div>

    <div class="filter-buttons filter-sticky">
        <div>
            <a class="btn btn-warning  btn-rounded btn-xs" data-toggle="modal" data-target="#modalFilters"><i
                    class="fa fa-filter mr-2"></i><?php _lang('search.filter.button') ?> <span >({{filter_counter}})</span></a>
        </div>
        <div>
            <div class="btn-group w-100">
                <button type="button" class="btn btn-warning  btn-rounded  btn-rounded btn-xs dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    {{filter.sort == null?'<?php _lang('search.sort.by') ?>':''}}
                    {{filter.sort==='PRICE'?'<?php _lang('search.sort.price_asc') ?>':''}}
                    {{filter.sort==='PRICE_ZA'?'<?php _lang('search.sort.price_desc') ?>':''}}
                    {{filter.sort==='TOP'?'<?php _lang('search.sort.top') ?>':''}}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item"
                            v-on:click="filterSortChange('PRICE')">  <?php _lang('search.sort.price_asc') ?></button>
                    <button class="dropdown-item"
                            v-on:click="filterSortChange('PRICE_ZA')">  <?php _lang('search.sort.price_desc') ?></button>
                    <button class="dropdown-item"
                            v-on:click="filterSortChange('TOP')">  <?php _lang('search.sort.top') ?></button>
                </div>
            </div>
        </div>
    </div>


    <div id="filters-button" data-toggle="modal" data-target="#modalFilters">
        <div class="container">
            <div class="filters-button">
                <div class="filters-button-left">
                    <div class="filters-button-title"><?php _lang('search.filter.button') ?></div>
                    <div class="filters-button-text"><?php _lang('search.filter.change') ?></div>
                </div>
                <div class="filters-button-right">
                    <div class="filters-button-icon">
                        <i class="icon icon-filter-buttons"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->render('layouts/search-bar') ?>
    <?php $this->render('layouts/search-steps') ?>

    <div id="results">
        <div class="container">
            <div class="results booking-results">
                <div v-if="!mobile.isMobile">
                <?php $this->render('layouts/search-left') ?>
                </div>
                <div class="results-right col-12 col-md-8">
                
                    <div class="results-title hidden-xs hidden-xxs">
                        <div class="results-title-left">
                            <h1 class="results-title-text"><?php _lang('hotels.results_title') ?>
                                {{filter.destination.name}} </h1>
                            <p class="results-title-description">
                                <?php _lang('hotels.results_text') ?>
                            </p>
                        </div>
                        <div class="results-title-right d-none d-lg-inline-block">
                            <div class="selectbox selectbox-results" data-selectbox="root">
                                <div class="selectbox-results-select">
                                    <select v-model="filter.sort" v-on:change="sortHotels" data-selectbox="select">
                                        <option value="PRICE"><?php _lang('search.sort.price_asc') ?></option>
                                        <option value="PRICE_ZA"><?php _lang('search.sort.price_desc') ?></option>
                                        <option value="TOP"><?php _lang('search.sort.top') ?></option>
                                    </select>
                                </div>
                                <div class="selectbox-results-button">
                                    <button class="button" type="button">
                                    <span class="selectbox-results-button-text">
                                        <span class="selectbox-results-button-text-title"><?php _lang('search.sort.by') ?></span>
                                        <span class="selectbox-results-button-text-value" data-selectbox="text"></span>
                                    </span>
                                        <span class="selectbox-results-button-icon"><i
                                                    class="icon icon-selectbox-caret"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="results-list">
                        <div class="alert alert-danger" role="alert" v-if="results.totalResultCount == 0">
                            <?php _lang('search.no_result')?>
                        </div>
                        <div v-if="is_duration_changed == true">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                   <i class="fa fa-calendar-times mr-2"></i><?php _lang('search.duration_error')?>

                                </div>
                                
                            </div>
                        </div>
                        <?php $this->render('search/hotel-results') ?>
                    </div>
                    <div class="lds-css ng-scope" v-show='loading'>
                        <div class="lds-dual-ring"></div>
                    </div>
                    <div class="results-button"
                         v-show="results.hotelList && results.totalResultCount >= limit && moreBtn == true ">
                        <a class="button " v-on:click="showMore('hotel')"
                           title="Show More Results"><span><?php _lang('offer.show_more') ?></span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->

        <!--filter-Modal-->
        <div class="modal fade modal-right" id="modalFilters" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-close" data-dismiss="modal">
                        <i class="icon icon-modal-close"></i>
                    </div>

                    <div class="modal-main">
                        <?php $this->render('layouts/search-left') ?>
                    </div>
                </div>
            </div>
        </div>
        <!--filter-Modal-->

        <?php $this->render('search/modals') ?>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoaWZ5rdu9j4gWtMs0dFGMhuTJQarcQnU"></script>
