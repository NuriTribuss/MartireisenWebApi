<div class="results-left col-12 col-md-4">
    <div class="filters">
        <h2 class="filters-title"><?php _lang('search.filters') ?></h2>
        <form class="search-form" method="get" action="">
            <div class="filters-tags">
                <template v-for="group in filters">
                <span class="filters-tags-item"
                      v-for="(option,index) in filter[group.code]"
                      v-on:click="removeFilterAttribute(group.code,index,option)">
                    <span v-if="group.code == 'locations'">{{getCountryFilterByCode(option,group.options)}}  </span>
                    <span v-if="group.code != 'locations'">{{translate['halalbooking.filter.'+group.code+'.'+ option]}}</span>
                    
                </span>
                </template>

                <div class="clear-button mt-2 mb-2 text-right">
                    <a v-on:click="removeAttribute(); !mobile.isMobile?loadHotels():false"
                       class="text-warning  font-weight-bold mt-2"> <i
                                class="far fa-times-circle mr-1"></i><?php _lang('search.clear') ?> </a>
                    <div class="filters-seperator"></div>
                </div>

            </div>
            <div style="min-height: 941px">
                <div v-if="is_filter_render">
                    <div class="filters-item" v-for="(group,index) in filters">
                        <div class="filters-item-header collapsed" data-toggle="collapse"
                             :data-target="`#filters-item-content-${index}`"
                             aria-expanded="false" :aria-controls="`filters-item-content-${index}`">
                            <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                            <div class="filters-item-header-content">
                                <h4 class="filters-item-header-content-title d-flex">
                                    <span class="flex-fill"> {{translate['halalbooking.filter.'+group.code]}} </span> <i
                                            class="fas fa-angle-down ml-2"></i></h4>
                            </div>
                        </div>

                        <div class="filters-item-content collapse show" :id="`filters-item-content-${index}`">
                            <div class="filters-item-main" v-for="(option,index) in group.options">
                                <div class="form-check custom-checkbox mb-1">
                                    <input v-bind:name="group.code+'[]'" v-bind:id="'filter'+group.code+option.code"
                                           v-on:change="filter_attributes(group.code,index,option.code)" type="checkbox"
                                           v-bind:checked="filter[group.code] && filter[group.code].indexOf(option.code) > -1"/>
                                    <label class="ml-2 w-100 form-check-label"
                                           v-bind:for="'filter'+group.code+option.code">
                                        <span v-if="option.name">{{option.name}}</span>
                                        {{translate['halalbooking.filter.'+group.code+'.'+option.code]}}
                                        <!--<span class="float-right" v-if="typeof results.counts[group.code] != 'undefined'">( {{results.counts[group.code][option.code]}} )</span>-->
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="filters-item">
            <div class="filters-item-header">
                <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title"><?php _lang('holiday_type') ?></h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div class="form-check mb-1">
                    <input class="form-check-input" v-model="filter.holiday_type" id="holiday_type_0" v-on:change="loadHotels" type="radio"  value="" checked />
                    <label class="ml-2  form-check-label" for="holiday_type_0">
                      <?php _lang('holiday_type.0') ?>
                    </label>
                </div>
                <div class="form-check mb-1">
                    <input class="form-check-input" v-model="filter.holiday_type" id="holiday_type_1" v-on:change="loadHotels" type="radio"  value="hotel" />
                    <label class="ml-2  form-check-label" for="holiday_type_1">
                      <?php _lang('holiday_type.1') ?>
                    </label>
                </div>
                <div class="form-check mb-1">
                    <input class="form-check-input" id="holiday_type_2" v-model="filter.holiday_type" v-on:change="loadHotels" type="radio"  value="resort" />
                    <label class="ml-2  form-check-label" for="holiday_type_2">
                      <?php _lang('holiday_type.2') ?>
                    </label>
                </div>
                <div class="form-check mb-1">
                    <input class="form-check-input" id="holiday_type_3" v-model="filter.holiday_type" v-on:change="loadHotels" type="radio"  value="villa" />
                    <label class="ml-2 form-check-label" for="holiday_type_3">
                      <?php _lang('holiday_type.3') ?>
                    </label>
                </div>
                <div class="form-check mb-1">
                    <input class="form-check-input" id="holiday_type_4" v-model="filter.holiday_type" v-on:change="loadHotels" type="radio"  value="thermal" />
                    <label class="ml-2  form-check-label" for="holiday_type_4">
                      <?php _lang('holiday_type.4') ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="filters-seperator"></div>

        <div class="filters-item mt-3 mb-3">
            <div class="filters-item-header">
                <div class="filters-item-header-icon"><i class="icon icon-filters-hotel-category"></i></div>
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title"><?php _lang('search.filter_rating') ?></h4>
                </div>
            </div>
            <div class="filters-item-main">
                <label class="radio radio-stars">
                    
                    <span class="radio-stars-main">
                        <span class="radio-stars-main-stars">
                            <i v-for='index in 5' v-on:click="star(index)" class="icon" v-bind:class="{'icon-filters-star' : filter.star == 0 || filter.star < index , 'icon-filters-star-active' : filter.star >= index}" ></i>
                        </span>
                    </span>
                    <span class="radio-stars-title d-block d-sm-none hidden-lg"><?php echo \Helper\Input::get('str') ?> <?php _lang('search.rating') ?></span>
                </label>
            </div>
        </div>
        <div class="filters-seperator"></div>
        <div class="clearfix"></div>
        <div class="filters-item mt-3 d-none">
          <div class="filters-item-header">
              <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
              <div class="filters-item-header-content">
                  <h4 class="filters-item-header-content-title"><?php _lang('search.hotel_name') ?></h4>
              </div>
          </div>
          <div class="filters-item-main">
                 <div id="textSearch" class="w-100">
                    <p>
                       <input type="text" class="w-100 p-2" name="gidon" value="" />
                    </p>
                </div>
          </div>
        </div>
        <div class="filters-item">
            <div class="filters-item-header">
                <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title"><?php _lang('halalbooking.regions') ?></h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div class="selectbox selectbox-default custominput" data-selectbox="root">
                    <div class="selectbox-default-select">
                        <select  v-model="defaults.active_country" v-on:change="loadStates()">
                            <option value="" >All</option>
                            <option v-for="country in defaults.countries" v-bind:value="country.id">{{localeCountry(country)}}</option>
                        </select>
                    </div>
                    <div class="selectbox-default-button">
                        <button class="button" type="button">
                            <span class="selectbox-default-button-text" data-selectbox="text"></span>
                            <span class="selectbox-default-button-icon"><i class="icon icon-selectbox-caret"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="filters-item">
            <div class="filters-item-header">
                <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title"><?php _lang('halalbooking.states') ?></h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div class="selectbox selectbox-default custominput" data-selectbox="root">
                    <div class="selectbox-default-select">
                        <select  v-model="defaults.active_state" v-on:change="loadHotels">
                            <option value="" >All</option>
                            <option v-for="state in defaults.states" v-bind:value="state.id">{{state.name}}</option>
                        </select>
                    </div>
                    <div class="selectbox-default-button">
                        <button class="button" type="button">
                            <span class="selectbox-default-button-text" data-selectbox="text"></span>
                            <span class="selectbox-default-button-icon"><i class="icon icon-selectbox-caret"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>-->
        </form>
        <div class="modal-close fixed-bottom btn btn-primary m-3 d-block d-sm-none" v-on:click='loadHotels()'>
            <?php _lang('search.filter.accept'); ?>
        </div>
    </div>
</div>