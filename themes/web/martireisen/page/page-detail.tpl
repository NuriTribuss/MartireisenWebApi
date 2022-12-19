
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
    </div>
</div>