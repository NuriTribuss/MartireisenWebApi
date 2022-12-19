
<div id="page-header" class="bg-about-us">
    <div class="container page-header-container">
        <div class="page-header">
            <div class="page-header-about-us">
                <div class="page-header-about-us-title">{{ post['translate']['name'] }}</div>
                <div class="page-header-about-us-text">{{ post['translate']['summary'] }}</div>
            </div>
        </div>
    </div>
</div>

<div id="breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="" title="Home">{{ 'menu.home' | translate }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>{{ post['translate']['name'] }}</span></li>
            </ol>
        </nav>
    </div>
</div>

<div id="about-us">
    <div class="container">
        <div class="about-us-title">
            <h3 class="about-us-title-text">
                {{ post['translate']['name'] }}
            </h3>
        </div>
        <div class="content">
            {{ post['translate']['content'] | raw }}
        </div>
    </div>
</div>
