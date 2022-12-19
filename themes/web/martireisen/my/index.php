
<section class="mt-4 mb-4">
    <div class="container ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" title="Home"><img src="<?php theme_dir()?>assets/img/profile/home.svg" alt="home" title="home" class="mr-2"/><?php _lang('menu.home')?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('user.menu.my_account')?></span></li>
            </ol>
        </nav>

        <div class="welcome-area">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                <h2><?php echo $this->account['name'] ?> <?php echo $this->account['surname'] ?> ,</h2>
                <p>Herhangi bir rezervasyon işlemin bulunmuyor.</p>
                <p class="description">15 Yılı aşkın seyahat deneyimimiz ve 600 binden fazla anlaşmalı otelimiz ile ideal tatilini bulmak için hazırız.</p>
                <a href="#">İNCELE</a>
            </div>
        </div>


        <ul class="welcome-links p-0">
            <li>
                <a href="/my/reservations">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_75" d="M0 0h80v80H0z" class="cls-1" data-name="Rectangle 75" transform="translate(514 681)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_14" class="cls-2" data-name="Mask Group 14" transform="translate(-514 -681)">
                            <g id="calendar-event-line" transform="translate(514 681)">
                                <path id="Path_133" d="M0 0h80v80H0z" class="cls-3" data-name="Path 133"/>
                                <path id="Path_134" d="M56.667 10H70a3.333 3.333 0 0 1 3.333 3.333v53.334A3.333 3.333 0 0 1 70 70H10a3.333 3.333 0 0 1-3.333-3.333V13.333A3.333 3.333 0 0 1 10 10h13.333V3.333H30V10h20V3.333h6.667zm10 20V16.667h-10v6.667H50v-6.667H30v6.667h-6.667v-6.667h-10V30zm0 6.667H13.333v26.666h53.334zM20 43.333h16.667v13.334H20z" class="cls-1" data-name="Path 134"/>
                            </g>
                        </g>
                    </svg>

                    <h3> <?php _lang('user.menu.reservations') ?></h3>
                    <p class="d-none">Tüm rezervasyonlarımın detayını göster</p>
                </a>
            </li>
            <li>
                <a href="/my/profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_76" d="M0 0h80v80H0z" class="cls-1" data-name="Rectangle 76" transform="translate(514 681)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_15" class="cls-2" data-name="Mask Group 15" transform="translate(-514 -681)">
                            <g id="user-line_3_" data-name="user-line (3)" transform="translate(514 681)">
                                <path id="Path_135" d="M0 0h80v80H0z" class="cls-3" data-name="Path 135"/>
                                <path id="Path_136" d="M13.333 73.333a26.667 26.667 0 1 1 53.333 0H60a20 20 0 1 0-40 0zm26.667-30a20 20 0 1 1 20-20 19.994 19.994 0 0 1-20 20zm0-6.667a13.333 13.333 0 1 0-13.333-13.333A13.33 13.33 0 0 0 40 36.667z" class="cls-1" data-name="Path 136"/>
                            </g>
                        </g>
                    </svg>


                    <h3><?php _lang('user.menu.my_profile') ?></h3>
                    <p class="d-none">Tüm rezervasyonlarımın detayını göster</p>
                </a>
            </li>
            <li>
                <a href="/my/password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_75" d="M0 0h80v80H0z" class="cls-1" data-name="Rectangle 75" transform="translate(514 681)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_16" class="cls-2" data-name="Mask Group 16" transform="translate(-514 -681)">
                            <g id="lock-2-line" transform="translate(514 681)">
                                <path id="Path_139" d="M0 0h80v80H0z" class="cls-3" data-name="Path 139"/>
                                <path id="Path_140" d="M20 26.667v-3.334a20 20 0 1 1 40 0v3.333h6.667A3.333 3.333 0 0 1 70 30v40a3.333 3.333 0 0 1-3.333 3.333H13.333A3.333 3.333 0 0 1 10 70V30a3.333 3.333 0 0 1 3.333-3.333zm43.333 6.667H16.667v33.333h46.666zM36.667 52.44a6.667 6.667 0 1 1 6.667 0V60h-6.667zm-10-25.773h26.666v-3.334a13.333 13.333 0 1 0-26.667 0z" class="cls-1" data-name="Path 140"/>
                            </g>
                        </g>
                    </svg>

                    <h3><?php _lang('user.menu.password_settings') ?></h3>
                    <p class="d-none">Tüm rezervasyonlarımın detayını göster</p>
                </a>
            </li>
        </ul>
        
    </div>
</section>
