<div id="app" v-cloak>
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <a v-show="this.filter.sf == 2" href="" title="<?php _lang('search.last_minute')?>"><?php _lang('search.last_minute')?></a>
                        <a v-show="this.filter.sf == 3" href="" title="<?php _lang('search.only_hotel')?>"><?php _lang('search.only_hotel')?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('search.results')?></span></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php $this->render('layouts/search-steps')?>
    <div>
        <?php $this->render('search/hotel-booking-form')?>
    </div>
</div>
