var Marti = Marti || {};

Marti.Locale = {

    lang: new Array(),
    get: function (key) {
        if (typeof console !== 'undefined')
            return typeof Marti.Locale.lang[key] !== 'undefined' ? Marti.Locale.lang[key] : key;
    },
    set: function (arr) {
        for (var key in arr) {
            Marti.Locale.lang[key] = arr[key];
        }
    },
    all: function () {
        return Marti.Locale.lang;
    },
};

Marti.Tools = {
    
    numberWithThousandSep: function (x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    frontEndDateFormat: function (d) {
        var date = new Date(Date.parse(d));
        return isNaN(date) ? "" : date.toLocaleDateString('de-DE', {day: '2-digit', month: '2-digit', year: 'numeric'});
    },

    getAirlineIconByFlightNr: function (d) {
        if(Array.isArray(d)){
            return '';
        }
        airline = d.substr(0, 2);
        return '/themes/web/martireisen/assets/img/airways/' + airline + '.svg';
    },
    replaceTr: function (str) {

        return  str.replace('Ğ', 'g').replace('Ü', 'u').replace('Ş', 's').replace('I', 'i')
                .replace('İ', 'i').replace('Ö', 'o').replace('Ç', 'c').replace('ğ', 'g')
                .replace('ü', 'u').replace('ş', 's').replace('ı', 'i').replace('ö', 'o')
                .replace('ç', 'c');

    },

    collapse: function (index) {

        var dom = $("[data-target='#resultCollapse-" + index + "']");
        var target = dom.attr("data-target"),
                isActive = dom.hasClass("active"),
                height = 0;

        $.each($(target).children(), function (key, element) {
            height += $(element).outerHeight(true);
        });

        dom.toggleClass("active");
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

    },
}

Marti.back = function(){
   
    if(document.referrer.indexOf('martireisen') > -1){
        window.history.back();
    }else{
        location.href = '/';
    }
}

Marti.Member = {
    id: 0,
    name: '',
    surname: '',
    mail: '',
    phone: '',
    currency: 'EUR',
    language: 'de'
}

Marti.getCurrency = function () {

    var currency = Marti.Member.currency;
    var symbols = {
        'TRY': '₺',
        'EUR': '€',
        'USD': '$',
        'CHF': 'CHF',
        'CZK': 'Kč',
        'PLN': 'zł',
        'HUF': 'Ft',
    }

    if (typeof symbols[currency] !== 'undefined') {
        return symbols[currency]+ ' ';
    }

    return currency;

}

Marti.page = '';
Marti.booking = {};

window.SocialShare = {};

SocialShare.Networks = [
    {
        name: 'Facebook',
        class: 'facebook',
        url: 'https://www.facebook.com/sharer.php?s=100&p[url]={url}'
    },
    {
        name: 'Twitter',
        class: 'twitter',
        url: 'https://twitter.com/intent/tweet?url={url}'
    },
    {
        name: 'Google+',
        class: 'google',
        url: 'https://plus.google.com/share?url={url}'
    }

];

SocialShare.generate = function (type, url) {

    var obj = {};
    for (var i = 0; i < SocialShare.Networks.length; i++) {
        if (SocialShare.Networks[i].name === type) {
            obj = SocialShare.Networks[i]; //4
            if (url.indexOf(window.location.host) === -1) {
                url = 'http://' + window.location.host + '/' + url;
            }
            url = obj.url.replace('{url}', url);
            window.open(url);
        }
    }

    return;
};