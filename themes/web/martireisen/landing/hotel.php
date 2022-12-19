<style>
    #search {
        background: none;
    }

    #page-header .page-header .page-header-about-us .page-header-about-us-title {
        font-size: 30px;
    }

    #page-header .page-header-container {
        height: auto;
    }

    .tab-content {
        display: block;
    }

    .landing-offer .spinner-border {
        vertical-align: inherit;
        border-width: .15rem;
    }
</style>
<script>
    var LatLng =  {lat: <?php echo $this->hotel['location']['latitude']?>, lng: <?php echo $this->hotel['location']['longitude']?>};
    var HOTEL_ID = '<?php echo $this->hotel['info']['id']?>';
</script>

<div >
    <div id="page-header" class="bg-about-us " style="background-image:url('/data/image/default-bg.jpg')">
        <div class="container page-header-container pt-lg-5">
            <div class="page-header col-12 col-md-6">
                <div class="page-header-about-us">
                    <div class="page-header-about-us-title"><h1
                                class="font-weight-bold"><?php echo $this->landing['translate']['title'] ?></h1></div>
                    <div class="page-header-about-us-text">
                        <?php for($i=0 ; $i < $this->hotel['info']['star']; $i++) { ?>
                            <i class=" fa fa-star  text-secondary mr-1"></i>
                        <?php } ?>
                        <span><?php echo $this->hotel['info']['city']['name']?> / <?php echo $this->hotel['info']['country']['name']?></span>
                    </div>
                </div>
            </div>
            <div class="page-header col-12 offset-2 col-md-4">
                <div class="page-header-like">
                    <div class="page-header-like-recommended pt-3 pb-3">
                        <div class="page-header-like-recommended-text">
                            Recommendation %<?php echo $this->hotel['reviews']['suggests']?>
                        </div>
                        <div class="page-header-like-recommended-progress">
                            <div class="page-header-like-recommended-progress-current"  style="width: <?php echo $this->hotel['reviews']['suggests'] ?>%">

                            </div>
                        </div>
                    </div>
                    <div class="page-header-like-comment pt-3 pb-3" >
                        <div class="page-header-like-comment-count">
                            <i class="far fa-thumbs-up mr-2 "></i> <?php echo $this->hotel['reviews']['average']?>
                        </div>
                        <div class="page-header-like-comment-text">
                            Guest Comment
                        </div>
                        <div class="page-header-like-comment-title">
                            <?php echo $this->hotel['reviews']['review_count']?> comments
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        </div>
    </div>
    <div id="breadcrumb" class="mt-1 mb-1">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="#"><?php echo $this->hotel['regionName'] ?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo $this->hotel['zielName'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span><?php echo $this->hotel['hotelName'] ?></span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="main-title">
            <h3 class="main-title-text mt-3"><?php echo $this->hotel['info']['name'] ?></h3>
        </div>

        <div class="row">
            <div class="col-12">
                <div id="top-hotels" class="pt-2">
                    <div class="top-hotels-header">
                        <div class="top-hotels-buttons">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item col-6 col-lg-3">
                                    <a data-toggle="tab" href="#general" role="tab" aria-controls="general"
                                       aria-selected="true" class="button active rounded-0">
                                        <i class="fa fa-bed mr-2"></i>
                                        Hotelinfos
                                    </a>
                                </li>
                                <li class="nav-item col-6 col-lg-3">
                                    <a data-toggle="tab" href="#review" role="tab" aria-controls="review"
                                       aria-selected="true" class="button rounded-0">
                                        <i class="fa fa-comments mr-2"></i>
                                        Bewertungen
                                    </a>
                                </li>
                                <li class="nav-item col-6 col-lg-3">
                                    <a id="home-tab3" data-toggle="tab" href="#location" role="tab"
                                       aria-controls="location" aria-selected="true" class="button rounded-0 ">
                                        <i class="fa fa-map mr-2"></i>
                                        Landkarte
                                    </a>
                                </li>
                                <li class="nav-item col-6 col-lg-3 ">
                                    <a id="home-tab4" data-toggle="tab" href="#weather" role="tab"
                                       aria-controls="weather" aria-selected="true" class="button rounded-0 ">
                                        <i class="fa fa-temperature-high mr-2"></i>
                                        Klima & Wetter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content col-12"   >
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="row">
                        <div class="col-12 col-lg-8 ">
                            
                            <div class="results-hotel-info row mb-3">
                                <div class="results-hotel-info-left col-12">

                                    <div style="height:500px" >
                                        <div id="hotelinfoSlider" class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <?php foreach( $this->hotel['images'] as $image){ ?>
                                                <div class="swiper-slide">
                                                    <div class="results-hotel-info-thumbnail-slider-item  w-100" 
                                                         style="background-repeat : no-repeat;  background-position: center; background-image: url('<?php echo $image['url']?>') ">
                                                        <a data-caption="<?php echo $image['name']?>"  src="<?php echo $image['url']?>">
                                                           
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <div class="results-hotel-info-slider-meta mt-2" >
                                        <div class="results-hotel-info-slider-meta-right">
                                            <div class="results-hotel-info-thumbnail-slider" style="height:100px">
                                                <div id="hotelinfoSliderThumbnails" class="swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <?php foreach( $this->hotel['images'] as $image){ ?>
                                                        <div class="swiper-slide" style='height:120px'>
                                                            <div class="results-hotel-info-thumbnail-slider-item w-100 h-100"
                                                                  style="background-repeat : no-repeat ; background-size: cover; background-image: url('<?php echo $image['url']?>') ">
                                                                
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 " id="hotel-app">
                            <div class="card border-0 rounded-0">
                                <div class="row align-items-center ">
                                    <div class="col-12 mx-auto hotel-landing-offer">
                                        <div class="card-body bg-light p-0 pt-4 border-primary justify-content-center">
                                            <p class="text-center hotel-landing-offer-title ">Pauschalreise</p>
                                            <p class="mb-4 mt-2 text-center" v-if="offer.pauschal.hotelOffer">{{offer.pauschal.hotelOffer.travelDate.duration}} Tage,
                                                {{offer.pauschal.hotelOffer.boardType.name}}</p>
                                            <div class="row">
                                                <div class="col-12 col-lg-12 landing-offer" v-on:click="makeUrl(2)">

                                                    <div class="offer-p-left float-left h-100 "  v-if="offer.pauschal"><small>ab</small>
                                                        <div class="spinner-border spinner-border-sm "
                                                             v-show="!offer.pauschal.personPrice.value" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        €{{offer.pauschal.personPrice.value}}
                                                    </div>
                                                    <button class="offer-p-right btn btn-primary h-100 rounded-0 float-right"
                                                            v-on:click="makeUrl(2)"><i class="fa fa-arrow-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning d-none" v-show="offer.pauschal.error">
                                        <?php _lang('offer.no_result')?>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 rounded-0 mt-4">
                                <div class="row align-items-center ">
                                    <div class="col-12 mx-auto hotel-landing-offer">
                                        <div class="card-body bg-light p-0 pt-4 border-primary justify-content-center">
                                            <p class="text-center hotel-landing-offer-title ">Nur Hotel</p>
                                            <div >
                                                <p class="mb-4 mt-2 text-center" v-if="offer.hotel.hotelOffer">{{offer.hotel.hotelOffer.travelDate.duration}} Tage,
                                                {{offer.hotel.hotelOffer.boardType.name}}</p>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 landing-offer" v-on:click="makeUrl(3)">
                                                        <div class="offer-p-left float-left h-100 "><small>ab</small>
                                                            <div class="spinner-border spinner-border-sm "
                                                             v-show="!offer.hotel.personPrice.value" role="status">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                        €{{offer.hotel.personPrice.value}}
                                                        </div>
                                                        <button class="offer-p-right btn btn-primary h-100 rounded-0 float-right"
                                                                v-on:click="makeUrl(3)"><i class="fa fa-arrow-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="alert alert-warning d-none" v-show="offer.hotel.error">
                                        <?php _lang('offer.no_result')?>
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-0 border-0 mt-5 ">
                                <div class="row align-items-center ">
                                    <div class="col-12 mx-auto">
                                        <div class="card-body bg-light  border-primary justify-content-center">
                                            <ul class="list-unstyled mt-3">
                                                <li class="font-weight-bold mb-2"><i class="fas fa-check mr-3 text-success "></i>{{offer.pauschal.hotelOffer.boardType.name}}
                                                </li>
                                                <li class="font-weight-bold mb-2"><i class="fas fa-check mr-3 text-success"></i>{{offer.pauschal.hotelOffer.roomType.name}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hotel-content mt-3">
                        <?php echo $this->landing['translate']['content'] ?>
                    </div>
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <div class="card w-100 rounded-0 mb-3 hotel-offer d-none">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12 col-lg-2">
                                        <img src="<?php theme_dir() ?>assets/img/landing/offer1.png"/>
                                    </div>
                                    <div class="col-lg-8">

                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <div class="results-item-discount float-left mt-5 hotel-price">
                                            <small>ab</small>
                                            €369
                                        </div>
                                        <button class="btn btn-primary h-100 rounded-0 float-right">
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade row" id="review" role="tabpanel">
                    <div class="col-12" style="height:800px" id="review-app">
                        <iframe data-src="https://review.holidaycheck.com/de/traffics/<?php echo $this->hotel['reviews']['id'] ?>" class="h-100" style="width:100%;border:none;"></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="location" role="tabpanel">
                    <div id="mapModal">
                        <div id="map"></div>
                        <div class="infobox">
                            <div class="row" >
                                <div class="col--4 col-lg-5">
                                    <img src="https://thumbnails.travel-it.com/g2thmb.php?gid=<?php echo $this->hotel['info']['id'] ?>" alt="Hotel - <?php echo $this->hotel['info']['name'] ?>"/>
                                </div>
                                <div class="col--8 col-lg-7">
                                    <?php echo $this->hotel['info']['name'] ?>
                                    <div class="map-stars">
                                        <?php for($i=0 ; $i < $this->hotel['info']['star']; $i++) { ?>
                                            <i class="icon icon-results-star"></i>
                                        <?php } ?>
                                    </div>
                                    <div class="map-review">
                                        <img src="<?php theme_dir() ?>assets/img/holiday.check.svg"  alt="Holiday Check"/>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="weather" role="tabpanel">

                    <div class="weather-box">
                        <div class="weather-box-header">
                            <h4>Klima & Wetter</h4>
                        </div>
                        <div class="weather-box-content">
                            <div class="mt-2 mb-4" id="weather-app">
                                <div class="weather-box-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mt-2 mb-2">
                                                <span> Aktuelle Wettervorhersage für <?php echo $this->hotel['info']['city']['name']?> / <?php echo $this->hotel['info']['country']['name']?></span>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <span class="text-primary">
                                                    Donnerstag <?php echo date('d.m.Y')?>   
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ?>
                                    <div class="row pl-2 pr-2 pt-3" v-show="weatherData.weather">
                                        <div class="col-sm-custom">
                                            <div class="weather-box-widget">
                                                <div class="weather-box-widget-icon">
                                                    <img v-bind:src="'http://openweathermap.org/img/wn/'+weatherData.weather[0].icon+'@2x.png'" alt="weather"/>
                                                </div>
                                                <div class="weather-box-widget-text">
                                                    <span>Wetter</span>
                                                    <span>{{ weatherData.weather[0].description }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-custom">
                                            <div class="weather-box-widget">
                                                <div class="weather-box-widget-icon">
                                                    <img src="<?php theme_dir() ?>assets/img/icons/2.png" alt="weather"/>
                                                </div>
                                                <div class="weather-box-widget-text">
                                                    <span>tagsüber</span>
                                                    <span>{{ weatherData.main.temp }} °C</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-custom">
                                            <div class="weather-box-widget">
                                                <div class="weather-box-widget-icon">
                                                    <img src="<?php theme_dir() ?>assets/img/icons/3.png" alt="weather"/>
                                                </div>
                                                <div class="weather-box-widget-text">
                                                    <span>nachts</span>
                                                    <span>{{ weatherData.main.feels_like }}  °C</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-custom">
                                            <div class="weather-box-widget">
                                                <div class="weather-box-widget-icon">
                                                    <img src="<?php theme_dir() ?>assets/img/icons/1.png" alt="weather"/>
                                                </div>
                                                <div class="weather-box-widget-text">
                                                    <span>Regen</span>
                                                    <span>{{ weatherData.clouds.all }} %</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-custom">
                                            <div class="weather-box-widget">
                                                <div class="weather-box-widget-icon">
                                                    <img src="<?php theme_dir() ?>assets/img/icons/4.png" alt="weather"/>
                                                </div>
                                                <div class="weather-box-widget-text">
                                                    <span>Wind</span>
                                                    <span>{{ weatherData.wind.speed}} km/h</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ?>
                                </div>
                            </div>

                            <div class="mt-2 mb-4 d-none">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="weather-box-card">
                                            <div class="weather-box-card-header">
                                                <strong>Freitag 27.03.2020</strong>
                                            </div>
                                            <div class="weather-box-card-content">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/1.png"  alt="weather"/> <span> Wetterlage  </span>
                                                        <strong>Gewitter</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/2.png"  alt="weather" />
                                                        <span> Tagsüber  </span> <strong>13 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/3.png"  alt="weather"/>
                                                        <span> Nachts  </span> <strong>8 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/4.png"  alt="weather"/> <span> Regenrisiko  </span>
                                                        <strong>60%</strong>
                                                    </li>
                                                   
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="weather-box-card">
                                            <div class="weather-box-card-header">
                                                <strong>Freitag 27.03.2020</strong>
                                            </div>
                                            <div class="weather-box-card-content">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/1.png"  alt="weather"/> <span> Wetterlage  </span>
                                                        <strong>Gewitter</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/2.png"  alt="weather"/>
                                                        <span> Tagsüber  </span> <strong>13 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/3.png"  alt="weather"/>
                                                        <span> Nachts  </span> <strong>8 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/4.png"  alt="weather"/> <span> Regenrisiko  </span>
                                                        <strong>60%</strong>
                                                    </li>
                                                   
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="weather-box-card">
                                            <div class="weather-box-card-header">
                                                <strong>Freitag 27.03.2020</strong>
                                            </div>
                                            <div class="weather-box-card-content">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/1.png"  alt="weather"/> <span> Wetterlage  </span>
                                                        <strong>Gewitter</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/2.png"  alt="weather"/>
                                                        <span> Tagsüber  </span> <strong>13 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/3.png"  alt="weather"/>
                                                        <span> Nachts  </span> <strong>8 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/4.png"  alt="weather"/> <span> Regenrisiko  </span>
                                                        <strong>60%</strong>
                                                    </li>
                                                  
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="weather-box-card">
                                            <div class="weather-box-card-header">
                                                <strong>Freitag 27.03.2020</strong>
                                            </div>
                                            <div class="weather-box-card-content">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/1.png"  alt="weather"/> <span> Wetterlage  </span>
                                                        <strong>Gewitter</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/2.png"  alt="weather"/>
                                                        <span> Tagsüber  </span> <strong>13 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/3.png"  alt="weather"/>
                                                        <span> Nachts  </span> <strong>8 °C</strong>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <img src="<?php theme_dir() ?>assets/img/icons/4.png"  alt="weather"/> <span> Regenrisiko  </span>
                                                        <strong>60%</strong>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mt-2 d-none">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="weather-box-card">
                                            <div class="weather-box-card-header">
                                                <strong>Klimaübersicht</strong>
                                            </div>
                                            <div class="weather-box-card-content">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered weather-box-table">
                                                        <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td><strong>Jan</strong></td>
                                                            <td><strong>Feb</strong></td>
                                                            <td><strong>Mrz</strong></td>
                                                            <td><strong>Apr</strong></td>
                                                            <td><strong>Mai</strong></td>
                                                            <td><strong>Jun</strong></td>
                                                            <td><strong>Jul</strong></td>
                                                            <td><strong>Aug</strong></td>
                                                            <td><strong>Sep</strong></td>
                                                            <td><strong>Okt</strong></td>
                                                            <td><strong>Nov</strong></td>
                                                            <td><strong>Dez</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="first">
                                                                <img src="<?php theme_dir() ?>assets/img/icons/1.png"  alt="weather"/>
                                                                <span>Temperatur Luft max. °C</span>
                                                            </td>
                                                            <?php foreach($this->hotel['climate']['rain'] as $item) { ?>
                                                                <td ><?php echo $item ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="first">
                                                                <img src="<?php theme_dir() ?>assets/img/icons/2.png"/>
                                                                <span>Temperatur Luft max. °C</span>
                                                            </td>
                                                            <?php foreach($this->hotel['climate']['dayTemperature'] as $item) { ?>
                                                                <td ><?php echo $item ?></td>
                                                            <?php } ?>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td class="first">
                                                                <img src="<?php theme_dir() ?>assets/img/icons/3.png"/>
                                                                <span>Temperatur Luft max. °C</span>
                                                            </td>
                                                            <?php foreach($this->hotel['climate']['nightTemperature'] as $item) { ?>
                                                                <td ><?php echo $item ?></td>
                                                            <?php } ?>
                                                            
                                                        </tr>
                                                   
                                                        <tr>
                                                            <td class="first">
                                                                <img src="<?php theme_dir() ?>assets/img/icons/8.png"/>
                                                                <span>Temperatur Luft max. °C</span>
                                                            </td>
                                                            <?php foreach($this->hotel['climate']['waterTemperature'] as $item) { ?>
                                                                <td ><?php echo $item ?></td>
                                                            <?php } ?>
                                                           
                                                        </tr>
                                                        <tr>
                                                            <td class="first">
                                                                <img src="<?php theme_dir() ?>assets/img/icons/9.png"/>
                                                                <span>Temperatur Luft max. °C</span>
                                                            </td>
                                                            <?php foreach($this->hotel['climate']['sunshine'] as $item) { ?>
                                                                <td ><?php echo $item ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                        </tbody>
                                                    </table>
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

        </div>
        <?php $this->render('landing/footer/standart') ?>
        <div class="mb-5"></div>
    </div>
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
<script src="<?php theme_dir() ?>assets/js/vue/landing-hotel.js?<?php echo time() ?>"></script>
<link rel="stylesheet" href="<?php theme_dir() ?>assets/photoswipe/photoswipe.css"/>
<link rel="stylesheet" href="<?php theme_dir() ?>assets/photoswipe/default-skin/default-skin.css">

<script src="<?php theme_dir() ?>assets/photoswipe/photoswipe.min.js"></script>
<script src="<?php theme_dir() ?>assets/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoaWZ5rdu9j4gWtMs0dFGMhuTJQarcQnU"></script>
