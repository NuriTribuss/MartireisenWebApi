<div class="modal-header">
    <div class="modal-title">
        <div class="modal-title-content">
            <div class="modal-title-icon"><i class="fa fa-lock"></i></div>
            <div class="modal-title-text"><?php _lang('user.login'); ?></div>
        </div>
    </div>
</div>
<div class="modal-main">
    <div class="modal-main-user p-3">
        <div class="modal-main-user-buttons">
            <button class="button active" type="button"><?php _lang('user.login'); ?></button>
            <button class="button" type="button"><?php _lang('user.register'); ?></button>
        </div>
        <div id="userTabPanel" class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="modal-main-user-content">
                        <form method="POST" id="login-form">

                            <label class="input">
                                <span class="input-label"><?php _lang('user.email'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input autocomplete="off" type="email" name="username" id="usermail" data-required/>
                                    </span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                    <span class="error-message"><?php _lang('user.email_error_message')?></span>
                                </span>
                            </label>
                            <label class="input no-margin">
                                <span class="input-label"><?php _lang('user.password'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data">
                                        <input type="password" name="password" id="userpass" data-required/>
                                    </span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                    <span class="error-message"><?php _lang('user.password_error_message')?></span>
                                </span>

                            </label>
                            <div class="modal-main-user-content-forgot mt-5" data-user-tab-panel="2"> <?php _lang('user.forget_password') ?></div>
                            <label class="checkbox checkbox-default">
                                <input type="checkbox" name="staySigned" checked>
                                <span class="checkbox-default-icon"></span>
                                <span class="checkbox-default-text">
                                    <?php _lang('user.remember_me') ?>
                                </span>
                            </label>
                            <div class="modal-main-user-content-button">
                                <button class="button" type="submit" data-login="true"><?php _lang('user.login'); ?></button>
                            </div>
                            <div class="alert alert-danger text-white rounded-0 login-error mt-4" style="display: none;">
                                <p><?php _lang('login_error'); ?></p>
                            </div>
                        </form>
                        <div class="modal-main-user-content-seperator d-none">
                            <div class="modal-main-user-content-seperator-text"><?php _lang('user.one_click'); ?></div>
                        </div>
                        <div class="modal-main-user-content-social d-none">
                            <a class="modal-main-user-content-social-item facebook" href="" title="Social">
                                <div class="modal-main-user-content-social-item-icon"><i class="icon icon-modal-social-facebook"></i></div>
                                <div class="modal-main-user-content-social-item-content">
                                    <div class="modal-main-user-content-social-item-content-text"><?php _lang('user.connect_with'); ?></div>
                                    <div class="modal-main-user-content-social-item-content-title">
                                        Facebook
                                    </div>
                                </div>
                            </a>
                            <a class="modal-main-user-content-social-item twitter" href="" title="Social">
                                <div class="modal-main-user-content-social-item-icon"><i class="icon icon-modal-social-twitter"></i></div>
                                <div class="modal-main-user-content-social-item-content">
                                    <div class="modal-main-user-content-social-item-content-text"><?php _lang('user.connect_with'); ?></div>
                                    <div class="modal-main-user-content-social-item-content-title">Twitter
                                    </div>
                                </div>
                            </a>
                        </div>
<!--                        <div class="modal-main-user-content-paragraph">-->
<!--                            --><?php //_lang('Make changes to a booking with your') ?>
<!--                            <a>--><?php //_lang('confirmation number and PIN') ?><!--</a>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="modal-main-user-content">
                        <form method="POST" id="register-form">
                            <div class="alert alert-danger register-error" style="display: none;">
                                <p></p>
                            </div>
                            <label class="input">
                                <span class="input-label"><?php _lang('user.name'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data"><input type="text" name="name" id="registername" data-required/></span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                     <span class="error-message">    <span class="error-message"><?php _lang('user.name_error_message')?></span></span>
                                </span>
                            </label>
                            <label class="input">
                                <span class="input-label"><?php _lang('user.surname'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data"><input type="text" name="surname" id="registersurname" data-required></span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                     <span class="error-message"><?php _lang('user.lastname_error_message')?></span></span>
                                </span>
                            </label>
                            <label class="input">
                                <span class="input-label"><?php _lang('user.email'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data"><input type="email" name="username" id="registermail" data-required></span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                      <span class="error-message"><?php _lang('user.email_error_message')?></span></span>
                                </span>
                            </label>
                            <label class="input no-margin">
                                <span class="input-label"><?php _lang('user.password'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data"><input type="password" name="password" id="registerpass" data-required></span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                      <span class="error-message"><?php _lang('user.new_password_error_message')?></span></span>
                                </span>
                            </label>
                            <div class="modal-main-user-content-button">
                                <button class="button" type="submit" data-register="true"><?php _lang('user.register'); ?></button>
                            </div>
                        </form>
                        <div class="modal-main-user-content-seperator">
                            <div class="modal-main-user-content-seperator-text"><?php _lang('user.or'); ?></div>
                        </div>
                        <div class="modal-main-user-content-social">
                            <a class="modal-main-user-content-social-item facebook" href="" title="Social">
                                <div class="modal-main-user-content-social-item-icon"><i
                                        class="icon icon-modal-social-facebook"></i></div>
                                <div class="modal-main-user-content-social-item-content">
                                    <div class="modal-main-user-content-social-item-content-text"><?php _lang('user.connect_with'); ?></div>
                                    <div class="modal-main-user-content-social-item-content-title">
                                        Facebook
                                    </div>
                                </div>
                            </a>
                            <a class="modal-main-user-content-social-item twitter" href="" title="Social">
                                <div class="modal-main-user-content-social-item-icon"><i
                                        class="icon icon-modal-social-twitter"></i></div>
                                <div class="modal-main-user-content-social-item-content">
                                    <div class="modal-main-user-content-social-item-content-text"><?php _lang('user.connect_with'); ?></div>
                                    <div class="modal-main-user-content-social-item-content-title">Twitter
                                    </div>
                                </div>
                            </a>
                        </div>
<!--                        <div class="modal-main-user-content-paragraph">-->
<!---->
<!--                        </div>-->
<!--                        <div class="modal-main-user-content-note">-->
<!--                            --><?php //_lang('user.register_aggregment'); ?><!--</a>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="modal-main-user-content">
                        <div class="modal-main-user-content-paragraph padding-top">
                            <?php _lang('user.forget_message') ?>
                        </div>
                        <form id="forget-form" method="POST">
                            <label class="input">
                                <span class="input-label"><?php _lang('user.email'); ?></span>
                                <span class="input-main">
                                    <span class="input-main-data"><input type="email" name="username" data-required></span>
                                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                                     <span class="error-message"><?php _lang('user.password_error_message')?></span>
                                </span>
                            </label>
                            <div class="modal-main-user-content-button">
                                <button class="button" type="button" data-forget="true"><?php _lang('user.send'); ?></button>
                            </div>
                            <div class="alert alert-danger text-white rounded-0 login-error mt-4" style="display: none;">
                                <p><?php _lang('login_error'); ?></p>
                            </div>
                        </form>
                        <div class="modal-main-user-content-forgot blue"  data-user-tab-panel="0"><?php _lang('user.cancel'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>