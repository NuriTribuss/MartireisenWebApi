<div >
    
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <a href="/tour" title="Home"><?php _lang('menu.tours')?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('search.results')?></span></li>
                </ol>
            </nav>
        </div>
    </div>
    <?php $this->render('tour/search-steps')?>

    <div id="results">
            <!-- Modal -->
        <?php if(count($this->tabs) > 0 ) { ?>
        <div id="top-hotels" class="d-none d-sm-block" v-cloak>

            <div class="container">
                <div class="main-title center">
                    <h3 class="main-title-text"> <?php _lang('tours.tab')?></h3>
                </div>
                <div class="top-hotels-header">
                    <nav>
                        <div class="top-hotels-buttons"  role="tablist" id="myTab">
                            <?php foreach($this->tabs as $key =>  $tab) { ?>
                            <button role="tab" class="button nav-link <?php echo $key == 0 ? 'active' : ''?>" data-toggle="tab" href="#t<?php echo $tab['id']?>" ><?php echo $tab['translate']['name']?></button>
                            <?php } ?>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="top-hotels-main">

                <div class="container tab-content d-block" id="myTabContent">
                    <?php foreach($this->tabs as $key =>  $country) {  ?>
                    <div  class="tab-pane fade show <?php echo $key == 0 ? 'active' : ''?>" id="t<?php echo $country['id']?>"  role="tabpanel">
                        <div class="swiper-container " >
                            <div class="swiper-wrapper row ml-1">
                                <?php foreach($country['children'] as $item) { ?>
                                <div class="swiper-slide col-12 col-lg-3 pr-lg-2 pl-lg-2"  style="">
                                    <a class="top-hotels-slider-item" href="<?php echo SITE_URL.'/'.$item['seo_url']?>/" >
                                        <div class="top-hotels-slider-item-image">
                                            <div class="w-100" style="height:270px; background-size:cover; background-image:url('<?php echo SITE_URL.'/'.$item['image']?>')"></div>
                                        </div>
                                        <div class="top-hotels-slider-item-content p-3">
                                            <div class="top-hotels-slider-item-content-header">
                                                <div class="w-100">
                                                    <h3 class="tour-title"><?php echo $item['title']?></h3>
                                                    <h5 class="top-hotels-slider-item-content-header-sub-title">
                                                        <?php echo $item['departure_place']?> >  <?php echo $item['destination']?> 
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="top-hotels-slider-item-content-day">
                                                        <i class="icon icon-top-hotels-day"></i>
                                                        <?php echo date('d.m.Y',$item['period']['start_date'])?>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <?php if($item['base_price'] > 0) { ?>
                                                    <div class="text-discount text-right text-nowrap">€ <?php echo $item['base_price'] ?></div>
                                                    <?php }?>
                                                    <div class="results-item-header-money text-right text-nowrap"  style="font-size:22px">€ <?php echo $item['price'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>    
        <?php } ?>
        <div class="container">
            
            <div class="results">
                <?php  //$this->render('tour/list-left')?>
                <div class="results-right col-12 col-md-12 mt-3 mt-lg-0">
                    <div class="results-title">
                        <div class="results-title-left">
                            <h4 class="results-title-text">
                                <?php echo isset($this->title) ? $this->title : _lang('tours.title')?>
                            </h4>
                            <p class="results-title-description">
                                <?php _lang('tours.subtitle')?>
                            </p>
                        </div>
                       
                    </div>
                    <div class="results-list row">
                        <?php $this->render('tour/list-results')?>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php if($this->main == 1 ) { ?>
        <div class="d-none d-sm-block">
            <div class="container">
                <div class="main-title center">
                    <h3 class="main-title-text"><?php _lang('tours.period')?></h3>
                </div>  
            </div>
            <div class="container">
                <div class="row">
                    <?php foreach($this->months as $key =>  $month) {  ?>
                    <div class="col-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <?php _lang('month.tr.'.($key+1))?><small class="float-right <?php echo $month['count'] > 0 ? 'text-success font-weight-bold' : ''?>"> ( <?php echo $month['count']?> Tur )  </small>
                                </h5>
                                <p class="card-text "></p>
                                <a href="/<?php echo $month['value']?>/" class="btn btn-sm  btn-block  <?php echo $month['count'] > 0 ? 'btn-primary' : 'btn-light btn-disabled'?>"> <?php _lang('tour.tour_view')?></a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
</div>
