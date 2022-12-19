<div id="app" v-cloak>
   
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <a  href="/halal-booking/hotels"><?php _lang('menu.halalbooking')?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span>{{filter.destination.name}}</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="summary" data-toggle="mobile-nav" data-href="#mobile-filter">
        <div class="container">
            <div class="summary-title"><strong>{{filter.destination.name}}</strong></div>
            <div class="summary-text">{{filter.adults}} <?php _lang('search.adult')?>,  {{filter.children.length}} <?php _lang('search.children')?></div>
            <div class="summary-text">{{ Marti.Tools.frontEndDateFormat(filter.date.start) }} - {{ Marti.Tools.frontEndDateFormat(filter.date.end) }}</div>
            <div class="summary-icon">
                <i class="icon icon-summary-pencil"></i>
            </div>
        </div>
    </div>
    
    <?php // $this->render('layouts/search-bar')?>
    <?php $this->render('layouts/search-steps')?>

    <div id="results">
        <div class="container">
            <div class="results halal-booking-results">
                <?php $this->render('halalbooking/hotel-left')?>
                <div class="results-right col-md-9">
                    <hotel-loader  v-if='typeof hotel.id == "undefined"' :height="400" :width="870" :speed="2" ></hotel-loader>

                    <div class="results-hotel-info row mb-3" v-if="hotel.id">
                        <div class="results-hotel-info-left col-12 col-md-7" v-if="hotel.photos.length > 0 " >
                            <div class="results-hotel-info-slider">
                                <div id="hotelinfoSlider" class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide" v-for="picture in hotel.photos">
                                            <div class="results-hotel-info-thumbnail-slider-item" >
                                                <a v-on:click="loadHotelImage(hotel)" v-bind:src="picture">
                                                    <img v-bind:src="picture"  />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next"></div> 
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                            <div class="results-hotel-info-slider-meta mt-2">
                                <div class="results-hotel-info-slider-meta-right">
                                    <div class="results-hotel-info-thumbnail-slider">
                                        <div id="hotelinfoSliderThumbnails" class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide" v-for="picture in hotel.photos">
                                                    <div class="results-hotel-info-thumbnail-slider-item">
                                                        <img v-bind:src="picture"  />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="results-hotel-info-right col-12 col-md-5"  >
                            <div class="results-hotel-info-right-top">
                                <h3 class="results-hotel-info-title">{{hotel.name}}</h3>
                                <div class="results-hotel-info-description">
                                    <div class="results-hotel-info-description-stars" v-if="hotel.stars">
                                        <i class="icon icon-results-star" v-for='n in hotel.stars'></i>
                                    </div>
                                    <div class="results-hotel-info-description-text">
                                        {{hotel.location.city}} {{hotel.location.name}}
                                    </div>
                                </div>
                                                                <p>{{hotel.overview}}</p>

                                <div class="results-hotel-info-links d-none">
                                    <a class="results-hotel-info-links-item" v-on:click="loadHotelMap(results)"><i class="icon icon-results-world"></i> <?php _lang('hotels.map');?></a>
                                </div>
                                  <a href="#" id="btn-check-offer" class="btn btn-block btn-primary mt-3 mb-2 btn-rounded" v-on:click="hotelTab = 1">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <?php _lang('hotels.check_offers')?>
                                </a>
                                <div class="mt-3">
                                    <i class="fa fa-check"></i>
                                    <span><?php _lang('hotels.checkin')?> : {{hotel.checkin_time}}</span>
                                    <div class='clearfix'></div>
                                    <i class="fa fa-check"></i>
                                    <span><?php _lang('hotels.checkout')?> : {{hotel.checkout_time}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="results-hotel-tab mt-4">
                        <div class="results-hotel-tab-buttons" data-slider-buttons="result-hotel-tab">
                            <button class="button" v-bind:class="{'active' : hotelTab == 1}" v-on:click="hotelTab = 1" type="button" ><?php _lang('hotels.tab_1');?></button>
                            <button class="button d-none" v-bind:class="{'active' : hotelTab == 2}" v-on:click="hotelTab = 2" type="button" ><?php _lang('hotels.tab_2');?></button>
                            <button class="button" v-bind:class="{'active' : hotelTab == 3}" v-on:click="hotelTab = 3" type="button" ><?php _lang('hotels.tab_3');?></button>
                        </div>
                        <div class="results-hotel-tab-content">
                            <div class="" data-slider="result-hotel-tab">
                                <div class="">
                                    <div class="" v-show="hotelTab == 1">
                                        <div class="results-hotel-tab-content-prices">
                                            <div class="results-hotel-tab-content-prices-main">
                                                
                                                <div v-for="(group,j) in results.offers">
                                                    <div v-show="group.offers.length == 0">
                                                        <div class="alert alert-warning mt-4">
                                                            <?php _lang('offer.no_result')?>
                                                        </div>
                                                    </div>
                                                    <div class="" v-for="(offer,index) in group.offers">
                                                        <div class="booking-item">
                                                            <div class="row">
                                                                <div class="col-md-4">
<!--                                                                    <img v-bind:src="offer.room.photos[0]" />-->
<!--                                                                    <div class="col-12 p-0 mt-4">-->
<!--                                                                        <img v-bind:src="photo"  class="mr-2"v-for="photo in offer.room.photos" style="width:36px"/>-->
<!--                                                                    </div>-->
                                                                    <div class="swiper-container hotel-list-slider"
                                                                         v-if="offer.room.photos && offer.room.photos.length > 0 ">
                                                                        <div class="swiper-wrapper">
                                                                            <a class="swiper-slide" style="height: 200px !important;" v-for="photo in offer.room.photos"
                                                                               type="button" v-on:click="imageModal(offer.room.photos)"
                                                                               v-bind:style="{ 'background-image': 'url(' + photo + ')' }">
                                                                            </a>
                                                                        </div>
                                                                        <div class="swiper-pagination">
                                                                        </div>
                                                                        <div class="swiper-button-prev"></div>
                                                                        <div class="swiper-button-next"></div>
                                                                        <div class="swiper-scrollbar"></div>
                                                                    </div>


                                                                </div>
                                                                <div class="booking-item-content col-md-8">
                                                                    <div class="d-flex">
                                                                        <div class="flex-fill pr-3">
                                                                            <h5 class="booking-item-title">{{offer.room.name}} x {{offer.quantity}}</h5>
                                                                            <p class="text-small">{{offer.rate_plan.board_basis_name}}</p>
                                                                            <ul class="booking-item-features booking-item-features-sign clearfix">
                                                                                <li rel="tooltip" data-placement="top" title="" ><i class="fa fa-male"></i><span class="booking-item-feature-sign">{{group.group}}</span>
                                                                                </li>
                                                                                <li rel="tooltip" data-placement="top" title="" ><i class="fas fa-utensils"></i><span class="booking-item-feature-sign"></span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="p-1">
                                                                            <div class="booking-item-price d-block text-right">{{Marti.getCurrency()}} {{offer.price}} </div>
                                                                            <div class="btn btn-primary btn-bold text-center" v-on:click="goBooking(results,j,index)"><?php _lang('hotels.offer_button');?></div>
                                                                        </div>

                                                                    </div>

                                                                 <div class="detail-collapse">
                                                                   <div class="text-right">
                                                                       <a  data-toggle="collapse"  :data-target="`#detail-${index}`" aria-expanded="false" :aria-controls="`detail-${index}`" >
                                                                           Detay <i class="fas fa-angle-down ml-2"></i>
                                                                       </a>
                                                                   </div>
                                                                     <div class="collapse" :id="`detail-${index}`">
                                                                         <div class="mt-3">
                                                                             <p style="white-space:pre-wrap">
                                                                                 {{offer.room.long_description}}
                                                                             </p>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="results-list"></div>
                                                        <div class="lds-css ng-scope" v-show='loading'>
                                                            <div class="lds-dual-ring"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                               
                                    </div>
                                    <div v-show="hotelTab == 3" style="white-space: pre-line; padding: 15px; background: white;">
                                        <div>
                                            {{hotel.overview}}
                                        </div>
                                        <div>
                                            {{hotel.facilities}}
                                        </div>
                                        <div>
                                            {{hotel.facts}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " id="angebotsinfo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-header">
                    <div class="modal-title">
                        <div class="modal-title-content">
                            <div class="modal-title-icon"></div>
                            <div class="modal-title-text"> <?php _lang('hotels.offer_info');?></div>
                        </div>
                    </div>
                </div>
                <div class="modal-main" style="overflow: hidden">
                    <iframe id="hotelInfo2" name="hotelInfo"  style="width:100%;height: 100%;border: none; margin-top: -217px"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-sidenav d-block d-md-none" id="mobile-offer-info" tabindex="-1" role="dialog">
        <div class="mobile-container">
            <div class="header">
                <div class="text">
                    <?php _lang('hotels.offer_info');?>
                </div>
                <div class="mobile-close"> 
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="mobile-divider"></div>

            </div>
            <div class="modal-body">
                <div class="infobox iframe-area">

                </div>
            </div>e>
        </div>
    </div>
   
    <div class="modal fade" id="offer-info" tabindex="-1" role="dialog">
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
    <div class="mobile-sidenav d-block d-md-none" id="mobile-offer-info" tabindex="-1" role="dialog">
        <div class="mobile-container">
            <div class="header">
                <div class="text">
                    <?php _lang('hotels.offer_info');?>
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
    
    
    <div class="modal fade" id="offer-error" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-body">
                    <div class=" ">
                        <h4><?php _lang('offer.check_title')?></h4>
                        <p>
                            <?php _lang('offer.check_message')?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mobile-offer-error"  tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl mt-5">
            <div class="modal-content">
                <div class="modal-close registered">
                    <i class="icon icon-modal-close"></i>
                </div>
                <div class="modal-body">
                   <div class="modal-body">
                        <div class=" ">
                            <h4><?php _lang('offer.check_title')?></h4>
                            <p>
                                <?php _lang('offer.check_message')?>
                            </p>
                        </div>
                    </div> 
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
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
                            <div v-for="picture in hotel.photos" class="swiper-slide" v-bind:style="{ 'background-image': 'url(' + picture.replace('size=180','size=800') + ')' }"></div>
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
                            <div v-for="picture in hotel.photos" class="swiper-slide" v-bind:style="{ 'background-image': 'url(' + picture.replace('size=180','size=800') + ')' }"></div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


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

<script src="<?php theme_dir() ?>assets/photoswipe/photoswipe.min.js"></script>
<script src="<?php theme_dir() ?>assets/photoswipe/photoswipe-ui-default.min.js"></script>
