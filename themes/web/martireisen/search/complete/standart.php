   
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
                    <p><?php _lang('booking.code.description')?></p>
                </div>
            <div class="finally-title">
                <h3 class="finally-title-text"><?php _lang('booking.title') ?></h3>
            </div>
            <div class="finally-summary">
                <div class="d-flex flex-wrap row m-0">
                <div class="finally-summary-col col-12 col-md-3">
                    <div class="finally-summary-image">
                        <img src="https://thumbnails.travel-it.com/g2thmb.php?gid=<?php echo $this->data['hotel_giata_code']?>" alt="Image"/>
                    </div>
                    <div class="finally-summary-title"><?php echo $this->data['hotel_name']?></div>
                    <div class="finally-summary-stars">
                        <?php for($i = 0 ; $i < (int)$this->data['offer']['hotelOffer']['hotel']['category']; $i++){?>
                        <i class="icon icon-results-star" ></i>
                        <?php } ?>
                    </div>
                    <div class="finally-summary-description"><?php echo (string)$this->data['offer']['hotelOffer']['hotel']['location']['name']?></div>
                    <div class="finally-summary-adventages d-none" >
                        
                     
                        </div>
                </div>
                <div class="finally-summary-col col-12 col-md-3">
                    <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.services') ?></h3>
                    <?php if($this->data['source'] == 'Traffics') {?>
                    <ul class="finally-summary-list">
                        <li><?php echo $this->data['offer']['hotelOffer']['travelDate']['duration']?> <?php _lang('offer.night') ?></li>
                        <li><?php echo $this->data['offer']['hotelOffer']['roomType']['name']?></li>
                        <li><?php echo $this->data['offer']['hotelOffer']['boardType']['name']?></li>
                    </ul>
                    <?php } else if($this->data['source'] == 'Tour'){?>
                    <ul class="finally-summary-list">
                        <?php foreach($this->data['tour']['properties'] as $property) { if($property['is_free'] != 1) continue; ?>
                        <li><?php echo $property['title']?></li>
                        <?php } ?>
                    </ul>
                    <?php } else{?>
                    <ul class="finally-summary-list">
                        <li><?php echo $this->data['service']['room']['name']?></li>
                        <li><?php echo $this->data['service']['rate_plan']['meal_plan_name']?></li>
                    </ul>
                    <?php }?>
                    
                    <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.additional_services') ?></h3>
                    <?php if(count($this->data['offer']['hotelOffer']['transferList'])>0) { ?>
                    <div class="finally-summary-property" >
                        <span class="finally-summary-property-icon"><i class="icon icon-prices-bus"></i></span>
                        <span class="finally-summary-property-text"><?php _lang('offer.transfer_detail') ?></span>
                    </div>
                    <?php } ?>
                    <?php if($this->data['service']['INCLUDING']['RAIL'] > 0) { ?>
                    <div class="finally-summary-property" >
                        <span class="finally-summary-property-icon"><i class="icon icon-prices-train"></i></span>
                        <span class="finally-summary-property-text"><?php _lang('offer.rail_detail') ?></span>
                    </div>
                    <?php } ?>
                    <?php if($this->data['source'] == 'Traffics') { ?>
                    <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.operators') ?>:</h3>
                    <div class="finally-summary-bid">
                        <img src="https://web3.travel-it.com/static/images/va/<?php echo $this->data['operator']?>_35.png" alt="Title" />
                    </div>
                    <?php } ?>
                </div>
                    
                <?php if($this->data['source'] == 'Traffics') { ?>
                <div class="finally-summary-col col-12 col-md-3"> 
                    <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.flight_info') ?></h3>
                    <div class="finally-summary-flight-details" >
                        <?php foreach($this->data['offer']['flightOffer']['flight']['outboundLegList'] as $flight) {  ?>
                        <div>
                            <div class="finally-summary-flight-details-title">
                                <h5 class="finally-summary-flight-details-title-text"><?php _lang('offer.flight_point') ?></h5>
                                <p class="finally-summary-flight-details-title-description"><?php echo $flight['departureDate']?></p>
                            </div>
                            <div class="finally-summary-flight-details-name " ></div>
                            <div class="finally-summary-flight-details-meta">
                                <div class="finally-summary-flight-details-meta-left">
                                    <span class="finally-summary-flight-details-meta-title"><?php echo $flight['departureAirportName']?></span>
                                    <span class="finally-summary-flight-details-meta-text"><?php echo $flight['departureAirportCode']?></span>
                                    <span class="finally-summary-flight-details-meta-time"><?php echo $flight['departureTime']?></span>
                                </div>
                                <div class="finally-summary-flight-details-meta-center">
                                    <i class="icon icon-prices-plane-grey" ></i>

                                </div>
                                <div class="finally-summary-flight-details-meta-right">
                                    <span class="finally-summary-flight-details-meta-title"><?php echo $flight['arrivalAirportName']?></span>
                                    <span class="finally-summary-flight-details-meta-text"><?php echo $flight['arrivalAirportCode']?></span>
                                    <span class="finally-summary-flight-details-meta-time"><?php echo $flight['arrivalTime']?></span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="finally-summary-flight-details" v-if='offer.SF == 2'>
                        <?php foreach($this->data['offer']['flightOffer']['flight']['inboundLegList'] as $flight) {  ?>
                        <div>
                            <div class="finally-summary-flight-details-title">
                                <h5 class="finally-summary-flight-details-title-text"><?php _lang('offer.flight_return') ?></h5>
                                <p class="finally-summary-flight-details-title-description"><?php echo $flight['departureDate']?></p>
                            </div>
                            <div class="finally-summary-flight-details-name " ></div>
                            <div class="finally-summary-flight-details-meta">
                                <div class="finally-summary-flight-details-meta-left">
                                    <span class="finally-summary-flight-details-meta-title"><?php echo $flight['departureAirportName']?></span>
                                    <span class="finally-summary-flight-details-meta-text"><?php echo $flight['departureAirportCode']?></span>
                                    <span class="finally-summary-flight-details-meta-time"><?php echo $flight['departureTime']?></span>
                                </div>
                                <div class="finally-summary-flight-details-meta-center">
                                    <i class="icon icon-prices-plane-grey" ></i>

                                </div>
                                <div class="finally-summary-flight-details-meta-right">
                                    <span class="finally-summary-flight-details-meta-title"><?php echo $flight['arrivalAirportName']?></span>
                                    <span class="finally-summary-flight-details-meta-text"><?php echo $flight['arrivalAirportCode']?></span>
                                    <span class="finally-summary-flight-details-meta-time"><?php echo $flight['arrivalTime']?></span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="finally-summary-links">
                     <!--   <a class="finally-summary-links-item"  title="Title" data-toggle="modal" data-target="#flugdetailsModal"><?php _lang('offer.flight_detail') ?></a>-->
                    </div>
                    <p class="finally-summary-text">
                        <?php _lang('offer.flight_time') ?>
                    </p>
                </div>
                <?php } ?>
                    
                <?php if($this->data['source'] == 'HalalBooking' || $this->data['source'] == 'Tour') { ?>
                     <div class="finally-summary-col col-12 col-md-3"> 
                        <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('search.travel_data') ?></h3>
                        <p>
                        <i class="fas fa-arrow-right"></i> <?php  echo ($this->data['start'])?>
                        </p>
                         <p>
                            <i class="fas fa-arrow-left"></i> <?php  echo ($this->data['end'])?>
                        </p>
                     </div>
                <?php } ?>
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
        </div>
        <div  class="finally finally-steps" >
            <div class="finally-title">
                <h3 class="finally-title-text"><?php _lang('booking.complete.step') ?></h3>
            </div>
            <div class="finally-summary">
                <div class="d-flex flex-wrap m-0"> 
                    <div class="finally-summary-col">
                        <span class="display-4"><img src="<?php theme_dir()?>assets/img/profile/user.png"/></span>
                        <p class="mt-3 p-2"><?php _lang('booking.complete.step1')?></p>
                    </div>
                    <div class="finally-summary-col">
                        <span class="display-4"><img src="<?php theme_dir()?>assets/img/profile/user.png"/></span>
                        <p class="mt-3 p-2"><?php _lang('booking.complete.step2')?></p>
                    </div>
                    <div class="finally-summary-col">
                        <span class="display-4"><img src="<?php theme_dir()?>assets/img/profile/user.png"/></span>
                        <p class="mt-3 p-2"><?php _lang('booking.complete.step3')?></p>
                    </div>
                    <div class="finally-summary-col">
                        <span class="display-4"><img src="<?php theme_dir()?>assets/img/profile/user.png"/></span>
                        <p class="mt-3 p-2"><?php _lang('booking.complete.step4')?></p>
                    </div>
                </div>
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
  
    
window.addEventListener('DOMContentLoaded', (event) => {
    var orderData = {
      value: <?php echo floatval($this->data['amount'])?>,
      currency: '<?php echo \Model\User\Customer::getCurrency()?>',
      contents: [
        {
          id: '<?php echo ($this->data['hotel_giata_code'])?>',
          quantity: 1
        }
      ],
      content_type: 'product'
    }
    window.FBConversion.complete(orderData);
});
    
</script>