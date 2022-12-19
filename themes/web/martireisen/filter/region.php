<div class="results-left">
    <div class="filters">
        <div class="filters-title d-flex">
            <div class="flex-fill">
                <h2>
                    {{ translate['search.filters'] }}
                </h2>
            </div>
        </div>
        <form class="search-form" method="get" action="">
            <div class="filters-tags">
                <span class="filters-tags-item" v-on:click="resetParam('city')" v-if='filter.city > 0'>{{ getCityByCode(filter.city) }} </span>
                <span class="filters-tags-item" v-on:click="resetParam('star')" v-if='filter.star > 0'>{{filter.star}} {{translate['search.rating']}}</span>
                <span class="filters-tags-item" v-on:click="resetParam('seaview')" v-if='filter.seaview > 0'>{{filter.seaview}} {{translate['search.seaview']}}</span>
                <span class="filters-tags-item" v-on:click="resetParam('transfer')" v-if='filter.transfer > 0'>{{filter.transfer}} {{translate['search.transfer']}}</span>
                <span class="filters-tags-item" v-on:click="resetParam('reviewRate')" v-if='filter.reviewRate > 0'>{{filter.reviewRate}}<i
                            class="fa fa-percent"></i> </span>
                <span class="filters-tags-item" v-on:click="resetParam('room')" v-if='filter.room > 0'>{{translate['search.room.'+(parseInt(filter.room)+1)]}}</span>
                <span class="filters-tags-item" v-on:click="resetParam('pansion')" v-if='filter.pansion > 0'>{{translate['search.pansion.'+((parseInt(filter.pansion)+1))]}}</span>
<!--            <span class="filters-tags-item" v-on:click="resetParam('sf')" v-if='filter.sf > 2'>{{filter.sf}} {{translate['search.sf']}}</span>-->
                <span v-for='attribute in filter.attributes' class="filters-tags-item"
                      v-on:click='filter_global_types(attribute)' v-if='filter.attributes.length > 0'>
                   {{attribute === 'GT03-DIBE' ? translate['search.filter_beach'] :''}}
                   {{attribute === 'GT03-FAFR' ? translate['search.filter_family'] :''}}
                   {{attribute === '0000000000000004' ? translate['search.filter_adults'] :''}}
                   {{attribute === 'GT03-CURE'  ? translate['search.filter_body'] :''}}
                   {{attribute === 'GT03-WATE,GT03-FITN,GT03-TENN,GT03-BEVO' ? translate['search.filter_sport']:''}}
                      {{attribute === 'GT03-BEAC' ? translate['search.filter_sandstrand'] :''}}
                      {{attribute === 'GT03-DIBE' ? translate['search.filter_beach_loc'] :''}}
                      {{attribute === 'GT03-POOL' ? translate['search.filter_pool'] :''}}
                      {{attribute === 'GT03-INTE' ? translate['search.filter_wifi'] :''}}
            </span>

                <div class="clear-button mt-2 mb-2 text-right">
                    <a v-on:click="reset(); !mobile.isMobile?loadHotels():false"
                       class="text-warning  font-weight-bold mt-2"> <i
                                class="far fa-times-circle mr-1"></i>{{ translate['search.clear'] }} </a>
                </div>
            </div>
            <div style="min-height: 941px">
                <div v-if="is_filter_render">
                    <div class="filters-seperator " v-show="filterActive"></div>
                    <div class="filters-seperator d-none"></div>
                    <div class="filters-item d-none">
                        <div class="filters-item-header" data-target="#hotelPrice">
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">{{ translate['search.filter_return_flight_time'] }}</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div id="hotelPrice" class="active overflow open">
                                <div class="range">
                                    <div class="range-input">
                                        <input name="flight-time" type="time" min="00:00" max="23:59" value="00:00">
                                    </div>
                                    <div class="range-progress">
                                        <div class="range-progress-total"></div>
                                        <div class="range-progress-current"></div>
                                        <div class="range-progress-handle"></div>
                                        <div class="range-progress-label">
                                            <span class="range-progress-label-value"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-seperator"></div>
                    <div class="filters-item mb-4">
                        <div class="filters-item-header">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-hotel-category"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">{{ translate['search.filter_rating'] }}</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <label class="radio radio-stars">
                                <span class="radio-stars-main">
                                    <span class="radio-stars-main-stars">
                                        <i v-for='index in 5' v-on:click="star(index)" class="icon"
                                           v-bind:class="{'icon-filters-star' : filter.star == 0 || filter.star < index , 'icon-filters-star-active' : filter.star >= index}"></i>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="filters-seperator"></div>
                    
                    <div class="filters-item">
                        <!--  data-collapse="button" data-target="#listRate" -->
                        <div class="filters-item-header active open">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-like"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">{{ translate['search.filter_rate'] }}:</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div id="listRate" class="active open" data-collapse="content">
                                <div class="filters-item-main-rate">
                                    <div class="filters-item-main-rate-input">
                                        <label class="filters-item-main-rate-input-item">
                                    <span v-on:click="review(80)" class="filters-item-main-rate-input-item-content"
                                          v-bind:class="{'selected-active' : filter.reviewRate == 80}">80<i
                                                class="fa fa-percent"></i> </span>
                                        </label>
                                        <label class="filters-item-main-rate-input-item">
                                    <span v-on:click="review(85)" class="filters-item-main-rate-input-item-content"
                                          v-bind:class="{'selected-active' : filter.reviewRate == 85}">85<i
                                                class="fa fa-percent"></i> </span>
                                        </label>
                                        <label class="filters-item-main-rate-input-item">
                                    <span v-on:click="review(90)" class="filters-item-main-rate-input-item-content"
                                          v-bind:class="{'selected-active' : filter.reviewRate == 90}">90<i
                                                class="fa fa-percent"></i> </span>
                                        </label>
                                        <label class="filters-item-main-rate-input-item">
                                    <span v-on:click="review(95)" class="filters-item-main-rate-input-item-content"
                                          v-bind:class="{'selected-active' : filter.reviewRate == 95}">95<i
                                                class="fa fa-percent"></i> </span>
                                        </label>
                                        <label class="filters-item-main-rate-input-item">
                                    <span v-on:click="review(100)" class="filters-item-main-rate-input-item-content"
                                          v-bind:class="{'selected-active' : filter.reviewRate == 100}">100<i
                                                class="fa fa-percent"></i> </span>
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-seperator"></div>
                    <div class="filters-item">
                        <div class="filters-item-header">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-accommodation"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">{{ translate['search.filter_pansion'] }}</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div class="selectbox selectbox-default custominput" data-selectbox="root">
                                <div class="selectbox-default-select">
                                    <select v-model="filter.pansion" v-on:change="filterDesktopChange">
                                        <option value="0">{{ translate['search.pansion.1'] }}</option>
                                        <option value="1">{{ translate['search.pansion.2'] }}</option>
                                        <option value="2">{{ translate['search.pansion.3'] }}</option>
                                        <option value="3">{{ translate['search.pansion.4'] }}</option>
                                        <option value="4">{{ translate['search.pansion.5'] }}</option>
                                        <option value="5">{{ translate['search.pansion.6'] }}</option>
                                    </select>
                                </div>
                                <div class="selectbox-default-button">
                                    <button class="button" type="button">
                                        <span class="selectbox-default-button-text" data-selectbox="text"></span>
                                        <span class="selectbox-default-button-icon"><i
                                                    class="icon icon-selectbox-caret"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-seperator"  v-show="results.cities && results.cities[0] && results.cities.length > 1"></div>
                    <div class="filters-item" v-if="results.cities && results.cities[0] && results.cities.length > 1">
                        <div class="filters-item-header">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">
                                    {{translate['search.filter_city']}}</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div class="selectbox selectbox-default custominput" data-selectbox="root">
                                <div class="selectbox-default-select">
                                    <select v-model="filter.city" v-on:change="filterDesktopChange" >
                                        <option value="0">{{ translate['search.room.1'] }}</option>
                                        <option v-for="(city,index) in results.cities" v-bind:value="city['@attributes'].ID">{{ city['@attributes'].NAME }}</option>
                                    </select>
                                </div>
                                <div class="selectbox-default-button">
                                    <button class="button" type="button">
                                        <span class="selectbox-default-button-text" data-selectbox="text"></span>
                                        <span class="selectbox-default-button-icon"><i
                                                    class="icon icon-selectbox-caret"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-seperator"></div>
                    <div class="filters-item">
                        <div class="filters-item-header">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">
                                    {{translate['search.filter_room_type']}}</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div class="selectbox selectbox-default custominput" data-selectbox="root">
                                <div class="selectbox-default-select">
                                    <select v-model="filter.room" v-on:change="filterDesktopChange">
                                        <option value="0">{{ translate['search.room.1'] }}</option>
                                        <option value="1">{{ translate['search.room.2'] }}</option>
                                        <option value="2">{{ translate['search.room.3'] }}</option>
                                        <option value="3">{{ translate['search.room.4'] }}</option>
                                        <option value="4">{{ translate['search.room.5'] }}</option>
                                        <option value="5">{{ translate['search.room.6'] }}</option>
                                        <option value="6">{{ translate['search.room.7'] }}</option>
                                        <option value="9">{{ translate['search.room.8'] }}</option>
                                    </select>
                                </div>
                                <div class="selectbox-default-button">
                                    <button class="button" type="button">
                                        <span class="selectbox-default-button-text" data-selectbox="text"></span>
                                        <span class="selectbox-default-button-icon"><i
                                                    class="icon icon-selectbox-caret"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                    <div class="filters-seperator"></div>
                    <div class="filters-item">
                        <div class="filters-item-header active open" data-collapse="button"
                             data-target="#specialPreferences">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-heart"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">{{ translate['search.filter_extra'] }}
                                    :</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div id="specialPreferences" class="active open overflow" data-collapse="content">
                                <div class="filters-item-main-special-preferences">
                                    <div class="filters-item-main-special-preferences-col">
                                        <div class="filters-item-main-special-preferences-item"
                                             v-on:click='filter_global_types("GT03-DIBE")'
                                             v-bind:class="{ selected : isSelectedAttribute('GT03-DIBE') }">
                                            <div class="filters-item-main-special-preferences-item-button">
                                                <div class="filters-item-main-special-preferences-item-button-icon">
                                                    <i class="icon icon-filters-beach"></i>
                                                    <i class="icon icon-filters-beach-active"></i>
                                                </div>
                                                <input type="checkbox" style="display: none;"
                                                       data-check="special-preferences"
                                                       value="GT03-DIBE"/>
                                                <div class="filters-item-main-special-preferences-item-button-text">
                                                    {{ translate['search.filter_beach'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filters-item-main-special-preferences-col">
                                        <div class="filters-item-main-special-preferences-item "
                                             v-on:click='filter_global_types("GT03-FAFR")'
                                             v-bind:class="{ selected : isSelectedAttribute('GT03-FAFR') }">
                                            <div class="filters-item-main-special-preferences-item-button">
                                                <div class="filters-item-main-special-preferences-item-button-icon">
                                                    <i class="icon icon-filters-family"></i>
                                                    <i class="icon icon-filters-family-active"></i>
                                                </div>
                                                <input name="gtype[]" type="checkbox" style="display: none;"
                                                       data-check="special-preferences" value="GT03-FAFR"/>
                                                <div class="filters-item-main-special-preferences-item-button-text">
                                                    {{ translate['search.filter_family'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filters-item-main-special-preferences-col">
                                        <div class="filters-item-main-special-preferences-item"
                                             v-on:click='filter_travel_types("0000000000000004")'
                                             v-bind:class="{ selected : isSelectedAttribute('0000000000000004') }">
                                            <div class="filters-item-main-special-preferences-item-button"
                                                 data-special-preferences="confirm">
                                                <div class="filters-item-main-special-preferences-item-button-icon">
                                                    <i class="icon icon-filters-adults"></i>
                                                    <i class="icon icon-filters-adults-active"></i>
                                                </div>
                                                <input name="atand" type="checkbox" style="display: none;"
                                                       data-check="special-preferences" value=""/>
                                                <div class="filters-item-main-special-preferences-item-button-text text-center">
                                                    {{ translate['search.filter_adults'] }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="filters-item-main-special-preferences-col">
                                        <div class="filters-item-main-special-preferences-item "
                                             v-on:click='filter_global_types("GT03-CURE")'
                                             v-bind:class="{ selected : isSelectedAttribute('GT03-CURE') }">
                                            <div class="filters-item-main-special-preferences-item-button"
                                                 data-special-preferences="confirm">
                                                <div class="filters-item-main-special-preferences-item-button-icon">
                                                    <i class="icon icon-filters-body"></i>
                                                    <i class="icon icon-filters-body-active"></i>
                                                </div>
                                                <input name="gtype[]" type="checkbox" style="display: none;"
                                                       data-check="special-preferences" value="GT03-CURE"/>
                                                <div class="filters-item-main-special-preferences-item-button-text">
                                                    {{ translate['search.filter_body'] }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="filters-item-main-special-preferences-col">
                                        <div class="filters-item-main-special-preferences-item"
                                             v-on:click='filter_global_types("GT03-WATE,GT03-FITN,GT03-TENN,GT03-BEVO")'
                                             v-bind:class="{ selected : isSelectedAttribute('GT03-WATE,GT03-FITN,GT03-TENN,GT03-BEVO') }">
                                            <div class="filters-item-main-special-preferences-item-button"
                                                 data-special-preferences="confirm">
                                                <div class="filters-item-main-special-preferences-item-button-icon">
                                                    <i class="icon icon-filters-sport"></i>
                                                    <i class="icon icon-filters-sport-active"></i>
                                                </div>
                                                <input name="gtype[]" type="checkbox" style="display: none;"
                                                       data-check="special-preferences"
                                                       value="GT03-WATE,GT03-FITN,GT03-TENN,GT03-BEVO"/>
                                                <div class="filters-item-main-special-preferences-item-button-text">
                                                    {{ translate['search.filter_sport'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filters-item-main-special-preferences-col">
                                        <div class="filters-item-main-special-preferences-item"
                                             data-root="special-preferences"
                                             data-esc="true">
                                            <div class="filters-item-main-special-preferences-item-button"
                                                 data-special-preferences="button">
                                                <div class="filters-item-main-special-preferences-item-button-icon">
                                                    <i class="icon icon-filters-specials"></i>
                                                    <i class="icon icon-filters-specials-active"></i>
                                                </div>
                                                <div class="filters-item-main-special-preferences-item-button-text text-center">
                                                    {{ translate['search.filter_hotel_specials'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-seperator"></div>
                    <div class="filters-item">
                        <div class="filters-item-header active open" data-collapse="button"
                             data-target="#hotelCriteria">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-criteria"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title">{{ translate['search.filter_hotel_extra'] }}
                                    :</h4>
                            </div>
                        </div>
                        <div class="filters-item-main">
                            <div id="hotelCriteria" class="active open overflow" data-collapse="content">
                                <div class="filters-item-main-hotel-criteria">
                                    <div class="filters-item-main-hotel-criteria-col"
                                         v-on:click.prevent='filter_global_types("GT03-BEAC")'>
                                        <label class="filters-item-main-hotel-criteria-item">
                                            <input type="checkbox" name="gtype[]" value="GT03-DIBE"
                                                   v-bind:checked="filter.attributes  && filter.attributes.indexOf('GT03-BEAC') > -1"/>
                                            <span class="filters-item-main-hotel-criteria-item-icon">
                                    <i class="icon icon-filters-sandstrand"></i>
                                    <i class="icon icon-filters-sandstrand-active"></i>
                                </span>
                                            <span class="filters-item-main-hotel-criteria-item-text">{{ translate['search.filter_sandstrand'] }}</span>
                                            <span class="filters-item-main-hotel-criteria-item-input"></span>
                                        </label>
                                    </div>
                                    <div class="filters-item-main-hotel-criteria-col"
                                         v-on:click.prevent='filter_global_types("GT03-DIBE")'>
                                        <label class="filters-item-main-hotel-criteria-item">
                                            <input type="checkbox" name="gtype[]" value="GT03-DIBE"
                                                   v-bind:checked="filter.attributes && filter.attributes.indexOf('GT03-DIBE') > -1"/>
                                            <span class="filters-item-main-hotel-criteria-item-icon">
                                    <i class="icon icon-filters-strandlage"></i>
                                    <i class="icon icon-filters-strandlage-active"></i>
                                </span>
                                            <span class="filters-item-main-hotel-criteria-item-text">{{ translate['search.filter_beach_loc'] }}</span>
                                            <span class="filters-item-main-hotel-criteria-item-input"></span>
                                        </label>
                                    </div>
                                    <div class="filters-item-main-hotel-criteria-col"
                                         v-on:click.prevent='filter_global_types("GT03-POOL")'>
                                        <label class="filters-item-main-hotel-criteria-item">
                                            <input type="checkbox" name="gtype[]" value="GT03-POOL"
                                                   v-bind:checked="filter.attributes  && filter.attributes.indexOf('GT03-POOL') > -1"/>
                                            <span class="filters-item-main-hotel-criteria-item-icon">
                                    <i class="icon icon-filters-pool"></i>
                                    <i class="icon icon-filters-pool-active"></i>
                                </span>
                                            <span class="filters-item-main-hotel-criteria-item-text">{{ translate['search.filter_pool'] }}</span>
                                            <span class="filters-item-main-hotel-criteria-item-input"></span>
                                        </label>
                                    </div>
                                    <div class="filters-item-main-hotel-criteria-col"
                                         v-on:click.prevent='filter_global_types("GT03-INTE")'>
                                        <label class="filters-item-main-hotel-criteria-item">
                                            <input type="checkbox" name="gtype[]" value="GT03-INTE#ST03-WLAN"
                                                   v-bind:checked="filter.attributes && filter.attributes.indexOf('GT03-INTE') > -1">
                                            <span class="filters-item-main-hotel-criteria-item-icon">
                                    <i class="icon icon-filters-wifi"></i>
                                    <i class="icon icon-filters-wifi-active"></i>
                                </span>
                                            <span class="filters-item-main-hotel-criteria-item-text">{{ translate['search.filter_wifi'] }}</span>
                                            <span class="filters-item-main-hotel-criteria-item-input"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filters-seperator"></div>
                </div>
            </div>
        </form>
        <div class="modal-close fixed-bottom btn btn-primary m-3 d-block d-sm-none" v-on:click='loadHotels()'>
            {{ translate['search.filter.accept'] }}
        </div>
    </div>
</div>