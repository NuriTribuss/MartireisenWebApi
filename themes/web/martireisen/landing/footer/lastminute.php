<section class="mt-4">
    <div class="container ">
        <div class="row m-0">
            <div class=" col-lg-3 profile-card border-0 link pl-0 pr-0 pb-4 pt-4">
                <div class="user-info p-0 pb-4">

                    <div class="info">
                         <p><?php  _lang('landing.footer.lastminute.1')?></p>
                    </div>
                </div>
                 <ul class="profile-links p-0 list-unstyled row ">
                    <?php foreach($this->landingFooter as $link) { if($link['col'] != 1 || $link['type'] != 2) continue;  ?>
                    <li class="list-item col-sm-12">
                        <a class="border-0" href="<?php echo str_replace('{{zone.seo_url}}',$this->zoneFooter['seo_url'],$link['translate']['url'])?>"><span><?php echo str_replace('{{zone.name}}',$this->zoneFooter['name'],$link['translate']['name'])?></span>
                            <i class="float-right fa fa-arrow-right"></i>
                        </a>
                    </li>
                    <?php  } ?>
                </ul>

            </div>
            <div class=" col-lg-3 profile-card border-0 link pl-0 pr-0 pb-4 pt-4">
                <div class="user-info p-0 pb-4">

                    <div class="info">
                        <p><?php _lang('landing.footer.lastminute.2')?></p>
                    </div>
                </div>
                <ul class="profile-links p-0 list-unstyled row ">
                    <?php foreach($this->landingFooter as $link) { if($link['col'] != 2 || $link['type'] != 2) continue;  ?>
                    <li class="list-item col-sm-12">
                        <a class="border-0" href="<?php echo str_replace('{{zone.seo_url}}',$this->zoneFooter['seo_url'],$link['translate']['url'])?>"><span><?php echo str_replace('{{zone.name}}',$this->zoneFooter['name'],$link['translate']['name'])?></span>
                            <i class="float-right fa fa-arrow-right"></i>
                        </a>
                    </li>
                    <?php  } ?>                 
                </ul>

            </div>
            <div class=" col-lg-3 profile-card border-0 link pl-0 pr-0 pb-4 pt-4">
                <div class="user-info p-0 pb-4">

                    <div class="info">
                         <p><?php  _lang('landing.footer.lastminute.3')?></p>
                    </div>
                </div>
                 <ul class="profile-links p-0 list-unstyled row ">
                    <?php foreach($this->landingFooter as $link) { if($link['col'] != 3 || $link['type'] != 2) continue;  ?>
                    <li class="list-item col-sm-12">
                        <a class="border-0" href="<?php echo str_replace('{{zone.seo_url}}',$this->zoneFooter['seo_url'],$link['translate']['url'])?>"><span><?php echo str_replace('{{zone.name}}',$this->zoneFooter['name'],$link['translate']['name'])?></span>
                            <i class="float-right fa fa-arrow-right"></i>
                        </a>
                    </li>
                    <?php  } ?>     
                </ul>

            </div>
            <div class=" col-lg-3 profile-card border-0 link pl-0 pr-0 pb-4 pt-4">
                <div class="user-info p-0 pb-4">

                    <div class="info">
                         <p><?php  _lang('landing.footer.lastminute.4')?></p>
                    </div>
                </div>
                  <ul class="profile-links p-0 list-unstyled row ">
                    <?php foreach($this->landingFooter as $link) { if($link['col'] != 4 || $link['type'] != 2) continue;  ?>
                    <li class="list-item col-sm-12">
                        <a class="border-0" href="<?php echo str_replace('{{zone.seo_url}}',$this->zoneFooter['seo_url'],$link['translate']['url'])?>"><span><?php echo str_replace('{{zone.name}}',$this->zoneFooter['name'],$link['translate']['name'])?></span>
                            <i class="float-right fa fa-arrow-right"></i>
                        </a>
                    </li>
                    <?php  } ?>     
                </ul>

            </div>
        </div>
    </div>
</section>
