<div v-if="results.hotels && results.hotels.length == 0" style="overflow: hidden" class="alert alert-info">

    <div class="mb-3">
        <div class="filters-tags" >
            <span class="filters-tags-item"  v-on:click="resetParam('star')" v-if='filter.star > 0'>{{filter.star}} {{translate['search.rating']}}</span>
            <span class="filters-tags-item"  v-on:click="resetParam('seaview')" v-if='filter.seaview > 0'>{{filter.seaview}} {{translate['search.seaview']}}</span>
            <span class="filters-tags-item"  v-on:click="resetParam('transfer')" v-if='filter.transfer > 0'>{{filter.transfer}} {{translate['search.transfer']}}</span>
            <span class="filters-tags-item"  v-on:click="resetParam('reviewRate')" v-if='filter.reviewRate > 0'>{{filter.reviewRate}}<i class="fa fa-percent"></i> </span>
            <span class="filters-tags-item"  v-on:click="resetParam('room')" v-if='filter.room > 0' >{{translate['search.room.'+(parseInt(filter.room)+1)]}}</span>
            <span class="filters-tags-item"  v-on:click="resetParam('pansion')" v-if='filter.pansion > 0' >{{translate['search.pansion.'+((parseInt(filter.pansion)+1))]}}</span>
            <span class="filters-tags-item"  v-on:click="resetParam('sf')" v-if='filter.sf > 2'>{{filter.sf}} {{translate['search.sf']}}</span>
            <span  v-for='attribute in filter.attributes' class="filters-tags-item"  v-on:click='filter_global_types(attribute)' v-if='filter.attributes.length > 0'>
                   {{attribute === 'GT03-DIBE'?'<?php _lang('search.filter_beach')?>':''}}
                   {{attribute === 'GT03-FAFR'?'<?php _lang('search.filter_family')?>':''}}
                   {{attribute === '0000000000000004'?'<?php _lang('search.filter_adults')?>':''}}
                   {{attribute === 'GT03-CURE'?'<?php _lang('search.filter_body')?>':''}}
                   {{attribute === 'GT03-WATE,GT03-FITN,GT03-TENN,GT03-BEVO'?'<?php _lang('search.filter_sport')?>':''}}
            </span>
            <?php if(\Helper\Input::get('atand') === "0000000000000004")  { ?>
                <span class="filters-tags-item" data-toggle="tag" data-cancel="gtype"><?php _lang('search.filter_adults')?></span>
            <?php } ?>
        </div>
    </div>

    <span class="float-left">
        <?php _lang('search.no_result')?>
    </span>
    <button class="btn btn-danger text-white btn-sm float-right" v-on:click="reset(); loadHotels();">
        <?php _lang('search.reset_filters')?>
    </button>
</div>
<div class="results-item" v-for="(hotel,index) in results.hotelList">
    <div class="results-item-links">
        <a class="results-item-links-item d-block d-md-none text-decoration-none" href="javascript:void(0)" title="Link" v-on:click='loadHotelImage(hotel)'><i class="icon fas fa-camera"></i> </a>
        <a class="results-item-links-item d-none d-md-block text-decoration-none" href="javascript:void(0)" title="Link" v-on:click='loadHotelImage(hotel)'><i class="fas fa-camera"></i> </a>

        <a class="results-item-links-item text-decoration-none" title="Link" v-on:click='loadHotelMap(hotel.giata.hotelId,hotel.tourOperator.code)'>
            <i class="icon icon-results-world d-none"></i>
            <i class="fas fa-map-marker d-none d-md-block"></i>
            <i class="icon fas fa-map-marker d-block d-md-none"></i>
            <span class="map-text d-none"><?php _lang('hotels.map')?></span>
        </a>
    </div>

    <div class="row m-0">
        <div class="col-12 col-md-4 pl-0 pr-0 pr-lg-3">
              <div class="results-item-slider" data-result-slider="root">
                <div v-show="hotel.rating > 92" class="results-item-slider-recommended"><?php _lang('hotels.recommended')?></div>
                <div class="results-item-slider-content">
                    <div class="swipercontainer" data-result-slider="sider">
                        <div class="swiperwrapper">
                            <div class="swiperslide">
                                <div class="results-item-slider-item">
                                    <a class="hotelImage" type="button" v-on:click="loadHotelImage(hotel)" v-if="hotel.mediaData">
                                        <img v-bind:src="hotel.mediaData.pictureUrl.replace('size=150','size=300')"/>
                                        <i class="icon icon-hotel-info-photo photo-list d-none"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 pl-0 pr-0 hotel-info">
            <div class="hotel-info-bar">
                <h3 class="results-item-title" data-url="<?php echo $url?>">{{hotel.name}}</h3>
                <div class="results-item-description hotels-list mb-2" data-url="">
                    <div class="results-item-description-stars float-left" v-if="hotel.category">
                        <i class="icon icon-results-star" v-for='n in parseInt(hotel.category)'></i>
                    </div>
                    <div class="results-item-description-text">
                        {{hotel.location.name}},<!--{{hotel.location.state}}--> ({{hotel.location.region.name}})
                    </div>
                    <div class="results-item-text" v-if="hotel.offerList.length > 0 ">{{hotel.offerList[0].travelDate.duration }} <?php _lang('common.days')?></div>
                </div>

            </div>
            <div class="d-flex justify-content-end" style="flex-wrap:wrap">
            <div class="results-item-center-bottom hotels-list recommend-item d-none d-md-block"  v-on:click="openReview(hotel.rating.hotelId)" v-if="hotel.rating">
                <div class="results-item-recommended">
                    <div class="results-item-recommended-image">
                        <img src="<?php theme_dir()?>assets/img/holiday.check.svg" alt="Holiday Check"/>
                    </div>
                    <div class="results-item-recommended-content">
                        <p class="results-item-recommended-content-text"><span>{{ hotel.rating.recommendation }}%</span> <?php _lang('hotels.suggestion')?></p>
                        <p class="results-item-recommended-content-text"><span>{{ hotel.rating.count }}</span> <?php _lang('hotels.review')?></p>
                    </div>
                </div>
                
            </div>
            <div class="d-block d-lg-none results-item-center-bottom hotels-list recommend-item"  v-on:click="openReview(hotel.rating.hotelId)" v-if="hotel.rating">
                <div class="results-item-recommended">
                    <div class="results-item-recommended-image mr-3">
                        <img src="<?php theme_dir()?>assets/img/holiday.check.svg" alt="Holiday Check"/>
                    </div>
                    <div class="results-item-recommended-content">
                        <p class="results-item-recommended-content-text d-inline-flex"><span>{{ hotel.rating.recommendation }}%</span> <?php _lang('hotels.suggestion')?></p>
                        <p class="results-item-recommended-content-text d-inline-flex"><span>{{ hotel.rating.count }}</span> <?php _lang('hotels.review')?></p>
                    </div>
                </div>
                
            </div>
             <div class=" mobile-price-block ml-lg-3">
                    <div class="results-item-button mt-0">
                        <a class="button" v-on:click="search_offers('hotel',hotel.giata.hotelId,hotel.tourOperator.code)"  >
                            <small class="mr-2"><?php _lang('hotels.ab')?></small> {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(hotel.bestPricePerPerson.value)}}
                            <i class="icon icon-header-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" d-none d-lg-block p-1 c-card__facts">
        <div>
            <i class="c-card__facts-summary-icon " :title="translate['facility_'+keyword]" v-if='index < 20' v-for='(keyword,index) in hotel.keywordList'><span v-bind:class='keyword'></span></i>
        </div>
    </div>
</div>

 <div class="mobile-sidenav d-block d-md-none" id="mobile-review" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="mobile-container">
        <div class="header">
            <div class="text">
                <?php _lang('hotels.review')?>
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