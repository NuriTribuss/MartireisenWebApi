window.addEventListener("load", function (event) {
    bindAll();
});

function bindAll() {
    if(typeof window['vue-tel-input'] != 'undefined'){
        Vue.use(window['vue-tel-input']);
    }

    var App = new Vue({

        el: '#app',

        data: {

            Marti: null ,
            loading: false,
            loader: {
                bookingCreate: false,
                bookingCheck: true,
                offers: false,
            },
            translate: [],
            limit: 25,
            step: 1,

            summary: {

            },

            booking: {

            },

            bookingForm: {
                personal: {},
                traveller: [],
                children: [],
                booking: {},
                payment: {
                    method: 1
                },
                coupon: '',
                aggregment: false,
                traveller_first: false,

            },

            bindProps: {
                disabled: false,
                disabledFormatting: false,
                placeholder: "",
                required: true,
                enabledCountryCode: true,
                enabledFlags: true,
                preferredCountries: ["AT", "DE", "TR"],
                validCharactersOnly: true,
                wrapperClasses: "",
                inputClasses: "",
            },

            hotelTab: 1,
            operators: [],
            countries: [],

            mobile: {
                isMobile: false,
                popup: false,
            },

            member: Marti.Member || {},
        },

        methods: {

            setCoupon: function () {

                var _this = this;
                this.loading = true;

                if (this.bookingForm.coupon.trim() == '') {
                    swal(Marti.Locale.get('common.warning'), Marti.Locale.get('offer.coupon_code_empty'), 'warning');
                    return false;
                }

                axios.get('/service/booking/set-discount/' + this.bookingForm.coupon + '/' + this.offer.price).then(function (response) {

                    if (response.data.status == false) {
                        swal(Marti.Locale.get('common.warning'), response.data.message, 'warning');
                        return false;
                    }
                    _this.offer.discount = response.data.data.discount.toFixed(2);
                    _this.offer.price_display = response.data.data.price;
                    _this.offer.price_base = response.data.data.price_base;

                    swal(Marti.Locale.get('common.success'), response.data.message, 'success');

                    _this.loading = false;
                });

            },

            checkBookingModal: function () {
                if (this.mobile.isMobile) {
                    mobileModOpen("#mobile-offer-error");
                } else {
                    $("#offer-error").modal('show');
                }
            },

            getBookingParams: function () {
                
                let _this = this;
                
                this.bookingForm.personal = this.bookingForm.personal || {};
                this.bookingForm.personal.name = Marti.Member.name;
                this.bookingForm.personal.surname = Marti.Member.surname;
                this.bookingForm.personal.email = Marti.Member.username;
                this.bookingForm.personal.gender = '';
                this.bookingForm.personal.country = 'AT';
                //  $("[name='reg_land']").parent().parent().find('.selectbox-mega-button-text').html('Österreich');

                var k = this.summary.adult;
                for (var i = 0; i < parseInt(k); i++) {
                    this.bookingForm.traveller.push({
                        'name': '',
                        'surname': '',
                        'birthday': '',
                        'gender': ''
                    });
                }

                var k = this.summary.children;
                for (var i = 0; i < parseInt(k); i++) {
                    this.bookingForm.children.push({
                        'name': '',
                        'surname': '',
                        'birthday': '',
                    });
                }
                
                
                axios.get('/service/booking/init').then(function (response) {
                    if(response.data.status){
                        _this.bookingForm = response.data.data;
                    }
                });
            },

            book: function () {

                if (this.booking == null) {
                    return false;
                }

                $(".checkbox-default-text").removeClass("text-danger");
              

                this.bookingForm['operator'] = '';
                this.bookingForm['ref'] = 'tour';
                this.bookingForm['hotel'] = {
                    'giata': this.summary.tour.id,
                    'name': this.summary.tour.title,
                };
                this.bookingForm['booking'] = {};// this.offer.SERVICE;
                this.bookingForm.tour = 1;


                var _this = this;
                _this.loader.bookingCreate = true;

                axios.post('/service/booking/create', this.bookingForm).then(function (response) {
                    _this.loader.bookingCreate = false;

                    if (response.data.status === false) {

                        $(".input-message").hide();
                        var errors = response.data.data;
                        if (Array.isArray(errors) == false) {
                            swal(Marti.Locale.get('warning'), response.data.message);
                            return false;
                        }

                        for (var i = 0; i < errors.length; i++) {
                            var domMsg = $('#' + errors[i].key + '_message');
                            $(domMsg).show();
                        }
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $('#' + errors[0].key).offset().top - 170
                        }, 500);



                        return false;
                    } else {
                        var result = response.data.data;

                        if (typeof result.url !== 'undefined') {
                            window.location.href = result.url;
                        } else {
                            window.location.href = '/booking/complete';
                        }
                    }
                });

            },

            loadCountries: function () {

                var _this = this;
                axios.get('/service/countries/get-defaults?t=' + (new Date().getTime())).then(function (response) {
                    _this.countries = response.data.data;
                });
            },
            
            getCountryByCode: function (code) {

                for (var i = 0; i < this.countries.length; i++) {
                    var el = this.countries[i];
                    if (el.code === code) {
                        return el.name;
                    }
                }

                return '';
            },

            loadSummary: function () {
                
                var _this = this;
                axios.get('/service/tours/get-summary').then(function (response) {
                    
                    _this.summary = response.data.data;
                    _this.loader.bookingCheck = false;
                    _this.getBookingParams();
                    
                    let data = response.data.data;
                    let id = data.tour.period.tour_id + '-'+data.tour.period.id;
                    
                    fbq('track','InitiateCheckout', {
                     //   contents: [id],
                        content_ids: [id],
                        currency: Marti.Member.currency,
                        value:  data.tour.price,
                        content_type: 'product',
                    }); 
                });
            }

        },

        watch: {

            'mobile.popup': {
                handler: function (a, b) {
                    if (this.mobile.popup && window.isMobile()) {
                        $("body").addClass('modal-open');
                    } else {
                        $("body").removeClass('modal-open');
                    }
                }, deep: true
            },

            'bookingForm.traveller_first': {
                handler: function (a, b) {

                    if (this.bookingForm.traveller_first === true) {
                        this.bookingForm.traveller[0] = {
                            name: this.bookingForm.personal.name || '',
                            surname: this.bookingForm.personal.surname || '',
                            gender: this.bookingForm.personal.gender || '',
                        }
                    }

                }, deep: true
            },

        },

        created: function () {

            this.loading = false;
            this.Marti = Marti;
            this.translate = Marti.Locale.all();
            this.mobile.isMobile = window.isMobile();
            
            if(typeof PAGE_TYPE != 'undefined' && PAGE_TYPE === 'tour-booking') {
                this.loadSummary();
            }
            
            this.loadCountries();
        },

        updated: function () {
            $('.input input,.input select').on('change', function () {
                var id = $(this).attr('id');
                $('#' + id + '_message').hide();
            });
        },

        components: {
            VueSlider: window['vue-slider-component'],
        }
    });
}