<?php

\Helper\Config::load(PATH . '/config/config.ini');
\Helper\Config::setProductionMode();

register_shutdown_function('shut');

define('E_FATAL', E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR |  E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

function shut() {

    $error = error_get_last();
    if ($error && ($error['type'] & E_FATAL)) {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        print 'Instandhaltung / Bakım Modu / Maintenance Mod'.PHP_EOL;
        print '<!-- '.PHP_EOL.$error['message'].'-->';
    }
}

define('SITE_URL', \Helper\Config::get('SITE_URL'));

$app = new \Core\App();
$app->start();
