<template id="search-bar">
    <div id="search" class="<?php echo $this->page !== 'home' ? 'p-0' : 'pt-5 pb-5' ?> p-md-5">
        <div class="container">
            <?php if ($this->page == 'home') { ?>
                <div class="search-tab-buttons mt-lg-4">
                    <button type="button" v-on:click="filter.sf=2" class="button" v-bind:class="{'active' : filter.sf == 2}" >
                        <i class="ml-1 mr-2 fa fa-briefcase"></i>
                        {{ translate['menu.pauschal'] }}
                    </button>
                    <button type="button" v-on:click="filter.sf=3" class="button" v-bind:class="{'active' : filter.sf == 3}" >
                        <i class="ml-1 mr-2 fa fa-hotel"></i>
                        {{ translate['search.only_hotel'] }}
                    </button>
                    <button type="button" class="button" onclick="window.open('https://www.martigo.com');" >
                        <i class="ml-1 mr-2 fa fa-plane-departure"></i>
                        {{ translate['menu.flights'] }}
                    </button>
                    <button type="button" v-on:click="filter.sf=4" class="button d-none " v-bind:class="{'active' : filter.sf == 4}" >{{ translate['menu.halalbooking'] }}
                    </button>
                     <button  class="d-none" type="button" v-on:click="filter.sf=5" class="button  " v-bind:class="{'active' : filter.sf == 5}" >
                          <i class="ml-1 mr-2 fa fa-bus"></i>
                          {{translate['menu.tours'] }}
                    </button>
                </div>
            <?php } ?>

            <div id="mobile-filter" class="<?php echo $this->page !== 'home' ? 'mobile-sidenav' : '' ?>">
                <div class="mobile-container">
                    <?php if ($this->page !== 'home') { ?>
                        <div class="header d-block d-md-none">
                            <div class="text">
                                {{ translate['search.travel_data'] }}
                            </div>
                            <div class="mobile-close">
                                <i class="icon icon-modal-close"></i>
                            </div>
                            <div class="mobile-divider"></div>
                        </div>
                    <?php } ?>
                    <div class="search-tab-content <?php echo $this->page !== 'home' ? '' : 'mb-md-4' ?>">
                        <div class="search-tab-content-item active">
                            <div class="search-box" data-scroll-focus="root">
                                <div class="search-box-col">
                                    <div class="search-box-item left"
                                         v-bind:class='{"active" : destinations.clicked == false }' >
                                        <div class="search-box-item-button absearch" v-on:click="focus('destinations')">
                                            <h5 class="form-title">{{translate['search.destination']}}</h5>
                                            <div class="button" type="button" data-scroll-focus="true">
                                                <span class="search-box-item-button-icon"><i
                                                            class="icon icon-search-arrival"></i></span>
                                                <span class="search-box-item-button-text cursor-effect" v-bind:class="filter.destination.name.length > 0 || filter_destination_focused?'stop':''">
                                                    <i class="fas fa-search"></i>
                                                    <input class="abflug-search" v-model='filter.destination.name'
                                                           v-bind:class="filter.destination.name.length > 0?'entering':''"
                                                           v-on:keyup='filter_destination' type="text"
                                                           v-focus="filter_destination_focused"
                                                           @focus='filter_destination_focused = true'
                                                           @blur='filter_destination_focused = false'
                                                           :placeholder="translate['common.beliebig']"
                                                           style="border: none;padding-left: 30px;"/>
                                                    <i id="abflug-search-reset"
                                                       v-on:click='filter.destination.name = ""'
                                                       class="fa fa-times-circle"></i>
                                                             <span class="tree-point"
                                                                   v-if="filter.destination.name.length > 15">...</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="search-box-item-content" v-if="mobile.isMobile == false">
                                            <div class="p-4 p-t-5 destinations-loader" v-show="loading">
                                                <list-loader :height="240" :width="500" :speed="2"></list-loader>
                                            </div>
                                            <div v-show="loading == false" class="scroll-wrapper scrollbar-inner"
                                                 style="position: relative;">
                                                <div class="scrollbar-inner scroll-content scroll-scrolly_visible"
                                                     style=" margin-bottom: 0; margin-right: 0; max-height: 400px;">
                                                    <div class="search-box-item-content-selectbox">
                                                        <div v-bind:class="{'regions-group' : true , 'd-none' : destinations.locations.length <= 0  }">
                                                            <div class="search-box-item-content-selectbox-title">{{
                                                                translate['search.regions']}}
                                                            </div>
                                                            <div class="search-box-item-content-selectbox-option-group">
                                                                <div v-for='state in destinations.locations'
                                                                     class="search-box-item-content-selectbox-option"
                                                                     v-bind:class="{'selected' : filter.destination.code == state.code}"
                                                                     v-on:click='select_destination("state",state)'>
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                    {{state.name}}
                                                                </div>
                                                            </div>
                                                            <div class="search-box-item-content-selectbox-seperator"></div>
                                                        </div>
                                                        <div v-bind:class="{'hotels-group' : true , 'd-none' : destinations.hotels.length <= 0  }">
                                                            <div class="search-box-item-content-selectbox-title">{{
                                                                translate['search.hotels'] }}
                                                            </div>
                                                            <div class="search-box-item-content-selectbox-option-group">
                                                                <div v-for='hotel in destinations.hotels'
                                                                     class="search-box-item-content-selectbox-option"
                                                                     v-bind:class="{'selected' : filter.destination.code == hotel.code}"
                                                                     v-on:click='select_destination("hotel",hotel)'>
                                                                    <i class="fas fa-hotel"></i> <b>{{hotel.name}}</b>
                                                                    &nbsp;<small>{{hotel.location.name }}</small>
                                                                </div>

                                                            </div>
                                                            <div class="search-box-item-content-selectbox-seperator"></div>
                                                        </div>
                                                        <div>
                                                            <div class="search-box-item-content-selectbox-option-group">
                                                                <div class="search-box-item-content-selectbox-option"
                                                                     v-bind:class="{'selected' : filter.destination.code}"
                                                                     v-on:click='select_destination("state",{code : "" , name : ""})'>
                                                                    <i class="fas fa-star"></i> {{
                                                                    translate['search.default'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-show="destinations.favourites.length > 0 "
                                                             class="search-box-item-content-selectbox-title">{{
                                                            translate['search.most_popular'] }}
                                                        </div>
                                                        <div class="search-box-item-content-selectbox-option-group">
                                                            <div v-for='state in destinations.favourites'
                                                                 class="search-box-item-content-selectbox-option"
                                                                 v-bind:class="{'selected' : filter.destination.code == state.traffics_code}"
                                                                 v-on:click='select_destination("state",state)'>
                                                                <i class="fas fa-star"></i> {{state.name}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="abflughafen" class="search-box-col"
                                     v-if='filter.sf==2 && typeof departures != "undefined"'>
                                    <div class="search-box-item " data-esc="true">
                                        <h5 class="form-title">{{translate['search.departure_place']}}</h5>
                                        <div class="search-box-item-button abflughafen " data-scroll-focus="true">
                                            <button class="button search-box-departure" type="button">
                                                <span class="search-box-item-button-icon"><i
                                                            class="icon icon-search-departure"></i></span>
                                                <span class="search-box-item-button-text lmin "
                                                      data-selectbox="root">
                                                   <select style="border: none" v-model="filter.departure" >
                                                       <option v-bind:value="{code : '',name : ''}" >{{translate['search.departure_place']}}</option>
                                                       <optgroup v-bind:label="departure.name" 
                                                                 v-for="departure in departures.results" v-if="departure.items.length > 0">
                                                           <option v-bind:value="airport"
                                                                   v-for="(airport,index) in departure.items">{{airport.name}}</option>
                                                       </optgroup>
                                                   </select>
                                               </span>
                                                <span class="search-box-item-button-text sr d-none"><span
                                                            class="">{{filter.departure.name }}</span><span
                                                            v-show="filter.departure.name == '' ">{{translate['common.beliebig']}}</span></span>
                                            </button>
                                        </div>
                                        <div class="search-box-item-content d-none departure-list mobile-departure">
                                            <div class="d-sm-none">
                                                <div class="search-result-head"><span class="action-close"><i class="icon fas fa-arrow-left"></i> <span class="modal-close-title">Reiseziel oder Hotel</span></span></div>
                                            </div>
                                            <div class="modal-close-cross action-close"><i class="icon icon-modal-close"></i></div>
                                            <!-- <div class="modal-close-cross action-close d-block d-sm-none">
                                                <i class="icon icon-modal-close"></i>
                                            </div> -->
                                            <div class="scroll-wrapper scrollbar-inner" style="position: relative;">
                                                <div class="scrollbar-inner scroll-content scroll-scrolly_visible"
                                                     style="height: auto; margin-bottom: 0; margin-right: 0; max-height: 400px;">
                                                    <div class="search-box-item-content-selectbox " > 
                                                        <span v-for="departure in departures.results" class="" >
                                                            <span role="button" class="m-2 py-2 px-3 rounded d-inline-block" v-for="airport in departure.items" style="border : 1px solid #ff932b;"
                                                                 v-bind:class="{'search-box-button-d text-white' : has_departure(airport)}"
                                                                 v-on:click='select_departure(airport)'>

                                                                {{airport.name}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-block mt-0 search-box-item-content-counter">
                                                <div class="search-box-item-content-counter-button justify-content-between">
                                                    <button type="button" class="button  bg-light text-black-50" v-on:click="filter.departure.code = ''; filter.departure.name = ''">
                                                        <?php _lang('search.reset_filters')?>
                                                    </button>
                                                    <button type="button" class="button departure-select">
                                                        <?php _lang('search.filter.accept')?>
                                                        <i class="icon icon-header-arrow-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="search-box-col">

                                    <div class="search-box-item calendar" data-datepicker="root"
                                         data-type="departureDate" data-esc="true">
                                         <h5 class="form-title">{{translate['search.depart_on']}}</h5>
                                        <div class="datepicker-trigger">
                                            <div class="search-box-item-button">
                                                <button class="button" type="button" id="datepicker-button-trigger">
                                                    <span class="search-box-item-button-icon"><i
                                                                class="icon icon-search-calendar"></i></span>
                                                    <span class="search-box-item-button-text" data-datepicker="text">
                                                       <span>{{renderDate(filter.date.start)}}<span
                                                                   v-show="filter.date.start == ''">{{translate['common.beliebig']}}</span></span>
                                                       <span><i v-show="filter.date.start != ''"
                                                                class="fas fa-arrow-right"></i>{{renderDate(filter.date.end)}}</span>
                                                   </span>
                                                </button>
                                            </div>
                                            <airbnb-style-datepicker
                                                    :trigger-element-id="'datepicker-button-trigger'"
                                                    :mode="'range'"
                                                    :date-one="filter.date.start"
                                                    :date-two="filter.date.end"
                                                    :min-date="'<?php echo date('Y-m-d') ?>'"
                                                    :fullscreen-mobile="true"
                                                    :months-to-show="2"
                                                    :offset-y="2"
                                                    :show-action-buttons="true"
                                                    :close-after-select="true"
                                                    :mobile-header="translate['search.depart_on']"
                                                    v-on:date-one-selected="function(val) { filter.date.start = val }"
                                                    v-on:date-two-selected="function(val) { filter.date.end = val;
                                                    if(val.length === 0){
                                                    return;
                                                    }
                                                    $('.asd__mobile-close-icon').trigger('click');
                                                    $('#datepicker-button-trigger').parent('.search-box-item-button').next('.asd__wrapper').removeClass('.asd__wrapper--datepicker-open').css('display','none')}"
                                            ></airbnb-style-datepicker>
                                        </div>


                                    </div>
                                </div>
                                <div class="search-box-col" v-if='filter.sf==2 || filter.sf == 3'>
                                    <div class="search-box-item">
                                        <h5 class="form-title">{{ translate['search.duration'] }}</h5>
                                        <div class="search-box-item-button duration-date">
                                            <button class="button" type="button">
                                                <span class="search-box-item-button-icon"><i
                                                            class="icon icon-search-calendar"></i></span>
                                                <span class="search-box-item-button-text lmin" data-selectbox="root">
                                                    <select name="lmin" v-model="filter.duration" style="border: none">
                                                        <option value="0">{{ translate['common.beliebig'] }}</option>
                                                        <option value="-1">{{ translate['common.exakt'] }}</option>
                                                        <option disabled value="-1">--</option>
                                                        <option selected="selected" value="7">1 {{ translate['common.week'] }}</option>
                                                        <option value="14">2 {{ translate['common.weeks'] }}</option>
                                                        <option value="21">3 {{ translate['common.weeks'] }}</option>
                                                        <option value="28">4 {{ translate['common.weeks'] }}</option>
                                                        <option disabled value="-1">--</option>
                                                        <option value="5-8">5-8 {{ translate['common.days'] }}</option>
                                                        <option value="9-12">9-12 {{ translate['common.days'] }}</option>
                                                        <option value="13-15">13-15 {{ translate['common.days'] }}</option>
                                                        <option value="16-22">16-22 {{ translate['common.days'] }}</option>
                                                        <option value="22-25">22-25 {{ translate['common.days'] }}</option>
                                                        <option value="26-28">26-28 {{ translate['common.days'] }}</option>
                                                        <option disabled value="-1">--</option>
                                                        <option v-bind:value="i" v-for="i in 22">{{i}} {{translate['common.days']}}</option>
                                                    </select>
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="search-box-col" v-if="filter.sf < 4">
                                    <div class="search-box-item last" data-esc="true">
                                        <h5 class="form-title">{{ translate['search.traveller'] }}</h5>
                                        <div class="search-box-item-button children-select" data-scroll-focus="true">
                                            <button class="button" type="button">
                                                <span class="search-box-item-button-icon"><i
                                                            class="icon icon-search-people"></i></span>
                                                <span class="search-box-item-button-text"><span data-adult="true">{{filter.adults}}</span> {{ translate['search.adult'] }},
                                                    <span data-child="true">{{filter.children.length}}</span> {{ translate['search.children'] }}</span>
                                            </button>
                                        </div>
                                        <div class="search-box-item-content"
                                             v-bind:class="{'mobile_person' : mobile.isMobile}">
                                            <div class="modal-close-cross action-close d-block d-sm-none">
                                                <i class="icon icon-modal-close"></i>
                                            </div>
                                            <div class="search-box-item-content-counter">
                                                <div class="search-box-item-content-counter-main">
                                                    <div class="search-box-item-content-counter-main-col">
                                                        <div class="search-box-item-content-counter-item">
                                                            <div class="search-box-item-content-counter-item-button"
                                                                 v-on:click="decrease('adult')">
                                                                <i class="icon icon-counter-minus"></i>
                                                            </div>
                                                            <div class="search-box-item-content-counter-item-content">
                                                                <div class="search-box-item-content-counter-item-content-title">
                                                                    {{ translate['search.adult'] }}
                                                                </div>
                                                                <div class="search-box-item-content-counter-item-content-number">
                                                                    {{filter.adults}}
                                                                </div>
                                                            </div>
                                                            <div class="search-box-item-content-counter-item-button"
                                                                 v-on:click="increase('adult')">
                                                                <i class="icon icon-counter-plus"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="search-box-item-content-counter-main-col">
                                                        <div class="search-box-item-content-counter-item">
                                                            <div class="search-box-item-content-counter-item-button"
                                                                 v-on:click="decrease('children')">
                                                                <i class="icon icon-counter-minus"></i>
                                                            </div>
                                                            <div class="search-box-item-content-counter-item-content">
                                                                <div class="search-box-item-content-counter-item-content-title">
                                                                    {{ translate['search.children'] }}
                                                                </div>
                                                                <div class="search-box-item-content-counter-item-content-number">
                                                                    {{filter.children.length}}
                                                                </div>
                                                            </div>
                                                            <div class="search-box-item-content-counter-item-button"
                                                                 v-on:click="increase('children')">
                                                                <i class="icon icon-counter-plus"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="search-box-item-content-counter-range">
                                                    <div class="search-box-item-content-counter-range-item"
                                                         v-for='(item,index) in filter.children'>
                                                        <div class="search-box-item-content-counter-range-item-title">
                                                            {{index +1 }}.Kind (Alter bei Rückreise)
                                                        </div>
                                                        <div class="search-box-item-content-counter-range-item-content">
                                                            <div class="range">
                                                                <div class="range-input">
                                                                    <input type="range"
                                                                           v-model="filter.children[index]['jahre']"
                                                                           min="0" max="17" step="1" value="6">
                                                                </div>
                                                                <div class="range-progress">
                                                                    <div class="range-progress-total"></div>
                                                                    <div class="range-progress-current"
                                                                         v-bind:style="{'width': item.percent + '%'}"></div>
                                                                    <div class="range-progress-handle"
                                                                         v-bind:style="{'left': item.percent + '%'}"></div>
                                                                    <div class="range-progress-label"
                                                                         v-bind:style="{'left': item.percent + '%'}">
                                                                        <span class="range-progress-label-value">{{item['jahre']}}</span>
                                                                        {{ translate['common.age'] }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="search-box-item-content-counter-info">
                                                    <div class="search-box-item-content-counter-info-icon">
                                                        <i class="icon icon-counter-info"></i>
                                                    </div>
                                                    <div class="search-box-item-content-counter-info-text">
                                                        <strong>{{ translate['search.note'] }}:</strong> {{
                                                        translate['search.note_message'] }}
                                                    </div>
                                                </div>
                                                <div class="search-box-item-content-counter-button">
                                                    <button class="button" type="button">
                                                        {{ translate['search.take'] }}
                                                        <i class="icon icon-header-arrow-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-box-col search-box-button-d">
                                    <div class="search-box-button">
                                        <button class="button" v-on:click="search_offers">{{
                                            translate['search.search_offers'] }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->render('layouts/search-mobile'); ?>
                </div>
            </div>
        </div>
    </div>
</template>