<div v-show="!offer.book" style="display: none;">
    <div class="text-center">
        <div class="spinner-border text-primary"></div>
    </div>
</div>
<div class="offer_detail">
<h3 v-if="offer.book && offer.book.statusCode == 'OK' " class="results-hotel-tab-content-prices-main-item-collapse-box-beforetitle"><i class="fa fa-check"></i> <?php _lang('offer.is_available')?></h3>
<div v-if="offer.book && offer.book.statusCode == 'OK' "  class="results-hotel-tab-content-prices-main-item-collapse-box">


    <div class="results-hotel-tab-content-prices-main-item-collapse-box-left" v-if='filter.sf == 2'>
        <h3 class="results-hotel-tab-content-prices-main-item-collapse-box-title"><?php _lang('offer.flight_info')?></h3>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details" v-if="offer.book.commonOffer.flightOffer != null" v-for="flight in offer.book.commonOffer.flightOffer['flight']['outbound']['legList']" >
            <div class="d-flex justify-content-between">
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title">
                    <h5 class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title-text"><?php _lang('offer.flight_point')?> {{ Marti.Tools.frontEndDateFormat(flight.departureTime)}}</h5>
                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-name">{{flight.flightCarrierName}}</div>
                </div>
                <div class="flight-details-airlineicon">
                    <img :src=Marti.Tools.getAirlineIconByFlightNr(flight.flightCarrierCode) class="img-responsive" onerror="this.src='/themes/web/martireisen/assets/img/airways/noimage.svg'" alt="Airline Icon" />
                </div>
            </div>

            <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta">
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-left">
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.departureAirportCode}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.departureAirportName}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.departureTime}}</span>
                </div>
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-center">
                    <i class="icon icon-prices-plane-h"></i>

                </div>
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-right">
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.arrivalAirportCode}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.arrivalAirportName}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.arrivalTime}}</span>
                </div>
            </div>
        </div>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details" v-if="offer.book.commonOffer.flightOffer != null" v-for="flight in offer.book.commonOffer.flightOffer['flight']['inbound']['legList']">
            <div class="d-flex justify-content-between">
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title">
                    <h5 class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title-text"><?php _lang('offer.flight_return')?>: {{ Marti.Tools.frontEndDateFormat(flight.departureTime) }}</h5>
                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-name">{{flight.flightCarrierName}}</div>
                </div>
                <div class="flight-details-airlineicon">
                    <img :src=Marti.Tools.getAirlineIconByFlightNr(flight.flightCarrierCode) class="img-responsive" onerror="this.src='/themes/web/martireisen/assets/img/airways/noimage.svg'" alt="Airline Icon" />
                </div>
            </div>
            <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta">
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-left">
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.departureAirportCode}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.departureAirportName}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.departureTime}}</span>
                </div>
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-center">
                    <i class="icon icon-prices-plane-h-down"></i>

                </div>
                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-right">
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.arrivalAirportCode}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.arrivalAirportName}}</span>
                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.arrivalTime}}</span>
                </div>
            </div>
        </div>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-links">
            <a class="results-hotel-tab-content-prices-main-item-collapse-box-links-item" data-toggle="modal" data-target='#flugDetail'><?php _lang('offer.flight_detail')?></a>
        </div>

        <p class="results-hotel-tab-content-prices-main-item-collapse-box-text">
            Die angegebenen Flugzeiten sind voraussichtlich.
        </p>

    </div>

    <div class="results-hotel-tab-content-prices-main-item-collapse-box-center">
        <h3 class="results-hotel-tab-content-prices-main-item-collapse-box-title"><?php _lang('offer.services')?></h3>
        <ul class="results-hotel-tab-content-prices-main-item-collapse-box-list">
            <li>{{offer.travelDate.duration}} <?php _lang('offer.night')?></li>
            <li>{{offer.hotelOffer.roomType.name}}</li>
            <li>{{offer.hotelOffer.boardType.name}}</li>
        </ul>
        <h3 class="results-hotel-tab-content-prices-main-item-collapse-box-title"> <?php _lang('offer.additional_services')?></h3>
       
        <h3 class="results-hotel-tab-content-prices-main-item-collapse-box-title"><?php _lang('offer.operators')?>:</h3>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-bid">
           {{  offer.tourOperator.name }}
             <img v-bind:src="offer.tourOperator.png"/>

        </div>
    </div>
    <div class="results-hotel-tab-content-prices-main-item-collapse-box-right">
        <h3 class="results-hotel-tab-content-prices-main-item-collapse-box-title"><?php _lang('offer.price_summary')?>:</h3>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-travellers">
            <div class="results-hotel-tab-content-prices-main-item-collapse-box-travellers-item"  v-for="(person,index) in offer.book.travellerList">
                <span class="text">{{index+1}}. 
                    <span v-if="person.type == 'H' ">
                        <?php _lang('offer.adult')?>
                    </span>
                    <span v-if="person.type != 'H' ">
                        <?php _lang('offer.children')?>
                    </span>
                </span>
                <span class="money" v-if="person.price ">{{  offer.book.totalPrice.currency }} {{Marti.Tools.numberWithThousandSep(person.price.value) || ''}}</span>
            </div>
        </div>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-total">
            <div class="results-hotel-tab-content-prices-main-item-collapse-box-total-left">
                <?php _lang('offer.amount')?>
                <small><?php _lang('hotels.inkl. aller Zuschläge')?></small>
            </div>
            <div class="results-hotel-tab-content-prices-main-item-collapse-box-total-right">
                {{ offer.book.totalPrice.currency  }} {{Marti.Tools.numberWithThousandSep(offer.book.totalPrice.value)}}
                <!--<small>.00</small> -->
            </div>
        </div>
        <div class="alert alert-warning p-2 mt-2 mb-0" v-show="offer.book.totalPrice.value > offer.totalPrice.value">
            <?php _lang('offer.price_change')?>
            <span class="font-weight-bold">
            {{ offer.book.totalPrice.value -offer.totalPrice.value  }} {{ offer.totalPrice.currency  }}
            </span>
        </div>
        <div class="alert alert-success p-2 mt-2 mb-0" v-show="offer.totalPrice.value > offer.book.totalPrice.value">
            <?php _lang('offer.price_down')?>
            <span class="font-weight-bold">
             {{ offer.totalPrice.value - offer.book.totalPrice.value }} {{ offer.totalPrice.currency  }}
            </span>
        </div>
        <div class="results-hotel-tab-content-prices-main-item-collapse-box-button">
            <a class="button" v-bind:href="getBookingUrl(offer.book,offer.code)" title="Title">
                <?php _lang('offer.take')?>
                <i class="icon icon-header-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
    <button class="btn btn-primary hotelinfos" type="button" data-toggle="collapse" data-target="#hotelInfoCollapse" aria-expanded="false" aria-controls="hotelInfoCollapse">
        Hotelinfos <i class="fas fa-chevron-down"></i>
    </button>
    <div class="collapse" id="hotelInfoCollapse">
        <div class="card card-body">
            <div class="p-3 bg-white " v-html="catalogData">
                
            </div>
        </div>
    </div>
</div>
<div id="ss" class="" data-collapse="content">
</div>

