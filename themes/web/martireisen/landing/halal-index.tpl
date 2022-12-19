<style>
    #search { background:none; }
    #page-header .page-header .page-header-about-us .page-header-about-us-title { font-size : 30px; }
    #page-header { height: 300px }
    #page-header .page-header-container {
        height: auto;
    }
</style>
<div id="page-header" class="bg-about-us " style="background-image:url('{{ data['image' ]}}')">
    <div class="container page-header-container pt-5">
        <div class="page-header col-sm-7">
            <div class="page-header-about-us">
                <div class="page-header-about-us-title">{{ data['translate']['title'] }}</div>
                <div class="page-header-about-us-text">{{ data['translate']['subtitle'] }}</div>
            </div>
        </div>
    </div>
    <div class="container">
        <div id="app" class="d-none" v-cloak>
            <?php // $this->render('layouts/search-bar')?>
        </div>
    </div>
</div>

<div id="results">
    <div class="container">
        <section id="country-price-list" class="no-pt mt-5">
            <div class="container">
                <h2 class="text-center">{{ data['translate']['second_title'] }}</h2>
                <p  class="subtitle text-center" >
                    {{ data['translate']['second_subtitle'] }}
                </p>

                <ul class="price-list mt-3"> <!-- desktop --> 
                    {% for country in countries %}
                        <li class="">
                            <a href="{{ country['url'] }}">
                                <p>{{ country['name'] }}</p>
                            </a>
                        </li>
                    {% endfor %}
                    {% if countries|length > 7 %}
                    <li>
                        <a class="load-more-item" href="javascript:;">
                            <i class="fas fa-plus mr-2"></i>
                            <p>{{ 'offer.show_more' | translate}}</p>
                        </a>
                    </li>
                    {% endif %}
                </ul>

                <ul class="mobile-price-list d-md-none p-0"><!-- mobile -->
                    {% for country in countries %}
                        <li class="">
                            <a href="{{ country['url'] }}">
                                <span>{{ country['name'] }}</span>
                                <div class="price">
                                    <span>
                                        <i class="float-right fa fa-arrow-right"></i>
                                    </span> 
                                </div>
                            </a>
                        </li>
                    {% endfor %}
                    
                    {% if countries|length > 7 %}
                    <li>
                        <a href="javascript:;" class="all-country load-more-item">
                            <i class="fas fa-plus mr-2"></i>
                            <p>{{ 'offer.show_more' | translate}}</p>
                        </a>
                    </li>
                    {% endif %}
                </ul>
            </div>
            
        </section>
        
        <section id="hoteltips-topseller" class="no-pt mt-4">
            <div class="container">
                <h2 class="text-center">{{ data['translate']['third_title'] }}</h2>
                <p class='mb-4 text-center'>{{ data['translate']['third_subtitle'] }}</p>
                <div class="row mt-3">
                    {% for country in countries %}
                    <div class="col-lg-4 col-md-6">
                        <div class="item">
                            <figure>
                                <img src="/data/image/countries/{{ country['iso2'] }}/{{ country['iso2'] }}.jpg" class="w-100" alt="{{ country['name'] }}" title=""/>
                                    <figcaption>
                                        <h3 class="mb-3">{{ country['name'] }}</h3>
                                        <small>{{ country['location']['city'] }}</small>
                                        <a href="{{ country['url'] }}">
                                            <span>
                                                {{ 'offer.show_more' | translate}}                           
                                            </span>
                                            <i class="float-right fa fa-arrow-right"></i>
                                        </a>
                                    </figcaption>
                            </figure>
                        </div>
                    </div>
                    {% endfor %}
                  
                </div>
            </div>
        </section>

        <section class="mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="content-card landing-page border-0">
                            <div class="card-content mt-4">
                                {{ data['translate']['content'] | raw }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
