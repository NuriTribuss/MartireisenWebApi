<div class="results-collapse-list">
     <div class="results-item"  v-if='results.top && sortLocal.column == ""'>
        <div class="results-item-header" data-toggle="collapse" aria-expanded="true" data-target="#resultCollapse-9999" >
            <div class="results-item-header-text">{{translate['search.most_popular_dest']}}</div>
            <div class="results-item-header-money"></div>
        </div>
        <div class="results-item-main region-results" >
            <div id="resultCollapse-9999" class="collapse multi-collapse show">
                <div v-for="region in results.top" >
                    <div v-if="['724'].indexOf(region.code) > -1">
                        <div class="results-item-main-item" v-on:click="search_offers('region',state)" v-for='(state,stateIndex) in region.children'>
                        <div class="results-item-main-item-title">
                            <div class="results-item-main-item-title-left" >
                                <h4 class="results-item-main-item-title-text">{{ translate['region_'+state.code]}} </h4>
                            </div>
                            <div class="d-block d-md-none hidden-sm ">
                                <div class="results-item-main-item-title-right">
                                    <i class="icon icon-results-people d-block d-sm-none"></i>
                                    <span><small>{{ translate['hotels.ab'] }}</small> {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(state.price)}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="results-item-main-item-content">
                            <div class="results-item-main-item-content-list">
                                <div class="results-item-main-item-content-list-item">
                                    <i class="icon icon-results-temperature"></i>
                                {{state.temp.air }}ºC
                                </div>
                                <div class="results-item-main-item-content-list-item">
                                    <i class="icon icon-results-moisture"></i>
                                    <span class="wassertemp" v-bind:data-watertemp="state.temp.water || ''">{{state.temp.water || '--'}}ºC</span>
                                </div>
                                <div class="results-item-main-item-content-list-item">
                                    <i class="icon icon-results-flight-time"></i>
                                        {{ toHour(state.flight.estimatedTime)}}
                                </div>
                                <div class="results-item-main-item-content-list-item blue">
                                    <i class="icon icon-results-people"></i>
                                    <small>{{ translate['hotels.ab'] }}</small> {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(state.price)}}
                                </div>
                            </div>
                        </div>
                        <div class="results-item-main-item-button">
                            <a class="button" v-on:click="search_offers('region',state)" title="Go!"><i class="icon icon-header-arrow-right"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="results-item" v-for="(region,index) in results.data">
        <div class="results-item-header" data-toggle="collapse" aria-expanded="false"  v-bind:data-target="'#resultCollapse-' + index">
            <div class="results-item-header-text">{{region.name}}</div>
            <div class="results-item-header-money"><small>{{ translate['hotels.ab'] }}</small> {{Marti.getCurrency()}} {{Marti.Tools.numberWithThousandSep(region.price)}}</div>
        </div>
        <div class="results-item-main region-results">
            <div v-bind:id="'resultCollapse-' + index" class="collapse multi-collapse" >
                <div class="results-item-main-item" v-on:click="search_offers('region',state)" v-for='(state,stateIndex) in region.children'>
                    <div class="results-item-main-item-title">
                        <div class="results-item-main-item-title-left" >
                            <h4 class="results-item-main-item-title-text">{{state.name}}</h4>
                        </div>
                        <div class="d-block d-md-none hidden-sm">
                            <div class="results-item-main-item-title-right">
                                <i class="icon icon-results-people d-block d-sm-none"></i>
                                <span><small>{{ translate['hotels.ab'] }}</small> {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(state.price)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="results-item-main-item-content">
                        <div class="results-item-main-item-content-list">
                            <div class="results-item-main-item-content-list-item">
                                <i class="icon icon-results-temperature"></i>
                                {{state.temp.air }}ºC
                            </div>
                            <div class="results-item-main-item-content-list-item">
                                <i class="icon icon-results-moisture"></i>
                                <span class="wassertemp" v-bind:data-watertemp="state.temp.water || ''">{{state.temp.water || '--'}}ºC</span>
                            </div>
                            <div class="results-item-main-item-content-list-item">
                                <i class="icon icon-results-flight-time"></i>
                                {{ toHour(state.flight.estimatedTime)}}
                            </div>
                            <div class="results-item-main-item-content-list-item blue">
                                <i class="icon icon-results-people"></i>
                                <small>{{ translate['hotels.ab'] }}</small> {{Marti.getCurrency()}}{{Marti.Tools.numberWithThousandSep(state.price)}}
                            </div>
                        </div>
                    </div>
                    <div class="results-item-main-item-button">
                        <a class="button" v-on:click="search_offers('region',state)" title="Go!"><i class="icon icon-header-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>