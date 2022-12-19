

<div id="order">
    <div class="container"> 
        <?php if($this->detail != true ) { ?> 
        <div class="order-title no-print ">
            <h3 class="order-title-text"><?php _lang('booking.approved'); ?> </h3>
            <div class="order-title-print">
                <a class="button" href="#" onclick="window.print();" title="Print">
                    <span class="hidden-xxs"><?php _lang('booking.print'); ?></span>
                    <i class="icon icon-order-printer"></i>
                </a>
            </div>
        </div>
        <div class="order-message no-print mb-4">
            <div class="order-message-icon">
                <i class="icon icon-order-success"></i>
            </div>
            <div class="order-message-content">
                <h5 class="order-message-content-title"><?php _lang('booking.thankyou')?> </h5>
                <p class="order-message-content-text"><?php _lang('booking.thankyou.message')?></p>
            </div>
        </div>
        <?php }?>
        
        <div class="mb-3"></div>
        
        <?php
            if($this->data['source'] == 'Tour') { 
                $this->render('search/complete/tour');
            }else {
                $this->render('search/complete/standart');
            }
        ?>
        <div>
            
            <div class="order-box d-none">
                <div class="order-box-header">
                    <i class="icon icon-order-people"></i>
                    <?php _lang('search.traveller'); ?>
                </div>
                <div class="order-box-main">
                    <h5 class="order-box-main-title"><?php _lang('search.adult'); ?> </h5>
                    <?php foreach($this->data['travellers'] as $traveller) { if($traveller['is_children'] == 1) continue; ?>
                    <ul class="order-box-main-list margin">
                        <li><?php echo $traveller['name']?> <?php echo $traveller['surname']?></li>
                        <li><?php echo $traveller['email']?></li>
                        <li><?php echo $traveller['phone']?></li>
                    </ul>
                    <?php } ?>                    
                    <h5 class="order-box-main-title"><?php _lang('search.children'); ?> </h5>
                    <?php foreach($this->data['travellers'] as $traveller) { if($traveller['is_children'] == 0) continue; ?>
                    <ul class="order-box-main-list margin">
                        <li><?php echo $traveller['name']?> <?php echo $traveller['surname']?></li>
                        <li>05.06.2012</li>
                        <li>5 years old</li>
                    </ul>
                    <?php }?>
                </div>
            </div>                    
        </div>
    </div>
</div>
