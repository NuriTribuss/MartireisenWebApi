<div id="page-header" class="bg-about-us">
    <div class="container page-header-container">
        <div class="page-header">
            <div class="page-header-about-us">
                <div class="page-header-about-us-title">    
                    <?php _lang('menu.customer_service') ?>
                </div>
                <div class="page-header-about-us-text"><?php echo $this->data['slogan'] ?></div>
            </div>
        </div>
    </div>
</div>

<div id="breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="" title="Home"><?php _lang('menu.home') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span><?php echo $this->data['title'] ?></span></li>
            </ol>
        </nav>
    </div>
</div>
<div id="about-us" class="cs-template pt-4">
    <div class="container">
        <div class="about-us-title">
            <h3 class="about-us-title-text">
                <?php _lang('menu.customer_service') ?>
            </h3>
        </div>
        <div class="content row">
            <div class="col-lg-4">
                <div class="nav nav-pills faq-nav" id="faq-tabs" role="tablist" aria-orientation="vertical">
                    <?php foreach ($this->categories as $index => $category) { ?>
                        <a href="#tab<?php echo $category['id'] ?>" class="rounded-0 pb-2 pt-2 nav-link <?php echo $index == 0 ? 'active' : '' ?>" data-toggle="pill" role="tab" aria-controls="tab1" aria-selected="true">
                            <i class="fa fa-arrow-right mr-2"></i> <?php echo $category['name'] ?>
                        </a>
                    <?php } ?>

                </div>
            </div>
            <div class="col-lg-8">
                <div class="tab-content p-0 shadow-none" id="faq-tab-content">
                    <?php foreach ($this->categories as $index => $category) { ?>

                        <div class="tab-pane   <?php echo $index == 0 ? 'active' : '' ?>" id="tab<?php echo $category['id'] ?>" role="tabpanel" aria-labelledby="tab1">
                            <div class="accordion" id="accordion-tab-<?php echo $index ?>">
                                <?php foreach ($category['posts'] as $subindex => $post) { ?>
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between <?php echo $subindex > 0 ? 'collapsed' : ''?>" data-toggle="collapse" data-target="#accordion-tab-<?php echo $subindex ?>-content-<?php echo $subindex ?>" id="accordion-tab-<?php echo $subindex ?>-heading-<?php echo $subindex ?>">
                                            <h5>
                                                <button class="btn btn-link" type="button" data-toggle="collapse"  aria-expanded="false" aria-controls="accordion-tab-<?php echo $subindex ?>-content-<?php echo $subindex ?>"><?php echo $post['title'] ?></button>
                                            </h5>
                                        </div>
                                        <div class="collapse <?php echo $subindex == 0 ? 'show' : '' ?>" id="accordion-tab-<?php echo $subindex ?>-content-<?php echo $subindex ?>" aria-labelledby="accordion-tab-1-heading-1" data-parent="#accordion-tab-<?php echo $subindex ?>">
                                            <div class="card-body">
                                                <?php echo $post['content'] ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
</div>
<div class="container row d-none">
    <div class="col-md-6 col-lg-4 col-xl-4 mb-3 mb-md-4 pb-1">
        <div class="card mb-1 transition-3d-hover shadow-hover-2 tab-card ">
            <div class="position-relative mb-2">
                <a href="../flights/flights-list.html" class="d-block gradient-overlay-half-bg-gradient-v5">
                    <img class="card-img-top" src="https://madrasthemes.github.io/mytravel-html/assets/img/300x230/img1.jpg" alt="img">
                </a>
                <div class="position-absolute top-0 left-0 pt-5 pl-3">
                    <span class="badge badge-pill bg-white text-primary px-4 py-2 font-size-14 font-weight-normal">Featured</span>
                    <span class="badge badge-pill bg-white text-danger px-3 ml-3 py-2 font-size-14 font-weight-normal">%25</span>
                </div>
                <div class="position-absolute top-0 right-0 pt-5 pr-3">
                    <button type="button" class="btn btn-sm btn-icon text-white rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save for later">
                        <span class="flaticon-valentine-heart"></span>
                    </button>
                </div>
                <div class="position-absolute bottom-0 left-0 right-0">
                    <div class="justify-content-between align-items-center">
                        <div class="px-3 pb-2">
                            <h2 class="h5 text-white mb-0 font-weight-bold"><small class="mr-2">From</small>£350.00</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-4 py-2">
                <a href="../flights/flights-list.html" class="d-block">
                    <div class="mb-1 d-flex align-items-center font-size-14 text-dark">
                        <i class="fa fa-map mr-2 font-size-15"></i> Greater London, United Kingdom
                    </div>
                </a>
                <a href="../flights/flights-list.html" class="card-title font-size-17 font-weight-bold mb-0 text-dark">Stonehenge, Windsor Castle,<br>and Bath from London</a>
                <div class="my-2">
                    <div class="d-inline-flex align-items-center font-size-17 text-lh-1 text-primary">
                        <div class="green-lighter mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                        </div>
                        <span class="text-secondary font-size-14 mt-1">48 Reviews</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .cs-template .tab-content{
        display:block;
    } 
    .cs-template .faq-nav{
        flex-direction: column;
        margin: 0 0 32px;
        border-radius: 2px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 5px rgba(85, 85, 85, 0.15);
    }
    .cs-template .faq-nav.nav-link {
        position: relative;
        display: block;
        margin: 0;
        padding: 13px 16px;
        background-color: #fff;
        border: 0;
        border-bottom: 1px solid #ddd;
        border-radius: 0;
        color: #616161;
        transition: background-color .2s ease;
    }
    .cs-template .faq-nav.nav-link:hover {
        background-color: #f6f6f6;
    }
    .cs-template .faq-nav.nav-link.active {
        background-color: #f6f6f6;
        font-weight: 700;
        color: rgba(0, 0, 0, 0.87);
    }
    .cs-template .faq-nav.nav-link:last-of-type {
        border-bottom-left-radius: 2px;
        border-bottom-right-radius: 2px;
        border-bottom: 0;
    }
    .cs-template .faq-nav.nav-link i.mdi {
        margin-right: 5px;
        font-size: 18px;
        position: relative;
    }

    .cs-template .tab-content {
        box-shadow: 0 1px 5px rgba(85, 85, 85, 0.15);
    }
    .cs-template .tab-content .card {
        border-radius: 0;
    }
    .cs-template .tab-content .card-header {
        padding: 15px 16px;
        border-radius: 0;
        background-color: #f6f6f6;
    }
    .cs-template .tab-content .card-header h5 {
        margin: 0;
    }
    .cs-template .tab-content .card-header h5 button {
        display: block;
        width: 100%;
        padding: 0;
        border: 0;
        font-weight: 700;
        color: rgba(0, 0, 0, 0.87);
        text-align: left;
        white-space: normal;
    }
    .cs-template .tab-content .card-header h5 button:hover, .cs-template .tab-content .card-header h5 button:focus, .cs-template .tab-content .card-header h5 button:active, .cs-template .tab-content .card-header h5 button:hover:active {
        text-decoration: none;
    }
    .cs-template .tab-content .card-body p {
        color: #616161;
    }
    .cs-template .tab-content .card-body p:last-of-type {
        margin: 0;
    }

    .accordion > .card:not(:first-child) {
        border-top: 0;
    }

    .collapse.show .card-body {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }


.card-img-top {
    width: 100%;
    border-top-left-radius: calc(0.3125rem - 1px);
    border-top-right-radius: calc(0.3125rem - 1px);
}
</style>