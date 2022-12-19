<script src="https://unpkg.com/vue-tel-input@5.4.0/dist/vue-tel-input.umd.min.js"></script>
<script> var PAGE_TYPE = 'tour-booking'; </script>
<div id="app" v-cloak>
    <div id="breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item">
                        <?php _lang('menu.tours')?>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><span>    <?php _lang('tour.reservation_count')?></span></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="">
        <div id="steps">
            <div class="container">
                <div class="steps">
                    <a id="step-1" class="steps-item active"  href="" title="Steps">
                        <div class="steps-item-number">1</div>
                        <div class="steps-item-text"><span><?php _lang('tour.tour_list')?> </span></div>
                    </a>
                    <a id="step-2" class="steps-item active" href="" title="Steps">
                        <div class="steps-item-number">2</div>
                        <div class="steps-item-text"><span><?php _lang('tour.tour_review')?> </span></div>

                    </a>
                    <a id="step-3" class="steps-item active"   href="" title="Steps">
                        <div class="steps-item-number">3</div>
                        <div class="steps-item-text"><span><?php _lang('tour.reservation')?></span></div>

                    </a>
                    <a id="step-4" class="steps-item "   href="" title="Steps">
                        <div class="steps-item-number">4</div>
                        <div class="steps-item-text"><span><?php _lang('tour.confirmation_page')?></span></div>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?php $this->render('tour/booking-form')?>
    </div>
</div>
