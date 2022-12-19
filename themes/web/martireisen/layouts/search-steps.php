<div id="steps">
    <div class="container">
        <div class="steps">
            <a id="step-1" class="steps-item" v-bind:class='{active : step >= 2}' href="<?php echo Helper\UrlGen::step(1,$this->step,$this->page)?>" title="Steps">
                <div class="steps-item-number">1</div>
                <div class="steps-item-text"><span><?php _lang('search.step1');?></span></div>
            </a>
            <a id="step-2" class="steps-item" v-bind:class='{active : step >= 3}' href="<?php echo Helper\UrlGen::step(2,$this->step,$this->page)?>" title="Steps">
                <div class="steps-item-number">2</div>
                <div class="steps-item-text"><span><?php _lang('search.step2');?></span></div>

            </a>
            <a id="step-3" class="steps-item" v-bind:class='{active : step >= 4}' href="<?php echo Helper\UrlGen::step(3,$this->step,$this->page)?>" title="Steps">
                <div class="steps-item-number">3</div>
                <div class="steps-item-text"><span><?php _lang('search.step3');?></span></div>

            </a>
            <a id="step-4" class="steps-item" v-bind:class='{active : step >= 5}' href="<?php echo Helper\UrlGen::step(4,$this->step,$this->page)?>" title="Steps">
                <div class="steps-item-number">4</div>
                <div class="steps-item-text"><span><?php _lang('search.step4');?></span></div>

            </a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo $this->header_title?></a></li>
                <li class="breadcrumb-item active d-none" aria-current="page"><a href="#"><i class="fas fa-map-marker-alt"></i> Furaveri Maldives</a></li>
            </ol>
        </nav>
    </div>
</div>
