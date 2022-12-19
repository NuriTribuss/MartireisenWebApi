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



<div id="results">
    <div class="container">
        <section id="country-price-list" class="no-pt mt-5">
            <div class="container">
                <h2 class="text-center"><?php echo $this->landing['translate']['second_title']?></h2>
                <p  class="subtitle text-center" >
                    <?php echo $this->landing['translate']['second_subtitle']?>
                </p>

                <ul class="price-list mt-3"> <!-- desktop --> 
                    <?php foreach ($this->countries as $index =>  $state) {  ?>
                        <li class="<?php echo $index > 7 ? 'd-none' : ''?>">
                            <a href="<?php echo Helper\UrlGen::filterLink($this, $state)?>">
                                <p><?php echo $state['name'] ?></p>
                                <span class='d-none'>€53</span>
                            </a>

                        </li>
                    <?php } ?>
                    <?php if(count($this->countries) > 7) { ?>
                    <li>
                        <a class="load-more-item" href="javascript:;">
                            <i class="fas fa-plus mr-2"></i>
                            <p><?php _lang('offer.show_more')?></p>
                        </a>
                    </li>
                    <?php } ?>
                </ul>

                <ul class="mobile-price-list d-md-none p-0"><!-- mobile -->
                    <?php foreach ($this->countries as $index => $state) { ?>
                        <li class="<?php echo $index > 7 ? 'd-none' : ''?>">
                            <a href="<?php echo Helper\UrlGen::filterLink($this, $state)?>">
                                <span><?php echo $state['name'] ?></span>
                                <div class="price">
                                    <span class='d-none'>€53</span>
                                    <span>
                                        <i class="float-right fa fa-arrow-right"></i>
                                    </span> 
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                     <?php if(count($this->countries) > 7) { ?>
                    <li>
                        <a href="javascript:;" class="all-country load-more-item">
                            <i class="fas fa-plus mr-2"></i>
                            <p><?php _lang('offer.show_more')?></p>
                        </a>
                    </li>
                     <?php } ?>
                </ul>
            </div>
            
        </section>
        
        <section id="hoteltips-topseller" class="no-pt mt-4" >
            <div class="container">
                <h2 class="text-center"><?php echo $this->landing['translate']['third_title']?></h2>
                <p class='mb-4 text-center'><?php echo $this->landing['translate']['third_subtitle']?></p>
                <div class="row mt-3">
                    <?php foreach($this->countries as $index => $country) { if($country['priority'] != 1 && $this->ferne != 1 ) continue;  if($this->ferne != 1 && $index > 5) break;?>
                    <div class="col-lg-4 col-md-6">
                        <div class="item">
                            <figure onClick="location.href='<?php echo Helper\UrlGen::filterLink($this, $country)?>'">
                                <img src="/data/image/countries/<?php echo $country['code'].'/'.$country['code']?>.jpg" class="w-100" alt="<?php echo $country['name'];?>" title=""/>
                                    <figcaption>
                                        <h3 class="mb-3"><?php echo Helper\UrlGen::filterText(_lang('landing.prefix.'.$this->prefix,true).' '.$country['name'])?></h3>
                                        <small><?php echo $country['location']['city']?></small>
                                        <a href="<?php echo Helper\UrlGen::filterLink($this, $country)?>">
                                            <span>
                                                <?php _lang('offer.show_more')?>
                                            </span>
                                            <i class="float-right fa fa-arrow-right"></i>
                                        </a>
                                    </figcaption>
                            </figure>
                        </div>
                    </div>
                    <?php } ?>
                  
                </div>
            </div>
        </section>
        <div id='landing'>
        <?php include 'section-otel.php'; ?>
        </div>
        <?php if(!empty($this->landing['translate']['content'])) { ?>
        <section class="mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="content-card landing-page border-0">
                            
                            <div class="card-content mt-4">
                                <?php echo $this->landing['translate']['content']?>
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
