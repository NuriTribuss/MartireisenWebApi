window.isMobile = function () {
    if (navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
    ) {
        return true;
    } else {
        return false;
    }
}
$.fn.modal.Constructor.prototype.enforceFocus = function () {
};

$.ajaxSetup({cache: false});

// Returns if a value is a string
function isString(value) {
    return typeof value === 'string' || value instanceof String;
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

login = function (e) {

    $("#modalLogin").modal('show');
    var target = 0;
    $(".modal-main-user-buttons .button").removeClass("active");
    $(".modal-main-user-buttons .button:eq(" + target + ")").addClass("active");
}
$(function () {

    $(window).scroll(function () {
        var searchBarSticky = $("#search.p-0");
        330 <= $(window).scrollTop() ? searchBarSticky.addClass("fixed") : searchBarSticky.removeClass("fixed");
    });
    
    setTimeout(function(){
        $("#whatsapp_chat").show();
    },5000);

    // if (window.isMobile()) {
    // }
    // $("#menu").show();
    new Mmenu("#menu", {
        extensions: ["shadow-panels", "fx-panels-slide-100", "border-none", "fullscreen", "position-right"],
        navbars: {
            content: ["prev", "breadcrumbs", "close"]
        },
    });

    $('#mobile-menu-toggle').click(function () {
        $("#menu").show();
    })

    $('.mm-btn_close').click(function () {
        $("#menu").hide();
    })
    
    $(document).on('click','.top-hotels-buttons button',function(){
        $(".top-hotels-buttons button").removeClass('active');
        $(this).addClass('active');
    });

    $("li[data-language]").on('click', function () {
        var language = $(this).attr('data-language');
        location.href = '/service/language/change/' + language;
    });
    $(".results-right .card a").on('click', function () {
        $(".results-right .card a").removeClass("text-primary");
        $(this).addClass("text-primary");
    });
    mobileModOpen = function (modal) {
        $(modal).css('width', '100%');
        $('.mobile-sidenav').css('right', '0%');
        $("body").addClass('modal-open');
        $(".mobile-close").on("click", function () {
            $('.mobile-sidenav').css('right', '-100%');
            $("body").removeClass('modal-open');
        });
    }
    $("li[data-currency]").on('click', function () {
        var currency = $(this).attr('data-currency');
        location.href = '/service/currency/change/' + currency;
    });
    $("#switch-currency").on('change', function () {
        location.href = '/service/currency/change/' + $(this).val();
    });

    $(document).on("click",".load-more-item", function () {
        var dom = $(this);
        var el = $(this).parent().parent();
        el.find('li').each(function () {
            $(this).removeClass('d-none');
        });

        dom.hide();
    });


    $(document).ready(function () {
        setTimeout(function () {
            $("#mobile-input-destinations").on('focus', function () {
                var el = $(this).parent('.search-result-label')
                el.addClass('focus')
            });

            $("#mobile-input-destinations").on('blur', function () {
                cursorEffectStop();
            });

            $("#mobile-input-destinations").on('keyup', function () {
                cursorEffectStop()
            });

            // $(".abflug-search").on('focus', function (e) {
            //     const el = $(this).parent('.cursor-effect');
            //     el.addClass('stop')
            // });


            if (!isMobile()) {
                $(document).on("keypress", function (element) {
                    if (element.target.nodeName !== "BODY") {
                        return;
                    }
                    const e = $(".abflug-search");
                    if (!e.parents('.search-box-item').hasClass('active')) {
                        e.parents('.button').trigger('click');
                        e.focus();
                    }
                });
            }


            // $(".abflug-search").on('blur', function () {
            //     const el = $(".abflug-search").parent('.cursor-effect');
            //     el.addClass('stop')
            // });

            function cursorEffectStop() {
                if ($("#mobile-input-destinations").length > 0) {
                    if ($("#mobile-input-destinations").val().length > 0) {
                        const el = $(this).parent('.search-result-label');
                        el.addClass('focus')
                    } else {
                        const el = $(this).parent('.search-result-label');
                        el.removeClass('focus')
                    }
                }
            }

            cursorEffectStop();
        }, 1000)
    })


    $("a[data-drawer-toggle]").on("click", function () {
        const id = $(this).data("drawer-toggle");
        if ($(id).hasClass('open')) {
            $(id).removeClass('open')
            $('.marti-drawer-overlay').remove()
        } else {
            $(id).addClass('open')
            $(id).after(function () {
                return "<div class='marti-drawer-overlay'></div>";
            });
        }
    });


    $(document.body).on('click', '.marti-drawer-overlay', function (e) {
        const id = '#' + $('.marti-drawer.open').attr('id')
        console.log('id', id)
        $(id).removeClass('open')
        $('.marti-drawer-overlay').remove()
    });


    $(window).scroll(function (e) {
        var top = $(document).scrollTop();
        if (top > 714) {
            $('.filter-buttons.hotel-detail').css('display', 'table')
        } else {
            $('.filter-buttons.hotel-detail').css('display', 'none')
        }
    });


    $('body').on('click', '.loginbuttons', function (e) {
        e.preventDefault();
        login(e);
    });
    window.modal = {
        open: function (target) {
            $("body").addClass("modal-open");
            target.addClass("active");
        },
        close: function (target) {
            $("body").removeClass("modal-open");
            target.removeClass("active");
        }
    }

    var custom = (function () {
        var result = {};
        result.esc = (function () {
            try {
                $(document).keyup(function (e) {
                    if (e.keyCode == 27) {
                        $("[data-esc=true]").removeClass("active");
                    }
                });
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.modal = (function () {
            try {
                // Modal açma ve kapama esnasında yapılacaklar
                function openModal(target) {
                    //$("body").addClass("modal-open");
                    $(target).addClass("active");
                    if (window.isMobile() && typeof target === 'string' && target.includes("mobile")) {
                        mobileModOpen($(target));
                    } else {
                        $(target).modal('show');
                    }
                }

                function closeModal(target) {
                    $("body").removeClass("mobile-menu-open");
                    $(".mobile-menu").removeClass("active");
                    $("body").removeClass("modal-open");
                    target.removeClass("active");
                    $(target).modal('hide');
                }

                // Modal açma
                $("[data-toggle=modal]").on("click", function (e) {
                    var target = $(this).attr("data-target");
                    var url = $(this).attr('data-url');
                    if (typeof url !== 'undefined') {
                        $(target).find('iframe').attr('src', url);
                    }
                    openModal($(target));
                    e.stopImmediatePropagation();
                });

                // Hedef dışı tıklamada modal kapatma
                $(".modal").on("click", function (event) {
                    if ($('.modal-dialog').has(event.target).length == 0 && !$('.modal-dialog').is(event.target)) {
                        $("body").removeClass("modal-open");
                        closeModal($(this));
                    }
                });

                // Hedef dışı tıklamada modal kapatma
//                $(".modal-open").on("click", function(event){
//                    if ($('.modal-dialog').has(event.target).length == 0 && !$('.modal-dialog').is(event.target)){
//                        $("body").removeClass("modal-open");
//                    }  
//                });
                // ESC'ye basıldığında modal kapatma
                $(document).keyup(function (e) {
                    if (e.keyCode == 27) {
                        closeModal($(".modal"));
                        e.stopImmediatePropagation();
                    }
                });
                // Çarpı simgesine tıklanıldığında modal kapatma
                $(document).on("click",".modal-close",function (e) {
                    closeModal($(".modal"));
                    e.stopImmediatePropagation();
                });

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.selectBox = (function () {
            try {

                var selectBox = $("[data-selectbox=root]");
                if (selectBox.length > 0) {
                    // Varsayılan seçimi gösterelim
                    $.each(selectBox, function (key, value) {
                        var selected = $(value).find("[data-selectbox=select]").data('val');
                        var textContainer = $(value).find("[data-selectbox=text]");
                        var text = $(value).find("[data-selectbox=select] option[data-val=" + selected + "]").text();
                        //textContainer.text(text);
                    });

                    // Değişiklik olduğundaki durumu gösterelim
                    selectBox.find("[data-selectbox=select]").on("change", function () {
                        var selected = $(this).val();
                        var textContainer = $(this).parents("[data-selectbox=root]").find("[data-selectbox=text]");
                        var text = $(this).parents("[data-selectbox=root]").find("[data-selectbox=select] option[value='" + selected + "']").text();
                        $('[data-select=reisedauer]').html(text);
                        textContainer.text(text);
                    });
                }


            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.collapse = (function () {
            try {

                $(document).on("click", "[data-collapse=button]", function (e) {
                    //console.log("data-collapse=button on click()");
                    e.preventDefault();
                    var target = $(this).attr("data-target"),
                        isActive = $(this).hasClass("active"),
                        height = 0;

                    $.each($(target).children(), function (key, element) {
                        height += $(element).outerHeight(true);
                    });

                    $(this).toggleClass("active");
                    $(target).removeClass("open");
                    if (isActive == true) {
                        $(target).css("max-height", 0);
                        $(target).removeClass("overflow").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
                            $(target).removeClass("active");
                        });
                    } else {
                        $(target).css("max-height", height + "px");
                        $(target).addClass("active").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
                            $(target).addClass("overflow");
                        });
                    }

                });


            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.tag = (function () {
            try {
                $("[data-toggle=tag]").on("click", function (e) {
                    e.preventDefault();
                    $(this).remove();
                });
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.homeSearch = (function () {
            try {
                //Murat: hotel search click
                result.searchDropdown = (function () {
                    try {
                        $(document).on("click", ".absearch.search-box-item-button .button,.children-select.search-box-item-button .button", function (e) {
                            /* console.log($(this)); */
                            /* console.log(e.target) */

                            var target = $(this).parents(".search-box-item"),
                                hasClass = target.hasClass("active");
                                /* console.log(hasClass); */
                            
                            

                            if (hasClass === true && e.target == '.button') {
                                target.removeClass("active");
                            } else {
                                $(".search-box-item").removeClass("active");
                                target.addClass("active");

                                if (isMobile()) {
                                    $("body").addClass("modal-open");
                                    $("#mobile-input-destinations").focus().select();
                                }
                            }
                        });
                        $(document).on("click", ".abflughafen.search-box-item-button .button, .duration-date.search-box-item-button .button", function (e) {
                            var target = $(this).parents(".search-box-item"),
                                hasClass = target.hasClass("active");
                            
                            if (hasClass === true && e.target == '.search-box-departure') {
                                target.removeClass("active");
                            } else {
                                $(".search-box-item").removeClass("active");
                                target.addClass("active");
                            }
                        });
                        
                         $(document).on("click", ".departure-select", function () {
                               var target = $(this).parents(".search-box-item");
                               target.removeClass("active");
                         });

                        $(document).on("click",".mobile_person .action-close", function () {
                            $('.search-box-item').removeClass('active');
                            $("body").removeClass("modal-open");
                        });

                        $(document).on("click",".mobile-departure .action-close", function () {
                            $('.search-box-item').removeClass('active');
                            $("body").removeClass("modal-open");
                        });

                        $(document).on("click",".search-box-col .datepicker-trigger", function () {
                            console.log(true)
                            $('#abflughafen .search-box-item').removeClass('active')
                        });

                        $(".search-box-item-content-selectbox-option").on("click", function () {
                            //console.log(".search-box-item-content-selectbox-option click()");
                            $('.search-box-item').removeClass("active");
                            $("body").removeClass("modal-open");
                        });
                        //Murat hotel and region search input keyup
                        $(".abflug-search").keyup(function () {
                            var target = $(this).parents(".search-box-item"),
                                hasClass = target.hasClass("active");
                            if (hasClass == true) {
                                //target.removeClass("active");
                            } else {
                                $(".search-box-item").removeClass("active");
                                target.addClass("active");
                            }
                        });
                        $(".abflug-research").keyup(function () {
                            var target = $(this).parents(".research-item"),
                                hasClass = target.hasClass("active");
                            if (hasClass == true) {
                                //target.removeClass("active");
                            } else {
                                $(".research-item").removeClass("active");
                                target.addClass("active");
                            }
                        });
                        $(window).on("click", function (event) {
                            if ($('.search-box-item').has(event.target).length == 0 && !$('.search-box-item').is(event.target)) {
                                //outside
                                $('.search-box-item').removeClass("active");
                            }
                        });
                    } catch (e) {
                        console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
                    }
                });
                result.searchCounter = (function () {
                    try {
                        // Counter alanının kapatılması
                        $(document).on("click", ".search-box-item-content-counter-button .button", function () {
                            $(this).parents(".search-box-item").removeClass("active");
                            $("body").removeClass("modal-open");
                        });
                    } catch (e) {
                        //console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
                    }
                });

                result.searchDropdown();
                //  result.searchSelectBox();
                result.searchCounter();

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.favoriteSlider = (function () {
            try {
                var favoriteSlider = new Swiper("#favoriteSlider", {
                    height: 432,
                    direction: "vertical",
                    slidesPerGroup: 4,
                    slidesPerView: 4,
                    loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: ".favorite-slider-indicators",
                        type: "bullets",
                        clickable: true,
                        bulletClass: "favorite-slider-indicators-item",
                        bulletActiveClass: "active"
                    },
                    breakpoints: {
                        575: {
                            height: 304
                        }
                    }
                });
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.magazineSlider = (function () {
            try {
                $('#magazine-slider').owlCarousel({
                    loop: true,
                    margin: 10,
                    dots: false,
                    nav: true,
                    navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                    responsive: {
                        0: {
                            items: 1,
                            dots: false,
                        },
                        600: {
                            nav: true,
                            dots: false,
                            items: 3
                        },
                        1000: {
                            items: 3,
                            dots: false,
                            nav: true,
                        }
                    }
                })

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });

        result.userTabPanel = (function () {
            try {
                var userTabPanel = new Swiper("#userTabPanel", {
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    autoplay: false,
                    spaceBetween: 0,
                    autoHeight: true,
                    effect: "fade",
                    fadeEffect: {
                        crossFade: true
                    }
                });
                userTabPanel.detachEvents();

                // Hangi panel açılacak
                $(document).on("click", "[data-user-tab-panel]", function () {
                    var target = $(this).attr("data-user-tab-panel");
                    console.log(target);
                    $(".modal-main-user-buttons .button").removeClass("active");
                    $(".modal-main-user-buttons .button:eq(" + target + ")").addClass("active");
                    userTabPanel.slideTo(target);
                });

                // Tab butonlara tıklanıldığında
                $(document).on("click", ".modal-main-user-buttons .button", function () {
                    var target = $(this).index();
                    console.log(target);
                    $(".modal-main-user-buttons .button").removeClass("active");
                    $(this).addClass("active");
                    userTabPanel.slideTo(target);
                });

                $(document).on("click", "#userTabPanel a.tablink", function (e) {
                    var target = $(this).data("index");
                    console.log(target);
                    $(".modal-main-user-buttons .button").removeClass("active");
                    $(".modal-main-user-buttons .button:eq(" + target + ")").addClass("active");
                    userTabPanel.slideTo(target);
                    e.stopPropagation();
                });

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.mobileMenus = (function () {
            try {
                
                $(document).on("click","[data-toggle=mobile-menu]", function () {
                    $("body").addClass("mobile-menu-open");
                    $(".mobile-menu").addClass("active");
                });

                $("[data-close=mobile-menu]").on("click", function () {
                    $("body").removeClass("mobile-menu-open");
                    $(".mobile-menu").removeClass("active");
                });

                $(".mobile-menu-main-list-item-link.dropdown").on("click", function (e) {
                    e.preventDefault();
                    var isActive = $(this).parents(".mobile-menu-main-list-item").stop().hasClass("active");
                    if (isActive == true) {
                        $(this).parents(".mobile-menu-main-list-item").find(".mobile-menu-main-dropdown-list").stop().slideUp("50ms", function () {
                            $(this).parents(".mobile-menu-main-list-item").stop().removeClass("active");
                        });
                    } else {
                        $(this).parents(".mobile-menu-main-list-item").stop().addClass("active");
                        $(this).parents(".mobile-menu-main-list-item").find(".mobile-menu-main-dropdown-list").stop().slideDown("50ms");
                    }
                });

                $(document).on("click","[data-toggle=mobile-nav]", function () {

                    if (!window.isMobile()) {
                        var url = $(this).attr('data-url');
                        var html = '<iframe src="' + url + '" style="width:100%;height:100%;border:none;"></iframe>';
                        var href = $(this).attr('data-href').replace('mobile-', '');
                        $(href + " .iframe-area").html(html);
                        //window.modal.open($(href));
                        $(href).modal('show');

                        return;
                    }
                    console.log("test");
                    var href = $(this).attr('data-href');
                    $(href).css('right', '0');

                    var url = $(this).attr('data-url');
                    if (typeof url != 'undefined' && url.length > 0) {
                        $(href).find('iframe').attr('src', url);
                    }
                    $("body").addClass('modal-open');
                    //  history.pushState({page: $(this).attr('data-href').replace('#','')}, "page 2", "/"+$(this).attr('data-href').replace('#',''));
                });

                window.mobileOpen = function (modal) {
                    $(modal).css('width', '100%');
                    $("body").addClass('modal-open');
                }
                
                $(document).on("click",".mobile-close", function () {
                    $('.mobile-sidenav').css('right', '-100%');
                    $("body").removeClass('modal-open');
                });
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.specialPreferences = (function () {
            try {
                // Butona tıklanıldığında açılıp kapanması
                $("[data-special-preferences=button]").on("click", function () {
                    var root = $(this).parents("[data-root=special-preferences]"),
                        dropdown = $(this).parents("[data-root=special-preferences]").find("[data-special-preferences=content]"),
                        hasActive = $(root).hasClass("active");

                    if (hasActive == true) {
                        $(root).removeClass("active");
                    } else {
                        $("[data-root=special-preferences]").removeClass("active");
                        $(root).addClass("active");
                    }
                });

                // Çıkış butonuna tıklanıldığında kapanması
                $("[data-special-preferences=close]").on("click", function () {
                    var root = $(this).parents("[data-root=special-preferences]");
                    $(root).removeClass("active");
                });

                /*$("[data-special-preferences=confirm]").on("click", function () {
                    var root = $(this).parents("[data-root=special-preferences]");
                    if (root.hasClass('selected')) {
                        $(root).removeClass("selected");
                    } else {
                        $(root).removeClass("active").addClass("selected");
                    }
                });*/
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.resultsSliders = (function () {
            try {
                var slider = $("[data-result-slider=slider]");
                var resultsSlidersList = new Array();
                $.each(slider, function (key, element) {
                    $(element).attr("data-index", key);
                    resultsSlidersList[key] = new Swiper(element, {
                        slidesPerGroup: 1,
                        slidesPerView: 1,
                        spaceBetween: 10,
                        loop: true,
                        effect: "fade",
                        fadeEffect: {
                            crossFade: true
                        },
                        autoplay: {
                            delay: 1000,
                            disableOnInteraction: false
                        }
                    });
                });

                $("[data-result-slider=previous]").on("click", function () {
                    var root = $(this).parents("[data-result-slider=root]").find("[data-result-slider=slider]"),
                        index = root.attr("data-index");
                    resultsSlidersList[index].slidePrev();
                });

                $("[data-result-slider=next]").on("click", function () {
                    var root = $(this).parents("[data-result-slider=root]").find("[data-result-slider=slider]"),
                        index = root.attr("data-index");
                    resultsSlidersList[index].slideNext();
                });

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.contactTab = (function () {
            try {

                var contactTab = new Swiper("[data-slider=contact]", {
                    slidesPerGroup: 1,
                    slidesPerView: 1,
                    effect: "fade",
                    autoHeight: true,
                    fadeEffect: {
                        crossFade: true
                    }
                });
                contactTab.detachEvents();
                $("[data-slider-buttons=contact] .button").on("click", function () {
                    var index = parseInt($(this).index(), 10);
                    $("[data-slider-buttons=contact] .button").removeClass("active");
                    $(this).addClass("active");
                    contactTab.slideTo(index);
                });

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.searchResultTab = (function () {
            try {

                var searchResultTab = new Swiper("[data-slider=result-hotel-tab]", {
                    slidesPerGroup: 1,
                    slidesPerView: 1,
                    effect: "fade",
                    roundLengths: true,
                    fadeEffect: {
                        crossFade: true
                    },
                    on: {
                        slideChange: function (e) {
                            if (!$(this)[0].realIndex) {
                                $("[data-slider=result-hotel-tab] .swiper-wrapper").css("height", "auto");
                            }
                            ;
                        },
                    }
                });
                searchResultTab.detachEvents();
                $("[data-slider-buttons=result-hotel-tab] .button").on("click", function () {
                    var index = parseInt($(this).index(), 10);
                    $("[data-slider-buttons=result-hotel-tab] .button").removeClass("active");
                    $(this).addClass("active");
                    searchResultTab.slideTo(index);
                });

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.mask = (function () {
            try {

                var windowWidth = $(window).width();
                if (windowWidth < 992) {
                    $.each($("[data-mask=date]"), function (index, element) {
                        $(element).attr("type", "date");
                    });
                }
                ;
                $("[data-mask=date]").mask('00.00.0000');
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.subscripbeForm = (function () {
            try {
                $(document).on("click", "#send-subscribe", function (e) {
                    e.preventDefault();
                    const element = $('#send-subscribe-email');
                    console.log('element', element);
                    const value = element.val();
                    if (!result.isStringNullOrEmpty(value)) {
                        if (validateEmail(value)) {
                            element.parents('.input-main').removeClass('invalid');
                        } else {
                            element.parents('.input-main').addClass('invalid');
                            element.focus();
                            return;
                        }
                    } else {
                        element.parents('.input-main').addClass('invalid');
                        element.focus();
                        return;
                    }
                    $.getScript('https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit', function () {
                        var email = $("#send-subscribe-email").val();
                        if (email != null && validateEmail(email)) {
                            $("#subscribe-modal").modal('show');
                            $("#subscribe-email").val(email);
                            grecaptcha.reset(window.subscribeCaptcha);
                        } else {
                            return false
                        }
                    });
                });

                $(document).on("click", "#subscribe", function () {
                    var email = $("#subscribe-email").val();
                    if (email != null && validateEmail(email)) {
                        $.ajax({
                            type: 'POST',
                            data: {response: $("#g-recaptcha-response").val(), 'email': email},
                            url: '/service/customers/subscribe',
                            dataType: 'json',
                            success: function (r) {
                                if (r.status == false) {
                                    swal(Marti.Locale.get('common.warning'), r.message, 'warning');
                                    return false;
                                } else {
                                    swal(Marti.Locale.get('common.success'), r.message, 'success');
                                    $("#subscribe-email").val('');
                                    $("#send-subscribe-email").val('');
                                    $("#subscribe-modal").modal('hide');
                                    return false;
                                }
                            }
                        });
                    } else {
                        return false
                    }
                });

            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        });
        result.isStringNullOrEmpty = function (val) {
            switch (val) {
                case "":
                case 0:
                case "0":
                case null:
                case false:
                case undefined:
                case typeof this === 'undefined':
                    return true;
                default:
                    return false;
            }
        };

        //Check is string null or whitespace
        result.isStringNullOrWhiteSpace = function (val) {
            return this.isStringNullOrEmpty(val) || val.replace(/\s/g, "") === '';
        };

        result.nullIfStringNullOrEmpty = function (val) {
            if (this.isStringNullOrEmpty(val)) {
                return null;
            }
            return val;
        };
        result.formValidation = function (form) {

            var is_valid = true;
            $.each(form, function (index, item) {
                if (!result.isStringNullOrEmpty(item.value)) {
                    $("[data-required][name='" + item.name + "']").parents('.input-main').removeClass('invalid');
                } else {
                    $("[data-required][name='" + item.name + "']").parents('.input-main').addClass('invalid');
                    $("[data-required][name='" + item.name + "']").focus();
                    is_valid = false
                }
            });
            return is_valid;
        };

        var collClick = $('.results-collapse-list').first().find('.results-item-header');

        if (collClick.length > 0) {
            //    collapseClick(collClick);
        }

        function collapseClick(clk) {

            var target = clk.data('target'),
                isActive = clk.hasClass("active"),
                height = 0;

            $.each($(target).children(), function (key, element) {
                height += $(element).outerHeight(true);
            });

            $('*[data-target="' + target + '"]').toggleClass("active");
            //clk.toggleClass("active");
            $(target).removeClass("open");
            if (isActive == true) {
                $(target).css("max-height", 0);
                $(target).removeClass("overflow").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
                    $(target).removeClass("active");
                });
            } else {
                $(target).css("max-height", height + "px");
                $(target).addClass("active").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
                    $(target).addClass("overflow");
                });
            }
        }

        /**login*/
        $("body").delegate("button", "click", function (e) {


            _trigger = $(this).get(0);

            // add .modal-open class at body to prevent scrolling behind the modal
            if (_trigger === $('#datepicker-button-trigger').get(0)) {
                if (!$(_trigger).hasClass("datepicker-open")) {
                    if (isMobile())
                        $("body").addClass("modal-open");
                }
            }
            //Datepicker click on x or buttons remove the modal-open class
            if (_trigger === $('.asd__mobile-close').get(0) || _trigger === $('.asd__action-buttons button').get(0) || _trigger === $('.asd__action-buttons button').get(1)) {
                $("body").removeClass("modal-open");
            }
            // 
            if (_trigger === $('div.dsdsdsds').get(0) || _trigger === $('.asd__action-buttons button').get(0) || _trigger === $('.asd__action-buttons button').get(1)) {
                $("body").removeClass("modal-open");
            }

            if ($(this).data("login") == true) {

                // $("#login-form .danger").css('opacity', 0);
                // $("#login-form .danger").css('visibility', 'hidden');
                // $("#login-form .success").css('opacity', 0);
                // $("#login-form .success").css('visibility', 'hidden');
                // $("#login-form .login-error").hide();

                const form = $("#login-form").serializeArray();

                if (!result.formValidation(form)) {
                    return false;
                }

                $.ajax({
                    url: "/service/customers/login",
                    type: "POST",
                    data: form,
                    dataType: 'json',
                    success: function (response) {

                        if (response.status === false) {

                            /*  var username = $("#login-form [name='username']");
                              var nameIcon = '';
                              if (username != null && validateEmail(username.val())){
                                  nameIcon = '.success';
                              } else {
                                  nameIcon = '.danger';
                              }
                              var icon = username.parent().parent().find(nameIcon);
                              icon.css('opacity',1);
                              icon.css('visibility','visible');


                              var password = $("#login-form [name='password']");
                              nameIcon = '';
                              if (password != null && password.val().length>0){
                                  nameIcon = '.success';
                              } else {
                                  nameIcon = '.danger';
                              }
                              var icon = password.parent().parent().find(nameIcon);
                              icon.css('opacity',1);
                              icon.css('visibility','visible');
  */
                            $('.login-error').show();
                            $(".login-error").html(response.message);
                            setTimeout(function () {
                                $('.login-error').hide();
                            }, 2000);
                        } else {
                            location.reload();
                        }

                        return false;


                    }

                })
            }

            if ($(this).data("forget") == true) {

                var form = $("#forget-form").serializeArray();

                var username = $("#forget-form [name='username']");
                var nameIcon = '';

                if (!result.formValidation(form)) {
                    return false;
                }

                if (username != null && validateEmail(username.val())) {
                    nameIcon = '.success';
                } else {
                    nameIcon = '.danger';
                }
                var icon = username.parent().parent().find(nameIcon);
                icon.css('opacity', 1);
                icon.css('visibility', 'visible');
                if (nameIcon != '.danger') {
                    $.ajax({
                        url: "/service/customers/recovery-password",
                        type: "POST",
                        data: form,
                        dataType: 'json',
                        success: function (response) {

                            if (response.status === false) {
                                swal("Warning", response.message, "warning");
                            } else {
                                swal(Marti.Locale.get('common.success'), response.message, "success");
                            }

                            return false;


                        }

                    });
                }
            }


            if ($(this).data("reset") == true) {

                var form = $("#reset-form").serializeArray();

                if (!result.formValidation(form)) {
                    return false;
                }

                $.ajax({
                    url: "/service/customers/reset-password",
                    type: "POST",
                    data: form,
                    dataType: 'json',
                    success: function (response) {

                        if (response.status === false) {
                            swal(Marti.Locale.get('common.warning'), response.message, "warning");
                        } else {
                            swal(Marti.Locale.get('common.success'), response.message, "success");
                            $("#reset-form")[0].reset();
                        }

                        return false;


                    }

                })
            }


            if ($(this).data("register") === true) {

                $("#register-form .danger").css('opacity', 0);
                $("#register-form .danger").css('visibility', 'hidden');
                $("#register-form .register-error").hide();

                var form = $("#register-form").serializeArray();

                if (!result.formValidation(form)) {
                    return false;
                }


                $.ajax({
                    url: "/service/customers/save",
                    type: "POST",
                    data: form,
                    dataType: 'json',
                    success: function (response) {

                        if (response.status) {
                            $('#modalLogin').removeClass("active");
                            $('#registered-modal').addClass("active");

                            location.reload();

                        } else {
                            if (response.data.type === 'empty') {
                                var dom = $("#register-form [name='" + response.data.field + "']").parent().parent().find('.danger');
                                dom.css('opacity', 1);
                                dom.css('visibility', 'visible');
                            } else {
                                swal("Warning", response.message, "warning");
                                //     $('.register-error p').html(response.message);
                                //     $(".register-error").show();
                            }

                        }

                    },

                })
            }

        });

        /**delagate modal*/
        $("body").delegate("a,select,#summary", "click", function () {
        //    custom.init();
        });

        $(document).ready(function () {
            function SmoothScrollTo(id_or_Name, timelength) {
                var timelength = timelength || 1000;
                $('html, body').animate({
                    scrollTop: $(id_or_Name).offset().top - 70
                }, timelength, function () {
                    window.location.hash = id_or_Name;
                });
            }

            setTimeout(function () {
                $('#btn-check-offer').click(function (e) {
                    e.stopPropagation();
                    SmoothScrollTo(".results-hotel-tab", 1000);
                })
            }, 1000)
        })

        result.init = function () {
            try {
                result.esc();
                result.modal();
                result.selectBox();
                result.collapse();
                result.tag();
                result.homeSearch();
                result.favoriteSlider();
                result.userTabPanel();
                result.mobileMenus();
                result.specialPreferences();
                result.resultsSliders();
                // result.recommendedProgress();
                result.contactTab();
                result.searchResultTab();
                result.mask();
                result.magazineSlider();
                result.subscripbeForm();
            } catch (e) {
                //  console.log("ErrorMessage: " + e.message + "\nErrorHere: " + e.lineNumber + ":" + e.columnNumber);
            }
        };
        return result;
    })();
    custom.init();
});

$(document).on('click', '.vti__selection', function () {
    $(".vti__dropdown-list").toggle();
});
$(document).on('click', '.vti__dropdown-item', function () {
    if ($(".vti__dropdown-list").is(':visible')) {
        $(".vti__dropdown-list").hide();
    }
});

