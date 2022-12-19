</section>
<!--footerBefore-->
<div id="properties" class="no-print d-none">
    <div class="container">
        <div class="properties">
            <div class="properties-item">
                <div class="properties-item-icon"><i class="icon icon-properties-surety"></i></div>
                <div class="properties-item-content">
                    <h3 class="properties-item-content-title">{{ 'footer.slogan_one_title' | translate }}</h3>
                    <p class="properties-item-content-text">{{ 'footer.slogan_one_text' | translate }}</p>
                </div>
            </div>
            <div class="properties-item">
                <div class="properties-item-icon"><i class="icon icon-properties-call-center"></i></div>
                <div class="properties-item-content">
                    <h3 class="properties-item-content-title">{{ 'footer.slogan_two_title' | translate }}</h3>
                    <p class="properties-item-content-text">{{ 'footer.slogan_two_text' | translate }}</p>
                </div>
            </div>
            <div class="properties-item">
                <div class="properties-item-icon"><i class="icon icon-properties-marker"></i></div>
                <div class="properties-item-content">
                    <h3 class="properties-item-content-title">{{ 'footer.slogan_three_title' | translate }}</h3>
                    <p class="properties-item-content-text">{{ 'footer.slogan_three_text' | translate }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footerBeforeend-->
<!--footer-->
<footer id="footer" class="no-print">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col--6 phone-numbers">
                    <h4 class="footer-top-title">{{ 'footer.phone_numbers' | translate }}</h4>
                    <ul class="footer-top-list">
                        <li><a href="tel:+43 1 90 94 500" title=""><img src="{{ theme_dir }}assets/img/flags/au-circle.svg" alt="Marti Reisen Osterrich" width="25"/> <span class="ml-2">+43 1 90 94 500 50</span></a></li>
                        <li><a href="tel:+49 69 333 98 011" title=""><img src="{{ theme_dir }}assets/img/flags/de-.svg" alt="Marti Reisen Deutschland"  width="25"/> <span class="ml-2">+49 69 333 98 011 50</span></a></li>
                        <li><a href="tel:+90 850 840 62 91" title=""><img src="{{ theme_dir }}assets/img/flags/tr-circle.png" alt="Marti Reisen Türkiye"  width="25"/> <span class="ml-2">+90 850 840 62 91 50</span></a></li>
                        <li><a href="tel:+43 1 90 94 500" title=""><img src="{{ theme_dir }}assets/img/flags/global-circle.svg" alt="Marti Reisen Global" width="25"/> <span class="ml-2">+43 1 90 94 500 50</span></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col--6">
                    <h4 class="footer-top-title">{{ menu.MENU2.data.name}}</h4>
                    <ul class="footer-top-list">
                        {% for item in menu.MENU2.children % }
                            <li><a href="{{ item.translate.url }}" title="">{{ item.translate.name }}</a></li>
                        {% endfor %}
                    </ul>
                </div>
                <div class="col-md-3 col--6">
                    <h4 class="footer-top-title">{{ menu.MENU3.data.name}}</h4>
                    <ul class="footer-top-list">
                        {% for item in menu.MENU2.children % }
                            <li><a href="{{ item.translate.url }}" title="">{{ item.translate.name }}</a></li>
                        {% endfor %}
                    </ul>
                </div>
                <div class="col-md-3 col--12">
                    <h4 class="footer-top-title light">{{ 'footer.subscribe' | translate }}</h4>
                    <p class="footer-top-description light"></p>
                    <form method="GET" action="/newsletter">
                        <div class="footer-top-form">
                            <div class="footer-top-form-input input-main">
                                <input type="email" id="send-subscribe-email" name="username"
                                       placeholder="{{ 'form.email'| translate }}" required/>
                                <span class="error-message">{{ 'user.email_error_message'| translate }}</span>
                            </div>
                            <div class="footer-top-form-button">
                                <button type="submit" class="button"> <i class="fas fa-envelope"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="footer-middle-container">
                <p class="footer-middle-copyright">{{ setting.copyright }} </p>
                <div class="footer-middle-social">
                    <a class="footer-middle-social-item" href="{{ setting.facebook }} "
                       target="_blank" title="Social"><i
                            class="fab fa-facebook"></i></a>
                    <a class="footer-middle-social-item" href="{{ setting.instagram }} "
                       target="_blank" title="Social"><i
                            class="fab fa-instagram"></i></a>
                    <a class="footer-middle-social-item" href="{{ setting.youtube }} "
                       target="_blank" title="Social"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h4 class="footer-bottom-title">{{ 'common.ssl_certificate' | translate }}</h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="{{ theme_dir }}assets/img/payment/ssl.svg"
                             alt="SSL Certificate"/>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4 class="footer-bottom-title">{{ 'common.payment_methods' | translate }}</h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="{{ theme_dir }}assets/img/payment/mastercard.svg"
                             alt="MasterCard"/>
                        <img class="footer-bottom-img" src="{{ theme_dir }}assets/img/payment/visa.svg"
                             alt="Visa"/>
                        <img class="footer-bottom-img" src="{{ theme_dir }}assets/img/payment/klarna.svg"
                             alt="Klarna"/>
                        <img class="footer-bottom-img" src="{{ theme_dir }}assets/img/payment/paypal.svg"
                             alt="Paypal"/>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4 class="footer-bottom-title">{{ 'common.security_certs' | translate }}</h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="{{ theme_dir }}assets/img/payment/iata.svg"
                             alt="Iata"/>
                        <img class="footer-bottom-img" style="width: 150px" src="{{ theme_dir }}assets/img/payment/OERV_Logo_4c.jpg"
                             alt="ORV"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footerend-->
<script type="text/javascript">
    var onloadCallback = function () {
        window.subscribeCaptcha = grecaptcha.render('g-recaptcha', {
            'sitekey': '<?php echo \Helper\Config::get('SITE_KEY }} '
        });
    };
</script>
<div class="modal fade" id="subscribe-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-close registered">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-title-content">
                        {{ 'user.subscribe' | translate }}
                    </div>
                </div>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="input">
                            <input class="border form-control form-marti p-4" id="subscribe-email"/>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="g-recaptcha"></div>
                    </div>
                    <div class="col-md-12">
                        <button class="button btn-block btn-marti mt-3 registered"
                                id="subscribe">{{ 'user.subscribe' | translate }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="registered-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-close registered">
                <i class="icon icon-modal-close"></i>
            </div>
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-title-content">
                        {{ 'user.register_successfull_title' | translate }}
                    </div>
                </div>
            </div>
            <div class="modal-main">
                <p>{{ 'register_successfull' | translate }}</p>
                <button class="button main-blue-button registered">{{ 'user.register_successfull_button' | translate }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal hi" id="modalLogin" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-close">
                <i class="icon icon-modal-close"></i>
            </div>
            <?php $this->render('master/login')?>
        </div>
    </div>
</div>

<script src="{{ theme_dir }}assets/js/jquery/jquery.min.js"></script>
<script src="{{ theme_dir }}assets/js/head.js"></script>
<script type="text/javascript" src="/service/language/loadJs/general/1?t=v=2"></script>
<script src="{{ theme_dir }}assets/js/swiper/swiper.min.js"></script>
<script src="{{ theme_dir }}assets/js/vue/bundle.js"></script>
<script src="{{ theme_dir }}assets/js/vue/content-loader.js"></script>
<script src="{{ theme_dir }}assets/js/mask/jquery.mask.min.js"></script>
<script src="{{ theme_dir }}assets/js/owl-carousel/owl.carousel.min.js"></script>
<script src="{{ theme_dir }}assets/js/popper/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.mmenu/8.2.3/mmenu.js"></script>

<script src="{{ theme_dir }}assets/js/bootstrap.min.js"></script>
<script src="{{ theme_dir }}assets/js/custom/custom-min.js?t=v=2"></script>
<script src="{{ theme_dir }}assets/js/sweetalert.min.js"></script>
<script src="{{ theme_dir }}assets/js/vue/modules.js?v=2"></script>

<?php if ($this->page == 'halalbooking') { ?>
    <link rel="stylesheet" href="{{ theme_dir }}assets/photoswipe/photoswipe.css"/>
    <link rel="stylesheet" href="{{ theme_dir }}assets/photoswipe/default-skin/default-skin.css">
        <script src="{{ theme_dir }}assets/js/vue/halalbooking.js?v=2"></script>
    <?php } else if ($this->page == 'tour') { ?>
        <script src="{{ theme_dir }}assets/js/vue/tour.js?v=2"></script>
    <?php } else if($this->page != 'landing_hotel') { ?>
        <script src="{{ theme_dir }}assets/js/vue/travel-it.js?v=2"></script>
    <?php } ?>

<script src="{{ theme_dir }}assets/js/jquery.cookie.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHnMpeLj9_pjdOwazdXEpkZehK4tkraU8"></script>

</body>

</html>