
<div class="search-result-modal mobile-search-modal" v-bind:class="{'active' : mobile.popup}" >
    
    <div class="search-result-action" id="mobile-destinations" >
		<div class="modal-close-cross action-close">
			<i class="icon icon-modal-close" v-on:click='mobile.popup = false'></i>
		</div>
        <div class="search-result-head">
            <span class="action-close">
                <i class="icon fas fa-arrow-left" v-on:click='mobile.popup = false'></i>
                <span class="modal-close-title"><?php _lang('search.destination') ?></span>
            </span>
        </div>

        <div class="search-result-content">
            <label class="search-result-label">
                <i class="icon icon-search-arrival" v-show="filter.destination.name.length == 0" ></i>
                <i class="icon fas fa-backspace" v-show="filter.destination.name.length > 0" v-on:click="filter.destination.name = ''"></i>
                <input id="mobile-input-destinations" class="mobilInput" type="text" placeholder="<?php _lang('search.destination') ?>"  :value='filter.destination.name' @input='evt=>filter.destination.name=evt.target.value' v-on:keyup='filter_destination' autofocus="autofocus" autocomplete="off" />
            </label>
        </div>
        <div class="search-result-data">
            
            <div class="lds-css ng-scope" v-show="loading" style="display: none;">
                <div class="lds-dual-ring"></div>
            </div>
            <div v-bind:class="{'regions-group' : true , 'hidden' : destinations.locations.length <= 0  }">
                <div class="search-box-item-content-selectbox-title"><i class="fas fa-globe-europe"></i><?php _lang('search.regions') ?></div>
                <div class="search-box-item-content-selectbox-option-group">
                    <div v-for='state in destinations.locations' class="search-box-item-content-selectbox-option"  v-bind:class="{'selected' : filter.destination.code == state.code}"  v-on:click='select_destination("state",state)'>
                        <i class="fas fa-map-marker-alt"></i><span v-html="highlight(state.name)"></span>
                    </div>
                </div>
                <div class="search-box-item-content-selectbox-seperator"></div> 
            </div>
            <div  v-bind:class="{'hotels-group' : true , 'hidden' : destinations.hotels.length <= 0  }">
                <div class="search-box-item-content-selectbox-title"><i class="fas fa-concierge-bell"></i><?php _lang('search.hotels') ?></div>
                <div class="search-box-item-content-selectbox-option-group">
                    <div v-for='hotel in destinations.hotels' class="search-box-item-content-selectbox-option"  v-bind:class="{'selected' : filter.destination.code == hotel.code}"  v-on:click='select_destination("hotel",hotel)'>
                        <i class="fas fa-hotel"></i><span v-html="highlight(hotel.name)"></span>&nbsp;<small>{{hotel.location.name }}</small>
                    </div>

                </div>
                <div class="search-box-item-content-selectbox-seperator"></div>
            </div>
            <div class="search-box-item-content-selectbox-title"><?php _lang('search.most_popular') ?></div>
            <div class="search-box-item-content-selectbox-option-group">
                <div v-for='state in destinations.favourites' class="search-box-item-content-selectbox-option" v-bind:class="{'selected' : filter.destination.code == state.code}" v-on:click='select_destination("state",state)'>
                    <i class="fas fa-star"></i><span v-html="highlight(state.name)"></span>
                </div>
            </div>
        </div>
        
    </div>
    <div class="search-result-action" id="mobile-departures" v-if="typeof departures != 'undefined'">
         <div class="search-result-head">
            <span class="action-close">
                <i class="icon fas fa-arrow-left" v-on:click='mobile.popup = false'></i>
                <span class="modal-close-title"><?php _lang('search.departure') ?></span>
            </span>
        </div>
        <div class="search-result-content">
            <label class="search-result-label" data-action="abflughafen">
                <i class="icon icon-search-departure"></i>
                <input autocomplete="off"  class="mobilInput" id="mobile-input-departures"  type="text" v-model="filter.departure.name" @keyup="filter_airports" placeholder="<?php _lang('search.departure_place') ?>" />
            </label>
        </div>
        <div class='search-result-data'>
            <div class="search-box-item-content-selectbox">
                <div v-for="departure in departures.results">
                    <div class="search-box-item-content-selectbox-title">{{departure.name}}</div>
                    <div class="search-box-item-content-selectbox-option-group">
                        <div v-for="airport in departure.items">
                            <div class="search-box-item-content-selectbox-option"   v-bind:class="{'selected' : filter.departure.code == airport.code}" v-on:click='select_departure(airport)'>{{airport.name}}
                            </div>
                        </div>
                    </div>
                    <div class="search-box-item-content-selectbox-seperator"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-result-action" id="mobile-destinations">
        <div class="search-result-head">
            <span class="action-close">
                <i class="icon fas fa-arrow-left" v-on:click='mobile.popup = false'></i>
                <span class="modal-close-title"><?php _lang('search.departure') ?></span>
            </span>
        </div>
        <div class="search-result-content">
            
        </div>
        
    </div>
    <div class="search-result-action" id="action-calendar">
        <div class="search-result-head"><span class="action-close"><span class="modal-close-title">Search</span> <i class="icon icon-modal-close"></i> </span></div>
        <div class="search-result-content">
            <label class="search-result-label" data-action="calendar">
                <i class="icon icon-search-calendar"></i>
                <select v-model="filter.duration" name="" id="">
                    <option value="7" selected="selected">1 Wochen</option>
                    <option value="14">2 Wochen</option>
                    <option value="21">3 Wochen</option>
                    <option value="28">4 Wochen</option>
                    <option value="1">1 Tag</option>
                    <option value="2">2 Tage</option>
                    <option value="3">3 Tage</option>
                    <option value="4">4 Tage</option>
                    <option value="5">5 Tage</option>
                    <option value="6">6 Tage</option>
                    <option value="8">8 Tage</option>
                    <option value="9">9 Tage</option>
                    <option value="10">10 Tage</option>
                    <option value="11">11 Tage</option>
                    <option value="12">12 Tage</option>
                    <option value="13">13 Tage</option>
                    <option value="15">15 Tage</option>
                    <option value="16">16 Tage</option>
                    <option value="17">17 Tage</option>
                    <option value="18">18 Tage</option>
                    <option value="19">19 Tage</option>
                    <option value="20">20 Tage</option>
                    <option value="22">22 Tage</option>
                    <option value="5-8">5-8 Tage</option>
                    <option value="9-12">9-12 Tage</option>
                    <option value="13-15">13-15 Tage</option>
                    <option value="16-22">16-22 Tage</option>
                    <option value="22-25">22-25 Tage</option>
                    <option value="26-28">26-28 Tage</option>
                </select>
            </label>
        </div>
    </div>
   
        <div class="search-box-button" v-show="1==2">
         <button class="search-result-button" v-on:click="mobile.popup = false" >OK</button>
        </div>
</div>



   <div class="search-result-content" v-if="1==2" style="display:none;">
        <ul class="search-result-tab">
            <li v-on:click="filter.sf=2" class="button"  v-bind:class="{'active' : filter.sf == 2}"><?php _lang('search.last_minute')?></li>
            <li v-on:click="filter.sf=3" class="button"  v-bind:class="{'active' : filter.sf == 3}"><?php _lang('search.only_hotel')?></li>
        </ul>
        <div class="search-result-form">
            <label class="search-result-label" data-action="reiseziel">
                <i class="icon icon-search-arrival"></i>
                <input autocomplete="off" type="text" placeholder="<?php _lang('search.destination') ?>" v-model='filter.destination.name' />
            </label>
            <label class="search-result-label" data-action="abflughafen" v-show='filter.sf==2'>
                <i class="icon icon-search-departure"></i>
                <input autocomplete="off" type="text" placeholder="<?php _lang('search.departure_place') ?>"/>
            </label>
            <label class="search-result-label" data-action="hinreise">
                <i class="icon icon-search-calendar"></i>
                <input type="text" placeholder="Hinreise" />
            </label>
            <label class="search-result-label" data-action="calendar">
                <i class="icon icon-search-calendar"></i>
                <input type="text" placeholder="1 Wochen" />
            </label>
            <label class="search-result-label" data-action="people">
                <i class="icon icon-search-people"></i>
                <input type="text" placeholder="2 Erwachsene, 0 kinden" />
            </label>
            <button class="search-result-button" v-on:click="search_offers"><?php _lang('search.search_offers') ?></button>
        </div>
    </div>