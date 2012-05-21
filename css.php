<?php

define('APP_NAME', 'site');
define('DAY', 7);

// Config
include("inc/config.inc.php");

load_helpers('debug', 'error_handler', 'languages', 'css');

$output = generate_css($_GET['dir'], $_GET['css']);


header("Date: " . date("D, j M Y G:i:s ", $newest_file_mtime) . 'GMT');
header("Content-Type: text/css");
header("Expires: " . gmdate("D, j M Y H:i:s", time() + DAY) . " GMT");
header("Cache-Control: cache"); // HTTP/1.1
header("Pragma: cache");        // HTTP/1.0
print $output;

?>