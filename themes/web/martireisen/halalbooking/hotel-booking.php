<div id="app" v-cloak>
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <?php _lang('menu.halalbooking')?>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('search.results')?></span></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php $this->render('layouts/search-steps')?>
    <div>
        <?php $this->render('halalbooking/hotel-booking-form')?>
    </div>
</div>
