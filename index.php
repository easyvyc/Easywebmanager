<?php

define('APP_NAME', 'site');

// Config
include("inc/config.inc.php");

load_helpers('autoload', 'debug', 'error_handler', 'paging', 'languages', 'css', 'url');

$CMS = cms::getInstance();
$CMS->process();

?>