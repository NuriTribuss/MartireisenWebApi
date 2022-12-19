   
        <div id="finally" class="finally" >
            <div class="finally-title">
                <h3 class="finally-title-text"><?php _lang('booking.code') ?></h3>
            </div>
            <div class="finally-summary">
                <div class="card text-white bg-success mb-4" >
                    <div class="card-body">
                        <h4 class="card-title mb-0 "><?php echo $this->data['code'] ?></h4>
                        <p class="card-text d-none"><?php _lang('booking.code.text') ?></p>
                    </div>
                </div>
               
            </div>
            <div class="card mb-4 p-3">
                 <b class="mb-3"><?php _lang('common.dear')?> <?php echo $this->data['name'].' '.$this->data['surname']?></b>
                 <?php if($this->data['payment_method'] == 1) { ?>
                    <p><?php _lang('booking.code.tour_pending')?></p>
                    <p><?php echo stripslashes(_lang('booking.code.tour_payment_text',true))?></p>
                 <?php }else{ ?>
                    <p><?php _lang('booking.code.tour_complete')?></p>
                 <?php } ?>
                <?php if(!empty($this->data['tour']['contact_phone'])) {?>
                <div class=" mb-1 mt-1  d-flex fa-1x float-right">
                    <i class="fa fa-phone mr-2"></i><?php _lang('tour.contact_phone')?> :
                    <a href="tel:<?php echo $this->data['tour']['contact_phone']?>"><?php echo $this->data['tour']['contact_phone']?></a>
                </div>
                <?php } ?>
            </div>
           
            <div class="finally-title">
                <h3 class="finally-title-text"><?php _lang('booking.title') ?></h3>
            </div>
            <div class="finally-summary mb-2">
                <div class="d-flex flex-wrap row m-0">
                <div class="finally-summary-col col-12 col-md-3">
                    <div class="finally-summary-image">
                        <img src="<?php echo $this->data['tour']['image']?>" alt="Image"/>
                    </div>
                    <div class="finally-summary-title"><?php echo $this->data['hotel_name']?></div>
                </div>
                <div class="finally-summary-col col-12 col-md-3">
                    <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.services') ?></h3>
                    <ul class="finally-summary-list">
                        <?php foreach($this->data['tour']['properties'] as $property) { if($property['is_free'] != 1) continue; ?>
                        <li><?php echo $property['title']?></li>
                        <?php } ?>
                    </ul>
                </div>
                    
                    
                <div class="finally-summary-col col-12 col-md-3"> 
                    <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('tour.date')?></h3>
                   <p>
                   <i class="fas fa-arrow-right"></i> <?php  echo ($this->data['start'])?>
                   </p>
                    <p>
                       <i class="fas fa-arrow-left"></i> <?php  echo ($this->data['end'])?>
                   </p>
                </div>
                <!---leistungen old-->
                <div class="finally-summary-col col-12 col-md-3">
                    <h3 class="finally-summary-main-title"><?php _lang('offer.price_summary') ?></h3>
                    <div class="finally-summary-travellers">
                        <div class="finally-summary-travellers-item d-block">
                            <?php foreach($this->data['travellers'] as $index => $traveller){ ?>
                            <span class="text d-block"><?php echo ($index+1).'.'.$traveller['name'].' '.$traveller['surname']?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="finally-summary-total">
                        <div class="finally-summary-total-left">
                            <?php _lang('offer.amount') ?>
                            <small><?php _lang('offer.amount_text') ?></small>
                        </div>
                        <div class="finally-summary-total-right">
                            € <?php echo number_format($this->data['amount'],0,'.','')?><small>.00</small>
                            
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="finally-title mt-4">
                <h3 class="finally-title-text"><?php _lang('tour.tour_plan') ?></h3>
            </div>
            <div class="finally-summary">
                  <ul class="timeline">
<?php foreach ($this->data['tour']['plans'] as $plan) { ?>
                                            <li class="timeline-item bg-white rounded ml-sm-3 ml-2 p-sm-4 p-3 shadow">
                                                <div class="timeline-arrow"></div>
                                                <h2 class="h5 mb-3 text-primary font-weight-bold"><?php echo $plan['title'] ?></h2>
                                                <p class="text-small mt-2 font-weight-light"> <?php echo nl2br($plan['content']) ?></p>
                                            </li>
                                        <?php } ?>
                                    </ul>
            </div>
        </div>

<script>
    
let mapping = ['','Überweisung','Sofort','Kreditkarte'];
dataLayer.push({
    'event': 'purchase',
    'ecommerce': {
      'purchase': {
        'actionField': {
          'id': '<?php echo $this->data['code'] ?>',                         // Transaction ID. Required for purchases and refunds.
          'affiliation': 'Online Travel Agency',
          'revenue': '<?php echo $this->data['amount']?>',                     // Total transaction value (incl. tax and shipping)
        },
        'products': [{                            
        'name':              '<?php echo $this->data['hotel_name']?>',     
        'id':                '<?php echo $this->data['hotel_giata_code']?>',
        'price':             '<?php echo $this->data['amount']?>',
        'brand':             '<?php echo $this->data['operator']?>',
        'variant1'        : '<?php echo $this->data['service']['ACCOMMODATION']['VT']?>',
        'duration'        : '<?php echo $this->data['duration']?>' + ' Days',
        'room_type'       : '<?php echo $this->data['service']['ACCOMMODATION']['ZT']?>',
        'adult'           : '<?php echo $this->data['adult_count']?>',
        'children'        : '<?php echo $this->data['children_count']?>',
        /*'checkin_date' : this.offer.start_date,*/
        'departure_date'  : '<?php echo $this->data['start']?>',
        'departure_name'  : '<?php echo $this->data['service']['APTA']?>',
        'package_type'    : '<?php echo $this->data['service']['REISEART']?>', 
        'payment_method'  : mapping[<?php echo $this->data['payment_method']?>]
         },
        ]
      }
    }
  });
  
$(document).ready(function(){
    fbq('track', 'Purchase',
        // begin parameter object data
        {
          value: <?php echo floatval($this->data['amount'])?>,
          currency: '<?php echo \Model\User\Customer::getCurrency()?>',
          contents: [
            {
              id: '<?php echo ($this->data['tour_id'].'-'.$this->data['period_id'])?>',
              quantity: 1
            }
          ],
          content_type: 'product'
        }
    );
});
    
</script>

        