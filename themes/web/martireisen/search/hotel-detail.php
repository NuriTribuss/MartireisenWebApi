 
<style>
[v-cloak] + #loader::before {
   display: block;
}
.operator-box:hover{
    cursor : pointer;
}
</style>
<div id="app" v-cloak>

    <div id="breadcrumb" class="bg-white">
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

    <div id="summary" class="mb-2" data-toggle="mobile-nav" data-href="#mobile-filter">
        <div class="container">
            <div class="summary-title pt-1"><strong>{{filter.destination.name}}</strong></div>
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

    <div class="filter-buttons filter-sticky hotel-detail" style="display: none">
        <div>
            <a class="btn btn-warning  btn-rounded btn-xs" data-toggle="modal" data-target="#modalFilters"><i
                    class="fa fa-filter mr-2"></i><?php _lang('search.filter.button') ?> </a>
        </div>
        <div>
            <div class="btn-group w-100">
                <button type="button" class="btn btn-warning  btn-rounded btn-xs dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    {{filter.sort == null?'<?php _lang('search.sort.by') ?>':''}}
                    {{filter.sort==='PRICE'?'<?php _lang('search.sort.price_asc') ?>':''}}
                    {{filter.sort==='PRICE_ZA'?'<?php _lang('search.sort.price_desc') ?>':''}}
                    {{filter.sort==='DATE'?'<?php _lang('search.sort.date_asc') ?>':''}}
                    {{filter.sort==='AIRPORT'?'<?php _lang('search.sort.departure_asc') ?>':''}}
                    {{filter.sort==='DURATION'?'<?php _lang('search.sort.duration_asc') ?>':''}}

                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item"
                            v-on:click="filterSortOfferChange('PRICE')">  <?php _lang('search.sort.price_asc') ?></button>
                    <button class="dropdown-item"
                            v-on:click="filterSortOfferChange('PRICE_ZA')">  <?php _lang('search.sort.price_desc') ?></button>
                    <button class="dropdown-item"
                            v-on:click="filterSortOfferChange('DATE')">  <?php _lang('search.sort.date_asc') ?></button>
                    <button class="dropdown-item"
                            v-on:click="filterSortOfferChange('AIRPORT')">  <?php _lang('search.sort.departure_asc') ?></button>
                    <button class="dropdown-item"
                            v-on:click="filterSortOfferChange('DURATION')">  <?php _lang('search.sort.duration_asc') ?></button>

                </div>
            </div>
        </div>
    </div>

    <?php $this->render('layouts/search-bar') ?>
    <?php $this->render('layouts/search-steps') ?>

    <div id="results">
        <div class="container">
            <div class="results booking-results">
                <div class="results-left col-md-3 ">
                    <?php $this->render('layouts/search-hotel-left') ?>
                </div>
                <div class="results-right col-md-9">
                    <hotel-loader v-if='typeof hotel == "undefined"' :height="400" :width="870"
                                  :speed="2"></hotel-loader>
                    <div class="results-hotel-info row mb-3" v-if='typeof hotel != "undefined"'>
                        <div class="results-hotel-info-left col-12 col-md-7" v-if="hotel.catalogData">

                            <div class="results-hotel-info-slider" v-if="hotel.catalogData.imageList.length > 0 ">
                                <div id="hotelinfoSlider" class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide" v-for="picture in hotel.catalogData.imageList">
                                            <div class="results-hotel-info-thumbnail-slider-item">
                                                <a v-bind:data-caption="Marti" v-on:click="imageModal"
                                                   v-bind:src="picture">
                                                    <img v-bind:src="picture.replace('size=180','size=800')" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                            <div class="results-hotel-info-slider-meta" v-if="hotel.catalogData.imageList.length > 0">
                                <div class="results-hotel-info-slider-meta-left d-none">
                                    <a v-on:click="loadHotelImage(hotel)" class="results-hotel-info-slider-meta-link"
                                       title=""><i class="icon icon-hotel-info-photo"></i></a>
                                    <a class="results-hotel-info-slider-meta-link" href="" title=""><i
                                            class="icon icon-hotel-info-video"></i></a>
                                    <a class="results-hotel-info-slider-meta-link" href="" title=""><i
                                            class="icon icon-hotel-info-360"></i></a>
                                </div>
                                <div class="results-hotel-info-slider-meta-right">
                                    <div class="results-hotel-info-thumbnail-slider">
                                        <div id="hotelinfoSliderThumbnails" class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide" v-for="picture in hotel.catalogData.imageList ">
                                                    <div class="results-hotel-info-thumbnail-slider-item">
                                                        <img v-bind:src="picture.replace('size=180','size=800')" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="results-hotel-info-right col-12 col-md-5">
                            <div class="results-hotel-info-right-top" >
                                <h3 class="results-hotel-info-title">{{hotel.catalogData.hotel.name}}</h3>
                                <div class="results-hotel-info-description">
                                    <div class="results-hotel-info-description-stars" v-if="hotel.category > 0">
                                        <i class="icon icon-results-star" v-for='n in parseInt(hotel.category)'></i>
                                    </div>
                                    <div class="results-hotel-info-description-text">
                                        {{hotel.location.name}} {{hotel.location.region.name}}
                                    </div>

                                </div>
                                <div class="results-hotel-info-links"
                                     v-on:click="loadHotelMap(hotel.giata.hotelId,hotel.tourOperator.code)">
                                    <a class="results-hotel-info-links-item"><i
                                            class="icon icon-results-world"></i> <?php _lang('hotels.map'); ?></a>
                                </div>
                                <div class="results-hotel-info-money " v-if="results.offerList">
                                    <small>ab</small>{{Marti.getCurrency()}}{{ results.offerList.length > 0 ?
                                    Marti.Tools.numberWithThousandSep(results.offerList[0].personPrice.value) : '' }}
                                </div>
                                <a href="#" id="btn-check-offer" class="btn btn-block btn-primary mt-3 mb-2 btn-rounded d-none d-lg-block"
                                   v-on:click="hotelTab = 1">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <?php _lang('hotels.check_offers') ?>
                                </a>
                            </div>
                            <div class="results-hotel-info-right-bottom">
                                <div class="results-hotel-info-adventages mt-3" v-if="hotel.rating"
                                     v-on:click="openReview(hotel.reviews.id)">
                                    <div class="results-hotel-info-adventages-recommended">
                                        <div class="results-hotel-info-adventages-recommended-image">
                                            <img src="<?php theme_dir() ?>assets/img/holiday.check.svg"
                                                 alt="Holiday Check"/>
                                        </div>
                                        <div class="results-hotel-info-adventages-recommended-content">
                                            <p class="results-hotel-info-adventages-recommended-content-text"><span>{{results.suggests }}%</span> <?php _lang('hotels.suggestion') ?>
                                            </p>
                                            <p class="results-hotel-info-adventages-recommended-content-text"><span>{{results.review_count }}</span> <?php _lang('hotels.review') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="results-hotel-info-social mt-2 ">
                                    <a href="https://www.facebook.com/sharer.php?u=<?php echo rawurlencode(Helper\Input::getFullUrl()) ?>"
                                       target="_blank" class="mr-2"><i class="fab fa-facebook-f"></i></a>
                                    <a href="whatsapp://send?text=<?php echo rawurlencode(Helper\Input::getFullUrl()) ?>"
                                       data-action="share/whatsapp/share" href="" class="mr-2 d-block d-md-none"><i
                                            class="fab fa-whatsapp"></i></a>
                                    <a href="fb-messenger://share?link=<?php echo rawurlencode(Helper\Input::getFullUrl()) ?>"
                                       href="" class="mr-2 d-block d-md-none"><i class="fab fa-facebook-messenger"></i></a>
                                    <a href="mailto:?subject=<?php _lang('share_mail_title') ?>&amp;body=<?php _lang('share_mail_body') ?><?php echo rawurlencode(Helper\Input::getFullUrl()) ?>"
                                       class="mr-2"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="results-hotel-tab">
                        <div class="results-hotel-tab-buttons" data-slider-buttons="result-hotel-tab">
                            <button class="button" v-bind:class="{'active' : hotelTab == 1}" v-on:click="hotelTab = 1"
                                    type="button"><?php _lang('hotels.tab_1'); ?></button>
                            <button class="button d-none" v-bind:class="{'active' : hotelTab == 2}"
                                    v-on:click="hotelTab = 2" type="button"><?php _lang('hotels.tab_2'); ?></button>
                            <button class="button" v-bind:class="{'active' : hotelTab == 3}" v-on:click="hotelTab = 3"
                                    type="button"><?php _lang('hotels.tab_3'); ?></button>
                        </div>
                        <div class="results-hotel-tab-content">
                            <div class="" data-slider="result-hotel-tab">
                                <div class="" >
                                    <div class="" v-show="hotelTab == 1">
                                        <div class="lds-css ng-scope" v-show='loading'>
                                            <div class="lds-dual-ring"></div>
                                        </div>
                                        <div class="results-hotel-tab-content-prices" id="hotel-offers">
                                            <div class="results-hotel-tab-content-prices-header">
                                                <div class="results-hotel-tab-content-prices-header-left">

                                                    <a class="results-hotel-tab-content-prices-header-link"
                                                       style="display: none" href="" title="Link">
                                                        <i class="icon icon-statistics"></i>
                                                        <?php _lang('hotels.Sparkalender einblenden'); ?>
                                                    </a>
                                                </div>
                                                <div class="results-hotel-tab-content-prices-header-right d-none d-lg-inline-block">
                                                    <div id="filters-button" data-toggle="modal"
                                                         data-target="#modalFilters">
                                                        <div class="container">
                                                            <div class="filters-button">
                                                                <div class="filters-button-left">
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
                                                    <!--<div id="filters-button" data-toggle="modal" data-target="#modalFilters">
                                                                    <button class="button d-block d-md-none hidden-sm hidden-xs hidden-xxs" ><?php _lang('search.filter.change'); ?></button>
                                                    </div>-->
                                                    <div class="selectbox selectbox-default" data-selectbox="root">
                                                        <div class="selectbox-default-select ">
                                                            <select v-model="filter.sort" v-on:change="sortOffers"
                                                                    class="offerSort">
                                                                <option value="PRICE"><?php _lang('search.sort.price_asc') ?></option>
                                                                <option value="PRICE_ZA"><?php _lang('search.sort.price_desc') ?></option>
                                                                <option value="DATE"><?php _lang('search.sort.date_asc'); ?></option>
                                                                <!--<option value="ROOM"><?php _lang('search.sort.room_type_asc'); ?></option>
                                                                <option value="BOARD"><?php _lang('search.sort.board_type_asc'); ?></option>-->
                                                                <option value="AIRPORT"><?php _lang('search.sort.departure_asc'); ?></option>
                                                                <option value="DURATION"><?php _lang('search.sort.duration_asc'); ?></option>
                                                            </select>
                                                        </div>
                                                        <div class="selectbox-default-button">
                                                            <button class="button" type="button">
                                                                <span class="selectbox-default-button-text"><?php _lang('search.sort.by') ?></span>
                                                                <span class="selectbox-default-button-icon"><i
                                                                        class="icon icon-selectbox-caret"></i></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="results-hotel-tab-content-prices-main">

                                                <hotel-offer-loader v-if='loader.offers' :height="390" :width="845"  :speed="2"></hotel-offer-loader>
                                                <div class="mobile-result-list-wrapper mb-3"
                                                     v-if="results.offerList">

                                                    <div v-show="results.offerList.length == 0" class="alert alert-info overflow-auto">
                                                        <span class="float-left">
                                                            <?php _lang('offer.no_result') ?>
                                                        </span> 
                                                        <button class="btn btn-danger text-white btn-sm float-right" v-on:click="reset(); loadHotelOffers();">
                                                            <?php _lang('search.reset_filters') ?>
                                                        </button>
                                                    </div>
                                                    <div class="mobile-result-list">
                                                        <div class="mobile-result-list-item"
                                                             v-for="(offer,index) in results.offerList"
                                                             v-if="results.offerList.length > 0"
                                                             v-bind:class="[{selected : (selectedOffer && selectedOffer.code == offer.code && offer.book && offer.book.PAGE == 'book'  && offer.book.STATUS.STATUS > 0)}, 'js-mobile-result-list-item-' + index]">

                                                            <div class="mobile-result-list-item-content">
                                                                <div class="item-row">
                                                                    <div class="item-col-6 border-right">
                                                                        <div class="col-item mb-1">
                                                                            <i class="icon icon-prices-plane-h d-inline-block mr-2"></i>
                                                                            <strong> Di. {{ Marti.Tools.frontEndDateFormat(offer.travelDate.fromDate) }}</strong>
                                                                        </div>
                                                                        <div class="col-item" v-if="offer.flightOffer !=null" >
                                                                            <strong>{{offer.flightOffer.flight.departureAirport.name}}</strong> <span>({{offer.flightOffer.flight.departureAirport.code}})</span>
                                                                        </div>
                                                                        <div class="col-item" v-if="offer.flightOffer != null">
                                                                            <span></span>
                                                                        </div>

                                                                    </div>
                                                                    <div class="item-col-6">
                                                                        <div class="col-item mb-1">
                                                                            <i class="icon icon-prices-plane-h-down d-inline-block mr-2"></i>
                                                                            <strong> Di. {{ Marti.Tools.frontEndDateFormat(offer.travelDate.toDate)}}</strong>
                                                                        </div>
                                                                        <div class="col-item" v-if='offer.flightOffer != null'>
                                                                            <strong>  {{offer.flightOffer.flight.arrivalAirport.name}}</strong> <span>( {{offer.flightOffer.flight.arrivalAirport.code}})</span>
                                                                        </div>
                                                                        <div class="col-item">
                                                                            <span></span>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="item-row" v-if="!offer.book">
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <strong>  {{ offer.travelDate.duration}}  <?php _lang('common.days'); ?></li></strong>
                                                                        </div>
                                                                        <div class="col-item">
                                                                            <span>inki. Transfer vor Ort</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <strong> {{offer.hotelOffer.roomType.name}}</strong>
                                                                        </div>
                                                                        <div class="col-item">
                                                                            <span>{{offer.hotelOffer.boardType.name}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-row" v-if="!offer.book">
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <img width="50" v-bind:src="offer.tourOperator.png"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <strong> <?php _lang('offer.operators') ?> :</strong>
                                                                        </div>
                                                                        <div class="col-item">
                                                                            <a class='d-none' v-on:click="openOperator(offer.tourOperator.code, hotel.giata.hotelId)">
                                                                                <span><?php _lang('hotels.offer_info'); ?></span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-row" v-if="!offer.book">
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <span><?php _lang('hotels.offer_info_price') ?></span>
                                                                        </div>
                                                                        <div class="col-item">
                                                                            <strong class="result-price">
                                                                                {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(offer.personPrice.value)}} </strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-col-6">
                                                                        <button class="btn btn-primary btn-lg btn-rounded"
                                                                                type="button"
                                                                                v-on:click="checkBooking(offer,index)">
                                                                                    <?php _lang('hotels.offer_button'); ?>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-3">
                                                                <div class="alert alert-warning"  v-if="offer.book && (offer.book.statusCode == 'NK' || offer.book.statusCode == 'XX' || !offer.book.statusCode)" >
                                                                    <i class="fa fa-info-circle mr-2"></i><strong> <?php _lang('offer.not_available') ?></strong>
                                                                </div>
                                                            </div>
                                                            <div class="mobile-result-list-item-header" v-if="offer.book && offer.book.statusCode == 'OK' ">
                                                                <i class="fa fa-check mr-2"></i><strong> <?php _lang('offer.is_available') ?></strong>
                                                            </div>
                                                            
                                                            <div class="mobile-result-list-item-content detail d-block" v-if="offer.book && offer.book.statusCode == 'OK' ">
                                                                <div class="item-row" v-if='filter.sf == 2'>
                                                                    <div class="item-col-12">
                                                                        <div class="mb-1">
                                                                            <strong><?php _lang('offer.flight_info') ?></strong>
                                                                        </div>
                                                                        <div>
                                                                            <div class="flight-col-item">
                                                                                <div class="flight-col-item-header">
                                                                                    <strong><?php _lang('offer.flight_point') ?> {{ Marti.Tools.frontEndDateFormat(offer.travelDate.fromDate)}}</strong>
                                                                                </div>
                                                                                <div class="flight-col-item-content">

                                                                                    <div class="item-row" v-if="offer.book.commonOffer.flightOffer != null" v-for="flight in offer.book.commonOffer.flightOffer['flight']['outbound']['legList']" >
                                                                                        <div class="item-col-5 pb-0 pl-0">
                                                                                            <div class="col-item">
                                                                                                <span>
                                                                                                   {{flight.departureAirportCode}} - {{flight.departureAirportName}}
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-item">
                                                                                                <span class="font-weight-bold text-warning">
                                                                                                    {{flight.departureTime}}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="item-col-2 pb-0">
                                                                                            <i class="icon icon-prices-plane-h"></i>
                                                                                        </div>
                                                                                        <div class="item-col-5 pb-0 pl-0 text-right">
                                                                                            <div class="col-item">
                                                                                                <span>
                                                                                                  {{flight.arrivalAirportCode}} - {{flight.arrivalAirportName}}
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-item">
                                                                                                <span class="font-weight-bold text-warning">
                                                                                                   {{flight.arrivalTime}}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flight-col-item">
                                                                                <div class="flight-col-item-header">
                                                                                    <strong><?php _lang('offer.flight_return') ?> {{ Marti.Tools.frontEndDateFormat(offer.travelDate.toDate)}}</strong>
                                                                                </div>
                                                                                <div class="flight-col-item-content">
                                                                                    <div class="item-row" v-if="offer.book.commonOffer.flightOffer != null" v-for="flight in offer.book.commonOffer.flightOffer['flight']['inbound']['legList']" >
                                                                                        <div class="item-col-5 pb-0 pl-0">
                                                                                             <div class="col-item">
                                                                                                <span>
                                                                                                   {{flight.departureAirportCode}} - {{flight.departureAirportName}}
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-item">
                                                                                                <span class="font-weight-bold text-warning">
                                                                                                    {{flight.departureTime}}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="item-col-2 pb-0">
                                                                                            <i class="icon icon-prices-plane-h"></i>
                                                                                        </div>
                                                                                        <div class="item-col-5 pb-0 pl-0 text-right">
                                                                                            <div class="col-item">
                                                                                                <span>
                                                                                                  {{flight.arrivalAirportCode}} - {{flight.arrivalAirportName}}
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="col-item">
                                                                                                <span class="font-weight-bold text-warning">
                                                                                                   {{flight.arrivalTime}}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-row">
                                                                    <div class="item-col-12">
                                                                        <div class="item-row">
                                                                            <div class="item-col-12">
                                                                                <div class="col-item">
                                                                                    <strong><?php _lang('offer.services') ?></strong>
                                                                                </div>
                                                                                <div class="col-item">
                                                                                    <ul class="box-list">
                                                                                        <li>
                                                                                            <i class="fa fa-check mr-2"></i>
                                                                                            <span>{{offer.travelDate.duration}}  <?php _lang('offer.night') ?></span>
                                                                                        </li>
                                                                                        <li>
                                                                                            <i class="fa fa-check mr-2"></i>
                                                                                            <span>{{offer.hotelOffer.roomType.name}}</span>
                                                                                        </li>
                                                                                        <li>
                                                                                            <i class="fa fa-check mr-2"></i>
                                                                                            <span>{{offer.hotelOffer.boardType.name}}</span>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-row">
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <strong><?php _lang('offer.operators') ?></strong>
                                                                        </div>
                                                                        <div class="col-item">
                                                                           <img width="50" v-bind:src="offer.tourOperator.png"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <strong><?php _lang('offer.additional_services') ?></strong>
                                                                        </div>
                                                                        <div class="col-item d-none"  >
                                                                            <i class="icon icon-prices-bus mr-2 d-inline-block"
                                                                               style="vertical-align: middle"></i>
                                                                            <span><?php _lang('offer.transfer_detail') ?></span>
                                                                        </div>
                                                                        <div class="col-item d-none" >
                                                                            <i class="icon icon-train-bus mr-2 d-inline-block"
                                                                               style="vertical-align: middle"></i>
                                                                            <span><?php _lang('offer.rail_detail') ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                                                              
                                                                <div class="item-row" v-if="book.totalPrice">
                                                                    <div class="alert alert-warning p-2 mt-2 mb-0" v-show="offer.book.totalPrice.value > offer.book.totalPrice.value">
                                                                        <?php _lang('offer.price_change') ?>  
                                                                        <span class="font-weight-bold">
                                                                             {{ offer.book.totalPrice.value -offer.totalPrice.value  }} {{ offer.totalPrice.currency  }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="alert alert-success p-2 mt-2 mb-0" v-show="offer.totalPrice.value < offer.book.totalPrice.value">
                                                                        <?php _lang('offer.price_down') ?> 
                                                                        <span class="font-weight-bold">
                                                                            {{ offer.totalPrice.value - offer.book.totalPrice.value }} {{ offer.totalPrice.currency  }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="item-row">
                                                                    <div class="item-col-6">
                                                                        <div class="col-item">
                                                                            <span><?php _lang('offer.amount') ?> </span>
                                                                        </div>
                                                                        <div class="col-item">
                                                                            <strong class="result-price">
                                                                                {{ offer.book.totalPrice.currency  }} {{Marti.Tools.numberWithThousandSep(offer.book.totalPrice.value)}}
                                                                            </strong>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-col-6">
                                                                        <a  v-bind:href="getBookingUrl(offer.book,offer.code)"  class="btn btn-success btn-lg btn-rounded" type="button">
                                                                            <?php _lang('offer.take') ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="result-loading" style="display: none"
                                                                 v-bind:id="'offer_detail_'+index">
                                                                <i class="fa fa-spinner fa-spin"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="desktop-result-list-wrapper mb-3" v-if="results.offerList">
                                                    <div v-show="results.offerList.length == 0" class="alert alert-info overflow-auto">
                                                        <span class="float-left">
                                                            <?php _lang('offer.no_result') ?>
                                                        </span> 
                                                        <button class="btn btn-danger text-white btn-sm float-right" v-on:click="reset(); loadHotelOffers();">
                                                            <?php _lang('search.reset_filters') ?>
                                                        </button>
                                                    </div>

                                                    <div v-for="(offer,index) in results.offerList"
                                                         v-if="results.offerList.length > 0"
                                                         class="results-hotel-tab-content-prices-main-item-wrapper"
                                                         v-bind:class="{selected : (selectedOffer && selectedOffer.code == offer.code &&  selectedOffer.book && ['OK'].indexOf(selectedOffer.book.statusCode) > -1   )}">
                                                        <div class="results-hotel-tab-content-prices-main-item"
                                                             v-bind:class="{expire : (selectedOffer.book && ['NK','XX'].indexOf(selectedOffer.book.statusCode) > -1  )}">
                                                            <div class="results-hotel-tab-content-prices-main-item-content row m-0 p-2 pt-3 pb-3">

                                                                <div class="col col-12 col-md-3 results-hotel-tab-content-prices-main-item-content-left">
                                                                    <div v-show="filter.sf == 2">
                                                                        <h3 class="results-hotel-tab-content-prices-main-item-content-title">
                                                                            <?php _lang('offer.flight_point') ?>
                                                                            {{ Marti.Tools.frontEndDateFormat(offer.travelDate.fromDate)}}
                                                                        </h3>
                                                                        <p class="mt-2" v-if="offer.flightOffer != null">
                                                                        <i class="icon icon-prices-plane-h mt-1 mr-2 float-left"></i>
                                                                        <span clasS="float-left">ab {{offer.flightOffer.flight.departureAirport.name}}<br>{{offer.flightOffer.flight.departureAirport.code}}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div v-show='filter.sf != 2'>
                                                                        <h3 class="results-hotel-tab-content-prices-main-item-content-title">
                                                                            <?php _lang('search.travel_data') ?>
                                                                            {{ Marti.Tools.frontEndDateFormat(offer.travelDate.fromDate)}}
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-12 col-md-3 results-hotel-tab-content-prices-main-item-content-left">
                                                                    <div v-show="filter.sf == 2">
                                                                        <h3 class="results-hotel-tab-content-prices-main-item-content-title">
                                                                            <?php _lang('offer.flight_return') ?>
                                                                            {{ Marti.Tools.frontEndDateFormat(offer.travelDate.toDate)}}
                                                                        </h3>
                                                                        <p class="mt-2" v-if="offer.flightOffer != null">
                                                                        <i class="icon icon-prices-plane-h-down mt-1 mr-2 float-left"></i>
                                                                        <span clasS="float-left">ab {{offer.flightOffer.flight.arrivalAirport.name}}<br>{{offer.flightOffer.flight.arrivalAirport.code}}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div v-show='filter.sf != 2'>
                                                                        <h3 class="results-hotel-tab-content-prices-main-item-content-title">
                                                                            <?php _lang('search.return_date') ?>
                                                                            {{ Marti.Tools.frontEndDateFormat(offer.travelDate.toDate)}}
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-12 col-md-4  results-hotel-tab-content-prices-main-item-content-center">
                                                                    <div class="row m-0">
                                                                        <div class="col-6">
                                                                            <ul class="results-hotel-tab-content-prices-main-item-content-list">
                                                                                <li>
                                                                                    {{offer.travelDate.duration}} <?php _lang('common.days'); ?>
                                                                                </li>
                                                                                <li>{{offer.hotelOffer.roomType.name}}</li>
                                                                                <li>{{offer.hotelOffer.boardType.name}}</li>
                                                                            </ul>
                                                                            <div class="mt-2">
                                                                                <a data-toggle="mobile-nav"
                                                                                   data-href="#mobile-transfer-info">
                                                                                    <i class="icon icon-prices-bus"
                                                                                       v-show="offer.transport == 1"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 results-hotel-tab-content-prices-main-item-content-center-right"
                                                                            v-on:click="openOperator(offer.tourOperator.code, hotel.giata.hotelId)">

                                                                            <a class="results-hotel-tab-content-prices-main-item-content-link">
                                                                                <img v-bind:src="offer.tourOperator.png"/>
                                                                                <div class="clearfix"></div>
                                                                                <?php _lang('hotels.offer_info'); ?>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-12 col-md-2">
                                                                    <div  v-if="offer.book && (offer.book.statusCode == 'NK' || offer.book.statusCode == 'XX' || !offer.book.statusCode)"
                                                                         class="alert alert-warning">
                                                                        <p><?php _lang('offer.not_available') ?> <a
                                                                                href="javascript:;"
                                                                                v-on:click="checkBookingModal"><?php _lang('offer.not_available_btn') ?> </a>
                                                                        </p></div>
                                                                    <div 
                                                                         class="float-right">
                                                                        <div class="d-none d-md-block"><?php _lang('hotels.offer_info_price') ?>
                                                                            <strong>{{Marti.Tools.numberWithThousandSep(offer.personPrice.value)}}{{Marti.getCurrency()}}</strong>
                                                                        </div>
                                                                        <div class="mt-3">
                                                                            <button class="btn btn-primary btn-bold buttonload"
                                                                                    v-bind:id="'offer_detail_'+index"
                                                                                    type="button"
                                                                                    v-on:click="checkBooking(offer,index)">
                                                                                <span class="d-block d-md-none ">
                                                                                    {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(offer.personPrice.value)}}
                                                                                </span>
                                                                                <i class="fa fa-spinner fa-spin"></i>
                                                                                <?php _lang('hotels.offer_button'); ?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div v-bind:id="'pricesCollapse' + index"
                                                             data-collapse="content">
                                                                 <?php $this->render('search/offer_detail') ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="results-list"></div>

                                                <div class="results-button"
                                                     v-show="results.offerList && results.totalResultCount >= limit && moreBtn == true ">
                                                    <a class="button " v-on:click="showMoreOffer"
                                                       title="Show More Results"><span><?php _lang('offer.show_more') ?></span></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 bg-white " v-if="hotel.catalogData" v-show="hotelTab == 3" >
                                    <div class="row mb-4" style="height:80px; overflow-y: scroll">
                                        
                                        <div class="col-lg-2 border operator-box" v-for="operator in operators"> 
                                            <div v-on:click='loadOperatorContent(operator.code)' class='text-center py-3'>
                                                <img class="img-fluid" :src="'https://media.traffics-switch.de/vadata/logo/png/h50/'+operator.code.toLowerCase()+'.png'"/>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div v-html='catalogData'></div>
 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal" id="flugDetail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-header">
                    <div class="modal-title">
                        <div class="modal-title-content">
                            <div class="modal-title-text"><?php _lang('offer.flight_info') ?></div>
                        </div>
                    </div>
                </div>
                <div class="modal-main" style="overflow: hidden" >
                    
                    <div v-if="selectedOffer.book && selectedOffer.book.statusCode == 'OK' " class="p-3">
                        <div class="results-hotel-tab-content-prices-main-item-collapse-box-left mb-3" v-if='filter.sf == 2'>
                            <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details" v-if='selectedOffer.flightOffer != null' v-for="flight in selectedOffer.book.commonOffer.flightOffer['flight']['outbound']['legList']" >
                                <div class="d-flex justify-content-between">
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title">
                                        <h5 class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title-text"><?php _lang('offer.flight_point')?> {{ Marti.Tools.frontEndDateFormat(flight.departureTime)}}</h5>
                                        <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-name">{{flight.flightCarrierName}}</div>
                                    </div>
                                    <div class="flight-details-airlineicon">
                                        <img :src=Marti.Tools.getAirlineIconByFlightNr(flight.flightCarrierCode) class="img-responsive" onerror="this.src='/themes/web/martireisen/assets/img/airways/noimage.svg'" alt="Airline Icon" />
                                    </div>
                                </div>

                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta">
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-left">
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.departureAirportCode}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.departureAirportName}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.departureTime}}</span>
                                    </div>
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-center">
                                        <i class="icon icon-prices-plane-h"></i>

                                    </div>
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-right">
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.arrivalAirportCode}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.arrivalAirportName}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.arrivalTime}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details" v-if="selectedOffer.flightOffer!=null" v-for="flight in selectedOffer.book.commonOffer.flightOffer['flight']['inbound']['legList']">
                                <div class="d-flex justify-content-between">
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title">
                                        <h5 class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title-text"><?php _lang('offer.flight_return')?>: {{ Marti.Tools.frontEndDateFormat(flight.departureTime) }}</h5>
                                        <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-name">{{flight.flightCarrierName}}</div>
                                    </div>
                                    <div class="flight-details-airlineicon">
                                        <img :src=Marti.Tools.getAirlineIconByFlightNr(flight.flightCarrierCode) class="img-responsive" onerror="this.src='/themes/web/martireisen/assets/img/airways/noimage.svg'" alt="Airline Icon" />
                                    </div>
                                </div>
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta">
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-left">
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.departureAirportCode}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.departureAirportName}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.departureTime}}</span>
                                    </div>
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-center">
                                        <i class="icon icon-prices-plane-h-down"></i>

                                    </div>
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-right">
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.arrivalAirportCode}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.arrivalAirportName}}</span>
                                        <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.arrivalTime}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="results-hotel-tab-content-prices-main-item-collapse-box-links">
                                <a class="results-hotel-tab-content-prices-main-item-collapse-box-links-item" data-toggle="modal" data-target='#flugDetail'><?php _lang('offer.flight_detail')?></a>
                            </div>

                            <p class="results-hotel-tab-content-prices-main-item-collapse-box-text">
                                Die angegebenen Flugzeiten sind voraussichtlich.
                            </p>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="angebotsinfo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-header">
                    <div class="modal-title">
                        <div class="modal-title-content">
                            <div class="modal-title-icon"></div>
                            <div class="modal-title-text"> <?php _lang('hotels.offer_info'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="modal-main" style="overflow: hidden">
                    <iframe id="hotelInfo2" name="hotelInfo"
                            style="width:100%;height: 100%;border: none; margin-top: -217px"></iframe>
                </div>
            </div>
        </div>
    </div>


    <?php $this->render('search/modals') ?>


    <div class="mobile-sidenav d-block d-md-none" id="mobile-offer-info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="mobile-container">
            <div class="header">
                <div class="text">
                    <?php _lang('hotels.offer_info'); ?>
                </div>
                <div class="mobile-close">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="mobile-divider"></div>

            </div>
            <div class="modal-body">
                <div class="infobox iframe-area">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="offer-info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-body">
                    <div class="infobox iframe-area">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-sidenav d-block d-md-none" id="mobile-transfer-info" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="mobile-container">
            <div class="header">
                <div class="text">
                    <?php _lang('offer.transfer_title'); ?>
                </div>
                <div class="mobile-close">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="mobile-divider"></div>

            </div>
            <div class="body">
                <?php _lang('offer.transfer_text'); ?>
            </div>
        </div>
    </div>
    <!-- Review Modal-->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
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
    <div class="modal fade" id="offer-error" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-body">
                    <div class=" ">
                        <h4><?php _lang('offer.check_title') ?></h4>
                        <p>
                            <?php _lang('offer.check_message') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-sidenav d-block d-md-none" id="mobile-offer-error" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="mobile-container">
            <div class="header">
                <div class="text">
                    <?php _lang('offer.check_title') ?>
                </div>
                <div class="mobile-close">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="mobile-divider"></div>

            </div>
            <div class="body">
                <?php _lang('offer.check_message') ?>
            </div>
        </div>
    </div>
    <div class="modal fade modal-right" id="modalFilters" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="modal-main">
                    <?php $this->render('layouts/search-hotel-left') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-sidenav d-block d-md-none" id="mobile-review" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="mobile-container">
            <div class="header">
                <div class="text">
                    <?php _lang('hotels.review') ?>
                </div>
                <div class="mobile-close">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="mobile-divider"></div>

            </div>
            <div class="iframe-area"></div>
        </div>
    </div>
</div>
<div class="lds-css ng-scope" id="loader" style="display:none">
    <div class="lds-dual-ring"></div>
</div>
<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php theme_dir() ?>assets/photoswipe/photoswipe.css"/>
<link rel="stylesheet" href="<?php theme_dir() ?>assets/photoswipe/default-skin/default-skin.css">

<script src="<?php theme_dir() ?>assets/photoswipe/photoswipe.min.js"></script>
<script src="<?php theme_dir() ?>assets/photoswipe/photoswipe-ui-default.min.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoaWZ5rdu9j4gWtMs0dFGMhuTJQarcQnU"></script>
