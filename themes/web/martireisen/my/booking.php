
<div id="breadcrumb " class="mt-4 ">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="/" title="Home"><img src="<?php theme_dir()?>assets/img/profile/home.svg" alt="home" class="mr-2" title="home"/><?php _lang('menu.home') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('user.menu.my_account') ?></span></li>
            </ol>
        </nav>
    </div>
</div>

<div class="mb-4">
    <div class="container">
        <div class="row">
            <?php $this->render('my/sidebar') ?> 
              <div class="col-lg-9 col-sm-12">
                <div class="content-card none-border">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover custom-table" style="font-size:14px">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <img src="<?php theme_dir()?>assets/img/profile/barcode.svg" alt="kod" alt="kod">
                                            <?php _lang('booking.code') ?>
                                        </th>
                                        <th width="140px">
                                            <img src="<?php theme_dir()?>assets/img/profile/p-info-table.svg" alt="yolcu sayısı" alt="yolcu sayısı">
                                            <?php _lang('offer.adult') ?>
                                        </th>
                                        <th scope="col">
                                            <img src="<?php theme_dir()?>assets/img/profile/fly.svg" alt="kod" alt="kod">
                                            <?php _lang('search.hotel_name') ?>
                                        </th>
                                        <th scope="col">
                                            <img src="<?php theme_dir()?>assets/img/profile/calendar.svg" alt="kod" alt="kod">
                                            <?php _lang('search.travel_data') ?>
                                        </th>
                                        <th scope="col">
                                            <img src="<?php theme_dir()?>assets/img/profile/calendar.svg" alt="kod" alt="kod">
                                            Date
                                        </th>
                                        <th scope="col" width="65px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->bookings as $booking) { ?>
                                    <tr>
                                        <td>
                                            <span class="hover-border"></span>
                                            <?php echo $booking['code'] ?>
                                        </td>
                                        <td>
                                            <div class="person">
                                                <span class="child">
                                                    <img src="<?php theme_dir()?>assets/img/profile/child.svg" alt="çocuk" title="çocuk">
                                                    <?php echo $booking['children_count'] ?>
                                                </span>
                                                <span class="parent">
                                                    <img src="<?php theme_dir()?>assets/img/profile/parent.svg" alt="yetişkin" title="yetişkin">
                                                    <?php echo $booking['adult_count'] ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td><?php echo $booking['hotel_name'] ?></td>
                                        <td><?php echo $booking['start'] ?></td>
                                        <td> <?php echo date('d.m.Y', strtotime($booking['created_at'])) ?> </td>
                                        <td>
                                            <a target="_blank" href="/booking/complete/<?php echo base64_encode($booking['code']) ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" id="right-arrow" width="4.66" height="6.99" viewBox="0 0 4.66 6.99">
                                                    <defs>
                                                    </defs>
                                                    <path id="Path_12" d="M11.673 11.252l-2.33-2.33 1.165-1.166 3.5 3.5-3.5 3.5-1.165-1.174z" class="cls-1" data-name="Path 12" transform="translate(-9.343 -7.757)"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
