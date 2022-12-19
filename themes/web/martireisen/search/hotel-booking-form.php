<div class="booking-loader" v-show="loader.bookingCreate">
    <div class="lds-css ng-scope">
        <div class="lds-dual-ring"></div>
    </div>
    <p><?php _lang('booking.loader1') ?></p>
    <p><?php _lang('booking.loader2') ?></p>
</div>
<div class="lds-css ng-scope" v-show="loader.bookingCheck">
    <div class="lds-dual-ring"></div>
</div>

<div class="booking-page-wrapper d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-box">
                    <div class="form-title">Your Information</div>
                    <div class="form-content">
                        <form class="custom-form">
                            <div class="form-group">
                                <label class="group-title">Cinsiyet: </label>
                                <div class="form-item">
                                    <input type="radio" id="gender1" name="radio-group" checked>
                                    <label for="gender1">Erkek</label>
                                </div>
                                <div class="form-item">
                                    <input type="radio" id="gender2" name="radio-group">
                                    <label for="gender2">Kadın</label>
                                </div>
                                <div class="form-item">
                                    <input type="radio" id="gender3" name="radio-group">
                                    <label for="gender3">Diğer</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 is-valid">
                                        <label class="group-title" for="name">Ad: </label>
                                        <input type="text" id="name">
                                        <p>Bu bir doğrulama mesajıdır.</p>
                                    </div>
                                    <div class="col-md-3 col-sm-12 not-valid">
                                        <label class="group-title" for="surname">Soyad: </label>
                                        <input type="text" id="surname">
                                        <p>Bu bir hata mesajıdır.</p>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="group-title" for="country">Doğum Tarihi: </label>
                                        <div class="select-group">
                                            <div class="row gutter-5">
                                                <div class="col-md-3 is-valid">
                                                    <select id="date">
                                                        <option value="">Date</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 not-valid">
                                                    <select id="month">
                                                        <option>Month</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="year">
                                                        <option>Year</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <label class="group-title" for="sokak">Sokak</label>
                                        <input type="text" id="sokak">
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label class="group-title" for="pcode">Posta Kodu</label>
                                        <input type="text" id="pcode">
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label class="group-title" for="sehir">Şehir</label>
                                        <input type="text" id="sehir">
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                    <label class="group-title" for="ulke">Ülke</label>
                                        <select id="ulke">
                                            <option>Ülke</option>
                                            <option>tr</option>
                                            <option>at</option>
                                            <option>03</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 is-valid">
                                        <label class="group-title" for="phone">Telefon: </label>
                                        <input type="text" id="phone">
                                        <p>Bu bir doğrulama mesajıdır.</p>
                                    </div>
                                    <div class="col-md-4 not-valid">
                                        <label class="group-title" for="mail">E-Posta: </label>
                                        <input type="text" id="mail">
                                        <p>Bu bir hata mesajıdır.</p>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="form-box">
                    <div class="form-title">1. Yolcu</div>
                    <div class="form-content">
                        <form class="custom-form">
                            <div class="form-group">
                                <label class="group-title">Cinsiyet: </label>
                                <div class="form-item">
                                    <input type="radio" id="gender6" name="radio-group" checked>
                                    <label for="gender6">Erkek</label>
                                </div>
                                <div class="form-item">
                                    <input type="radio" id="gender4" name="radio-group">
                                    <label for="gender4">Kadın</label>
                                </div>
                                <div class="form-item">
                                    <input type="radio" id="genderr5" name="radio-group">
                                    <label for="genderr5">Diğer</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <label class="group-title" for="name">Ad: </label>
                                        <input type="text" id="name">
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label class="group-title" for="surname">Soyad: </label>
                                        <input type="text" id="surname">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="form-box">
                    <div class="form-title">Payment Methods</div>
                    <div class="finally group mb-0">
                    <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" v-model="bookingForm.payment.method" name="pay_mode"
                                   data-payment="radio" value="1"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <div class="finally-payment-radio-content-title"><?php _lang('offer.payment.offline') ?>
                                    <div v-show="bookingForm.payment.method == 1">
                                        <small><?php _lang('offer.payment.uberweisung') ?></small>
                                    </div>
                                </div>
                            </span>
                        </label>
                    </div>
                    <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" name="pay_mode" v-model="bookingForm.payment.method"
                                    data-payment="radio" value="2"/>
                                <span class="finally-payment-radio-icon"></span>
                                <span class="finally-payment-radio-content">
                                    <div class="finally-payment-radio-content-title" style="margin-top: 14px;">Klarna
    <!--                                    <img src="https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/pay_now/descriptive/pink.svg"-->
    <!--                                            height="31" align="absmiddle">-->
                                    </div>
                                <span class="finally-payment-radio-content-text">
                                    <div class="finally-payment-radio-content-image">
                                        <img src="<?php theme_dir() ?>assets/img/klarna-checkout.png" width="80"/>
                                    </div>
                                </span>

                            </label>
                        </div>
                        <div class="finally-payment" data-payment="root">
                            <label class="finally-payment-radio">
                                <input type="radio" name="pay_mode" v-model="bookingForm.payment.method"
                                    data-payment="radio" checked value="3"/>
                                <span class="finally-payment-radio-icon"></span>
                                <span class="finally-payment-radio-content">
                                    <div class="finally-payment-radio-content-title"><?php _lang('offer.payment.creditcart') ?></div>
    <!--                                <span class="finally-payment-radio-content-text">--><?php //_lang('offer.payment.creditcom') ?><!--</span>-->
                                        <div class="finally-payment-radio-content-image">
                                        <img src="<?php theme_dir() ?>assets/img/cards.png" width="150"/>
                                    </div>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-box">
                    <div class="form-title">Geschäftsbedingungen</div>
                    <div class="group">
                        <div class="finally-faq-item-collapse">
                            <label class="checkbox checkbox-default">
                                <input type="checkbox" name="check1" v-model="bookingForm.aggregment" id='aggregment'
                                    required/>
                                <span class="checkbox-default-icon border"></span>
                                <span class="checkbox-default-text dark">
                                    <?php _lang('offer.condition1') ?>
                                    <br>
                                    <br>
                                    <?php _lang('offer.condition2') ?>
                                    <br>
                                    <br>
                                    <?php _lang('offer.condition3') ?>
                                    <br>
                                    <br>
                                    <?php _lang('user.subscribe_request') ?>
                                </span>
                            </label>
                            <label class='input'>
                                <span class="input-message " v-bind:id="'aggregment_message'" style="padding-left:25px">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.form.req.aggregment') ?></span>
                                </span>
                            </label>

                            <label class="checkbox checkbox-default">
                                <input type="checkbox" name="check2" v-model="bookingForm.tourAggregment" id='tourAggregment'
                                    required/>
                                <span class="checkbox-default-icon border"></span>
                                <span class="checkbox-default-text dark">
                                    <?php
                                        $el =  _lang('offer.tourOperator.aggregment',true);
                                        $el =  str_replace('{{ OPERATOR_URL }}','/service/operators/condition/',$el);
                                        echo $el;
                                    ?>
                                
                                </span>
                            </label>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-lg-4">
                <div class="form-box booking-page">
                    <div class="form-title">Booking Detail</div>
                    <div class="group">
                        <div class="booking-img">
                            <img src="https://techydevs.com/demos/themes/html/trizen-demo/trizen/images/img1.jpg"
                                alt="Image"/>
                        </div>
                        <div class="booking-title">{{hotel.catalogData.hotel.name}}</div>
                        <div class="booking-stars" v-if="hotel.category">
                            <i class="icon icon-results-star" v-for='n in parseInt(hotel.category)'></i>
                        </div>
                        <div class="booking-description">{{hotel.location.name}} {{hotel.location.region.name}}</div>
                    </div>

                    <div class="group">
                        <div class="group-box">
                            <div><strong>Check-in:</strong></div>
                            <div>12 Dec 2019 at 11:10 am</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Check Out:</strong></div>
                            <div>12 Dec 2019 at 11:10 am</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Room Type:</strong></div>
                            <div>Standart family</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Room:</strong></div>
                            <div>2 Rooms</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Per Room Price:</strong></div>
                            <div>$121</div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="group-box">
                            <div><strong>Hinflug:</strong></div>
                            <div>Barcelona BCN 09:40 <br> Köln/Bonn (DE) 11:45</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Rückflug:</strong></div>
                            <div>Barcelona BCN 09:40 <br> Köln/Bonn (DE) 11:45</div>
                        </div>
                    </div>
                    <form class="custom-form save-btn mb-0">
                        <div class="form-group mb-0">
                            <div class="relative">
                                <input type="text" placeholder="Kupon Kodu">
                                <button type="submit" class="btn btn-marti">Kaydet <i class="icon icon-header-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="group">
                        <div class="group-box">
                            <div><strong>Sub Total</strong></div>
                            <div>$121</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Taxes And Fees</strong></div>
                            <div>$5</div>
                        </div>
                        <div class="group-box">
                            <div><strong>Total Price:</strong></div>
                            <div>$560</div>
                        </div>
                    </div>

                    <div class="group">
                        <div class="btn btn-success w-100 text-center lg">Ödeme adımına geç</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="finally" class="finally"> <!-- v-if='offer.statusCode == "OK"' -->
    <div class="container">
        <div class="finally-title">
            <h3 class="finally-title-text"><?php _lang('booking.title') ?></h3>
        </div>
          <div class="finally-summary row m-0 mb-4">
            <div class="finally-summary-col col-12 col-lg-3 p-3" v-if="hotel">
                <div class="finally-summary-image">
                    <img v-bind:src="hotel.mediaData.pictureUrl"
                         alt="Image"/>
                </div>
                <div class="finally-summary-title">{{hotel.catalogData.hotel.name}}</div>
                <div class="finally-summary-stars" v-if="hotel.category">
                    <i class="icon icon-results-star" v-for='n in parseInt(hotel.category)'></i>
                </div>
                <div class="finally-summary-description">{{hotel.location.name}} {{hotel.location.region.name}}</div>
               
            </div>
            <div class="finally-summary-col col-12 col-lg-3 p-3">
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.services') ?></h3>
                <ul class="finally-summary-list">
                    <li>{{offer.commonOffer.travelDate.duration}} <?php _lang('offer.night') ?></li>
                    <li>{{offer.commonOffer.hotelOffer.roomType.name}}</li>
                    <li>{{offer.commonOffer.hotelOffer.boardType.name}}</li>
                </ul>
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.additional_services') ?></h3>
                <div class="finally-summary-property d-none" >
                    <span class="finally-summary-property-icon"><i class="icon icon-prices-bus"></i></span>
                    <span class="finally-summary-property-text"><?php _lang('offer.transfer_detail') ?></span>
                </div>
                <div class="finally-summary-property d-none" >
                    <span class="finally-summary-property-icon"><i class="icon icon-prices-train"></i></span>
                    <span class="finally-summary-property-text"><?php _lang('offer.rail_detail') ?></span>
                </div>

                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.operators') ?>:</h3>
                <div class="finally-summary-bid"
                     v-on:click="openOperator(offer.operator.code, offer.hotel_info.id)">
                    <a class="results-hotel-tab-content-prices-main-item-content-link">
                        <img v-bind:src="offer.commonOffer.tourOperator.png"
                             alt="Title"/>
                        <div class="clearfix"></div>
                        <?php _lang('hotels.offer_info') ?>
                    </a>
                </div>
            </div>
            <div class="finally-summary-col" v-if="!offer.commonOffer.flightOffer">
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('search.travel_data') ?></h3>
                <p>
                    <i class="fas fa-arrow-right"></i> {{ Marti.Tools.frontEndDateFormat(offer.commonOffer.travelDate.fromDate) }}
                </p>
                <p>
                    <i class="fas fa-arrow-left"></i> {{ Marti.Tools.frontEndDateFormat(offer.commonOffer.travelDate.toDate)}}
                </p>
            </div>
            <div class="finally-summary-col" v-if="offer.commonOffer.flightOffer">
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.flight_info') ?></h3>
                <div class="finally-summary-flight-details">
                    <div 
                         v-for="flight in offer.commonOffer.flightOffer['flight']['outbound']['legList']">
                        <div class="finally-summary-flight-details-title">
                            <h5 class="finally-summary-flight-details-title-text"><?php _lang('offer.flight_point') ?></h5>
                            <div class="flight-details-airlineicon">
                            </div>
                            <p class="finally-summary-flight-details-title-description">
                                {{Marti.Tools.frontEndDateFormat(flight.departureTime)}}</p>
                        </div>
                        <div class="finally-summary-flight-details-name "></div>
                        <div class="finally-summary-flight-details-meta">
                            <div class="finally-summary-flight-details-meta-left">
                                <span class="finally-summary-flight-details-meta-title">{{flight.departureAirportName}}</span>
                                <span class="finally-summary-flight-details-meta-text">{{flight.departureAirportCode}}</span>
                                <span class="finally-summary-flight-details-meta-time">{{flight.departureTime}}</span>
                            </div>
                            <div class="finally-summary-flight-details-meta-center">
                                <i class="icon icon-prices-plane-grey"></i>

                            </div>
                            <div class="finally-summary-flight-details-meta-right">
                                <span class="finally-summary-flight-details-meta-title">{{flight.arrivalAirportName}}</span>
                                <span class="finally-summary-flight-details-meta-text">{{flight.arrivalAirportCode}}</span>
                                <span class="finally-summary-flight-details-meta-time">{{flight.arrivalTime}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="finally-summary-flight-details">
                    <div v-if="offer.commonOffer.flightOffer"
                         v-for="flight in offer.commonOffer.flightOffer['flight']['inbound']['legList']">
                        <div class="finally-summary-flight-details-title">
                            <h5 class="finally-summary-flight-details-title-text"><?php _lang('offer.flight_return') ?></h5>
                            <p class="finally-summary-flight-details-title-description">
                                {{Marti.Tools.frontEndDateFormat(flight.departureTime)}}</p>
                        </div>
                        <div class="finally-summary-flight-details-name "></div>
                        <div class="finally-summary-flight-details-meta">
                            <div class="finally-summary-flight-details-meta-left">
                                <span class="finally-summary-flight-details-meta-title">{{flight.departureAirportName}}</span>
                                <span class="finally-summary-flight-details-meta-text">{{flight.departureAirportCode}}</span>
                                <span class="finally-summary-flight-details-meta-time">{{flight.departureTime}}</span>
                            </div>
                            <div class="finally-summary-flight-details-meta-center">
                                <i class="icon icon-prices-plane-grey"></i>

                            </div>
                            <div class="finally-summary-flight-details-meta-right">
                                <span class="finally-summary-flight-details-meta-title">{{flight.arrivalAirportName}}</span>
                                <span class="finally-summary-flight-details-meta-text">{{flight.arrivalAirportCode}}</span>
                                <span class="finally-summary-flight-details-meta-time">{{flight.arrivalTime}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="finally-summary-links" v-if='offer.type == 2'>
                    <a class="finally-summary-links-item" data-toggle="modal"
                       data-target='#flugDetail'><?php _lang('offer.flight_detail') ?></a>
                </div>
                <p class="finally-summary-text" v-if='offer.type == 2'>
                    <?php _lang('offer.flight_time') ?>
                </p>
            </div>

            <!---leistungen old-->

            <div class="finally-summary-col">
                <h3 class="finally-summary-main-title text-success"><?php _lang('offer.is_available') ?></h3>
                <div class="finally-summary-travellers">
                    <div class="finally-summary-travellers-item">
                        <span class="text">{{ booking.adults}}  <?php _lang('search.adult') ?></span>
                    </div>
                    <div class="finally-summary-travellers-item" v-show="booking.children.length > 0">
                        <span class="text" >{{booking.children.length}} <?php _lang('search.children') ?>  (<span v-for="item in booking.children">{{item.jahre }} <?php _lang('common.age') ?>,</span>)</span>
                    </div>

                </div>
                <div class="finally-summary-total">
                    <div class="finally-summary-total-left">
                        <?php _lang('offer.amount') ?>
                        <small><?php _lang('offer.amount_text') ?></small>
                    </div>
                    <div class="finally-summary-total-right">
                        € {{Marti.Tools.numberWithThousandSep(offer.totalPrice.value)}}<small>.00</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <?php if ((int)\Model\User\Customer::getId() <= 0) { ?>
                    <div class="finally-login-message d-none d-lg-flex">
                        <div class="finally-login-message-icon">
                            <i class="icon icon-finally-person"></i>
                            <div class="finally-login-message-icon-title d-block d-md-none hidden-sm"><?php _lang('offer.login.account') ?></div>
                        </div>
                        <div class="finally-login-message-content">
                            <h5 class="finally-login-message-content-title hidden-xs hidden-xxs"><?php _lang('offer.login.account') ?></h5>
                            <p class="finally-login-message-content-text">
                                <?php _lang('offer.login.account_text') ?>
                            </p>
                        </div>
                        <div class="finally-login-message-buttons">
                            <a class="loginbuttons button c-pointer">
                                <?php _lang('user.login') ?>
                                <i class="icon icon-header-arrow-right"></i>
                            </a>
                            <a class="loginbuttons finally-login-message-buttons-link c-pointer"><?php _lang('hotels.Ich möchte mich registrieren') ?></a>
                        </div>
                    </div>
                <?php } ?>
                <div class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('user.profile.title') ?></h3>
                    </div>
                    <div class="row">

                        <div class="col-4 col-md-2">
                            <label class="radio radio-default border p-3">
                                <input type="radio" id="personal_gender" name="gender" v-model="bookingForm.personal.gender" v-on:change="checkFirstTraveller" value="1"/>
                                <span class="radio-default-icon"></span>
                                <span class="radio-default-text"><?php _lang('user.profile.male') ?></span>
                                <span class="radio-default-status"></span>
                            </label>
                        </div>
                        <div class="col-4 col-md-2">
                            <label class="radio radio-default border p-3">
                                <input type="radio" id="personal_gender" name="gender" v-model="bookingForm.personal.gender"  v-on:change="checkFirstTraveller" value="2"/>
                                <span class="radio-default-icon"></span>
                                <span class="radio-default-text"><?php _lang('user.profile.female') ?></span>
                                <span class="radio-default-status"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 col-md-2">
                            <div class="input">
                                <span class="input-message " id="personal_gender_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_gender') ?></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="input succes">
                                <span class="input-label dark"><?php _lang('user.profile.name') ?></span>
                                <span class="input-message " id="personal_name_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_name') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive"
                                               placeholder="<?php _lang('user.profile.name.placeholder') ?>" type="text"
                                               v-model="bookingForm.personal.name" v-on:change="checkFirstTraveller()" id="personal_name" required/>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="input dange">
                                <span class="input-label dark"><?php _lang('user.profile.surname') ?></span>
                                <span class="input-message " id="personal_surname_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_surname') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive"
                                               placeholder="<?php _lang('user.profile.surname.placeholder') ?>"
                                               type="text" id="personal_surname"
                                               v-model="bookingForm.personal.surname" v-on:change="checkFirstTraveller()" />
                                    </span>
                                </span>

                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input d-block">
                                <span class="input-label dark"><?php _lang('user.profile.birthday') ?></span>
                                <span class="input-message " id="personal_birthday_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_birthday') ?></span>
                                </span>
                                <marti-birthday-picker v-model="bookingForm.personal.birthday"
                                                       v-bind:id="'personal_birthday'" v-bind:item_id="'personal_birthday'"></marti-birthday-picker>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="input">
                                <span class="input-label dark"><?php _lang('user.profile.address') ?></span>
                                <span class="input-message " id="personal_address_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_address') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive"
                                               placeholder="<?php _lang('user.profile.address.placeholder') ?>"
                                               v-model="bookingForm.personal.address" id="personal_address"
                                               type="text"/>
                                    </span>
                                </span>

                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="input">
                                <span class="input-label dark"> <?php _lang('user.profile.state') ?></span>
                                <span class="input-message " id="personal_state_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_state') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input placeholder="<?php _lang('user.profile.state.placeholder') ?>"
                                               v-model="bookingForm.personal.state" class="border LoNotSensitive" id="personal_state"
                                               type="text"/>
                                    </span>
                                </span>

                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="input">
                                <span class="input-label dark"> <?php _lang('user.profile.city') ?></span>
                                <span class="input-message " id="personal_city_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_city') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input placeholder="<?php _lang('user.profile.city.placeholder') ?>"
                                               v-model="bookingForm.personal.city" class="border LoNotSensitive" type="text"
                                               id="personal_city"/>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="selectbox selectbox-mega" data-selectbox="root">
                                <div class="selectbox-mega-title">
                                    <?php _lang('user.profile.region') ?>
                                </div>
                                <span class="input-message " id="personal_country_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_country') ?></span>
                                </span>
                                <div class="selectbox-mega-select">
                                    <select name="reg_land" v-model="bookingForm.personal.country"
                                            data-selectbox="select">
                                        <option v-bind:value="region.code" v-for="region in countries"
                                                :selected="region.code == 'AT'">{{region.name}}
                                        </option>

                                    </select>
                                </div>
                                <div class="selectbox-mega-button">
                                    <button class="button" type="button">
                                        <span class="selectbox-mega-button-text" data-selectbox="text">{{ (bookingForm.personal.country) }}</span>
                                        <span class="selectbox-mega-button-icon"><i
                                                    class="icon icon-selectbox-caret"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="input">
                                <span class="input-label dark"><?php _lang('user.profile.mail') ?></span>
                                <span class="input-message " id="personal_email_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_email') ?></span>
                                </span>
                                <span class="input-main">
                                     <span class="input-main-data">
                                         <input placeholder="<?php _lang('user.profile.mail.placeholder') ?>"
                                                class="border" type="email" v-model="bookingForm.personal.email"
                                                id="personal_email"/>
                                     </span>
                                     <span class="input-main-icon success"><i
                                                 class="icon icon-input-success"></i></span>
                                    <small><?php _lang('user.profile.mail.description')?></small>

                                </span>

                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="input">
                                <span class="input-label dark"><?php _lang('user.profile.phone') ?></span>
                                <span class="input-message " id="personal_phone_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_phone') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input placeholder="zb. +49 123 34567890"
                                               class="border" type="tel" v-model="bookingForm.personal.phone"
                                               id="personal_phone"/>
                                    </span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                </span>

                            </label>
                        </div>
                    </div>
                </div>
                <div class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('search.traveller') ?></h3>
                    </div>
                    <div class="adult-input" v-for="(value,index) in bookingForm.traveller">

                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="finally-section-title">{{index+1}}. <?php _lang('search.adult') ?>
                                </h2>
                                <label class="checkbox checkbox-default" v-if="index == 0">
                                    <input type="checkbox" v-model="bookingForm.traveller_first" required/>
                                    <span class="checkbox-default-icon border"></span>
                                    <span class="checkbox-default-text lead mb-2">
                                        <?php _lang('booking.traveller.mine') ?>
                                    </span>
                                </label>
                            </div>
                            <div class="col-4 col-md-2">
                                <label class="radio radio-default border p-3">
                                    <input type="radio" v-model="value.gender" value="1" checked/>
                                    <span class="radio-default-icon"></span>
                                    <span class="radio-default-text"><?php _lang('user.profile.male') ?></span>
                                    <span class="radio-default-status"></span>
                                </label>
                            </div>
                            <div class="col-4 col-md-2">
                                <label class="radio radio-default border p-3">
                                    <input type="radio" v-model="value.gender" value="2"/>
                                    <span class="radio-default-icon"></span>
                                    <span class="radio-default-text"><?php _lang('user.profile.female') ?></span>
                                    <span class="radio-default-status"></span>
                                </label>
                            </div>
                            <div class="input">
                                <span class="input-message " v-bind:id="'traveller'+index+'_gender_message'">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_gender') ?></span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="input">
                                    <span class="input-label dark"><?php _lang('user.profile.name') ?></span>
                                    <span class="input-message " v-bind:id="'traveller'+index+'_name_message'">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_name') ?></span>
                                    </span>
                                    <span class="input-main">
                                        <span class="input-main-data">
                                        <input class="border LoNotSensitive" v-bind:id="'traveller'+index+'_name'" v-model="value.name"
                                               type="text"/></span>
                                        <span class="input-main-icon success"><i
                                                    class="icon icon-input-success"></i></span>
                                    </span>

                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="input">
                                    <span class="input-label dark"><?php _lang('user.profile.surname') ?></span>
                                    <span class="input-message " v-bind:id="'traveller'+index+'_surname_message'">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_surname') ?></span>
                                    </span>
                                    <span class="input-main">
                                        <span class="input-main-data">
                                            <input class="border LoNotSensitive" v-bind:id="'traveller'+index+'_surname'"
                                                   v-model="value.surname" type="text"/>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-4 d-none">
                                <div class="input d-block">
                                    <span class="input-label dark"><?php _lang('user.profile.birthday') ?></span>
                                    <span class="input-message " v-bind:id="'traveller'+index+'_birthday_message'">
                                       <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_birthday') ?></span>
                                    </span>
                                    <marti-birthday-picker v-model="value.birthday"
                                                           v-bind:id="'traveller'+index+'_birthday'"  v-bind:item_id="'traveller'+index+'_birthday'"></marti-birthday-picker>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                    </div>
                    <div class="adult-input" v-for="(children,index) in bookingForm.children">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="finally-section-title">{{index+1}}. <?php _lang('search.children') ?></h2>
                            </div>
                            <div class="col-md-6">
                                <label class="input">
                                    <span class="input-label dark"><?php _lang('user.profile.name') ?>:</span>
                                    <span class="input-message " v-bind:id="'children'+index+'_name_message'">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_name') ?></span>
                                    </span>
                                    <span class="input-main">
                                        <span class="input-main-data">
                                            <input class="border LoNotSensitive" v-model="children.name"
                                                   v-bind:id="'children'+index+'_name'" type="text"/>
                                        </span>
                                    </span>

                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="input">
                                    <span class="input-label dark"><?php _lang('user.profile.surname') ?></span>
                                    <span class="input-message " v-bind:id="'children'+index+'_surname_message'">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_surname') ?></span>
                                    </span>
                                    <span class="input-main">
                                        <span class="input-main-data">
                                            <input class="border LoNotSensitive" v-model="children.surname"
                                                   v-bind:id="'children'+index+'_surname'" type="text"/>
                                        </span>
                                    </span>

                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input d-block">
                                    <span class="input-label dark"><?php _lang('user.profile.birthday') ?></span>
                                    <span class="input-message " v-bind:id="'children'+index+'_birthday_message'">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_birthday') ?></span>
                                    </span>
                                    <!-- v-bind:max="filter.children[index].jahre"-->
                                    <marti-birthday-picker  children="true" v-model="children.birthday"
                                                           v-bind:id="'children'+index+'_birthday'" v-bind:item_id="'children'+index+'_birthday'"></marti-birthday-picker>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
                <div class="finally-section mt-4">
                    <div class="finally-title">
                        <h3 class="finally-title-text">{{translate['offer.coupon_code_title']}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <span class="input-label dark">{{translate['offer.coupon_code']}}:</span>
                            </div>
                            <div class="d-flex">
                                <label class="input">
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive" type="text" v-model="bookingForm.coupon">
                                    </span>

                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                </span>
                                </label>
                                <button class="button btn btn-marti" type="button" v-on:click="setCoupon">
                                    {{translate['offer.coupon_apply']}}
                                    <i class="icon icon-header-arrow-right"></i>
                                </button>
                                <div class="alert alert-success" style="display: none">
                                    success <span class="discount-pay"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="kredit-karte" class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('offer.payment.title') ?></h3>
                    </div>
                    <!-- <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" v-model="bookingForm.payment.method" name="pay_mode"
                                   data-payment="radio" value="1"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <div class="finally-payment-radio-content-title"><?php _lang('offer.payment.offline') ?>
                                    <div v-show="bookingForm.payment.method == 1">
                                        <small><?php _lang('offer.payment.uberweisung') ?></small>
                                    </div>
                                </div>
                            </span>
                        </label>
                    </div>
                    <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" name="pay_mode" v-model="bookingForm.payment.method"
                                   data-payment="radio" value="2"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <div class="finally-payment-radio-content-title">Klarna - Sofortüberweisung
                                   <img src="https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/pay_now/descriptive/pink.svg"
                                            height="31" align="absmiddle">
                                </div>
                               <span class="finally-payment-radio-content-text">
                                 <div class="finally-payment-radio-content-image">
                                     <img src="<?php theme_dir() ?>assets/img/klarna-checkout.png" width="100"/>
                                 </div>
                            </span>

                        </label>
                    </div>
                    <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" name="pay_mode" v-model="bookingForm.payment.method"
                                   data-payment="radio" checked value="3"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <div class="finally-payment-radio-content-title" style="margin-top: 14px;"><?php _lang('offer.payment.creditcart') ?></div>
                               <span class="finally-payment-radio-content-text"><?php //_lang('offer.payment.creditcom') ?></span>
                                     <div class="finally-payment-radio-content-image">
                                     <img src="<?php theme_dir() ?>assets/img/cards.png" width="150"/>
                                 </div>
                            </span>
                        </label>
                    </div> -->
                </div>
                <div class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('offer.conditions') ?></h3>
                    </div>
                    <div class="finally-faq-item-collapse">

                        <label class="checkbox checkbox-default">
                            <input type="checkbox" name="check1" v-model="bookingForm.aggregment" id='aggregment'
                                   required/>
                            <span class="checkbox-default-icon border"></span>
                            <span class="checkbox-default-text dark">
                                <?php _lang('offer.condition1') ?>
                                <br>
                                <br>
                                <?php _lang('offer.condition2') ?>
                                <br>
                                <br>
                                <?php _lang('offer.condition3') ?>
                                <br>
                                <br>
                                  <?php _lang('user.subscribe_request') ?>
                            </span>
                        </label>
                        <label class='input'>
                            <span class="input-message " v-bind:id="'aggregment_message'" style="padding-left:25px">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php _lang('booking.form.req.aggregment') ?></span>
                            </span>
                        </label>
                        
                        <label class="checkbox checkbox-default">
                            <input type="checkbox" name="check2" v-model="bookingForm.tourAggregment" id='tourAggregment'
                                   required/>
                            <span class="checkbox-default-icon border"></span>
                            <span class="checkbox-default-text dark">
                                <?php
                                    $el =  _lang('offer.tourOperator.aggregment',true);
                                    $el =  str_replace('{{ OPERATOR_URL }}','/service/operators/condition/',$el);
                                    echo $el;
                                ?>
                               
                            </span>
                        </label>
                        <label class='input'>
                            <span class="input-message " v-bind:id="'tourAggregment_message'" style="padding-left:25px">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?php _lang('booking.form.req.aggregment') ?></span>
                            </span>
                        </label>
                        
                        <div class="finally-holiday d-none">
                            <div class="finally-holiday-left">
                                <div class="finally-holiday-image">
                                    <!-- <img v-bind:src="'http://thumbnails.travel-it.com/g2thmb.php?gid='+offer['SERVICE']['ACCOMMODATION']['GID']" alt="Image"/>-->
                                </div>
                            </div>
                            <div class="finally-holiday-center">
                                <div class="finally-holiday-title">
                                    {{hotel.catalogData.hotel.name}}
                                </div>
                                <div class="finally-holiday-stars" v-if="hotel.category">
                                    <i class="icon icon-results-star" v-for='n in parseInt(hotel.category)'></i>
                                </div>
                                <div class="finally-holiday-description">{{offer.commonOffer.hotelOffer.roomType.name}}
                                </div>
                            </div>
                            <div class="finally-holiday-right">
                                <div class="finally-holiday-numbers">
                                    <div class="finally-holiday-numbers-item">{{offer.commonOffer.travelDate.duration}}</div>
                                </div>
                                <?php _lang('messages.Tage bis zum Urlaub!') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="finally-section mt-5">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('offer.price_summary') ?></h3>
                    </div>
                    <div class="finally-price">
                        <div class="finally-price-item">
                            <div class="finally-price-item-text">
                                <div class="finally-price-item-text-left">
                                    {{filter.adults}} <?php _lang('search.adult') ?>
                                </div>
                                <div class="finally-price-item-text-right">
                                    {{ offer.totalPrice.currency  }} {{ offer.totalPrice.label  }}
                                </div>
                            </div>
                            <div class="finally-price-item-text" v-show="filter.children.length > 0 ">
                                <div class="finally-price-item-text-left">
                                    {{filter.children.length}} <?php _lang('search.children') ?>
                                </div>
                                <div class="finally-price-item-text-right">

                                </div>
                            </div>
                        </div>

                        <div class="finally-price-item" v-show="bookingForm.payment.method == 3">
                            <div class="finally-price-item-text">
                                <div class="finally-price-item-text-left">
                                    <?php _lang('offer.payment.credit_cart') ?>
                                </div>
                                <div class="finally-price-item-text-right">
                                   {{ offer.totalPrice.currency  }} <span class="kredit_amount"></span>
                                </div>
                            </div>
                        </div>
                        <div class="finally-price-item" v-show="offer.discount > 0">
                            <div class="finally-price-item-text">
                                <div class="finally-price-item-text-left">
                                    <?php _lang('offer.coupon_code_discount') ?>
                                </div>
                                <div class="finally-price-item-text-right">
                                    - {{ offer.totalPrice.currency  }} <span class="kredit_amount">{{offer.discount}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="finally-price-total">
                            <div class="finally-price-total-left">
                                <?php _lang('offer.amount') ?>
                                <small><?php _lang('offer.amount_text') ?></small>
                            </div>
                            <div class="finally-price-total-right">
                               {{ offer.totalPrice.currency  }} {{ offer.totalPrice.label  }}
                            </div>
                        </div>
                        <div class="finally-price-ssl">
                            <div class="finally-price-ssl-left">

                            </div>
                            <div class="finally-price-ssl-right">
                                <button class="button m-lg-0 mx-2 my-4" v-on:click='book' v-href="" title="Title"
                                        v-bind:disabled="booking.bookingCreate == true">
                                    <?php _lang('offer.complete') ?>
                                    <i v-show="booking.bookingCreate == false" class="icon icon-header-arrow-right"></i>
                                    <i v-show="booking.bookingCreate == true" class="fas fa-spinner ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="flugDetail" tabindex="-1" role="dialog" aria-hidden="true" v-if="offer['SERVICE']">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-close registered">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-title-content">
                        <div class="modal-title-text"><?php _lang('offer.flight_info') ?></div>
                    </div>
                </div>
            </div>
            <div class="modal-main" style="overflow: hidden">
                <div>
                    <div class="flight-detail" v-show='filter.sf == 2'>
                        <div class="detail" v-for="flight in offer.commonOffer.flightOffer['flight']['outbound']['legList']" >
                            <div class="d-flex justify-content-between">
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title">
                                    <h5 class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title-text"><?php _lang('offer.flight_return') ?>
                                        : {{ Marti.Tools.frontEndDateFormat(flight.departureTime) }}</h5>
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-name">
                                        {{flight.flightCarrierName}}
                                    </div>
                                </div>
                                <div class="flight-details-airlineicon">
                                    <img :src=Marti.Tools.getAirlineIconByFlightNr(flight.flightCarrierCode) class="img-responsive"
                                         onerror="this.src='/themes/web/martireisen/assets/img/airways/noimage.svg'"
                                         alt="Airline Icon"/>
                                </div>
                            </div>
                            <div class="flight-item">
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-left">
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.departureAirportCode}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.departureAirportName}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.departureTime}}</span>
                                </div>
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-center">
                                    <i class="icon icon-prices-plane-h"></i>

                                </div>
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-right">
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.arrivalAirportCode}}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.arrivalAirportName}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.arrivalTime}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="detail" v-for="flight in offer.commonOffer.flightOffer['flight']['inbound']['legList']" >
                            <div class="d-flex justify-content-between">
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title">
                                    <h5 class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-title-text"><?php _lang('offer.flight_return') ?>
                                        : {{ Marti.Tools.frontEndDateFormat(flight.departureTime) }}</h5>
                                    <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-name">
                                        {{flight.flightCarrierName}}
                                    </div>
                                </div>
                                <div class="flight-details-airlineicon">
                                    <img :src=Marti.Tools.getAirlineIconByFlightNr(flight.flightCarrierCode) class="img-responsive"
                                         onerror="this.src='/themes/web/martireisen/assets/img/airways/noimage.svg'"
                                         alt="Airline Icon"/>
                                </div>
                            </div>
                            <div class="flight-item">
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-left">
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.departureAirportCode}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.departureAirportName}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.departureTime}}</span>
                                </div>
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-center">
                                    <i class="icon icon-prices-plane-h-down"></i>

                                </div>
                                <div class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-right">
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-title">{{flight.arrivalAirportCode}}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-text">{{flight.arrivalAirportName}}</span>
                                    <span class="results-hotel-tab-content-prices-main-item-collapse-box-flight-details-meta-time">{{flight.arrivalTime}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal " id="aggregment" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-close registered">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-title-content">
                        <div class="modal-title-icon"></div>
                        <div class="modal-title-text"> <?php _lang('hotels.offer_info'); ?></div>
                    </div>
                </div>
            </div>
            <div class="modal-main" style="overflow: hidden">
                <iframe src=""></iframe>
            </div>
        </div>
    </div>
</div>
<div class="mobile-sidenav d-block d-md-none" id="mobile-flugdetailsModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="mobile-container">
        <div class="header">
            <div class="text">
                abflugdetailsModal Title
            </div>
            <div class="mobile-close">
                <i class="icon icon-modal-close"></i>
            </div>

            <div class="mobile-divider"></div>

        </div>
        <div class="body">
            abflugdetailsModal Body
        </div>
    </div>
</div>
<div class="modal fade" id="flugdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-close registered">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-body">

                <h4>abflugdetailsModal Title</h4>
                <p>
                    abflugdetailsModal Body
                </p>

            </div>
        </div>
    </div>
</div>
<div class="mobile-sidenav d-block d-md-none" id="mobile-offer-info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="mobile-container">
        <div class="header">
            <div class="text">
                <?php _lang('hotels.offer_info'); ?>
            </div>
            <div class="mobile-close">
                <i class="icon icon-modal-close"></i>
            </div>

            <div class="mobile-divider"></div>

        </div>
        <div class="modal-body">
            <div class="infobox iframe-area">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="offer-info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-close registered">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-body">
                <div class="infobox iframe-area">

                </div>
            </div>
        </div>
    </div>
</div>