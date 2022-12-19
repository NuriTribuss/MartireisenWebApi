<div class="filters">
    <form class="search-form mt-4 mt-lg-0" method="get" action="">
       
        <div class="filters-item">
            <div class="filters-item-header">
                <div class="filters-item-header-icon"><i class="icon icon-filters-room"></i></div>
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title">{{translate['search.filter_room_type']}}</h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div class="selectbox selectbox-default custominput" data-selectbox="root">
                    <div class="selectbox-default-select">
                        <select v-model="filter.room" v-on:change="loadHotelOffers">
                            <option value="0" ><?php _lang('search.room.1') ?></option>
                            <option v-for="room in results.roomTypeList" v-bind:value="room.code">{{ room.name }}</option>

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
        <div class="filters-seperator"></div>
        <div class="filters-item">
            <div class="filters-item-header" >
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title"><?php _lang('search.filter.transfer'); ?></h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div  class="filters-operator" >
                    <div  v-if="filter.sf == 2" v-on:click="filter.transfer = parseInt( 1 - filter.transfer); loadHotelOffers()" >
                        <span v-bind:class="{'active' : filter.transfer == 1}" class="filters-marti-checkbox"></span>
                        <span class="filters-marti-checkbox-label"><?php _lang('search.transfer.1') ?></span>
                    </div>
                    <div v-on:click="filter.seaview = parseInt( 1 - filter.seaview); loadHotelOffers()" >
                        <span v-bind:class="{'active' : filter.seaview == 1}" class="filters-marti-checkbox"></span>
                        <span class="filters-marti-checkbox-label"><?php _lang('search.seawide') ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="filters-seperator"></div>
        <div class="filters-item">
            <div class="filters-item-header">
                <div class="filters-item-header-icon"><i class="icon icon-filters-keys"></i></div>
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title">
                        Extra</h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div class="" data-selectbox="root">
                    <div v-on:click="filter.directness = (filter.directness == true ? '' : true ); loadHotelOffers()" >
                        <span v-bind:class="{'active' : filter.directness == true}" class="filters-marti-checkbox"></span>
                        <span class="filters-marti-checkbox-label">Direkt Flight {{ filter.directness }}</span>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="filters-seperator"></div>
        <div class="filters-item">
            <div class="filters-item-header" >
                <div class="filters-item-header-content">
                    <h4 class="filters-item-header-content-title"><?php _lang('search.operators'); ?></h4>
                </div>
            </div>
            <div class="filters-item-main">
                <div  class="filters-operator" >
                    <div  v-for="operator in operators" v-on:click="filter_operator(operator.code)">
                        <span v-bind:class="{'active' : filter_check(operator.code,filter.operators)}" class="filters-marti-checkbox"></span>
                        <span class="filters-marti-checkbox-label">{{operator.name}}</span>
                    </div>
                </div>
            </div>
            <div class="m-5">
            </div>
        </div>
    </form>
    <div class="modal-close fixed-bottom btn btn-primary m-3 d-block d-sm-none">
        <?php _lang('search.filter.accept'); ?>
    </div>
</div>




