<div class="results-left col-md-3"> 
    <div class="filters" v-if="hotel.id"> 
        <h5>{{translate['halalbooking.filter.header']}}</h5>
        <div class="filters-seperator"></div>
        <div  v-for="feature in features">
            <div class="filters-item">
                <div class="filters-item-header">
                    <div class="filters-item-header-icon d-none"><i class="icon icon-filters-accommodation"></i></div>
                    <div class="filters-item-header-content">
                        <h4 class="filters-item-header-content-title">{{ feature.title}}</h4>
                    </div>
                </div>
                <div class="filters-item-main">
                    <p v-for="children in feature.children">
                        <i class="fa fa-check text-info"></i>
                        {{children}}
                    </p> 
                </div>
            </div>    
        </div>
    </div>
</div>
