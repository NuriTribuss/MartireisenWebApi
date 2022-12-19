
<div class="booking-loader" v-show="loader.bookingCreate">
    <div class="lds-css ng-scope">
        <div class="lds-dual-ring"></div>
    </div>
</div>
<div id="finally" class="finally">
    <div class="container" v-show="loader.bookingCheck">
        <marti-loader></marti-loader>
    </div>
    <div class="container" v-if="summary.tour">
        <?php if($this->payment_error == true) { ?>
        <div class="card  w-100 mb-4">
                <div class="card-body d-flex">
                    <i class="fa fa-times-circle text-danger fa-4x mr-4"></i>
                    <div>
                        <h2 class="font-weight-bold text-danger"><?php _lang('offer.payment_error')?></h2>
                        <p><?php _lang('offer.payment_error_desc')?></p>
                    </div>
                </div>
            </div>
        <?php }?>
        <div class="finally-summary row m-0 p-2 mb-4 d-none">
            <div class="finally-summary-col col-12 col-md-3">
                <div class="finally-summary-image">
                    <img v-bind:src="summary.tour.image" alt="Image"/>
                </div>
                <div class="finally-summary-title">{{summary.tour.title}}</div>
                <div class="finally-summary-stars">
                    <i class="icon icon-results-star" v-for='n in 5'></i>
                </div>
                <div class="finally-summary-description">{{summary.tour.destination}}</div>
            </div>
            <div class="finally-summary-col col-12 col-md-3">
                <h3 class="finally-summary-main-title d-none d-md-block">{{translate['offer.services']}}</h3>
                <ul class="finally-summary-list">
                    <li v-for="property in summary.tour.properties" v-if="property.is_free == 1">{{property.title}}</li>
                </ul>
            </div>
            <div class="finally-summary-col col-12 col-md-3">
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('tour.reservation_information')?> </h3>
                <p>
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <?php _lang('tour.departure_date')?> : <br> {{summary.period.start_date_pretty}}
                </p>
                <p>
                    <i class="fas fa-bus mr-2"></i>
                    <?php _lang('tour.departure_stop')?> : <br> {{summary.station.station}} {{summary.station.hour}}
                </p>
            </div>
            <div class="finally-summary-col col-12 col-md-3">
                <h3 class="finally-summary-main-title"><?php _lang('tour.payment_information')?></h3>
                <div class="finally-summary-travellers">
                    <div class="finally-summary-travellers-item">
                        <span class="text">{{summary.adult}} {{translate['search.adult']}}</span>
                    </div>
                    <div class="finally-summary-travellers-item" v-if="summary.children > 0">
                        <span class="text">{{summary.children}} {{translate['search.children']}}</span>
                    </div>
                </div>
                <div class="finally-summary-total">
                    <div class="finally-summary-total-left">
                        {{translate['offer.amount']}}
                        <small>{{translate['offer.amount_text']}}</small>
                    </div>
                    <div class="finally-summary-total-right">
                        {{Marti.getCurrency()}} {{Marti.Tools.numberWithThousandSep(summary.total)}}
                        <small>.00</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-12  order-1 order-md-0">
                <div class="finally-login-message" v-if="!(Marti.Member.id > 0)">
                    <div class="finally-login-message-icon">
                        <i class="icon icon-finally-person"></i>
                        <div class="finally-login-message-icon-title d-block d-md-none hidden-sm">
                            {{translate['offer.login.account']}}
                        </div>
                    </div>
                    <div class="finally-login-message-content">
                        <h5 class="finally-login-message-content-title hidden-xs hidden-xxs">
                            {{translate['offer.login.account']}}</h5>
                        <p class="finally-login-message-content-text">
                            {{translate['offer.login.account_text']}}
                        </p>
                    </div>
                    <div class="finally-login-message-buttons">
                        <a class="loginbuttons button c-pointer" title="Einloggen">
                            {{translate['user.login']}}
                            <i class="icon icon-header-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="finally-section">
                            <div class="finally-title">
                                <h3 class="finally-title-text">{{translate['user.profile.title']}}</h3>
                            </div>
                            <div class="row">
                                <div class="col-4 col-md-12 d-flex">
                                   
                                    <label class="radio radio-default border p-3 mr-2">
                                        <input type="radio" name="gender" v-model="bookingForm.personal.gender"  value="1"/>
                                        <span class="radio-default-icon"></span>
                                        <span class="radio-default-text">{{translate['user.profile.male']}}</span>
                                        <span class="radio-default-status"></span>
                                    </label>
                                     <label class="radio radio-default border p-3 ">
                                        <input type="radio" name="gender" v-model="bookingForm.personal.gender"    value="2"/>
                                        <span class="radio-default-icon"></span>
                                        <span class="radio-default-text">{{translate['user.profile.female']}}</span>
                                        <span class="radio-default-status"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="input succes">
                                        <span class="input-label dark">{{translate['user.profile.name']}}:</span>
                                        <span class="input-message " id="personal_name_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_name']}}</span>
                                        </span>
                                        <input class="form-control form-marti p-4 LoNotSensitive" type="text" placeholder="<?php _lang('user.profile.name.placeholder') ?>"
                                               v-model="bookingForm.personal.name" id="personal_name" required/>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="input dange">
                                        <span class="input-label dark">{{translate['user.profile.surname']}}:</span>
                                        <span class="input-message " id="personal_surname_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_surname']}}</span>
                                        </span>
                                        <input class="form-control form-marti p-4 LoNotSensitive" type="text" id="personal_surname" placeholder="<?php _lang('user.profile.surname.placeholder') ?>"
                                               v-model="bookingForm.personal.surname"/>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="input">
                                        <span class="input-label dark">{{translate['user.profile.mail']}}:</span>
                                        <span class="input-message " id="personal_email_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_email']}}</span>
                                        </span>
                                        <input class="form-control form-marti p-4" type="email"  placeholder="<?php _lang('user.profile.mail.placeholder') ?>"
                                               v-model="bookingForm.personal.email" id="personal_email"/>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="input">
                                        <span class="input-label dark">{{translate['user.profile.phone']}}:</span>
                                        <span class="input-message " id="personal_phone_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_phone']}}</span>
                                        </span>
                                        <input class="form-control form-marti p-4" type="text"  placeholder="<?php _lang('user.profile.phone.placeholder') ?>"
                                               v-model="bookingForm.personal.phone" id="personal_phone_message"/>
                                        
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input">
                                        <span class="input-label dark">{{translate['user.profile.address']}}:</span>
                                        <span class="input-message " id="personal_address_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_address']}}</span>
                                        </span>
                                        <input class="form-control form-marti p-4 LoNotSensitive" placeholder="<?php _lang('user.profile.address.placeholder') ?>"
                                               v-model="bookingForm.personal.address" id="personal_address"
                                               type="text"/>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="selectbox selectbox-mega" data-selectbox="root">
                                        <div class="selectbox-mega-title">
                                            {{translate['user.profile.region']}}
                                        </div>
                                        <span class="input-message " id="personal_country_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.form.req.country']}}</span>
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
                                                <span class="selectbox-mega-button-text" data-selectbox="text">{{ getCountryByCode(bookingForm.personal.country) }}</span>
                                                <span class="selectbox-mega-button-icon"><i
                                                            class="icon icon-selectbox-caret"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="input">
                                        <span class="input-label dark"> {{translate['user.profile.state']}}:</span>
                                        <span class="input-message " id="personal_state_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_state']}}</span>
                                        </span>
                                        <input v-model="bookingForm.personal.state" placeholder="<?php _lang('user.profile.state.placeholder') ?>"  class="form-control form-marti p-4 LoNotSensitive"
                                               id="personal_state" type="text"/>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="input">
                                        <span class="input-label dark"> {{translate['user.profile.city']}}:</span>
                                        <span class="input-message " id="personal_city_message">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span>{{translate['booking.personal.e_city']}}</span>
                                        </span>
                                        <input v-model="bookingForm.personal.city"  placeholder="<?php _lang('user.profile.city.placeholder') ?>" class="form-control form-marti p-4 LoNotSensitive"
                                               type="text" id="personal_city"/>
                                    </label>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="finally-section mb-0">
                            <div class="finally-title">
                                <h3 class="finally-title-text">{{translate['search.traveller']}}</h3>
                            </div>
                            <div class="adult-input" v-for="(value,index) in bookingForm.traveller">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="finally-section-title">{{index+1}}.
                                            {{translate['search.adult']}}:</h2>
                                        <label class="checkbox checkbox-default" v-if="index == 0">
                                            <input type="checkbox" v-model="bookingForm.traveller_first" required/>
                                            <span class="checkbox-default-icon border"></span>
                                            <span class="checkbox-default-text lead mb-2">
                                                <?php _lang('booking.traveller.mine') ?>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <label class="radio radio-default border p-3 mr-2">
                                            <input type="radio" v-model="value.gender" value="1" checked/>
                                            <span class="radio-default-icon"></span>
                                            <span class="radio-default-text">{{translate['user.profile.male']}}</span>
                                            <span class="radio-default-status"></span>
                                        </label>
                                        <label class="radio radio-default border p-3">
                                            <input type="radio" v-model="value.gender" value="2"/>
                                            <span class="radio-default-icon"></span>
                                            <span class="radio-default-text">{{translate['user.profile.female']}}</span>
                                            <span class="radio-default-status"></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="input">
                                            <span class="input-label dark">{{translate['user.profile.name']}}:</span>
                                            <span class="input-message " v-bind:id="'traveller'+index+'_name_message'">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>{{translate['booking.traveller.e_name']}}</span>
                                            </span>
                                            <input class="form-control form-marti p-4 LoNotSensitive"
                                                   v-bind:id="'traveller'+index+'_name'" v-model="value.name"
                                                   type="text"/>

                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="input">
                                            <span class="input-label dark">{{translate['user.profile.surname']}}:</span>
                                            <span class="input-message "
                                                  v-bind:id="'traveller'+index+'_surname_message'">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>{{translate['booking.traveller.e_surname']}}</span>
                                            </span>
                                            <input class="form-control form-marti p-4 LoNotSensitive"
                                                   v-bind:id="'traveller'+index+'_surname'" v-model="value.surname"
                                                   type="text"/>
                                        </label>
                                    </div>
                                   
                                </div>

                            </div>
                            <div class="adult-input" v-for="(children,index) in bookingForm.children">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="finally-section-title">{{index+1}}.
                                            {{translate['search.children']}}:</h2>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="input">
                                            <span class="input-label dark">{{translate['user.profile.name']}}:</span>
                                            <span class="input-message " v-bind:id="'children'+index+'_name_message'">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>{{translate['booking.traveller.e_name']}}</span>
                                            </span>
                                            <input class="form-control form-marti p-4 LoNotSensitive" v-model="children.name"
                                                   v-bind:id="'children'+index+'_name'" type="text"/>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="input">
                                            <span class="input-label dark">{{translate['user.profile.surname']}}:</span>
                                            <span class="input-message "
                                                  v-bind:id="'children'+index+'_surname_message'">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>{{translate['booking.traveller.e_surname']}}</span>
                                            </span>
                                            <input class="form-control form-marti p-4 LoNotSensitive" v-model="children.surname"
                                                   v-bind:id="'children'+index+'_surname'" type="text"/>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="input d-block">
                                            <span class="input-label dark">{{translate['user.profile.birthday']}}:</span>
                                            <span class="input-message "
                                                  v-bind:id="'children'+index+'_birthday_message'">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>{{translate['booking.traveller.e_birthday']}}</span>
                                            </span>
                                            <marti-birthday-picker children="true" v-bind:id="'children'+index+'_birthday'"
                                                                   v-model="children.birthday"></marti-birthday-picker>

                                        </div>
                                    </div>
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
                        <div class="col-md-6 d-flex">

                            <div class="input-group mb-3">
                                <input class="form-control form-marti p-4 shadow-none LoNotSensitive" type="text" id="discountCode"
                                       name="coupon_code"/>
                                <div class="input-group-append">
                                    <button class="button btn btn-marti" type="button" title="Coupon"
                                            id="checkCouponCode">
                                        {{translate['offer.coupon_apply']}}
                                        <i class="icon icon-header-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div id="kredit-karte" class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text">{{translate['offer.payment.title']}}</h3>
                    </div>
                    <div class="finally-payment pr-3" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" v-model="bookingForm.payment.method" name="pay_mode"
                                   data-payment="radio" value="1"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <span class="finally-payment-radio-content-title">Ön Kayıt </span>
                                <span class="finally-payment-radio-content-text">{{translate['offer.payment.offline_text']}}</span>
                            </span>
                        </label>
                    </div>
                    <div class="finally-payment pr-3" data-payment="root" v-show="summary.bus_payment">
                        <label class="finally-payment-radio">
                            <input type="radio" v-model="bookingForm.payment.method" name="pay_mode"
                                   data-payment="radio" value="4"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <span class="finally-payment-radio-content-title"> <?php _lang('tour.pay_on_the_bus')?></span>
                                <span class="finally-payment-radio-content-text"> <?php _lang('tour.pay_on_the_bus_message')?> </span>
                            </span>
                        </label>
                    </div>
                    <div class="finally-payment pr-3" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" name="pay_mode" v-model="bookingForm.payment.method"
                                   data-payment="radio" value="2"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <span class="finally-payment-radio-content-title"><?php _lang('tour.sofort')?>  <img
                                            src="https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/pay_now/descriptive/pink.svg"
                                            height="31" align="absmiddle"></span>
                                <span class="finally-payment-radio-content-text">{{translate['offer.payment.onlinebanking']}}</span>
                            </span>
                        </label>
                    </div>
                    <div class="finally-payment pr-3" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" name="pay_mode" v-model="bookingForm.payment.method"
                                   data-payment="radio" checked value="3"/>
                            <span class="finally-payment-radio-icon"></span>
                            <span class="finally-payment-radio-content">
                                <span class="finally-payment-radio-content-title">{{translate['offer.payment.creditcart']}}</span>
                                <span class="finally-payment-radio-content-text">
                                    <img width="40" src="/themes/web/martireisen/assets/img/payment/mastercard.svg"/>
                                    <img width="40" src="/themes/web/martireisen/assets/img/payment/visa.svg"/>

                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text">{{translate['offer.price_summary']}}</h3>
                    </div>
                    <div class="finally-price">
                        <div class="finally-price-item">
                            <div class="finally-price-item-text">
                                <div class="finally-price-item-text-left">
                                    <!--groups-->{{summary.adult}} {{translate['search.adult']}}
                                </div>
                                <div class="finally-price-item-text-right">
                                    <small>(<?php _lang('tour.per_person')?> )</small> {{Marti.getCurrency()}}
                                    {{Marti.Tools.numberWithThousandSep(summary.station.price)}}
                                </div>
                            </div>
                            <div class="finally-price-item-text" v-show="summary.children != 0 ">
                                <div class="finally-price-item-text-left">
                                    {{summary.children}} {{translate['search.children']}}
                                </div>
                                <div class="finally-price-item-text-right">
                                    <small>(<?php _lang('tour.per_person')?>)</small> {{Marti.getCurrency()}}
                                    {{Marti.Tools.numberWithThousandSep(summary.station.child_price > 0 ?
                                    summary.station.child_price : summary.station.price)}}
                                </div>
                            </div>
                        </div>
                        <div class="finally-price-item" v-show="bookingForm.payment.method == 3">
                            <div class="finally-price-item-text">
                                <div class="finally-price-item-text-left">
                                    {{translate['offer.payment.credit_cart']}}
                                </div>
                                <div class="finally-price-item-text-right">
                                    {{Marti.getCurrency()}} 1.60<span class="kredit_amount"></span>
                                </div>
                            </div>
                        </div>
                        <div class="finally-price-total">
                            <div class="finally-price-total-left">
                                {{translate['offer.amount']}}
                                <small>{{translate['offer.amount_text']}}</small>
                            </div>
                            <div class="finally-price-total-right">
                                {{Marti.getCurrency()}} <span class="total-price">{{Marti.Tools.numberWithThousandSep(summary.total)}}</span><small>.00</small>
                            </div>
                        </div>
                        <div class="finally-price-ssl">
                            <div class="finally-price-ssl-left">

                            </div>
                            <div class="finally-price-ssl-right">
                                <button class="button" v-on:click='book' title="Title"
                                        v-bind:disabled="booking.bookingCreate == true">
                                    {{translate['offer.complete']}}
                                    <i v-show="booking.bookingCreate == false" class="icon icon-header-arrow-right"></i>
                                    <i v-show="booking.bookingCreate == true" class="fas fa-spinner ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-order-1">
                <div class="card">
                    <div class="card-body">
                        <div class="finally-title">
                            <h3 class="finally-title-text">{{translate['booking.title']}}</h3>
                        </div>
                        <div class="finally-summary row m-0 mb-4 shadow-none">
                            <div class="finally-summary-col col-12 border-0 ">
                                <div class="finally-summary-image">
                                    <img v-bind:src="summary.tour.image" alt="Image"/>
                                </div>
                                <div class="finally-summary-title">{{summary.tour.title}}</div>
                                <div class="finally-summary-stars">
                                    <i class="icon icon-results-star" v-for='n in 5'></i>
                                </div>
                                <div class="finally-summary-description">{{summary.tour.destination}}</div>
                            </div>
                            <div class="finally-summary-col col-12 border-0 ">
                                <h3 class="finally-summary-main-title d-none d-md-block">
                                    {{translate['offer.services']}}</h3>
                                <ul class="finally-summary-list">
                                    <li v-for="property in summary.tour.properties" v-if="property.is_free == 1">
                                        {{property.title}}
                                    </li>
                                </ul>

                            </div>
                            <div class="finally-summary-col col-12 border-0 ">
                                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('tour.reservation_information')?></h3>
                                <div class="row">
                                    <div class="col-6">
                                        <p>
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <?php _lang('tour.departure_date')?>  <br> {{summary.period.start_date_pretty}}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p>
                                            <i class="fas fa-bus mr-2"></i>
                                            <?php _lang('tour.departure_stop')?> <br> {{summary.station.station}} {{summary.station.hour}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="finally-summary-col col-12 ">
                                <h3 class="finally-summary-main-title"><?php _lang('tour.payment_information')?></h3>
                                <div class="finally-summary-travellers">
                                    <div class="finally-summary-travellers-item">
                                        <span class="text">{{summary.adult}} {{translate['search.adult']}}</span>
                                    </div>
                                    <div class="finally-summary-travellers-item" v-if="summary.children > 0">
                                        <span class="text">{{summary.children}} {{translate['search.children']}}</span>
                                    </div>

                                </div>
                                <div class="finally-summary-total">
                                    <div class="finally-summary-total-left">
                                        {{translate['offer.amount']}}
                                        <small>{{translate['offer.amount_text']}}</small>
                                    </div>
                                    <div class="finally-summary-total-right">
                                        {{Marti.getCurrency()}}
                                        {{Marti.Tools.numberWithThousandSep(summary.total)}}
                                        <small>.00</small>
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

