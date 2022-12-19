<div class="home" id="app">
    <?php $this->render('layouts/search-bar') ?>
</div>

<!-- CORONA -->
<div class="section pt-4 d-lg-block">
    <div class="container corona">
        <div class="row d-none ">
          
            <div class="col-12 col-lg-6">
                <?php $link1 = Model\User\Customer::getLanguage() == 'tr' ? 'guncel-bilgi-danisma-hatti' : 'erreichbarkeit' ?>
                <?php $link2 = Model\User\Customer::getLanguage() == 'tr' ? 'tatil-paketi-koronavirus-covid-19' : 'pauschalreisen-coronavirus-covid-19' ?>

                <div class="card p-1 rounded-0 text-white " onclick="location.href='/<?php echo $link1?>'" style="background-color: #009ee6">
                    <div class="card-body   " style="border:2px solid white;">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <i class="fa fa-3x fa-exclamation mt-2"></i>
                                <div class="ml-4">
                                <h2 class="text-white mb-3"><?php echo stripslashes(_lang('corona_title',true))?></h2>
                                <p class="mb-1" style='height:57px'><?php echo stripslashes(_lang('corona_description',true))?></p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <a type="button" style="width:140px" href="/<?php echo $link1?>" class=" float-right btn btn-sm btn-warning"><?php _lang('corona_button')?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             
           <div class="col-12 col-lg-6">
                <div class="card p-1 rounded-0 text-white " onclick="location.href='/<?php echo $link2?>'" style="background-color: #009ee6">
                    <div class="card-body   " style="border:2px solid white;">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <i class="fa fa-3x fa-exclamation mt-2"></i>
                                <div class="ml-4">
                                <h2 class="text-white mb-3"><?php echo stripslashes(_lang('corona_2title',true))?></h2>
                                <p class="mb-4"><?php echo stripslashes(_lang('corona_2description',true))?></p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <a type="button" style="width:140px"  href="/<?php echo $link2?>" class=" float-right   btn btn-sm btn-warning"><?php _lang('corona_button')?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CORONA -->

<div class="section pt-5 pb-4 d-none d-lg-block">
    <div class="section-header ">
        <div class="container">
            <div class="text-center">
                <h1 class="font-weight-bold"><?php _lang('homepage.block.header') ?></h1>
                <h3><?php _lang('homepage.block.header_desc') ?></h3>
            </div>
        </div>
    </div>
    <div class="section-content">
        <div id="top-hotels" v-cloak>
            <div class="container">
                <div class="top-hotels-header">
                    <div class="top-hotels-buttons">
                        <button v-on:click="activeIndex = index" v-for="(region,index) in results"
                                v-bind:class="{'button':true , active : index == activeIndex}" class="rounded-0">{{region.title}}
                        </button>
                    </div>
                </div>
            </div>
            <div class="top-hotels-main">
                <div class="container">
                    <div v-bind:class="{'tab-content':true , active : index == activeIndex}" v-for="(region,index) in results">
                        <div class="swiper-container " v-bind:id="'top-swiper-'+index">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide" style="" v-for='(hotel,hotelIndex) in region.children'>
                                   
                                    <a class="top-hotels-slider-item "
                                       v-bind:href="'/hotel/'+hotel.name_sef+'?sf=2&adults=2&destination[type]=hotel&destination[name]='+hotel.name+'&destination[code]='+hotel.giataCode">
                                        <div class="top-hotels-slider-item-image gradient-overlay-half-bg-gradient-v5">
                                            <img v-lazy="hotel.image"
                                                 alt="Image" width="100%"/>
                                        </div>
                                        <div class="top-hotels-slider-item-content">
                                            <div class="top-hotels-slider-item-content-header">
                                                <div class="top-hotels-slider-item-content-header-left w-100">
                                                    <h3 class="top-hotels-slider-item-content-header-title">{{hotel.name}}</h3>
                                                    <h5 class="top-hotels-slider-item-content-header-sub-title">
                                                        {{hotel.state}}</h5>
                                                </div>

                                            </div>
                                            <div class="row top-hotels-slider-item-content-header">
                                                <div class="col-6">
                                                    <div class="top-hotels-slider-item-content-day">
                                                        <i class="d-none icon icon-top-hotels-day"></i>
                                                        {{hotel.duration}} <?php _lang('common.days') ?>
                                                    </div>
                                                    <div class="w-100 d-flex">
                                                        <i class="icon mr-1"
                                                           v-bind:class="{'icon-top-hotels-star-active' : i <= hotel.star, 'icon-top-hotels-star' : i > hotel.star }"
                                                           v-for="i in 5"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="top-hotels-slider-item-content-header-right">
                                                        <div class="top-hotels-slider-item-content-header-discount">€
                                                            {{(parseFloat(hotel.price)*1.15).toFixed(0)}}
                                                        </div>
                                                        <div class="top-hotels-slider-item-content-header-cost">
                                                            <small>ab</small>
                                                            € {{hotel.price}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="section  d-sm-block pt-4 pb-4">
    <div class="section-header">
        <div class="container">
            <div class="text-center">
                <h2><?php _lang('homepage.block.header') ?></h2>
                <h3><?php _lang('homepage.block.header_desc') ?></h3>
            </div>
        </div>
    </div>
    <div class="section-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="mr-card mr-card-style-1 btn p-0 text-left" onClick="location.href = '/familienhotels/'">
                        <div class="mr-card-img">
                            <img alt="Marti Reisen Famillien Hotels" src="<?php theme_dir() ?>assets/img/homebanner/famillienhotels.jpg">
                        </div>
                        <div class="mr-card-description">
                            <div class="text">
                                <div class="title">
                                    <?php _lang('homepage.card1.title') ?>

                                    <div>
                                        <p>
                                            <?php _lang('homepage.card1.description') ?>
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <div class="buttons">
                                <a  href="/hotels/turkei?type=3&attributes[]=chf&destination%5Btype%5D=country&destination%5Bcode%5D=TR&destination%5Bname%5D=Türkei" class="btn btn-warning btn-rounded">p.P. ab 149€</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="mr-card mr-card-style-1 btn p-0 text-left" onClick="location.href = '/wellnesshotels/'">
                        <div class="mr-card-img">
                            <img alt="Marti Reisen Wellness" src="<?php theme_dir() ?>assets/img/homebanner/wellness.jpg">
                        </div>
                        <div class="mr-card-description">
                            <div class="text">
                                <div class="title">
                                    <?php _lang('homepage.card2.title') ?>

                                    <div>
                                        <p>
                                            <?php _lang('homepage.card2.description') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <a  href="/hotels/turkei?type=3&attributes[]=wel&destination%5Btype%5D=country&destination%5Bcode%5D=TR&destination%5Bname%5D=Türkei" class="btn btn-warning  btn-rounded">p.P. ab 99€</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-sm-0">
                        <div class="mr-card mr-card-style-2 btn p-0 text-left" onClick="location.href = '/fernreisen/'">
                            <div class="mr-card-img">
                                <img alt="Marti Reisen Fernreisen" src="<?php theme_dir() ?>assets/img/homebanner/fernreisen.jpg">
                            </div>
                            <div class="mr-card-description">
                                <div class="text">
                                    <div class="title">
                                        <?php _lang('homepage.card3.title') ?>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <a href="/hotels/indischer-ozean?type=3&destination%5Btype%5D=region&destination%5Bcode%5D=100016&destination%5Bname%5D=Indischer+Ozean" class="btn btn-warning"><?php _lang('homepage.card3.description') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-sm-0">
                        <div class="mr-card mr-card-style-2 btn p-0 text-left" onClick="location.href = '/sports-aktivurlaub/'">
                            <div class="mr-card-img">
                                <img alt="Marti Reisen Aktivurlaub" src="<?php theme_dir() ?>assets/img/homebanner/aktivurlaub.jpg">
                            </div>
                            <div class="mr-card-description">
                                <div class="text">
                                    <div class="title">
                                        <?php _lang('homepage.card4.title') ?>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <a href="/hotels/turkei?type=3&attributes[]=spt&destination%5Btype%5D=country&destination%5Bcode%5D=TR&destination%5Bname%5D=Türkei" class="btn btn-warning "><?php _lang('homepage.card4.description') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-sm-0">
                        <div class="mr-card mr-card-style-2 btn p-0 text-left" onClick="location.href = '/strandhotels'">
                            <div class="mr-card-img">
                                <img alt="Marti Reisen Strandurlaub" src="<?php theme_dir() ?>assets/img/homebanner/strandurlaub.jpg">
                            </div>
                            <div class="mr-card-description">
                                <div class="text">
                                    <div class="title">
                                        <?php _lang('homepage.card5.title') ?>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <a href="/hotels/turkei?type=3&attributes[]=bea&destination%5Btype%5D=country&destination%5Bcode%5D=TR&destination%5Bname%5D=Türkei" class="btn btn-warning"><?php _lang('homepage.card5.description') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section  d-sm-block pt-5 pb-5">
        <div class="section-header section-header mb-5 pb-4">
            <div class="container">
                <div class="text-center">
                    <h2><?php _lang('homepage.block.magazine') ?></h2>
                    <h3><?php _lang('homepage.block.magazine_desc') ?></h3>
                </div>
            </div>
        </div>
        <div class="section-content magazine-carousel-content">
            <div class="container">
                <div id="magazine-slider" class="owl-carousel owl-theme owl-carousel-style-1">
                    <?php foreach ($this->blog_posts as $post) { ?>
                        <div class="item">
                            <a class="mr-card mr-card-style-3" href="<?php echo $post['translate']['url'] ?>">
                                <div class="mr-card-img">
                                    <img alt="Marti Reisen Urlaub Blog" src="/data/image/posts/<?php echo $post['id'] ?>/<?php echo $post['id'] ?>.jpg">
                                </div>
                                <div class="mr-card-description">
                                    <div class="text">
                                        <div class="badge badge-warning"><?php echo \Helper\Config::getDomain()?></div>
                                        <div class="title">
                                            <strong class="d-none">Familienurlaub</strong>                                    
                                            <span><?php echo $post['translate']['name'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


    <div class="section d-none d-sm-block pt-5 pb-5">
        <div class="section-content">
            <div class="container">
                <div class="row">
                    <?php foreach ($this->block_texts as $block) { ?>
                        <div class="col-lg-6">
                            <h2 class="text-center"><?php echo $block['translate']['name'] ?></h2>
                            <div class="mt-3">
                                <?php echo $block['translate']['content'] ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <div class="section d-none d-sm-block pt-5 pb-5">
        <div class="section-content">
            <div class="container">
                <div class="tags">
                    <h2><?php _lang('homepage.block.link_1') ?></h2>
                    <div class="mt-2">
                        <?php foreach ($this->block_links as $link) {
                            if ($link['row'] != 1)
                                continue;
                            ?>
                            <a href="<?php echo $link['translate']['url'] ?>"><?php echo $link['translate']['name'] ?></a>
<?php } ?>
                    </div>
                </div>
                <div class="dashed-divider"></div>
                <div class="tags">
                    <h2><?php _lang('homepage.block.link_2') ?></h2>
                    <div class="mt-2">
                        <?php foreach ($this->block_links as $link) {
                            if ($link['row'] != 2)
                                continue;
                            ?>
                            <a href="<?php echo $link['translate']['url'] ?>"><?php echo $link['translate']['name'] ?></a>
<?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--bestHotels-->
    <div id="best-hotels" class="d-none" v-cloak>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="main-title">
                        <h3 class="main-title-text"><?php _lang('homepage.block.sale') ?></h3>
                    </div>
                    <div v-if="Array.isArray(results)" v-for="(region,index) in bestFiveReg()" class="card mb-3"
                         style="max-width: 540px;">
                        <a v-bind:href="'/search/hotels?sf=2&adults=2&destination[type]=state&destination[name]='+region.children[0].name+'&destination[code]='+region.children[0].code"
                           target='_blank'>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img v-lazy="'/data/image/countries/'+region.code+'/'+region.code+'.jpg'"
                                         class="card-img" v-bind:alt="region.code"/>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="card-content-title">{{region.name}}</h5>
                                                <p class="card-content-text">{{region.children[0].name}}</p>
                                                <p class="card-content-description">
                                                <i class="icon icon-best-hotels-money"></i>
                                                {{Math.ceil(Math.random()*200)}} Menschen gekauft
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card-icons">
                                                    <i class="icon icon-best-hotels-plane"></i>
                                                    <i class="icon icon-best-hotels-building"></i>
                                                    <i class="icon icon-best-hotels-swimming"></i>
                                                </div>

                                                <div class="card-content-stars">
                                                    <i v-for='i in region.star' class="fas fa-star text-danger"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="best-hotels-button">
                        <a class="button" href="/search/region?sf=2&adults=2" title="">
<?php _lang('search.other_regions') ?>
                            <span class="icons">
                                <i class="icon icon-best-hotels-arrow-right"></i>
                                <i class="icon icon-best-hotels-arrow-right-active"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="main-title">
                        <h3 class="main-title-text"><?php _lang('homepage.block.favourite') ?></h3>
                    </div>
                    <div v-if="Array.isArray(results)" v-for="(hotel,index) in bestFiveFav()" class="card mb-3"
                         style="max-width: 540px;">
                        <a v-bind:href="'/hotel/'+hotel.name_sef+'?sf=2&adults=2&destination[type]=hotel&destination[name]='+hotel.name+'&destination[code]='+hotel.gid_id"
                           target='_blank'>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img v-lazy="'https://thumbnails.travel-it.com/g2thmb.php?gid='+hotel.gid_id"
                                         class="card-img" alt="..."/>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="card-content-title">{{hotel.name}}</h5>
                                                <p class="card-content-text">{{hotel.city_title}}</p>
                                                <p class="card-content-description">
                                                <i class="icon icon-best-hotels-money"></i>
                                                {{Math.ceil(Math.random()*200)}} Menschen gekauft
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card-icons">
                                                    <i class="icon icon-best-hotels-plane"></i>
                                                    <i class="icon icon-best-hotels-building"></i>
                                                    <i class="icon icon-best-hotels-swimming"></i>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--recommendedEnd-->
    <script src="<?php theme_dir() ?>assets/js/vue/home.js?v=2"></script>
