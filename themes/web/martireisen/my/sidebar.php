<div class="col-lg-3 col-md-12">
    <div class="profile-card">
        <div class="user-info">
            <div class="avatar">
                <img src="<?php theme_dir()?>assets/img/profile/user.png" alt="avatar" title="avatar">
            </div>
            <div class="info">
                <h4>HOŞGELDİNİZ,</h4>
                <h3><?php echo $this->account['name'] ?> <?php echo $this->account['surname'] ?> </h3>
            </div>
        </div>
        <ul class="profile-links p-0">
            <li>
                <a href="/my/index" class="<?php echo \Helper\Input::getRequestUrl() == '/my/index' ? 'active' : ''?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_5" d="M0 0h16v16H0z" class="cls-1" data-name="Rectangle 5" transform="translate(385 489)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_2" class="cls-2" data-name="Mask Group 2" transform="translate(-385 -489)">
                            <g id="home-smile-fill" transform="translate(385 489)">
                                <path id="Path_3" d="M0 0h16v16H0z" class="cls-3" data-name="Path 3"/>
                                <path id="Path_4" d="M13.5 13.559a.667.667 0 0 1-.667.667H3.5a.667.667 0 0 1-.667-.667v-6h-2L7.718 1.3a.667.667 0 0 1 .9 0L15.5 7.559h-2zM5.167 8.892a3 3 0 0 0 6 0H9.833a1.667 1.667 0 1 1-3.333 0z" class="cls-1" data-name="Path 4" transform="translate(-.167 -.225)"/>
                            </g>
                        </g>
                    </svg>
                    <span>  <?php _lang('user.menu.dashboard') ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" id="right-arrow" width="4.66" height="6.99" viewBox="0 0 4.66 6.99">
                        <defs>
                        </defs>
                        <path id="Path_12" d="M11.673 11.252l-2.33-2.33 1.165-1.166 3.5 3.5-3.5 3.5-1.165-1.174z" class="cls-1" data-name="Path 12" transform="translate(-9.343 -7.757)"/>
                    </svg>

                </a>
            </li>
            <li>
                <a href="/my/reservations" class="<?php echo \Helper\Input::getRequestUrl() == '/my/reservations' ? 'active' : ''?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_5" d="M0 0h16v16H0z" class="cls-1" data-name="Rectangle 5" transform="translate(385 491)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_5" class="cls-2" data-name="Mask Group 5" transform="translate(-385 -491)">
                            <g id="calendar-event-fill" transform="translate(385 491)">
                                <path id="Path_9" d="M0 0h16v16H0z" class="cls-3" data-name="Path 9"/>
                                <path id="Path_10" d="M11.333 2H14a.667.667 0 0 1 .667.667v10.666A.667.667 0 0 1 14 14H2a.667.667 0 0 1-.667-.667V2.667A.667.667 0 0 1 2 2h2.667V.667H6V2h4V.667h1.333zM2.667 6v6.667h10.666V6zM4 8.667h3.333v2.667H4z" class="cls-1" data-name="Path 10"/>
                            </g>
                        </g>
                    </svg>
                    <span><?php _lang('user.menu.reservations') ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" id="right-arrow" width="4.66" height="6.99" viewBox="0 0 4.66 6.99">
                        <defs>
                        </defs>
                        <path id="Path_12" d="M11.673 11.252l-2.33-2.33 1.165-1.166 3.5 3.5-3.5 3.5-1.165-1.174z" class="cls-1" data-name="Path 12" transform="translate(-9.343 -7.757)"/>
                    </svg>

                </a>
            </li>
            <li>
                <a href="/my/profile" class="<?php echo \Helper\Input::getRequestUrl() == '/my/profile' ? 'active' : ''?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_5" d="M0 0h16v16H0z" class="cls-1" data-name="Rectangle 5" transform="translate(385 489)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_3" class="cls-2" data-name="Mask Group 3" transform="translate(-385 -489)">
                            <g id="user-fill" transform="translate(385 489)">
                                <path id="Path_5" d="M0 0h16v16H0z" class="cls-3" data-name="Path 5"/>
                                <path id="Path_6" d="M3.333 14.833a5.333 5.333 0 1 1 10.667 0zm5.333-6a4 4 0 1 1 4-4 4 4 0 0 1-3.999 4z" class="cls-1" data-name="Path 6" transform="translate(-.667 -.167)"/>
                            </g>
                        </g>
                    </svg>
                    <span> <?php _lang('user.menu.my_profile') ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" id="right-arrow" width="4.66" height="6.99" viewBox="0 0 4.66 6.99">
                        <defs>
                        </defs>
                        <path id="Path_12" d="M11.673 11.252l-2.33-2.33 1.165-1.166 3.5 3.5-3.5 3.5-1.165-1.174z" class="cls-1" data-name="Path 12" transform="translate(-9.343 -7.757)"/>
                    </svg>

                </a>
            </li>
            <li>
                <a href="/my/password" class="<?php echo \Helper\Input::getRequestUrl() == '/my/password' ? 'active' : ''?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <defs>
                            <clipPath id="clip-path">
                                <path id="Rectangle_5" d="M0 0h16v16H0z" class="cls-1" data-name="Rectangle 5" transform="translate(385 489)"/>
                            </clipPath>
                        </defs>
                        <g id="Mask_Group_4" class="cls-2" data-name="Mask Group 4" transform="translate(-385 -489)">
                            <g id="lock-2-fill_1_" data-name="lock-2-fill (1)" transform="translate(385 489)">
                                <path id="Path_7" d="M0 0h16v16H0z" class="cls-3" data-name="Path 7"/>
                                <path id="Path_8" d="M12.5 5.5h1.333a.667.667 0 0 1 .667.667v8a.667.667 0 0 1-.667.667H3.167a.667.667 0 0 1-.667-.667v-8a.667.667 0 0 1 .667-.667H4.5v-.667a4 4 0 0 1 8 0zm-4.667 5.155v1.512h1.334v-1.512a1.333 1.333 0 1 0-1.333 0zM11.167 5.5v-.667a2.667 2.667 0 0 0-5.333 0V5.5z" class="cls-1" data-name="Path 8" transform="translate(-.5 -.167)"/>
                            </g>
                        </g>
                    </svg>
                    <span><?php _lang('user.menu.password_settings') ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" id="right-arrow" width="4.66" height="6.99" viewBox="0 0 4.66 6.99">
                        <defs>
                        </defs>
                        <path id="Path_12" d="M11.673 11.252l-2.33-2.33 1.165-1.166 3.5 3.5-3.5 3.5-1.165-1.174z" class="cls-1" data-name="Path 12" transform="translate(-9.343 -7.757)"/>
                    </svg>

                </a>
            </li>
            <li>
                <a href="/service/customers/logout" class="logout">
                    <img src="<?php theme_dir()?>assets/img/profile/close.svg" alt="log out" alt="log out">
                    <span> <?php _lang('header.logout') ?></span>
                </a>
            </li>
        </ul>
        <a href="/service/customers/logout" class="support-center">
            <div>
                <h3>Yardım Merkezi</h3>
                <p>Sorunuz mu var?</p>
            </div>
            <div>
                <img src="<?php theme_dir()?>assets/img/profile/support.svg" alt="support" title="support">
            </div>
        </a>
    </div>
</div>