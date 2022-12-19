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
                <div class="col-md-3 col--6 phone-numbers">
                    <h4 class="footer-top-title"><?php _lang('footer.phone_numbers'); ?></h4>
                    <ul class="footer-top-list">
                        <li><a href="tel:+43 1 90 94 500" title=""><img src="<?php theme_dir() ?>assets/img/flags/au-circle.svg" alt="Marti Reisen Osterrich" width="25"/> <span class="ml-2">+43 1 90 94 500 50</span></a></li>
                        <li><a href="tel:+49 69 333 98 011" title=""><img src="<?php theme_dir() ?>assets/img/flags/de-circle.svg?v=2" alt="Marti Reisen Deutschland"  width="25"/> <span class="ml-2">+49 69 333 98 011 50</span></a></li>
                        <li><a href="tel:+90 850 840 62 91" title=""><img src="<?php theme_dir() ?>assets/img/flags/tr-circle.png" alt="Marti Reisen Türkiye"  width="25"/> <span class="ml-2">+90 850 840 62 91 50</span></a></li>
                        <li><a href="tel:<?php echo Helper\Setting::get('phone')?>" title=""><img src="<?php theme_dir() ?>assets/img/flags/global-circle.svg" alt="Marti Reisen Global" width="25"/> <span class="ml-2"><?php echo Helper\Setting::get('phone')?></span></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col--6">
                    <h4 class="footer-top-title"><?php echo $this->menu['MENU2']['data']['name'] ?></h4>
                    <ul class="footer-top-list">
                        <?php foreach ($this->menu['MENU2']['children'] as $menu) { ?>
                            <li><a href="<?php echo $menu['translate']['url'] ?>" title=""><?php echo $menu['translate']['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-3 col--6">
                    <h4 class="footer-top-title"><?php echo $this->menu['MENU3']['data']['name'] ?></h4>
                    <ul class="footer-top-list">
                        <?php foreach ($this->menu['MENU3']['children'] as $menu) { ?>
                            <li><a href="<?php echo $menu['translate']['url'] ?>" title=""><?php echo $menu['translate']['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-3 col--12">
                    <h4 class="footer-top-title light"><?php _lang('footer.subscribe'); ?></h4>
                    <p class="footer-top-description light"></p>
                    <form method="GET" action="/newsletter">
                        <div class="footer-top-form">
                            <div class="footer-top-form-input input-main">
                                <input type="email" id="send-subscribe-email" name="username"
                                       placeholder="<?php _lang('form.email') ?>" required/>
                                <span class="error-message"><?php _lang('user.email_error_message') ?></span>
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
                <p class="footer-middle-copyright"><?php echo Helper\Setting::get('copyright') ?>  </p>
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
                <div class="col-md-2">
                    <h4 class="footer-bottom-title"><?php _lang('common.ssl_certificate'); ?></h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/ssl.svg"
                             alt="SSL Certificate"/>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4 class="footer-bottom-title"><?php _lang('common.payment_methods'); ?></h4>
                    <div class="img-div">
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
                <div class="col-md-5">
                    <h4 class="footer-bottom-title"><?php _lang('common.security_certs'); ?></h4>
                    <div class="img-div">
                        <img class="footer-bottom-img" src="<?php theme_dir() ?>assets/img/payment/iata.svg"
                             alt="Iata"/>
                        <img class="footer-bottom-img" style="width: 150px" src="<?php theme_dir() ?>assets/img/payment/OERV_Logo_4c.jpg"
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
            'sitekey': '<?php echo \Helper\Config::get('SITE_KEY') ?>'
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

<a class="whats-app" href="https://wa.me/<?php echo Helper\Setting::get('tour_whatsapp'); ?>?text=Hallo" target="_blank">
    <i class="fab fa-whatsapp my-float"></i>
</a>
<script src="<?php theme_dir() ?>assets/js/jquery/jquery.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/head.js"></script>
<script type="text/javascript" src="/service/language/loadJs/general/1?t=v=2"></script>
<script type="text/javascript" src="/service/language/loadJs/trafficsregion-facility_list/1?t=v=2"></script>
<script src="<?php theme_dir() ?>assets/js/swiper/swiper.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/vue/bundle.js"></script>
<script src="<?php theme_dir() ?>assets/js/vue/content-loader.js"></script>
<script src="<?php theme_dir() ?>assets/js/mask/jquery.mask.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/owl-carousel/owl.carousel.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/popper/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.mmenu/8.2.3/mmenu.js"></script>

<script src="<?php theme_dir() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/custom/custom-min.js?t=v=<?php echo time()?>"></script>
<script src="<?php theme_dir() ?>assets/js/sweetalert.min.js"></script>
<script src="<?php theme_dir() ?>assets/js/vue/modules.js?v=2"></script>

<?php if ($this->page == 'halalbooking') { ?>
    <link rel="stylesheet" href="<?php theme_dir() ?>assets/photoswipe/photoswipe.css"/>
    <link rel="stylesheet" href="<?php theme_dir() ?>assets/photoswipe/default-skin/default-skin.css">
        <script src="<?php theme_dir() ?>assets/js/vue/halalbooking.js?v=2"></script>
    <?php } else if ($this->page == 'tour') { ?>
        <script src="<?php theme_dir() ?>assets/js/vue/tour.js?v=3"></script>
    <?php } else if($this->page != 'landing_hotel') { ?>
        <script src="<?php theme_dir() ?>assets/js/vue/travel-it.js?v=20221"></script>

    <?php } ?>

<script src="<?php theme_dir() ?>assets/js/jquery.cookie.js"></script>
<script>
    let fb_event_ID = 'px-'+ new Date().getTime();
    let pageType = '<?php echo Core\App::$linkData['type']?>';
    if(pageType === '') {
        pageType = '<?php echo $this->page?>';
    }
   
    dataLayer.push({
        'event' : 'page_view',
        'ecomm_pagetype' : pageType,
        'ecomm_category' : '<?php echo $this->meta['title']?>',
    });
    
</script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '285839698423327');
  
</script>
<script>
document.addEventListener("DOMContentLoaded", function(event) { 
    
  window.FBConversion = {
	
	send_member: false,
	pixel_id: '285839698423327',
	
	request: function (data, type)
	{
            data.event_id =  fb_event_ID;
            $.ajax(
            {
                type: "POST",
                url: '/console/fbconversion.php',
                data:{
                    track_data: data
                },
                dataType: 'json',
                success: function (response)
                {
                    if (typeof response.error !== 'undefined') {
                        console.log('FB Conversion API: Error!');
                    } else {
                        console.log('FB Conversion API: Worked For The ' + type + '.');
                    }
                }
            });
            
            fbq('track', type , data.custom_data || {} , {eventID: data.event_id});
	},
	run: function () {
            if (Marti.page === 'other' && window.location.href.indexOf('&mail=') > -1) {
                return;
            }
            this.request(this.page(), 'PageView');
	},
	page: function (){
            return {
                event_name: 'PageView',
                event_source_url: document.URL,
                action_source: 'website',
                user_data: this.member_info()
            }

	},
	product: function (hotel){
            let data =  {
                event_name: 'ViewContent',
                event_source_url: document.URL,
                action_source: 'website',
                custom_data:
                {
                    content_name: hotel.name,
                    content_ids: [hotel.giata.hotelId],
                    content_type: 'product',
                    value: 1,
                    currency: Marti.Member.currency
                },
                user_data: this.member_info()
            }
            this.request(data,'ViewContent');
	},
	
	search: function (data,query){
            
            let ids = [];
            for(var i = 0 ; i< data.length; i++) {
                ids.push(data[i].id);
              
            }
            let tmp =  {
                event_name: 'Search',
                event_source_url: document.URL,
                action_source: 'website',
                custom_data:
                {
                    content_category : 'Hotel List',
                    content_ids: ids,
                    search_string : query,
                    value: 1,
                    currency: Marti.Member.currency
                },
                user_data: this.member_info()
            };
            this.request(tmp,'Search');
	},
	checkout: function (data) {
           
               var _this = this;

                _this.request(
                {
                    event_name: 'InitiateCheckout',
                    event_source_url: document.URL,
                    action_source: 'website',
                    custom_data:
                    {
                        'currency': Marti.Member.currency,
                        'value': data.price,
                        'contents': [{id : data.id , quantity : 1}],
                        'content_type': 'product',
                        'offer' : data
                    },
                    user_data: _this.member_info()
                }, "InitiateCheckout");
		
	},
	
	complete: function (orderData)
	{

            var orderData =  {
                event_name: 'Purchase',
                event_source_url: document.URL,
                action_source: 'website',
                custom_data: orderData,
                user_data: this.member_info()
            };
            this.request(orderData,'Purchase');
	},
	
	
	member_info: function ()
	{
            var member = {
                fn: "Guest",
                ln: this.getCookie('PHPSESSID')
            };

            return member;
	},
        
	getCookie: function (name)
	{
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2)
            {
                    return parts.pop().split(';').shift();
            }
            return '';
	}
    }
    
    FBConversion.run();
});
</script>

<script type='text/javascript'>
    
    window.__lo_site_id = 143292;

    (function() {
            var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;
            wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);
      })();
      
</script>
<!--
<script src="//code.tidio.co/rbaa4qcwatqy91dugcd06ej7tlotx99o.js" async></script>-->
    </body>

</html>