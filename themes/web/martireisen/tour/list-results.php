<?php if(count($this->tours) == 0){?>
<div  style="overflow: hidden" class="alert alert-info">
    <span class="float-left">
        <?php _lang('search.no_result')?>
    </span> 
</div>
<?php } ?>
<?php foreach($this->tours as $tour){ ?>
<div class="results-item col-12 col-lg-6  " >
    <div class='row'>
        <div class="results-item-left col-12 col-md-6">
            <a class='w-100' href='<?php echo  SITE_URL.'/'.$tour['seo_url']?>'>
                <img class="w-100" src="<?php echo $tour['image']?>" alt="<?php echo $tour['title']?>"/>
             <!--   <div class="w-100" style="height:190px; background-image: url('<?php echo $tour['image']?>'); background-size:cover;">

                </div>-->
            </a>
        </div>
        <div class="col-12 col-md-6 px-4">
       
            <div class="row">    
                <div class="results-item-center-top hotel-info-bar col-7 col-md-12" style="height:110px">
                    <div><h4 class="results-item-title-tour-list text-primary " style="min-width: 185px;" data-url="<?php echo $url?>"><?php echo $tour['title']?></h4></div>
                    <div class="results-item-description" data-url="">
                        <div class="results-item-description-stars text-secondary text-nowrap">
                            <i class="fas fa-calendar-alt mr-2"></i>
                                <?php if((int)$tour['period']['id'] == 0){ echo '-';} else { ?>
                                <?php echo date('d.m.Y',($tour['period']['start_date']))?>  <?php echo $tour['period']['start_date'] != $tour['period']['end_date'] ? '-' .date('d.m.Y',($tour['period']['end_date'])) : ''?>
                                <?php }?>
                        </div>
                        <div class="clearfix mt-2"></div>
                        <div class="results-item-description-text text-truncate" style="min-width: 185px;">
                            <?php echo $tour['departure_place']?> -> <?php echo $tour['destination']?>
                        </div>
                    </div>
                </div>
                <div class="col align-self-end">
                    <?php if($tour['base_price'] > 0) { ?>
                    <div class="text-discount text-right text-nowrap">€ <?php echo $tour['base_price'] ?></div>
                    <?php } ?>
                    <div class="results-item-header-money text-right text-nowrap">€ <?php echo $tour['price'] ?></div>
                    
                    <div class="results-item-button mt-0 mx-auto p-1">
                        <a class="button" href="<?php echo  SITE_URL.'/'.$tour['seo_url']?>/">
                             <?php _lang('tour.look') ?>
                            <i class="icon icon-header-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<script>
    
window.addEventListener("load", function (event) {
        
    let products = [];
    for( var i = 0 ; i < TourList.length; i++) {
        products.push(TourList[i].id);
    }

     fbq('track','ViewCategory',{ 
        content_name     : 'Tour List', 
        content_type     : 'product', 
        content_ids      : products, 
    }); 
        
});
   
</script>