<div class="results-left col-12 col-md-4">
    <div class="filters">
        <h2 class="filters-title"><?php _lang('search.filters') ?></h2>
        <form class="search-form" method="get" action="">


            <div class="filters-item mt-3 mb-3">

                <div class="filters-item-header">
                    <div class="filters-item-header-icon"><i class="icon icon-filters-hotel-category"></i></div>
                    <div class="filters-item-header-content">
                        <h4 class="filters-item-header-content-title"><?php _lang('tour.category') ?></h4>
                    </div>
                </div>
                <div class="filters-item-main">
                    <ul class="list-group">
                        <?php foreach ($this->data['categories'] as $category) { ?>
                            <li class="list-group-item"><?php echo $category['title'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="filters-seperator"></div>
            <div class="filters-item mt-3 mb-3">

                <div class="filters-item-header">
                    <div class="filters-item-header-icon"><i class="icon icon-filters-hotel-category"></i></div>
                    <div class="filters-item-header-content">
                        <h4 class="filters-item-header-content-title"><?php _lang('tour.tour_type') ?></h4>
                    </div>
                </div>
                <div class="filters-item-main">
                    <ul class="list-group">
                        <?php foreach ($this->data['types'] as $type) { ?>
                            <li class="list-group-item <?php echo $this->typeId == $type['id'] ? 'active' : '' ?>">
                                <a href="<?php echo SITE_URL . '/' . $type['seo_url'] ?>/"
                                   class="text-reset"><?php echo $type['title'] ?></a>

                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="filters-seperator"></div>
            <div class="filters-item mt-3 mb-3 d-none">

                <div class="filters-item-header">
                    <div class="filters-item-header-icon"><i class="icon icon-filters-hotel-category"></i></div>
                    <div class="filters-item-header-content">
                        <h4 class="filters-item-header-content-title"><?php _lang('tour.age_group') ?> </h4>
                    </div>
                </div>
                <div class="filters-item-main">
                    <ul class="list-group">
                        <?php foreach ($this->data['ages'] as $age) { ?>
                            <li class="list-group-item"><?php echo $age['title'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="filters-seperator"></div>
        </form>
    </div>
</div>