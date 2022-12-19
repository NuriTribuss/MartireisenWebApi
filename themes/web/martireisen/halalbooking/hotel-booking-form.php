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

<div id="finally" class="finally" v-if='typeof hotel.id != "undefined"'>
    <div class="container">
        <div class="finally-title">
            <h3 class="finally-title-text"><?php _lang('booking.title') ?></h3>
        </div>
        <div class="finally-summary row m-0 p-2 mb-4">
            <div class="finally-summary-col col-12 col-md-3">
                <div class="finally-summary-image">
                    <img v-bind:src="hotel.photo" alt="Image"/>
                </div>
                <div class="finally-summary-title">{{hotel.name}}</div>
                <div class="finally-summary-stars">
                    <i class="icon icon-results-star" v-for='n in hotel.stars'></i>
                </div>
                <div class="finally-summary-description">{{hotel.location.city}} , {{hotel.location.name}}</div>
            </div>
            <div class="finally-summary-col col-12 col-md-3">
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.services') ?></h3>
                <ul class="finally-summary-list">
                    <li>{{booking.data.room.name}} x {{booking.data.quantity}}</li>
                    <li>{{booking.data.rate_plan.meal_plan_name}}</li>
                </ul>
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('offer.additional_services') ?></h3>
            </div>
            <div class="finally-summary-col col-12 col-md-3">
                <h3 class="finally-summary-main-title d-none d-md-block"><?php _lang('search.travel_data') ?></h3>
                <p>
                    <i class="fas fa-arrow-right"></i> {{renderDate(filter.date.start)}}
                </p>
                <p>
                    <i class="fas fa-arrow-left"></i> {{renderDate(filter.date.end)}}
                </p>
            </div>
            <div class="finally-summary-col col-12 col-md-3">
                <h3 class="finally-summary-main-title"><?php _lang('offer.is_available') ?></h3>
                <div class="finally-summary-travellers">
                    <div class="finally-summary-travellers-item">
                        <span class="text">{{booking.traveller}} <?php _lang('search.adult') ?></span>
                    </div>
                    <div class="finally-summary-travellers-item" v-if="booking.children && booking.children.length > 0">
                        <span class="text">{{booking.children.length}} <?php _lang('search.children') ?></span>
                    </div>

                </div>
                <div class="finally-summary-total">
                    <div class="finally-summary-total-left">
                        <?php _lang('offer.amount') ?>
                        <small><?php _lang('offer.amount_text') ?></small>
                    </div>
                    <div class="finally-summary-total-right">
                        {{Marti.getCurrency()}} {{Marti.Tools.numberWithThousandSep(booking.price)}}
                        <small>.00</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <?php if ((int)\Model\User\Customer::getId() <= 0) { ?>
                    <div class="finally-login-message">
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
                            <a class="loginbuttons button c-pointer" title="Einloggen">
                                <?php _lang('user.login') ?>
                                <i class="icon icon-header-arrow-right"></i>
                            </a>
                            <a class="loginbuttons finally-login-message-buttons-link c-pointer"
                               title="Reg"><?php _lang('hotels.Ich möchte mich registrieren') ?></a>
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
                                <input type="radio" name="gender" v-model="bookingForm.personal.gender" checked
                                       value="1"/>
                                <span class="radio-default-icon"></span>
                                <span class="radio-default-text"><?php _lang('user.profile.male') ?></span>
                                <span class="radio-default-status"></span>
                            </label>
                        </div>
                        <div class="col-4 col-md-2">
                            <label class="radio radio-default border p-3">
                                <input type="radio" name="gender" v-model="bookingForm.personal.gender" value="2"/>
                                <span class="radio-default-icon"></span>
                                <span class="radio-default-text"><?php _lang('user.profile.female') ?></span>
                                <span class="radio-default-status"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="input succes">
                                <span class="input-label dark"><?php _lang('user.profile.name') ?>:</span>
                                <span class="input-message " id="personal_name_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_name') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive" type="text" v-model="bookingForm.personal.name"
                                               id="personal_name" required/>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="input dange">
                                <span class="input-label dark"><?php _lang('user.profile.surname') ?>:</span>
                                <span class="input-message " id="personal_surname_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_surname') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive" type="text" id="personal_surname"
                                               v-model="bookingForm.personal.surname"/>
                                    </span>
                                </span>

                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input d-block">
                                <span class="input-label dark"><?php _lang('user.profile.birthday') ?>:</span>
                                <span class="input-message " id="personal_birthday_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_birthday') ?></span>
                                </span>
                                <marti-birthday-picker v-model="bookingForm.personal.birthday"
                                                       v-bind:id="'personal_birthday'"></marti-birthday-picker>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="input">
                                <span class="input-label dark"><?php _lang('user.profile.address') ?>:</span>
                                <span class="input-message " id="personal_address_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_address') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input class="border LoNotSensitive" v-model="bookingForm.personal.address"
                                               id="personal_address" type="text"/>
                                    </span>
                                </span>

                            </label>
                        </div>

                        <div class="col-md-2">
                            <label class="input">
                                <span class="input-label dark"> <?php _lang('user.profile.state') ?>:</span>
                                <span class="input-message " id="personal_state_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_state') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input v-model="bookingForm.personal.state" class="border LoNotSensitive" id="personal_state"
                                               type="text"/>
                                    </span>
                                </span>

                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="input">
                                <span class="input-label dark"> <?php _lang('user.profile.city') ?>:</span>
                                <span class="input-message " id="personal_city_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_city') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input v-model="bookingForm.personal.city" class="border LoNotSensitive" type="text"
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
                                    <span><?php _lang('booking.form.req.country') ?></span>
                                </span>
                                <div class="selectbox-mega-select">
                                    <select name="reg_land" v-model="bookingForm.personal.country"
                                            data-selectbox="select">
                                        <option v-bind:value="region.code" v-for="region in countries"
                                                :selected="region.code == 'AT'">{{ region.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="selectbox-mega-button">
                                    <button class="button" type="button">
                                        <span class="selectbox-mega-button-text" data-selectbox="text">{{ getCountryByCode(bookingForm.personal.country)}}</span>
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
                                <span class="input-label dark"><?php _lang('user.profile.mail') ?>:</span>
                                <span class="input-message " id="personal_email_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_email') ?></span>
                                </span>
                                <span class="input-main">
                                     <span class="input-main-data">
                                         <input class="border" type="email" v-model="bookingForm.personal.email"
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
                                <span class="input-label dark"><?php _lang('user.profile.phone') ?>:</span>
                                <span class="input-message " id="personal_phone_message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span><?php _lang('booking.personal.e_phone') ?></span>
                                </span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input placeholder="zb. +49 123 34567890" class="border" type="tel" v-model="bookingForm.personal.phone"
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
                                <h2 class="finally-section-title">{{index+1}}. <?php _lang('search.adult') ?>:</h2>
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
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="input">
                                    <span class="input-label dark"><?php _lang('user.profile.name') ?>:</span>
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
                                    <span class="input-label dark"><?php _lang('user.profile.surname') ?>:</span>
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
                                    <span class="input-label dark"><?php _lang('user.profile.birthday') ?>:</span>
                                    <span class="input-message " v-bind:id="'traveller'+index+'_birthday_message'">
                                       <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_birthday') ?></span>
                                    </span>
                                    <marti-birthday-picker v-model="value.birthday"
                                                           v-bind:id="'traveller'+index+'_birthday'"></marti-birthday-picker>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="adult-input" v-for="(children,index) in bookingForm.children">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="finally-section-title">{{index+1}}. <?php _lang('search.children') ?>:</h2>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <label class="input">
                                    <span class="input-label dark"><?php _lang('user.profile.surname') ?>:</span>
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
                            <div class="col-md-4">
                                <div class="input d-block">
                                    <span class="input-label dark"><?php _lang('user.profile.birthday') ?>:</span>
                                    <span class="input-message " v-bind:id="'children'+index+'_birthday_message'">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span><?php _lang('booking.traveller.e_birthday') ?></span>
                                    </span>
                                    <marti-birthday-picker children="true" v-model="children.birthday"
                                                           v-bind:id="'children'+index+'_birthday'"></marti-birthday-picker>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('offer.coupon_code_title') ?></h3>
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
                                    <i class="icon icon-header-arrow-right ml-2"></i>
                                </button>
                                <div class="alert alert-success" style="display: none">
                                    success <span class="discount-pay"></span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <span class="input-message " v-bind:id="'aggregment_message'">
                                <span><?php _lang('booking.form.req.aggregment') ?></span>
                            </span>
                        </label>

                    </div>
                </div>
                <div id="kredit-karte" class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('offer.payment.title') ?></h3>
                    </div>
                    <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" v-model="bookingForm.payment.method" name="pay_mode"
                                   data-payment="radio" value="1"/>
                            <span class="finally-payment-radio-icon">
                            </span>
                            <span class="finally-payment-radio-content d-block">
                                <div class="finally-payment-radio-content-title"><?php _lang('offer.payment.offline') ?></div>
                                <div v-show="bookingForm.payment.method == 1">
                                    <small><?php _lang('offer.payment.uberweisung') ?></small>
                                </div>
                            </span>
                        </label>
                    </div>
                    <div class="finally-payment" data-payment="root">
                        <label class="finally-payment-radio">
                            <input type="radio" name="pay_mode" v-model="bookingForm.payment.method" data-payment="radio" value="2"/>
                            <span class="finally-payment-radio-icon">
                            </span>
                            <span class="finally-payment-radio-content">
                                <span class="finally-payment-radio-content-title">
                                    Klarna - Sofortüberweisung
                                </span>
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
                            <span class="finally-payment-radio-icon">
                            </span>
                            <span class="finally-payment-radio-content">
                                <div class="finally-payment-radio-content-title" style="margin-top: 14px;"><?php _lang('offer.payment.creditcart') ?></div>
                                       <div class="finally-payment-radio-content-image">
                                     <img src="<?php theme_dir() ?>assets/img/cards.png" width="250"/>
                                 </div>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="finally-section">
                    <div class="finally-title">
                        <h3 class="finally-title-text"><?php _lang('offer.price_summary') ?></h3>
                    </div>
                    <div class="finally-price">
                        <div class="finally-price-item">
                            <div class="finally-price-item-text">
                                <div class="finally-price-item-text-left">
                                    <!--groups--> <?php _lang('search.adult') ?>
                                </div>
                                <div class="finally-price-item-text-right">
                                    {{Marti.getCurrency()}}
                                    {{Marti.Tools.numberWithThousandSep(booking.price)}}<small>.00</small>
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
                                    {{Marti.getCurrency()}} 1.60<span class="kredit_amount"></span>
                                </div>
                            </div>
                        </div>
                        <div class="finally-price-total">
                            <div class="finally-price-total-left">
                                <?php _lang('offer.amount') ?>
                                <small><?php _lang('offer.amount_text') ?></small>
                            </div>
                            <div class="finally-price-total-right">
                                {{Marti.getCurrency()}} <span class="total-price">{{Marti.Tools.numberWithThousandSep(booking.price)}}</span><small>.00</small>
                            </div>
                        </div>
                        <div class="finally-price-ssl">
                            <div class="finally-price-ssl-left">

                            </div>
                            <div class="finally-price-ssl-right">
                                <button class="button" v-on:click='book' title="Title"
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