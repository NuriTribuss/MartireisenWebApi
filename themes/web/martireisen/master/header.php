<html lang="<?php echo !empty($this->meta['locale']) ? $this->meta['locale']  : \Model\User\Customer::getLanguage() ?>">
<head>
    <!-- Meta -->
    <meta charset="utf-8"/>
    <meta name="viewport"  content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
    <meta name="theme-color" content="#fff">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="-VnZ7-L_CZh_A26QvlpKBMJEGK-KkBvdkv22IL1t28c" />
    <meta name="yandex-verification" content="c72b025eca43816a" />
    <!-- Add to home screen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Martireisen">
    <meta name="msapplication-TileImage" content="/data/image/settings/logo/logo.png">
    <meta name="msapplication-TileColor" content="#2F3BA2">

    <link rel="manifest" href="<?php echo SITE_URL.'/manifest.json'?>"/>
    <link rel="apple-touch-icon" href="<?php echo SITE_URL.'//data/image/settings/logo/logo.png'?>"/>
<script>
 if ('serviceWorker' in navigator) {
  window.addEventListener('load', function () {
   navigator.serviceWorker.register('service-worker.js').then(function (registration) {
    console.log('Registered!');
   }, function (err) {
    console.log('ServiceWorker registration failed: ', err);
   }).catch(function (err) {
    console.log(err);
   });
  });
 } else {
  console.log('service worker is not supported');
 }
</script>
    <?php   if(\Helper\Config::getDomain() == 'akin.at'){ ?>
    <link rel="shortcut icon" href="/favicona.ico" type="image/x-icon"/>
    <link rel="icon" href="<?php theme_dir() ?>assets/favicona.ico" type="image/x-icon"/>
    <?php }else{ ?>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="icon" href="<?php theme_dir() ?>assets/favicon.ico" type="image/x-icon"/>
    <?php   }?>
    <?php $this->render('master/meta') ?>

    <?php foreach($this->meta['alternates'] as $meta) { ?>
<link rel="alternate" hreflang="<?php echo $meta['language']?>"    href="<?php echo SITE_URL.'/'.$meta['url']?>" />
    <?php } ?>

    <link rel="canonical" href="<?php echo Helper\Input::getFullUrl() ?>"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap" rel="stylesheet"/>
    <!-- Stylesheets -->

    <link rel="stylesheet" href="/service/css/compress"/>
    <link rel="stylesheet" href="<?php echo theme_dir() ?>assets/css/custom/custom.css?v=<?php echo time()?>"/>
    <!-- <link rel="stylesheet" href="<?php echo theme_dir() ?>assets/css/custom/custom.css?v=68786453435"/> -->
    <link rel="stylesheet" href="<?php echo theme_dir() ?>assets/css/custom/style-marti.css?v=23"/>
    <link rel="stylesheet" href="/service/css/modules"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"  crossorigin="anonymous"/>
    <link rel="stylesheet" href="/service/css/load"/>

    <script>
        window.addEventListener("load", function (event) {
        Marti.Member = JSON.parse('<?php echo json_encode(\Model\User\Customer::getAll()) ?>');
            Marti.Member.currency = '<?php echo \Model\User\Customer::getCurrency() ?>';
        });


    </script>

    <?php if($this->page == 'home')  { ?>


    <script type="application/ld+json">
    {
        "@context" : "http://schema.org",
        "@type" :"Organization",
        "name": "Marti Reisen",
        "url": "https://www.martireisen.at",
        "logo": "https://www.martireisen.at/<?php echo Helper\Setting::get('alternative_logo')?>",
        "address":{
            "@type": "PostalAddress",
            "addressLocality": "Wien, Österreich",
            "postalCode": "1100",
            "streetAddress": "<?php echo Helper\Setting::get('address') ?>"
        },
        "contactPoint": [
            {
                "@type": "ContactPoint",
                "email": "<?php echo Helper\Setting::get('email') ?>",
                "telephone": "<?php echo str_replace(' ','',Helper\Setting::get('phone')) ?>",
                "contactType": "customer service",
                "faxNumber": "<?php  echo str_replace(' ','',Helper\Setting::get('fax')) ?>"
            }
        ],
        "sameAs": [
            "<?php echo Helper\Setting::get('facebook') ?>",
            "<?php echo Helper\Setting::get('instagram') ?>",
            "<?php echo Helper\Setting::get('twitter') ?>",
            "<?php echo Helper\Setting::get('youtube') ?>",
            "https://www.linkedin.com/company/martireisen/"
        ]
    }
    </script>


    <?php } ?>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5X64LHM');</script>
    <!-- End Google Tag Manager -->


</head>
<body class="<?php echo $this->page ?>">

    <header id="header" class="no-print">
        <div class="header-top">
            <div class="container">
                <div class="header-top-container">
                    <div class="header-top-left">
                        <ul class="header-top-list">
                            <?php foreach ($this->menu[0]['children'] as $menu) { ?>
                                <li><a href="<?php echo $menu['link'] ?>" title=""><?php echo $menu['title'] ?></a></li>
                            <?php } ?>
                        </ul>
                        <div class="mobile-top hidden-lg d-lg-none">
                            <a data-toggle="mobile-nav" data-href="#mobile-support">
                                <span class="header-top-link-icon"><i class="fas fa-phone"></i></span>
                            </a>

                            <?php if (!\Model\User\Customer::isLogged()) { ?>
                                <a class="loginbuttons">
                                    <i class="fas fa-user"></i>
                                </a>
                            <?php } else { ?>
                                <a title="" href="/my/index">
                                    <i class="fas fa-user"></i>
                                </a>
                            <?php } ?>
                            <a href="#menu">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>

                    </div>
                    <div class="header-top-right">
                        <ul class="header-top-links">
                            <li class="header-top-link header-top-link-logo d-none">
                                <a href="https://www.martigo.com/tr" title="martigo" target="_blank">
                                    <img alt="Martireisen" src="<?php theme_dir() ?>assets/img/martigo-logo.png">
                                </a>
                            </li>

                            <li class="header-top-link header-top-link-social">
                                <a href="<?php echo Helper\Setting::get('facebook') ?>" title="facebook" target="_blank">
                                    <span class="header-top-link-icon"><i class="icon icon-header-facebook"></i></span>
                                </a>
                            </li>

                            <li class="header-top-link header-top-link-social">
                                <a href="<?php echo Helper\Setting::get('instagram') ?>" title="instagram" target="_blank">
                                    <span class="header-top-link-icon"><i class="icon icon-header-instagram"></i></span>
                                </a>
                            </li>
                            <li class="header-top-link header-top-link-social">
                                <a href="<?php echo Helper\Setting::get('youtube') ?>" title="youtube" target="_blank   ">
                                    <span class="header-top-link-icon"><i class="icon icon-header-youtube"></i></span>
                                </a>
                            </li>


                            <?php if (!\Model\User\Customer::isLogged()) { ?>
                                <li class="header-top-link header-top-link-mega d-none d-md-block">
                                    <a class="loginbuttons">
                                        <span class="header-top-link-icon "><i class="fas fa-user"></i></span>
                                        <span class="header-top-link-text"><?php _lang('header.login'); ?></span>
                                        <span class="header-top-link-icon "><i
                                                class="icon icon-header-arrow-right"></i></span>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="header-top-link header-top-link-mega d-none d-md-block">
                                    <a title="" href="/my/index">
                                        <span class="header-top-link-icon "><i class="icon icon-header-user"></i></span>
                                        <span class="header-top-link-text "><?php echo \Model\User\Customer::getFullName() ?></span>
                                    </a>
                                </li>
                                <li class="header-top-link header-top-link-mega d-none d-md-block">
                                    <a title="" href="/service/customers/logout">
                                        <span class="header-top-link-text"><?php _lang('header.logout'); ?></span>
                                        <span class="header-top-link-icon"><i
                                                class="icon icon-header-arrow-right"></i></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if (\Model\User\Customer::isLogged()) { ?>
                                <li class="header-top-link header-top-link-mega">
                                    <a href="" title="" data-toggle="modal" data-target="#modalfavorite"
                                       data-user-tab-panel="1">
                                        <span class="header-top-link-icon"><i class="icon icon-filters-heart"></i></span>
                                        <span class="header-top-link-text"><?php _lang('header.wishlist'); ?></span>
                                        <span class="badge badge-pill badge-orange">0</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="header-top-link header-top-link-mega d-block d-md-none">
                                <a data-toggle="mobile-nav" data-href="#mobile-languages">
                                    <img width="24"
                                         src="<?php theme_dir() ?>assets/img/flags/<?php echo \Core\Translation\Language::getLanguage() ?>.svg"
                                         alt="Martireisen Language"/>
                                </a>
                            </li>
                            <li class="header-top-link header-top-link-mega d-block d-md-none">
                                <a data-toggle="mobile-nav" data-href="#mobile-currencies">
                                    <?php echo strtoupper(\Model\User\Customer::getCurrency()) ?>
                                </a>
                            </li>
                            <li class="header-top-link header-top-link-mega d-none d-md-block mr-1">
                                <select id="switch-currency">
                                    <?php foreach ($this->currencies as $currency) { ?>
                                        <option <?php echo \Model\User\Customer::getCurrency() == $currency['code'] ? 'selected' : '' ?>
                                            value="<?php echo $currency['code'] ?>"><?php echo $currency['title'] ?></option>
                                        <?php } ?>
                                </select>
                            </li>
                            <li class="header-top-link header-top-link-mega d-none d-md-block">
                                <div class="dropdown">
                                    <a class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <img class="mr-2" width="20"
                                             src="<?php theme_dir() ?>assets/img/flags/<?php echo \Core\Translation\Language::getLanguage() ?>.svg"
                                             alt="Martireisen Language"/>
                                    </a>
                                    <div class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                        <?php foreach ($this->languages as $language) { if(\Model\User\Customer::getLanguage() == $language['code'] || $language['code'] == 'en')  continue; ?>
                                            <a class="dropdown-item" rel="noindex"
                                               href="<?php echo \Helper\UrlGen::langUri($language['code'])?>"><img
                                                    class="mr-2" width='16'
                                                    src="<?php theme_dir() ?>assets/img/flags/<?php echo $language['code'] ?>.svg"
                                                    alt="<?php echo strtoupper($language['code']) ?>"><?php echo strtoupper($language['code']) ?></a>
                                            <?php } ?>
                                    </div>
                                </div>
                            </li>
                            <li class="header-bottom-menu-link d-none">
                                <a type="button">
                                    <span class="header-bottom-menu-link-icon img-icon">
                                        <img src="<?php theme_dir() ?>assets/img/flags/<?php echo \Core\Translation\Language::getLanguage() ?>.svg"
                                             alt="Martireisen Language"/>
                                    </span>
                                    <span class="header-bottom-menu-link-text"><?php echo \Core\Translation\Language::getLanguage() ?></span>
                                    <div class="header-bottom-menu-dropdown lang-dropdown">
                                        <div class="">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-1 offset-md-10 lang-selector">
                                                        <ul id="langselect">
                                                            <?php foreach ($this->languages as $language) { ?>
                                                                <li data-language="<?php echo $language['code'] ?>"><img
                                                                        src="<?php theme_dir() ?>assets/img/flags/<?php echo $language['code'] ?>.svg"
                                                                        alt="Martireisen Language"><?php echo strtoupper($language['code']) ?>
                                                                </li>
                                                            <?php } ?>
                                                            <li></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="header-middle-container">
                    <div class="header-middle-logo">
                        <a href="/" title="Marti Reisen">
                            <img src="<?php echo \Helper\Setting::get('logo') ?>" alt="Marti Reisen" width="214" height="89"/>
                        </a>
                    </div>
                    <div class="header-middle-headline">
                        <h4 class="header-middle-headline-title"><?php _lang('header.slogan_one'); ?></h4>
                        <p class="header-middle-headline-description"><?php _lang('header.slogan_two'); ?></p>
                    </div>
                    <div class="header-middle-contact">
                        <div class="header-middle-contact-icon"><i class="icon icon-header-whatsapp"></i></div>
                        <div class="header-middle-contact-phone">
                            <h5 class="header-middle-contact-phone-title"><?php _lang('header.contact_info') ?></h5>
                            <p class="header-middle-contact-phone-number"><a class="text-white"
                                                                             href="tel:<?php echo \Helper\Setting::get('phone') ?>"><?php echo \Helper\Setting::get('phone') ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-bottom-container">
                    <nav class="header-bottom-menu d-none d-md-block">
                        <ul class=" mx-auto">
                            <?php foreach ($this->main_menu as $menu) { ?>
                                <?php if ($menu['has_children'] == 1) { ?>
                                    <li class="header-bottom-menu-default  nav-item dropdown megamenu">
                                        <a href="<?php echo $menu['translate']['url'] ?>" data-target="<?php echo $menu['translate']['url'] ?>"
                                           aria-haspopup="true" aria-expanded="false"
                                           class="nav-link dropdown-toggle font-weight-bold text-uppercase header-bottom-menu-item">
                                            <span class="header-bottom-menu-item-icon">
                                                <i class="<?php echo $menu['icon_class'] ?>"></i>
                                                <i class="<?php echo $menu['icon_class'] ?>-active"></i>
                                            </span>
                                            <span class="header-bottom-menu-item-text"><?php echo _lang('menu.' . $menu['menu_code']); ?></span>

                                        </a>
                                        <div aria-labelledby="megamneu" class="dropdown-menu me border-0 p-0 m-0">
                                            <div class="container position-relative">
                                                <div class="row bg-white rounded-0 m-0 shadow-sm">
                                                    <div class="col-lg-7 col-xl-8" style="z-index: 1;">
                                                        <div class="p-4">
                                                            <div class="row">
                                                                <div class="col-lg-4 mb-4">
                                                                    <h6 class="font-weight-bold">
                                                                        <?php echo $menu['translate']['title_1'] ?>
                                                                    </h6>
                                                                    <ul class="list-unstyled">
                                                                        <?php
                                                                        foreach ($menu['children'] as $child) {
                                                                            if ($child['location'] != 0)
                                                                                continue;
                                                                            ?>
                                                                            <li class="nav-item">
                                                                                <a
                                                                                    class="nav-link text-small text-dark pb-0"
                                                                                    href="<?php echo $child['translate']['url'] ?>">
                                                                                    <i class="fa fa-angle-right"></i>
                                                                            <?php echo $child['translate']['name'] ?></a>
                                                                            </li>
        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-lg-4 mb-4">
                                                                    <h6 class="font-weight-bold text-blue">
        <?php echo $menu['title_2'] ?>&nbsp;
                                                                    </h6>
                                                                    <ul class="list-unstyled">
                                                                        <?php
                                                                        foreach ($menu['children'] as $child) {
                                                                            if ($child['location'] != 1)
                                                                                continue;
                                                                            ?>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link text-small text-dark pb-0"
                                                                                   href="<?php echo $child['translate']['url'] ?>">
                                                                                    <i class="fa fa-angle-right"></i>
                                                                            <?php echo $child['translate']['name'] ?>
                                                                                </a>
                                                                            </li>
        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-lg-4 mb-4">
                                                                    <h6 class="font-weight-bold">&nbsp;</h6>
                                                                    <ul class="list-unstyled">
                                                                        <?php
                                                                        foreach ($menu['children'] as $child) {
                                                                            if ($child['location'] != 2)
                                                                                continue;
                                                                            ?>
                                                                            <li class="nav-item"><a
                                                                                    class="nav-link text-small text-dark pb-0"
                                                                                    href="<?php echo $child['translate']['url'] ?>">
                                                                                    <i class="fa fa-angle-right"></i>
            <?php echo $child['translate']['name'] ?></a>
                                                                            </li>
        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-0 d-none d-lg-block megamenu-image"
                                                         style="max-height:100%; background: center center url(<?php echo $menu['image'] ?>)no-repeat; background-size: cover;"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </li>

    <?php } else { ?>
                                    <li class="header-bottom-menu-default">
                                        <a class="header-bottom-menu-item" <?php echo $menu['blank'] == 1 ? 'target="blank"' : '' ?>
                                           href="<?php echo $menu['translate']['url'] ?>">
                                            <span class="header-bottom-menu-item-icon">
                                                <?php if (!empty($menu['icon_class'])) { ?>
                                                    <i class="<?php echo $menu['icon_class'] ?> "></i>
                                                    <i class="<?php echo $menu['icon_class'] ?>-active"></i>
        <?php } ?>
                                            </span>
                                            <span class="header-bottom-menu-item-text"><?php echo _lang('menu.' . $menu['menu_code']); ?></span>
                                        </a>
                                    </li>
    <?php } ?>
<?php } ?>


                            <li class="header-bottom-menu-link" style="display: none">
                                <a href="" title="">
                                    <span class="header-bottom-menu-link-icon">
                                        <i class="icon icon-header-arrow-down"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

<div class="mobile-sidenav d-block d-md-none no-print" id="mobile-languages" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="mobile-container">
        <div class="header">
            <div class="text">
<?php _lang('common.language') ?>
            </div>
            <div class="mobile-close">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="mobile-divider"></div>

        </div>

        <ul>
<?php foreach ($this->languages as $language) { ?>
                <li data-language="<?php echo $language['code'] ?>">
                    <img src="<?php theme_dir() ?>assets/img/flags/<?php echo $language['code'] ?>.svg" alt="Martireisen Language"/>
                    <span class="<?php echo \Core\Translation\Language::getLanguage() == $language['code'] ? 'active' : '' ?>"><?php echo strtoupper($language['title']) ?></span>
                </li>
<?php } ?>
        </ul>
    </div>
</div>
<div class="mobile-sidenav d-block d-md-none no-print" id="mobile-currencies" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="mobile-container">
        <div class="header">
            <div class="text">
<?php _lang('common.currency') ?>
            </div>
            <div class="mobile-close">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="mobile-divider"></div>
        </div>
        <ul>
<?php foreach ($this->currencies as $currency) { ?>
                <li data-currency="<?php echo $currency['code'] ?>">
                    <i class="currency-icon fas"><?php echo $currency['icon'] ?></i>

                    <span class="<?php echo \Model\User\Customer::getCurrency('currency') == $currency['code'] ? 'active' : '' ?>"><?php echo strtoupper($currency['code']) ?></span>
                </li>
<?php } ?>
        </ul>
    </div>
</div>
<div class="mobile-sidenav d-block d-md-none no-print" id="mobile-support" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="mobile-container">
        <div class="header">
            <div class="text">
<?php _lang('header.contact') ?>
            </div>
            <div class="mobile-close">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="mobile-divider"></div>

        </div>
        <div class="body">
            <h5 class="header-middle-contact-phone-title"><?php _lang('header.contact_info') ?></h5>
            <p class="header-middle-contact-phone-number"><i class="fas fa-phone"></i><a
                href="tel:<?php echo \Helper\Setting::get('phone') ?>"><?php echo \Helper\Setting::get('phone') ?></a>
            </p>
            <h5 class="header-middle-contact-phone-title"><?php _lang('user.email') ?></h5>
            <p class="header-middle-contact-phone-number"><a
                    href="mailto:<?php echo \Helper\Setting::get('email') ?>"><i
                        class="fas fa-envelope"></i><?php echo \Helper\Setting::get('email') ?></a></p>
            <ul class="mobile-menu-footer-social">
                <li class="mobile-menu-footer-social-item">
                    <a href="<?php echo Helper\Setting::get('facebook') ?>" title="">
                        <img width="32" alt="Marti Reisen Facebook" src="<?php theme_dir() ?>assets/img/socials/facebook.svg"/>
                    </a>
                </li>
                <li class="mobile-menu-footer-social-item">
                    <a href="<?php echo Helper\Setting::get('instagram') ?>" title="">
                        <img width="32" alt="Marti Reisen Instagram" src="<?php theme_dir() ?>assets/img/socials/instagram.svg"/>
                    </a>
                </li>
                <li class="mobile-menu-footer-social-item">
                    <a href="<?php echo Helper\Setting::get('youtube') ?>" title="">
                        <img width="32" alt="Marti Reisen Youtube" src="<?php theme_dir() ?>assets/img/socials/youtube.svg"/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<header id="header-mobile">
    <nav role="navigation">
        <div class="left">
            <?php if ($this->searchEngine != 1) { ?>
                <a href="/" class="logo" title="Marti Reisen">
                    <img src="<?php echo \Helper\Setting::get('logo') ?>" alt="Marti Reisen">
                </a>
<?php } else { ?>
                <a onclick="Marti.back()" class="back-button" title="Geri">
                    <span class="arrow">
                    </span> <span><?php echo $this->header_button ?></span>
                </a>
<?php } ?>
        </div>
        <?php if ($this->searchEngine == 1) { ?>
            <div class="center">
                <strong><?php echo $this->header_title ?></strong>
            </div>
                <?php } ?>
        <div class="right">
            <div class="buttons">
                        <?php if ($this->page == 'home') { ?>
                    <div class="currency-button">
                        <a data-toggle="mobile-nav" data-href="#mobile-currencies">
    <?php echo strtoupper(\Model\User\Customer::getCurrency()) ?>
                        </a>
                    </div>
                    <div class="language-button">
                        <a data-toggle="mobile-nav" data-href="#mobile-languages">
                            <img width="24"
                                 src="<?php theme_dir() ?>assets/img/flags/<?php echo \Core\Translation\Language::getLanguage() ?>.svg"
                                 alt="Martireisen Language"/>
                        </a>
                    </div>
                    <div class="phone-button">
                        <a data-toggle="mobile-nav" data-href="#mobile-support">
                            <i class="fas fa-phone"></i>
                        </a>
                    </div>
                    <?php } else { ?>

<?php } ?>
                <div class="account-button">
                    <?php if (!\Model\User\Customer::isLogged()) { ?>
                        <a class="loginbuttons">
                            <i class="fas fa-user"></i>
                        </a>
                    <?php } else { ?>
                        <a title="" href="/my/index">
                            <i class="fas fa-user"></i>
                        </a>
<?php } ?>
                </div>
                <div class="menu-button">
                    <a id="mobile-menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <nav id="menu">
                        <ul class="panel-menu">
                            <li><a href="/"><?php _lang('menu.home') ?></a></li>
                             <li><a href="/kontakt"><?php _lang('header.contact') ?></a></li>
                                    <?php foreach ($this->main_menu as $menu) { ?>
                                        <?php if ($menu['has_children'] == 1) { ?>
                                    <li class="marti-drawer-children-menu">
                                        <span>
        <?php if (!empty($menu['icon_class'])) { ?>
                                                <i class="<?php echo $menu['icon_class'] ?> d-inline-block mr-2"></i>
                                            <?php } ?>
                                            <span class="icon-text"><?php echo _lang('menu.' . $menu['menu_code']); ?></span>
                                        </span>
                                        <ul>
                                            <?php foreach ($menu['children'] as $child) { ?>
                                                <li>
                                                    <a href="<?php echo $child['translate']['url'] ?>"><?php echo $child['translate']['name'] ?></a>
                                                </li>
                                    <?php } ?>
                                        </ul>
                                    </li>
                                            <?php } else { ?>
                                    <li>
                                        <a <?php echo $menu['blank'] == 1 ? 'target="blank"' : '' ?>
                                            href="<?php echo $menu['translate']['url'] ?>">
        <?php if (!empty($menu['icon_class'])) { ?>
                                                <i class="<?php echo $menu['icon_class'] ?> d-inline-block mr-2"></i>
                                    <?php } ?>
                                            <span class="icon-text"><?php echo _lang('menu.' . $menu['menu_code']); ?></span>
                                        </a>
                                    </li>
    <?php } ?>
<?php } ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</header>


<section id='app--'>