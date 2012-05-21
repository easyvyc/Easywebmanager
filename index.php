<?php

define('APP_NAME', 'fb');

// Config
include("inc/config.inc.php");

load_helpers('autoload', 'debug', 'error_handler', 'paging', 'languages', 'DB', 'css');

include_once(APP_CLASSDIR."site.class.php");
$CMS = site::getInstance();
echo $CMS->process();

ob_flush();

?>