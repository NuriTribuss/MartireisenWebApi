
<div id="about-us" class="support-detail">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="about-us-title">
                    <h3 class="about-us-title-text">
                        {{ support['translate']['name'] }}
                    </h3>
                </div>
                <div class="content">
                    {{ support['translate']['content'] | raw }}
                </div>
            </div>
            <div class="mt-4 w-100"></div>
            {% for item in related %}
            <div class="col-12 col-lg-4 mb-1">
                 <a href="{{ item.translate.url }}" class="white-card  w-100 p-3 text-dark d-flex justify-content-between">
                 <span>{{ item.translate.name }}</span>
                 <i class=" fa fa-arrow-right"></i>
                 </a>
            </div>
            {% endfor %}
        </div>
    </div>
</div>
<style>
  .support-detail  ul  {
     padding-left:10px;
 }
 .support-detail  ul li {
     margin-bottom: 10px;
 }
 
 .white-card {
    color: rgb(36, 42, 49);
    display: flex;
    position: relative;
    align-self: stretch;
    box-shadow: rgba(116, 129, 141, 0.1) 0px 3px 8px 0px;
    align-items: center;
    justify-self: stretch;
    flex-direction: row;
    background-color: rgb(255, 255, 255);
 
    border :1px solid rgb(230, 236, 241);
    border-image: initial;
    border-radius: 3px;
    text-decoration: none;
    page-break-inside: avoid;
    transition: border 250ms ease 0s;
 }
</style>