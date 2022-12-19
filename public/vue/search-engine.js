
window.addEventListener("load", function (event) {
    bindSearchEngine();
});

function bindSearchEngine() {

    window.SearchEngine = new Vue({

        el: '#search-engine-app',
        data: {
            
            destinations: {
                states: [],
                hotels: [],
                favourites: [],
                populars: [],
                clicked: true
            },
        },
        
        methods: {
           
        },

        created() {
            
            this.filter = Marti.filter;
            this.translate = Marti.Locale.all();
        //    this.mobile.isMobile = window.isMobile();
        }
    });
}

var timeout;
var dateEls = {
    days: [],
    daysShort: [],
    months: []
}
for (var i = 1; i < 8; i++) {
    dateEls.days.push(Marti.Locale.get('day.' + i));
    dateEls.daysShort.push(Marti.Locale.get('day.' + i).substr(0, 3));
}
for (var i = 1; i < 13; i++) {
    dateEls.months.push(Marti.Locale.get('month.' + i));
}

Vue.use(window.AirbnbStyleDatepicker, {
    colors: {
        selected: '#ff9700',
        inRange: '#fdb245',
        selectedText: '#fff',
        text: '#565a5c',
        inRangeBorder: '#fff',
        disabled: '#fff',
        hoveredInRange: '#67f6ee'
    },
    days: dateEls.days,
    daysShort: dateEls.daysShort,
    monthNames: dateEls.months,
    texts: {
        apply: Marti.Locale.get('search.take'),
        cancel: Marti.Locale.get('user.cancel'),
        keyboardShortcuts: 'Keyboard Shortcuts',
    },
});