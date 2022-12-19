
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"/>

<div id="breadcrumb " class="mt-4 ">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/" title="Home"><img src="<?php theme_dir()?>assets/img/profile/home.svg" alt="home" class="mr-2" title="home"/><?php _lang('menu.home') ?></a></li>
                <li class="breadcrumb-item " aria-current="page"><span><?php _lang('user.menu.my_account') ?></span></li>
                <li class="breadcrumb-item active"><span><?php _lang('user.menu.my_profile')?></span></li>
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
                        <img src="<?php theme_dir()?>assets/img/profile/personal-info.svg" alt="personal information" title="personal information"/>
                        <h2><?php _lang('user.profile.title')?></h2>
                    </div>
                    <div class="card-content" id="profile-app">
                        <form @submit.prevent="save">
                            <div class="form-group">
                                <label class="group-title"><?php _lang('booking.personal.e_gender')?>: </label>
                                <div class="form-item is-valid">
                                    <input id="gender1" type="radio" v-model="user.gender" value="0" name="radio-group" >
                                    <label for="gender1"><?php _lang('user.profile.male')?></label>
                                </div>
                                <div class="form-item">
                                    <input id="gender2" type="radio" v-model="user.gender" value="1"   name="radio-group">
                                    <label for="gender2"><?php _lang('user.profile.female')?></label>
                                </div>
                                <div class="form-item d-none" >
                                    <input id="gender3" type="radio" v-model="user.gender" value="2"  name="radio-group">
                                    <label for="gender3">Diğer</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <label class="group-title" for="name"><?php _lang('user.profile.name')?>: </label>
                                        <input type="text" v-model="user.name"/>
                                        <img src="/assets/img/security-on.svg" alt="security on" title="security on" class="security-on"/>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label class="group-title" for="name"><?php _lang('user.profile.surname')?>: </label>
                                        <input type="text" v-model="user.surname"/>
                                        <img src="/assets/img/security-on.svg" alt="security on" title="security on" class="security-on"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="group-title" for="address"><?php _lang('user.profile.address')?>: </label>
                                        <textarea rows="4" v-model="user.address"  ></textarea>
                                        <img src="/assets/img/security-on.svg" alt="security on" title="security on" class="security-on"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <label class="group-title" for="country">Ülke: </label>
                                        <select  v-model="user.country_code" class="selectpicker is-valid country-picker"   v-on:change="changeCountry">
                                            <option>- Bitte Land Wählen -</option>
                                            <option v-bind:value="region.code" v-for="region in countries">{{region.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label class="group-title" for="pcode"><?php _lang('user.profile.state')?>: </label>
                                        <input type="text" v-model="user.city">
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on">
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label class="group-title" for="pcode"><?php _lang('user.profile.city')?>: </label>
                                        <input type="text" v-model="user.town">
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="group-title" for="phone"><?php _lang('user.profile.phone')?>: </label>
                                        <input type="text" v-model="user.phone"/>
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="group-title" for="mail"><?php _lang('user.profile.mail')?>: </label>
                                        <input type="text" v-model="user.username" />
                                        <img src="<?php theme_dir()?>assets/img/profile/security-on.svg" alt="security on" title="security on" class="security-on">
                                    </div>
                                </div>

                                <button v-on:click="save" class="submit-btn"><?php _lang('user.send')?></button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script>
window.addEventListener("load", function (event) {

    var ProfileApp = new Vue({

        el: '#profile-app',

        data: {
            user : {},
            countries : [],
        },

        methods : {
            save(){

                var form = new FormData();
                for (const key in this.user) {
                    form.append(key, this.user[key]);
                }

                axios({
                    method: 'post',
                    url: '/service/customers/save/',
                    data: form
                }).then(function (response) {

                    if (response.data.status) {
                        swal('',response.data.message , 'success');
                    } else {
                        swal('',response.data.message , 'warning');
                    }
                    return false;
                });
            },
            changeCountry(){

                for(var i = 0 ; i < this.countries.length; i++){
                    var el = this.countries[i];
                    if(el['code'] === this.user.country_code){
                        this.user.country= el['name'];
                    }
                }
            }
        },

        created : function(){

            var _this = this;

            axios.get('/service/my/get').then(function (response) {
                _this.user = response.data.data;
            });

            axios.get('/service/countries/get').then(function (response) {
                _this.countries = response.data.data;

                setTimeout(function(){
                    $(".country-picker").selectpicker()
                },350);
            });
        }
    });    
});
</script>