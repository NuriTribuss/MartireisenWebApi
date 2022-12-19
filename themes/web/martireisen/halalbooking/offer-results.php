<div v-if="results.offers && results.offers.length == 0" style="overflow: hidden" class="alert alert-info">
    <span class="float-left">
        <?php _lang('search.no_result') ?>
    </span>
</div>
<div class="results-item" v-for="(hotel,index) in results.offers"
     v-if="filter.star == '' || parseInt(hotel.place.stars) >= filter.star">
    <div class="results-item-left">
        <div class="results-item-slider" data-result-slider="root">
            <div class="results-item-slider-recommended"><?php _lang('hotels.recommended') ?></div>
            <div class="results-item-slider-content">
                <div class="swipercontainer" data-result-slider="sider">
                    <div class="swiperwrapper">
                        <div class="swiperslide">
                            <div class="results-item-slider-item">
                                <div class="hotelImage">
                                    <!--                                    <img v-bind:src="hotel.place.photo"/>-->
                                    <!--                                    <i class="icon icon-hotel-info-photo photo-list hidden-xs hidden-xxs"></i>-->
                                    <div class="swiper-container hotel-list-slider"
                                         v-if="hotel.place.photos && hotel.place.photos.length > 0 ">
                                        <div class="swiper-wrapper">
                                            <a class="swiper-slide" v-for="picture in hotel.place.photos.slice(0,4)"
                                               type="button"
                                               v-on:click="search_offers('hotel',hotel.place.id,hotel.place.name)"
                                               v-bind:style="{ 'background-image': 'url(' + picture + ')' }">
                                            </a>
                                        </div>
                                        <div class="swiper-pagination">
                                        </div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-scrollbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="results-item-center hotel-info">
        <div class="results-item-center-top hotel-info-bar">
            <h3 class="results-item-titlehotels-list" data-url="<?php echo $url ?>">{{hotel.place.name}}</h3>
            <div class="results-item-description hotels-list" data-url="">
                <div class="results-item-description-stars">
                    <i class="icon icon-results-star" v-for='n in parseInt(hotel.place.stars)'></i>
                </div>
                <div class="clearfix mt-2"></div>
                <div class="results-item-description-text">
                    {{hotel.place.location.name}},{{hotel.place.location.subregion}}({{hotel.place.location.country}})
                </div>
            </div>
            <div class="results-item-links d-none">
                <a class="results-item-links-item d-block d-md-none" title="Link"><i class="icon fas fa-camera"></i>
                </a>
                <a class="results-item-links-item" title="Link" v-on:click='loadHotelMap(hotel)'><i
                            class="icon icon-results-world hidden-xxs"></i><i
                            class="d-block d-md-none icon fas fa-map-marker"></i> <span
                            class="map-text"><?php _lang('hotels.map') ?></span></a>
            </div>
        </div>
        <div class="results-item-center-bottom hotels-list recommend-item">
            <div class="results-item-recommended halal-hotel-score" v-on:click="openReview(hotel.place.id)">
                <div class="hotel-score-title">
                    <span> <?php _lang('hotels.score') ?></span>
                    <div class="halal-hotel-score-stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div>
                <div class="hotel-score-content" v-html='hotel.place.score'>

                </div>
            </div>
        </div>
    </div>
    <div class="results-item-right">
        <div class="results-item-like">
            <label class="checkbox checkbox-like">
                <span class="checkbox-like-icons">
                    <i class="icon icon-results-like"></i>
                    <i class="icon icon-results-like-active"></i>
                </span>
            </label>
        </div>
        <div class="results-item-price  d-md-block text-right">
            {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep((hotel.min_price *
            1.15).toFixed(0))}}
        </div>
        <div class="d-block  mobile-price-block">
            <div class="results-item-discount"><small><?php _lang('hotels.ab') ?></small>
                {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep((hotel.min_price).toFixed(0))}}
            </div>
        </div>
        <div class="results-item-button mt-3 mb-3">
            <a class="button" v-on:click="search_offers('hotel',hotel.place.id,hotel.place.name)" title="Title"
               target="_blank">
                <?php _lang('hotels.check_offers') ?>
                <i class="icon icon-header-arrow-right"></i>
            </a>
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
        <div class="iframe-area">

        </div>

    </div>
</div>

