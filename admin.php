<?php 

define('APP_NAME', 'admin');

// Config
include("inc/config.inc.php");

load_helpers('autoload', 'debug', 'error_handler', 'paging', 'languages', 'css', 'validation');

include_once(APP_CLASSDIR."cms.class.php");
$CMS = cms::getInstance();
$CMS->process();

?>