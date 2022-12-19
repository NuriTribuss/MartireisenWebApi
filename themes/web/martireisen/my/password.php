<div id="breadcrumb " class="mt-4 ">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/" title="Home"><img src="<?php theme_dir()?>assets/img/profile/home.svg" alt="home" class="mr-2" title="home"/><?php _lang('menu.home') ?></a></li>
                <li class="breadcrumb-item " aria-current="page"><span><?php _lang('user.menu.my_account') ?></span></li>
                <li class="breadcrumb-item active"><span><?php _lang('user.menu.password_settings')?></span></li>
            </ol>
        </nav>
    </div>
</div>

<div class="mt-3 mb-4">
    <div class="container">
        <div class="row">
            <?php $this->render('my/sidebar')?>
            <div class="col-lg-9 col-sm-12">
                <div class="content-card">
                    <div class="card-title">
                        <img src="<?php theme_dir()?>assets/img/profile/password.svg" alt="personal information" title="personal information">
                        <h2><?php _lang('user.menu.password_settings')?></h2>
                    </div>
                    <div class="card-content" id="password-app">
                        <form @submit.prevent="save">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <label class="group-title" for="oldpw"><?php _lang('user.old_password')?> </label>
                                        <input class="is-valid" type="password" v-model="password.password"/>
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                     <div class="col-md-8 col-sm-12">
                                        <label class="group-title" for="oldpw"><?php _lang('user.new_password')?> </label>
                                        <input class="is-valid" type="password" v-model="password.new_password"/>
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on"/>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                     <div class="col-md-8 col-sm-12">
                                        <label class="group-title" for="oldpw"><?php _lang('user.new_passworda')?> </label>
                                        <input class="is-valid" type="password" v-model="password.new_password_a"/>
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on"/>
                                    </div>
                                   
                                </div>
                                <button v-on:click="save"  class="submit-btn">KAYDET</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
    </div>
</div>


<script>
window.addEventListener("load", function (event) {

    var PasswordApp = new Vue({

        el: '#password-app',
        data: {
            password : {},
        },

        methods : {

            save(){

                var form = new FormData();
                for (const key in this.password) {
                    form.append(key, this.password[key]);
                }

                var _this = this;

                axios({
                    method: 'post',
                    url: '/service/my/change-password/',
                    data: form
                }).then(function (response) {

                    if (response.data.status) {

                        swal('',response.data.message , 'success');
                        _this.password['new_password'] = '';
                        _this.password['new_password_a'] = '';

                    } else {
                        swal('',response.data.message , 'warning');
                        return false;
                    }
                });

            }
        },

        created : function(){

        }
    });  
});
</script>