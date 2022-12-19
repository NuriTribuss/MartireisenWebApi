
<div id="page-header" class="bg-about-us">
    <div class="container page-header-container">
        <div class="page-header">
            <div class="page-header-about-us">
                <h1 class="page-header-about-us-title">{{ page['translate']['name'] }}</h1>
                <div class="page-header-about-us-text">{{ page['translate']['summary'] }}</div>
            </div>
        </div>
    </div>
</div>

<div id="breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="" title="Home">{{ 'menu.home' | translate }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>{{ page['translate']['name'] }}</span></li>
            </ol>
        </nav>
    </div>
</div>

<div id="about-us">
    <div class="container">
        <div class="about-us-title">
            <h3 class="about-us-title-text">
                {{ page['translate']['name'] }}
            </h3>
        </div>
        <div class="content">
            {{ page['translate']['content'] | raw }}
        </div>

        {% for branch in branchs %}

        <div class="d-flex flex-wrap row mb-3  bg-light border px-1 py-4 mx-1">
            <div class="col-lg-4 col-10 mb-2">
                <div class="d-flex">
                    <i class="fa-2x fa fa-map-marker-alt mr-4  text-secondary"></i>
                    <div class="ml-2">
                        <strong>{{ branch['name'] }}</strong><br>
                        {% if branch.old_address != '' %}
                        <span class="text-discount " style="font-size:14px">{{ branch.old_address }}</span>
                        {% endif %}
                        {{ branch['address'] }}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-8 mb-2">
                <strong>Tel.:</strong>&nbsp;<a href="tel:{{ branch['phone'] }}">{{ branch['phone'] }}</a><br>
                <strong>Fax:</strong>&nbsp;{{ branch['fax'] }}
            </div>
            <div class="col-lg-2 col-4  ">
                <a title="{{ branch['title'] }}" href="mailto:{{ branch['email'] }}">E-Mail</a>
            </div>
           
            <div class="col-lg-2 col-6">
                {% if 'Flughafen' in branch.name %}
                Mo-So : {{ branch['week_hours'] }}
                {% elseif branch.id == 3 or branch.id == 16 %}
                Mo-Fr.: {{ branch['week_hours'] }}<br>Sams.:{{ branch['weekend_hours'] }}<br> So.: 09:00 - 19:00
                {% elseif branch.week_hours != '' %}
                Mo-Fr.: {{ branch['week_hours'] }}<br>Sams.: {{ branch['weekend_hours'] }}
                {% else %}
                Umgesiedelt
                {% endif %}
            </div>
        </div>

        {% endfor %}

        <div class="content mt-5 mb-5">
            {{ setting.map_iframe | raw }}
        </div>
    </div>
</div>
