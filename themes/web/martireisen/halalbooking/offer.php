<div id="app" v-cloak>
    
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <?php _lang('menu.halalbooking')?>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('search.results')?></span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="summary" data-toggle="mobile-nav" data-href="#mobile-filter">
        <div class="container">
            <div class="summary-title"><strong>{{filter.destination.name}}</strong></div>
            <div class="summary-text">{{filter.adults}} <?php _lang('search.adult')?>,  {{filter.children.length }} <?php _lang('search.children')?></div>
            <div class="summary-text">{{ Marti.Tools.frontEndDateFormat(filter.date.start) }} - {{ Marti.Tools.frontEndDateFormat(filter.date.end) }}</div>
            <div class="summary-icon">
                <i class="icon icon-summary-pencil"></i>
            </div>
        </div>
    </div>

    <div id="filters-button" data-toggle="modal" data-target="#modalFilters">
        <div class="container">
            <div class="filters-button">
                <div class="filters-button-left">
                    <div class="filters-button-title"><?php _lang('search.filter.button')?></div>
                    <div class="filters-button-text"><?php _lang('search.filter.change')?></div>
                </div>
                <div class="filters-button-right">
                    <div class="filters-button-icon">
                        <i class="icon icon-filter-buttons"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="filter-buttons filter-sticky">
        <div>
            <a class="btn btn-warning  btn-rounded btn-xs" data-toggle="modal" data-target="#modalFilters"><i
                        class="fa fa-filter mr-2"></i><?php _lang('search.filter.button') ?> <span >({{filter_count}})</span></a>
        </div>
        <div>
            <div class="btn-group w-100">
                <button type="button" class="btn btn-warning  btn-rounded  btn-rounded btn-xs dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    {{filter.sort == null?'<?php _lang('search.sort.by') ?>':''}}
                    {{filter.sort == 'price-asc'?'<?php _lang('search.sort.price_asc') ?>':''}}
                    {{filter.sort == 'price-desc'?'<?php _lang('search.sort.price_desc') ?>':''}}
                    {{filter.sort == 'stars-asc'?'<?php _lang('search.sort.star_asc') ?>':''}}
                    {{filter.sort == 'stars-desc'?'<?php _lang('search.sort.star_desc') ?>':''}}
                    {{filter.sort == 'score-asc'?'<?php _lang('search.sort.score_asc') ?>':''}}
                    {{filter.sort == 'score-desc'?'<?php _lang('search.sort.score_desc') ?>':''}}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item" v-on:click="filterSortChange('price-asc')">  <?php _lang('search.sort.price_asc') ?></button>
                    <button class="dropdown-item" v-on:click="filterSortChange('price-desc')">  <?php _lang('search.sort.price_desc') ?></button>
                    <button class="dropdown-item" v-on:click="filterSortChange('stars-asc')">  <?php _lang('search.sort.star_asc') ?></button>
                    <button class="dropdown-item" v-on:click="filterSortChange('stars-desc')">  <?php _lang('search.sort.star_desc') ?></button>
                    <button class="dropdown-item" v-on:click="filterSortChange('score-asc')">  <?php _lang('search.sort.score_asc') ?></button>
                    <button class="dropdown-item" v-on:click="filterSortChange('score-desc')">  <?php _lang('search.sort.score_desc') ?></button>
                </div>
            </div>
        </div>
    </div>

   
    <?php // $this->render('layouts/search-bar')?>
    <?php $this->render('layouts/search-steps')?>

    <div id="results">
        <div class="container">
            <div class="results  halal-booking-results">
                <?php $this->render('halalbooking/offer-left')?>
                <div class="results-right col-12 col-md-8">
                    <div class="results-title hidden-xs hidden-xxs">
                        <div class="results-title-left">
                            <h4 class="results-title-text"><?php _lang('hotels.results_title')?> <?php echo $this->region_name?> </h4>
                            <p class="results-title-description">
                                <?php _lang('hotels.results_text')?>
                            </p>
                        </div>
                        <div class="results-title-right  d-none d-lg-inline-block">
                            <div class="selectbox selectbox-results " data-selectbox="root">
                                <div class="selectbox-results-select">
                                    <select v-model="filter.sort" v-on:change="sortHotels" data-selectbox="select" >
                                        <option value="price-asc"><?php _lang('search.sort.price_asc')?></option>
                                        <option value="price-desc" ><?php _lang('search.sort.price_desc')?></option>
                                        <option value="stars-asc"><?php _lang('search.sort.star_asc')?></option>
                                        <option value="stars-desc" ><?php _lang('search.sort.star_desc')?></option>
                                        <option value="score-asc"><?php _lang('search.sort.score_asc')?></option>
                                        <option value="score-desc" ><?php _lang('search.sort.score_desc')?></option>
                                    </select>
                                </div>
                                <div class="selectbox-results-button">
                                    <button class="button" type="button">
                                    <span class="selectbox-results-button-text">
                                        <span class="selectbox-results-button-text-title"><?php _lang('search.sort.by')?></span>
                                        <span class="selectbox-results-button-text-value" data-selectbox="text"></span>
                                    </span>
                                        <span class="selectbox-results-button-icon"><i class="icon icon-selectbox-caret"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="results-list">
                        <?php $this->render('halalbooking/offer-results')?>
                    </div>
                    <div class="lds-css ng-scope" v-show='loading' >
                        <div class="lds-dual-ring"></div>
                    </div>
                    <div class="results-button"  v-show="results.offers && results.total_results >= limit && moreBtn == true ">
                        <a  class="button " v-on:click="showMore('hotel')" title="Show More Results"><span><?php _lang('offer.show_more')?></span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        


        <!-- İmage Modal-->
        <div class="modal fade" id="imageModal"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg mt-5">
                <div class="modal-content">
                    <div class="modal-close registered">
                        <i class="icon icon-modal-close"></i>
                    </div>
                    <div class="modal-body">
                        <!-- Slider main container -->
                        <div class="swiper-container gallery-top" v-if="hotel && hotel.id > 0">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <div v-for="picture in hotel.photos" class="swiper-slide" v-bind:style="{ 'background-image': 'url(' + picture + ')' }"></div>
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination">
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                            <!-- If we need scrollbar -->
                            <div class="swiper-scrollbar"></div>
                        </div>
                        <div class="swiper-container gallery-thumbs" v-if="hotel">
                            <div class="swiper-wrapper">
                                <div v-for="picture in hotel.photos" class="swiper-slide" v-bind:style="{ 'background-image': 'url(' + picture + ')' }"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!-- Map Modal-->
        <div class="modal fade" id="mapModal"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-close registered">
                        <i class="icon icon-modal-close"></i>
                    </div>
                    <div class="modal-body">
                        <div id="map" ></div>
                        <div class="infobox">
                            <div class="row" v-if="hotel">
                                <div class="col--4 col-lg-5">
                                    <img v-bind:src="hotel.photo"/>
                                </div>
                                <div class="col--8 col-lg-7">
                                    {{hotel.name}}
                                    <div class="map-stars">
                                        <i class="icon icon-results-star" v-for="index in hotel.star"></i>
                                    </div>
                                    <div class="map-review">
                                        <img src="<?php theme_dir()?>assets/img/holiday.check.svg" alt="Holiday Check"/>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <!-- Review Modal-->
        <div class="modal fade" id="reviewModal"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-close registered">
                        <i class="icon icon-modal-close"></i>
                    </div>
                    <div class="modal-body  mt-5">
                        <div class="infobox iframe-area">
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--filter-Modal-->
    <div class="modal fade modal-right" id="modalFilters" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close" data-dismiss="modal">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="modal-main">
                    <?php $this->render('halalbooking/offer-left') ?>
                </div>
            </div>
        </div>
    </div>
    <!--filter-Modal-->


</div>