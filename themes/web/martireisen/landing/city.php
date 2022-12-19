
<style>
    #search {background:none;}
    #page-header .page-header .page-header-about-us .page-header-about-us-title { font-size : 30px; }
    #page-header {height: 300px}
    #page-header .page-header-container {
        height: auto;
    }
</style>
<div id="page-header" class="bg-about-us " style="background-image:url('<?php echo $this->landing['image']?>')">
    <div class="container page-header-container pt-5">
        <div class="page-header col-sm-7">
            <div class="page-header-about-us">
                <div class="page-header-about-us-title"><h1 class="font-weight-bold"><?php echo $this->landing['translate']['title']?></h1></div>
                <div class="page-header-about-us-text"><?php echo $this->landing['translate']['subtitle']?></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="app" v-cloak>
            <?php $this->render('layouts/search-bar')?>
        </div>
    </div>
</div>
<!--
<div id="breadcrumb" class="mt-3 mb-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/<?php echo $this->prefix ?>" title=""><?php echo ucfirst($this->prefix) ?></a></li>
                <li class="breadcrumb-item"><a href="/<?php echo $this->prefix ?>/<?php echo $this->country['seo_url'] ?>" title=""><?php echo $this->country['name'] ?></a></li>
                <li class="breadcrumb-item"><a href="/<?php echo $this->prefix ?>/<?php echo $this->state['seo_url'] ?>" title=""><?php echo $this->state['name'] ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span><?php echo $this->zone['name'] ?></span></li>
            </ol>
            </ol>
        </nav>
    </div>
</div>-->



<div id="landing">
    <div class="container">

         <section id="hoteltips-topseller" class="no-pt mt-4" v-cloak>
            <div class="container">
                <h2 class="text-center"><?php echo $this->landing['translate']['third_title']?></h2>
                <div class="row">
                     <div class="col-lg-4 col-md-6"  v-for="i in 6"  v-show="loading">
                        <hotel-landing-loader :width="350" :height="450" :speed="2"></hotel-landing-loader>
                    </div>
                    <div class="col-lg-4 col-md-6" v-for="hotel in results.hotelList">
                        <div class="item">
                            <figure v-on:click="openHotelPage(hotel)">
                                <img v-if="hotel.mediaData" :src="hotel.mediaData.pictureUrl.replace('size=150','size=400')" class="w-100" :alt="hotel.name" :title="hotel.name"/>
                                    <ul class="icon-list">
                                        <li>
                                            <img src="<?php theme_dir() ?>assets/img/landing/family.svg"  class="mt-2"  alt="aile için uygun" title="aile için uygun"/>
                                        </li>
                                    </ul>
                                    <figcaption>
                                        <h3>
                                            <a v-bind:href="'/hotel/'+hotel.name_sef+'?sf='+filter.sf+'&adults=2&destination[type]=hotel&destination[name]='+hotel.name+'&destination[code]='+hotel.giata.hotelId+'&duration='+filter.duration"   class="text-reset">{{hotel.name}}</a>
                                        </h3>
                                        <small>{{hotel.location.name}}</small>
                                        <ul class="rating p-0">
                                            <li v-for="i in 5 ">
                                                <i :class="{'text-warning' : i <= hotel.category}" class=" fas fa-star"></i>
                                            </li>
                                        </ul>
                                        <a v-bind:href="'/hotel/'+hotel.name_sef+'?sf='+filter.sf+'&adults=2&destination[type]=hotel&destination[name]='+hotel.name+'&destination[code]='+hotel.giata.hotelId+'&duration='+filter.duration"   class="price-more">
                                            <span>
                                                p.P ab {{hotel.bestPricePerPerson.value}} €
                                            </span>
                                            <i class="float-right fa fa-arrow-right"></i>
                                        </a>
                                    </figcaption>
                            </figure>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 offset-md-4">
                        <a href="<?php echo Helper\UrlGen::loadMore($this->prefix,$this->zone)?>" class="read-more"><?php _lang('offer.show_more')?></a>
                    </div>
                </div>
            </div>
        </section>
        <?php if(!empty($this->landing['translate']['content'])) { ?>
        <section class="mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="content-card landing-page border-0">
                            <div class="card-content mt-4">
                                <?php echo str_replace('{#region_name#}',$this->zone['name'],$this->landing['translate']['content'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?> 
        <?php 
            switch($this->prefix) {
                case 'pauschalreisen':
                    $this->render('landing/footer/pauschal');
                break;
                
                case 'lastminute':
                    $this->render('landing/footer/lastminute');
                    break;

                default:
                    $this->render('landing/footer/standart');
                    break;
            }
        ?>
    </div>
</div>    
<script src="<?php theme_dir()?>assets/js/vue/landing.js?<?php echo time()?>"></script>
