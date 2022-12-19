<div id="app" v-cloak>

    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="/" title="Home">{{ translate['menu.home'] }}</a></li>
                    <li class="breadcrumb-item">
                        <a v-show="this.filter.sf == 2" href=""
                           title=" translate['search.last_minute'] ">{{ translate['search.last_minute'] }}</a>
                        <a v-show="this.filter.sf == 3" href=""
                           title=" translate['search.only_hotel'] ">{{ translate['search.only_hotel'] }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span>{{ translate['search.results'] }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div id="summary" data-toggle="mobile-nav" data-href="#mobile-filter">
        <div class="container">
            <div class="summary-title"><strong>{{filter.destination.name}}</strong></div>
            <div class="summary-text">{{filter.adults}} {{ translate['search.adult'] }},
                {{filter.children.length}} {{ translate['search.children'] }}</div>
            <div class="summary-text">{{Marti.Tools.frontEndDateFormat(filter.date.start) }} -
                {{Marti.Tools.frontEndDateFormat(filter.date.end)}}
            </div>
            <div class="summary-icon">
                <i class="icon icon-summary-pencil"></i>
            </div>
        </div>
    </div>



    <div class="filter-buttons filter-sticky">
        <div>
            <a class="btn btn-warning  btn-rounded btn-xs" data-toggle="modal" data-target="#modalFilters"><i class="fa fa-filter mr-2"></i>{{ translate['search.filter.button'] }} ({{filter_counter}})</a>
        </div>
        <div>
            <div class="btn-group w-100">
                <button type="button" class="btn btn-warning  btn-rounded btn-xs dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-sort-amount-down"></i> {{ translate['search.sort.by'] }} <i
                            class="fas fa-sort"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" v-on:click="sortRegions('NAME')"><i
                                class="fas fa-sort-alpha-down"></i> {{ translate['search.sort.asc'] }}
                        <i class="fas" v-show="sortLocal.column == 'NAME'"
                           v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                    </a>
                    <a class="dropdown-item" v-on:click="sortRegions('LUFTTEMP')"><i
                                class="fas fa-sun"></i> {{ translate['search.sort.tempature'] }}
                        <i class="fas" v-show="sortLocal.column == 'LUFTTEMP'"
                           v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                    </a>
                    <a class="dropdown-item" v-on:click="sortRegions('WASSERTEMP')"><i
                                class="fas fa-water"></i> {{ translate['search.sort.water'] }}
                        <i class="fas" v-show="sortLocal.column == 'WASSERTEMP'"
                           v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                    </a>
                    <a class="dropdown-item" v-on:click="sortRegions('FLUGZEIT')"><i
                                class="fas fa-plane"></i> {{ translate['search.sort.flight'] }}
                        <i class="fas" v-show="sortLocal.column == 'FLUGZEIT'"
                           v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                    </a>
                    <a class="dropdown-item" v-on:click="sortRegions('GPREIS')"><i
                                class="fas fa-funnel-dollar"></i> {{ translate['search.sort.price'] }}
                        <i class="fas" v-show="sortLocal.column == 'GPREIS'"
                           v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div id="filters-button" data-toggle="modal" data-target="#modalFilters">
        <div class="container">
            <div class="filters-button">
                <div class="filters-button-left">
                    <div class="filters-button-title">{{ translate['search.filter.button'] }}</div>
                    <div class="filters-button-text">{{ translate['search.filter.change'] }}</div>
                </div>
                <div class="filters-button-right">
                    <div class="filters-button-icon">
                        <i class="icon icon-filter-buttons"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->render('layouts/search-bar') ?>
    <?php  $this->render('layouts/search-steps') ?>

    <div id="results">
        <div class="container">
            <div class="results">
                <?php $this->render('layouts/search-left') ?>
                <div class="results-right col-12 col-md-8">
                    <div class="d-none d-lg-block">
                        <p>
                            <button class="btn btn-primary btn-srt" type="button" data-toggle="collapse"
                                    data-target="#collapseSorting" aria-expanded="false"
                                    aria-controls="collapseSorting">
                                <i class="fas fa-sort-amount-down"></i> {{ translate['search.sort.by'] }} <i
                                        class="fas fa-sort"></i>
                            </button>
                        </p>
                        <div class="collapse" id="collapseSorting">
                            <div class="card card-body mb-2">
                                <a class="" v-on:click="sortRegions('name')"><i
                                            class="fas fa-sort-alpha-down"></i> {{ translate['search.sort.asc'] }}
                                    <i class="fas" v-show="sortLocal.column == 'name'"
                                       v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                                </a>
                                <a class="" v-on:click="sortRegions('LUFTTEMP')"><i
                                            class="fas fa-sun"></i> {{ translate['search.sort.tempature'] }}
                                    <i class="fas" v-show="sortLocal.column == 'LUFTTEMP'"
                                       v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                                </a>
                                <a class="" v-on:click="sortRegions('WASSERTEMP')"><i
                                            class="fas fa-water"></i> {{ translate['search.sort.water'] }}
                                    <i class="fas" v-show="sortLocal.column == 'WASSERTEMP'"
                                       v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                                </a>
                                <a class="" v-on:click="sortRegions('FLUGZEIT')"><i
                                            class="fas fa-plane"></i> {{ translate['search.sort.flight'] }}
                                    <i class="fas" v-show="sortLocal.column == 'FLUGZEIT'"
                                       v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                                </a>
                                <a class="" v-on:click="sortRegions('price')"><i
                                            class="fas fa-funnel-dollar"></i> {{ translate['search.sort.price'] }}
                                    <i class="fas" v-show="sortLocal.column == 'price'"
                                       v-bind:class="{'fa-sort-down' : sortLocal.direction == 'desc' , 'fa-sort-up' : sortLocal.direction != 'desc'}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="result-region">
                        <?php $this->render('search/region_results')?>
                    </div>
                    <div class="lds-css ng-scope" v-show="loading" style="display: none;">
                        <div class="lds-dual-ring"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="modal fade modal-right" id="modalFilters" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close">
                    <i class="icon icon-modal-close"></i>
                </div>

                <div class="modal-main">
                    <?php $this->render('filter/region')?>
                </div>
            </div>
        </div>
    </div>

</div>
