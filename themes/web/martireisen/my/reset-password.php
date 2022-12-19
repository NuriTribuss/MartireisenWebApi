

<div id="breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="" title="Home"><?php _lang('menu.home')?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span><?php _lang('menu.reset_password')?></span></li>
            </ol>
        </nav>
    </div>
</div>

<div class="mt-3 mb-4">
    <div class="container">
        <div class="about-us-title">
            <h3 class="about-us-title-text">
                <?php _lang('menu.reset_password')?>
            </h3>
        </div>
        <form method="POST" id="reset-form">
            <input type="hidden" name="recovery_key" value="<?php echo $this->token?>">
            <div class="alert alert-danger reset-error" style="display: none;margin-bottom: 20px">
                <p></p>
            </div>
            <label class="input no-margin">
                <span class="input-label"><?php _lang('user.new_password')?></span>
                <span class="input-main">
                    <span class="input-main-data"><input type="password" name="password" id="userpass" data-required></span>
                    <span class="input-main-icon danger"><i class="icon icon-input-danger"></i></span>
                    <span class="input-main-icon success"><i class="icon icon-input-success"></i></span>
                    <span class="error-message"><?php _lang('user.new_password_error_message')?></span>
                </span>

            </label>
            <br>
            <div class="modal-main-user-content-button">
                <button class="button button-primary" type="button" data-reset="true"><?php _lang('user.send')?></button>
            </div>
        </form>
    </div>
</div>
