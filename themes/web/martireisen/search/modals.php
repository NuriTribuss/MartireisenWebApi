   <!-- İmage Modal-->
        <div class="modal fade" id="imageModal"  tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-if='hotel.catalogData'>
                    <div data-dismiss="modal" class="modal-close registered">
                        <i class="icon icon-modal-close"></i>
                    </div>
                    <div class="modal-body">
                        <div class="my-3">
                            <!-- Slider main container -->
                            <div class="swiper-container gallery-top" v-if="hotel.catalogData.imageList && hotel.catalogData.imageList.length  > 0 ">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <div v-for="picture in hotel.catalogData.imageList" class="swiper-slide" v-bind:style="{ 'background-image': 'url(' + picture.replace('size=180','size=800') + ')' }"></div>
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
                            <div class="swiper-container gallery-thumbs"  v-if="hotel.catalogData.imageList && hotel.catalogData.imageList.length  > 0 ">
                                <div class="swiper-wrapper">
                                    <div v-for="picture in hotel.catalogData.imageList" class="swiper-slide" v-bind:style="{ 'background-image': 'url(' + picture + ')' }"></div>
                                </div>
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
            <div class="modal-close registered" data-dismiss="modal">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-body pt-5">
                <div id="map" ></div>
                <div class="infobox">
                    <div class="row" v-if="hotel.info">
                        <div class="col--4 col-lg-5">
                            <img v-bind:src="'https://thumbnails.travel-it.com/g2thmb.php?gid='+hotel.info.id"/>
                        </div>
                        <div class="col--8 col-lg-7">
                            {{hotel.info.name}}
                            <div class="map-stars">
                                <i class="icon icon-results-star" v-for="index in hotel.info.star"></i>
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
            <div class="modal-close registered" data-dismiss="modal">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-body mt-5">
                <div class="infobox iframe-area">

                </div>
            </div>
        </div>
    </div>
</div>