</section>
<!--footerBefore-->
<div id="properties" class="no-print d-none">
    <div class="container">
        <div class="properties">
            <div class="properties-item">
                <div class="properties-item-icon"><i class="icon icon-properties-surety"></i></div>
                <div class="properties-item-content">
                    <h3 class="properties-item-content-title"><?php _lang('footer.slogan_one_title'); ?></h3>
                    <p class="properties-item-content-text"><?php _lang('footer.slogan_one_text'); ?></p>
                </div>
            </div>
            <div class="properties-item">
                <div class="properties-item-icon"><i class="icon icon-properties-call-center"></i></div>
                <div class="properties-item-content">
                    <h3 class="properties-item-content-title"><?php _lang('footer.slogan_two_title'); ?></h3>
                    <p class="properties-item-content-text"><?php _lang('footer.slogan_two_text'); ?></p>
                </div>
            </div>
            <div class="properties-item">
                <div class="properties-item-icon"><i class="icon icon-properties-marker"></i></div>
                <div class="properties-item-content">
                    <h3 class="properties-item-content-title"><?php _lang('footer.slogan_three_title'); ?></h3>
                    <p class="properties-item-content-text"><?php _lang('footer.slogan_three_text'); ?></p>
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

                <div class="col-md-3 col--6">
                    <h4 class="footer-top-title"><?php echo $this->menu[1]['title'] ?></h4>
                    <ul class="footer-top-list">
                        <?php foreach ($this->menu[1]['children'] as $menu) { ?>
                            <li><a href="<?php echo $menu['link'] ?>" title=""><?php echo $menu['title'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-5 col--6">
                    <h4 class="footer-top-title"><?php echo $this->menu[2]['title'] ?></h4>
                    <ul class="footer-top-list">
                        <?php foreach ($this->menu[2]['children'] as $menu) { ?>
                            <li><a href="<?php echo $menu['link'] ?>" title=""><?php echo $menu['title'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-4 col--12">
                    <h4 class="footer-top-title light"><?php _lang('footer.subscribe'); ?></h4>
                    <p class="footer-top-description light"></p>
                        <div class="footer-top-form">
                            <div class="footer-top-form-input input-main">
                                <input type="email" id="send-subscribe-email" name="send-subscribe-email"
                                       placeholder="<?php _lang('form.email') ?>" data-required/>
                                <span class="error-message">Lütfen email giriniz<?php _lang('user.subscribe_email_invalid_message')?></span>
                            </div>
                            <div class="footer-top-form-button">
                                <button id="send-subscribe" class="button"><?php _lang('user.subscribe'); ?></button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="footer-middle-container">
                <p class="footer-middle-copyright"><?php echo Helper\Setting::get('copyright') ?></p>
                <div class="footer-middle-social">
                    <a class="footer-middle-social-item" href="<?php echo Helper\Setting::get('facebook') ?>"
                       target="_blank" title="Social"><i
                                class="fab fa-facebook"></i></a>
                    <a class="footer-middle-social-item" href="<?php echo Helper\Setting::get('instagram') ?>"
                       target="_blank" title="Social"><i
                                class="fab fa-instagram"></i></a>
                    <a class="footer-middle-social-item" href="<?php echo Helper\Setting::get('youtube') ?>"
                       target="_blank" title="Social"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="footer-bottom-title"><?php _lang('common.payment_methods'); ?></h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/ssl.svg"
                             alt="SSL Sertificate"/>
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/mastercard.svg"
                             alt="MasterCard"/>
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/visa.svg"
                             alt="Visa"/>
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/klarna.svg"
                             alt="Klarna"/>
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/paypal.svg"
                             alt="Paypal"/>
                    </div>

                </div>
                <div class="col-md-6">
                    <h4 class="footer-bottom-title"><?php _lang('common.security_certs'); ?></h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/iata.svg"
                             alt="Iata"/>
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
            'sitekey': '<?php echo \Helper\Config::get('SITE_KEY')?>'
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
                        <?php _lang('user.subscribe') ?>
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
                                id="subscribe"><?php _lang('user.subscribe'); ?></button>
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
                        <?php _lang('user.register_successfull_title') ?>
                    </div>
                </div>
            </div>
            <div class="modal-main">
                <p><?php _lang('register_successfull'); ?></p>
                <button class="button main-blue-button registered"><?php _lang('user.register_successfull_button'); ?></button>
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
            <?php $this->render('master/login'); ?>
        </div>
    </div>
</div>


<script src="<?php theme_dir() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/custom/custom-min.js?t=<?php echo time() ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/vue/modules.js?<?php echo time() ?>"></script>

<?php if ($this->page == 'halalbooking') { ?>
    <script src="<?php theme_dir() ?>assets/js/vue/halalbooking.js?<?php echo time() ?>"></script>
<?php } else if ($this->page == 'tour') { ?>
    <script src="<?php theme_dir() ?>assets/js/vue/tour.js?<?php echo time() ?>"></script>
<?php } else { ?>
    <script src="<?php theme_dir() ?>assets/js/vue/travel-it.js?<?php echo time() ?>"></script>
<?php } ?>

<script src="<?php theme_dir() ?>assets/js/jquery.cookie.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfGHDX_FKXSgWRUBWLfxjz5aHAzG6aatQ"></script>

</body>

</html>