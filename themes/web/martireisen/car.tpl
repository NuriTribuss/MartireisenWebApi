<div class="container">
    <div class="row mb-5">
        <div class="col-12 col-md-12 mt-3 text-center p-0">
            <div class="car-header " id="carHeaderId">
                <div class="header-content">
                </div>
            </div>
            <div class="content p-0 container" style="background-color: #f8f8f8 !important;" ct-app>
                <div class="lds-css ng-scope" ><div class="lds-dual-ring"></div></div>
                <noscript>YOUR BROWSER DOES NOT SUPPORT JAVASCRIPT</noscript>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    // Booking Engine Settings.
    const languageCode = getUrlParameter('lang');
    const type = getUrlParameter('type');
    const currency = getUrlParameter('currency');
    var CT = {
        ABE: {
            Settings: {
                clientID: '537458',
                language: '{{language}}',
                type: ((window.innerWidth <= 800)) ? 'mobile' : 'desktop',
                logo: '/data/image/settings/email_logo/email_logo.png',
                currency: '{{currency}}',
                rtl: false,
                templateLayout: {
                    breadcrumbs: true
                },
                theme: {
                    primary: '#ff932b', // e.g #0000FF
                    secondary: '#ff9700', // e.g #FF0000
                    complimentary: '#003283' // e.g #000000
                },
            }
        }
    };
    // Booking Engine Loader.
    (function () {
        CT.ABE.Settings.version = '5.0';
        var cts = document.createElement('script');
        cts.type = 'text/javascript';
        cts.async = true;
        cts.src = '//ajaxgeo.cartrawler.com/abe' + CT.ABE.Settings.version + '/ct_loader.js?' + new Date().getTime();
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(cts, s);
    })();

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
    ;
</script>
<style>
    .ct-search-cars-form-container {
        width: 100%;
       /* background-image: url(themes/web/martireisen/assets/img/search.png);*/
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: #11408b;
        padding: 50px;
    }
    .ct-search-cars-form-container label {
        color :white;
    }
    .ct-search-cars-form-container h2 {
        color : white !important;
    } 
    
    
</style>