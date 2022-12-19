<script>window.RELATED_IDS = '<?php echo $this->landing['related_ids'] ?>';</script>;
<section id="hoteltips-topseller" class="no-pt mt-4" v-cloak>
    <div class="container">
        <h2 class="text-center" v-if='relatedResults.hotelList'><?php _lang('landing.related_otels') ?></h2>
        <p class='mb-4 text-center'  v-if='relatedResults.hotelList '><?php _lang('landing.related_otels_text') ?></p>
        <div class="row">
            <div class="col-lg-4 col-md-6"  v-for="i in 6"  v-show="relatedLoading">
                <hotel-landing-loader :width="350" :height="450" :speed="2"></hotel-landing-loader>
            </div>
            <div class="col-lg-4 col-md-6" v-for="hotel in relatedResults.hotelList">
                <div class="item">
                    <figure v-on:click="openHotelPage(hotel)">
                        <img v-if="hotel.mediaData" :src="hotel.mediaData.pictureUrl.replace('size=150','size=400')" class="w-100" :alt="hotel.name" :title="hotel.name"/>
                        <img v-if="!hotel.mediaData" :src="'https://thumbnails.travel-it.com/g2thmb.php?gid='+hotel.giata.hotelId"  class="w-100"/>
                        <ul class="icon-list">
                            <li>
                                <img src="<?php theme_dir() ?>assets/img/landing/family.svg"  class="mt-2"  alt="aile için uygun" title="aile için uygun"/>
                            </li>
                        </ul>
                        <figcaption>
                            <h3>
                                <a v-bind:href="'/hotel/'+hotel.name_sef+'_hid_'+hotel.giata.hotelId"   class="text-reset">{{hotel.name}}</a>
                            </h3>
                            <small>{{hotel.location.name}}</small>
                            <ul class="rating p-0">
                                <li v-for="i in 5 ">
                                    <i :class="{'text-warning' : i <= hotel.category}" class=" fas fa-star"></i>
                                </li>
                            </ul>
                            <a v-bind:href="'/hotel/'+hotel.name_sef+'_hid_'+hotel.giata.hotelId"   class="price-more">
                                <span>
                                    p.P ab {{hotel.bestPricePerPerson.value}} €
                                </span>
                                <i class="float-right fa fa-arrow-right"></i>
                            </a>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>