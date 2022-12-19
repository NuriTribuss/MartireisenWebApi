<style>
    .swiper-container {
        height: 400px;
    }
</style>

<div>
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <a href="/tour" title=""><?php _lang('menu.tours') ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span><?php echo $this->data['title'] ?></span></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php $this->render('tour/search-steps') ?>

    <div id="results">
        <div class="container">
            <div class="results">

                <div class="results-right col-md-12">
                    <div class=" row mb-3" >

                        <div class="results-hotel-info-right col-12 col-md-12"  >
                            <div class="results-hotel-info-right-top">
                                <h3 class="results-hotel-info-title mt-lg-2 mt-4 mb-4" style="font-size: 26px"><?php echo $this->data['title'] ?></h3>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <i class="far fa-clock text-secondary"></i>
                                                <span class="ml-2"><?php _lang('tour.tour_type') ?>: <?php echo $this->data['type'] ?></span>
                                            </div>
                                            <div class="col-lg-6">
                                                <i class="fas fa-map-marker-alt m-0 text-secondary"></i>
                                                <span class="ml-2"><?php _lang('tour.departure') ?>: <?php echo $this->data['departure_place'] ?></span>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <i class="fas fa-map-marker-alt mr-0 text-secondary"></i>
                                                <span class="ml-2"><?php _lang('tour.arrival') ?> : <?php echo $this->data['destination'] ?></span>
                                            </div>
                                            <div class="col-lg-6">
                                                <i class="fas fa-calendar-alt mr-0 text-secondary"></i>
                                                <?php if ((int) $this->data['period']['id'] <= 0) { ?>
                                                    <span class="text-danger ml-2" ><?php _lang('tour.tour_period_message') ?> </span>
                                                <?php } else { ?>
                                                    <span class="ml-2"><?php _lang('tour.date') ?> : <?php echo date('d.m.Y', $this->data['period']['start_date']) ?> - <?php echo date('d.m.Y', $this->data['period']['end_date']) ?>
                                                        <?php $day = day_calculate($this->data['period']['start_date'], $this->data['period']['end_date']);
                                                        if($day > 0 ){
                                                           echo  '<span>(' . ($day) . ' ' . _lang('tour.night',true) . ' </span><span>' . ($day + 1) . ' ' . _lang('tour.day',true) . ' )</span>' ;
                                                        }
                                                        ?>
                                                    </span>
<?php } ?>
                                            </div>
                                            <div class="col-lg-6 d-none">
                                                <i class="fas fa-user-friends m-0 text-secondary"></i>
                                                <span class="ml-2"><?php _lang('tour.max_person') ?>: <?php echo $this->data['period']['available_count'] ?></span>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <i class="fas fa-bus mr-0 text-secondary"></i>
                                                <span class="ml-2"><?php _lang('tour.transfer') ?> <?php echo $this->data['period']['transfer'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <p><?php echo $this->data['content'] ?></p>
                            <div class="mt-4 mb-4 ">
                                <div class="">
                                    <h5 class="mb-4 text-primary"><?php _lang('tour.tour_program_title') ?> </h5>
                                </div>
                                <div class="">
                                    <?php foreach ($this->data['properties'] as $property) {
                                        if ($property['is_free'] == 0)
                                            continue;
                                        ?>
                                        <p>
                                        <i class="fas fa-check-circle mr-2 text-success"></i><?php echo $property['title'] ?>
                                        </p>
<?php } ?>
                                </div>

                            </div>
                            <div class="mt-4 mb-4 ">
                                <div class="">
                                    <h5 class="mb-4 text-primary"> <?php _lang('tour.not_included_in_the_price') ?> </h5>
                                </div>
                                <div class="">
<?php foreach ($this->data['properties'] as $property) {
    if ($property['is_free'] == 1 || $property['is_static'] == 1)
        continue;
    ?>
                                        <p>
                                        <i class="fas fa-minus-circle mr-2 text-warning"></i><?php echo $property['title'] ?> <?php echo (int) $property['price'] > 0 ? '( ' . $property['price'] . ' € )' : '' ?>
                                        </p>
<?php } ?>
                                </div>

                            </div>

                          
                        </div>
                        <div class="col-lg-4">
                            <div class="" id="tour-reservation">
                                <div class="card" >
                                    <div class="card-body" v-if="booking.period_id > 0 ">

                                        <div class="card-text mb-3">
                                            <i class=" fas fa-user"></i>
<?php _lang('tour.available_seat') ?> {{period.available_count}}
                                        </div>

                                        <div class="form-group" >
                                            <div data-selectbox="root" class="selectbox selectbox-results">
                                                <div class="selectbox-results-select">
                                                    <select v-on:change="changePeriod()" class="form-control" v-model="booking.period" class="form-control form-control-lg">
                                                        <option v-for="period in periods" v-bind:value="period">{{period.start_date_pretty}}</option>
                                                    </select>
                                                </div>
                                                <div class="selectbox-results-button">
                                                    <button type="button" class="button">
                                                        <span class="selectbox-results-button-text">
                                                            <span class="selectbox-results-button-text-title"> <?php _lang('tour.tour_date') ?></span>
                                                            <span data-selectbox="text" class="selectbox-results-button-text-value">{{period.start_date_pretty}}</span>
                                                        </span>
                                                        <span class="selectbox-results-button-icon"><i class="icon icon-selectbox-caret"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div data-selectbox="root" class="selectbox selectbox-results">
                                                <div class="selectbox-results-select">
                                                    <select v-on:change="changeStation()" v-model="booking.station_id" id="departure" class="form-control form-control-lg">
                                                        <option v-for="station in period.stations" v-bind:value="station.id">{{station.station}} {{station.hour}}</option>
                                                    </select>
                                                </div>
                                                <div class="selectbox-results-button">
                                                    <button type="button" class="button">
                                                        <span class="selectbox-results-button-text">
                                                            <span class="selectbox-results-button-text-title"> <?php _lang('tour.departure') ?> </span>
                                                            <span data-selectbox="text" class="selectbox-results-button-text-value">{{activeStation}}</span>
                                                        </span>
                                                        <span class="selectbox-results-button-icon"><i class="icon icon-selectbox-caret"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="adult_1"> <?php _lang('tour.adult_count') ?> </label>
                                                    <select v-model="booking.adult" class="form-control" id="adult_1">
                                                        <option v-for="n in 15">{{n}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" v-show="booking.child_price > 0 ">
                                                <div class="form-group">
                                                    <label for="child_1"> <?php _lang('tour.children_count') ?> </label>
                                                    <select v-model="booking.children" class="form-control" id="child_1">
                                                        <option v-for="n in 10">{{n-1}}</option> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button  v-on:click="book" class="btn btn-primary btn-block"> <?php _lang('tour.make_a_reservation') ?> ({{totalPrice}} €)</button>
                                        <div class="text-center mt-2 mb-2"><?php _lang('tour.or') ?></div>
                                        <a class="btn btn-success btn-block text-white" target="_blank"
                                           href="https://api.whatsapp.com/send?phone=4312366060&text=Merhaba, <?php echo $this->data['title'] ?> hakkında Bilgi Almak İstiyorum"
                                           ><i class="mr-2 fab fa-whatsapp"></i><?php        _lang('tour.whatsapp')?>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-none" id="period-table">
                                    <table class="table table-striped table-bordered mt-4">
                                         <thead>
                                           <tr>
                                             <th scope="col"><?php _lang('tour.tour_date')?></th>
                                             <th scope="col"><?php _lang('tour.available_count')?></th>
                                             <th scope="col">#</th>
                                           </tr>
                                         </thead>
                                         <tbody>
                                           <tr v-for="period in periods">
                                             <td>{{ period.start_date_pretty }}</td>
                                             <td>{{ period.available_count }}</td>
                                             <td > 
                                                 <button v-bind:data-id="period.id" v-if="period.available_count > parseInt(booking.children) + parseInt(booking.adult) " class="btn btn-warning btn-sm btn-block p-1 selectPeriod" >Seç</button>
                                             </td>
                                           </tr>
                                         </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills mb-4 mt-4 custom-tab  mx-auto justify-content-center d-flex flex-md-row flex-column"  id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#pills-plan"  aria-controls="pills-plan" role="tab" aria-selected="true"><?php _lang('tour.tour_plan') ?> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#pills-map" aria-controls="pills-map" role="tab"  aria-selected="false"><?php _lang('tour.map') ?> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#pills-photo" aria-controls="pills-photo" role="tab" aria-selected="false"><?php _lang('tour.pictures') ?> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#pills-video" aria-controls="pills-video" role="tab" aria-selected="false"><?php _lang('tour.video') ?> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#pills-agreegment" aria-controls="pills-agreegment" role="tab" aria-selected="false"><?php _lang('tour.important_notes_and_warnings') ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content active" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-plan" role="tabpanel" aria-labelledby="pills-plan">
                                    <ul class="timeline">
<?php foreach ($this->data['plans'] as $plan) { ?>
                                            <li class="timeline-item bg-white rounded ml-sm-3 ml-2 p-sm-4 p-3 shadow">
                                                <div class="timeline-arrow"></div>
                                                <h2 class="h5 mb-3 text-primary font-weight-bold"><?php echo $plan['title'] ?></h2>
                                                <p class="text-small mt-2 font-weight-light"> <?php echo nl2br($plan['content']) ?></p>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map">
<?php echo $this->data['map'] ?>
                                </div>
                                <div class="tab-pane fade" id="pills-photo" role="tabpanel" aria-labelledby="pills-photo">
                                    <div class="row" id="lightgallery">
<?php foreach ($this->data['images'] as $image) { ?>
                                            <div class="col-lg-3  p-2">
                                                <a href="<?php echo $image['image'] ?>">
                                                    <img  class="w-100" src="<?php echo $image['image'] ?>" alt="<?php echo $this->data['title']?>"/>
                                                </a>
                                            </div>
<?php } ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video">
                                    <div class="row">
<?php foreach ($this->data['videos'] as $video) { ?>
                                        <div class="col-lg-6  p-2">
                                            <?php echo $video['embed']?>
                                        </div>
<?php } ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade text-center pt-4 pb-4 bg-light" id="pills-agreegment" role="tabpanel" aria-labelledby="pills-agreegment">
<?php echo nl2br($this->data['agreegment']) ?> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="results-hotel-tab mt-4 d-none">
                        <div class="results-hotel-tab-buttons" data-slider-buttons="result-hotel-tab">
                            <button class="button" v-bind:class="{'active' : hotelTab == 1}" v-on:click="hotelTab = 1" type="button" ><?php _lang('hotels.tab_1'); ?></button>
                            <button class="button d-none" v-bind:class="{'active' : hotelTab == 2}" v-on:click="hotelTab = 2" type="button" ><?php _lang('hotels.tab_2'); ?></button>
                            <button class="button" v-bind:class="{'active' : hotelTab == 3}" v-on:click="hotelTab = 3" type="button" ><?php _lang('hotels.tab_3'); ?></button>
                        </div>
                        <div class="results-hotel-tab-content">
                            <div class="" data-slider="result-hotel-tab">

                            </div>
                        </div>
                    </div>
                </div>
<?php //$this->render('tour/detail-right')  ?>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="<?php theme_dir() ?>assets/css/magnific-popup.css"/>
<script src="<?php theme_dir() ?>assets/js/jquery/jquery.magnific-popup.min.js"></script>

<link type="text/css" rel="stylesheet" href="<?php theme_dir() ?>assets/css/lightgallery.min.css" /> 
<script src="<?php theme_dir() ?>assets/js/lightgallery-all.min.js"></script>

<script>
window.addEventListener("load", function (event) {

    $(function () {
        var hash = window.location.hash;
        if (hash) {
            $('ul.nav.nav-pills a[href="' + hash + '"]').tab('show');
            $([document.documentElement, document.body]).animate({
                scrollTop: $('ul.nav.nav-pills').offset().top
            }, 2000);
        }
        $('ul.nav.nav-pills a').click(function (e) {
            $(this).tab('show');
            window.location.hash = this.hash;

        });
        
    });

});


window.addEventListener("load", function (event) {

    window.TourApp = new Vue({

        el: '#tour-reservation',
        data: {
            booking: {
                tour_id: <?php echo $this->data['id'] ?>,
                period_id: <?php echo (int) $this->data['period']['id'] ?>,
                station_id:<?php echo (int) $this->data['period']['stations'][0]['id'] ?>,
                adult: 1,
                children: 0,
                price: <?php echo (int) $this->data['period']['stations'][0]['price'] ?>,
                child_price: <?php echo (int) $this->data['period']['stations'][0]['child_price'] ?>,
                period: {},
            },
            activeStation: '<?php echo $this->data['period']['stations'][0]['station'] ?>',
            period: JSON.parse('<?php echo json_encode($this->data['period']) ?>'),
            periods: JSON.parse('<?php echo json_encode($this->data['periods']) ?>'),
        },
        methods: {
            changeStation: function () {

                var activeStation = '';
                for (var i = 0; i < this.period.stations.length; i++) {
                    if (this.period.stations[i].id == this.booking.station_id) {
                        activeStation = this.period.stations[i];
                    }
                }
                this.activeStation = activeStation.station;
                this.booking.price = activeStation.price;
                if (activeStation.child_price < 0) {
                    this.booking.child_price = activeStation.child_price;
                }
            },

            changePeriod: function () {
                this.period = this.booking.period;
                this.activeStation = this.period.stations[0].station;

                this.booking.price = this.period.stations[0].price;
                if (this.period.stations[0].child_price > 0) {
                    this.booking.child_price = this.period.stations[0].child_price;
                }
            },
            
            selectPeriod (id){
                
                for (var i = 0; i < this.periods.length; i++) {
                    if (this.periods[i].id == id) {
                        this.booking.period = this.periods[i];
                    }
                }
                this.changePeriod();
                swal.close();
            },

            book: function () {
                
                let _self = this;
                
                axios.post('/service/tours/create', this.booking).then(function (response) {
                    if (response.data.status) {
                        location.href = '/tour/booking';
                    }else{
                        
                        var span = document.createElement("div");
                        span.innerHTML = Marti.Locale.get('tour.available_error_desc') + '<br>' + $("#period-table").html();
                        swal({
                            title: Marti.Locale.get('tour.available_error_title') ,
                            content: span,
                            allowOutsideClick: "true" 
                        });
                    }
                });
            }
        },
        computed: {
            totalPrice: function () {
                var childPrice = parseInt(this.booking.child_price) > 0 ? parseInt(this.booking.child_price) : parseInt(this.booking.price);
                return (parseInt(this.booking.price) * parseInt(this.booking.adult)) + (parseInt(this.booking.children) * childPrice);
            }
        },
        created: function () {
            this.booking.period = this.period;
        }
    });
    
    $(document).on('click','.selectPeriod',function(){
        window.TourApp.selectPeriod($(this).data('id'))
    })
});


    
window.addEventListener("load", function (event) {
        
    fbq('track','ViewContent',{ 
        content_name     : TourDetail.title, 
        content_category : 'Tour',
        content_type     : 'product', 
        content_ids      : [TourDetail.id], 
        value            : TourDetail.price,
        currency         : Marti.Member.currency,
    }); 
        
});
   

</script>

