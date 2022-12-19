<title><?php echo $this->meta['title'] ?></title>
    <meta name="description" content="<?php echo $this->meta['description'] ?>">
    <meta name="keywords"    content="<?php echo $this->meta['keywords'] ?>">
<?php if (\Helper\Setting::get('facebook_meta') == 1) { ?>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $this->meta['title'] ?>" />
    <meta property="og:description" content="<?php echo $this->meta['description'] ?>" />
    <meta property="og:url"  content="<?php echo \Helper\Url::get(); ?>" />
    <meta property="og:image"  content="https://www.martireisen.at/data/image/sg.jpg" />
    <link rel="image_src" href="https://www.martireisen.at/data/image/sg.jpg" />


<?php } ?>
<?php if (\Helper\Setting::get('twitter_meta') == 1) { ?>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?php echo $this->meta['title'] ?>" />
    <meta name="twitter:description" content="<?php echo $this->meta['description'] ?>" />
    <meta name="twitter:url" content="<?php echo \Helper\Url::get(); ?>" />
<?php } ?>
<?php if (!empty(\Helper\Setting::get('google_verification'))) { ?>
    <meta name="google-site-verification" content="<?php echo \Helper\Setting::get('google_verification'); ?>" />
<?php } ?>

