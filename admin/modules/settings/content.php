<?php

error_reporting(0);
ob_start();

include_once(CLASSDIR."tpl.class.php");

$_SESSION['interface_lng'] = 'lt';

if(!isset($_GET['page'])) $_GET['page'] = $default['page'];

if(!isset($_SESSION['admin'][id]) && $_SESSION['admin']['level']>1) // Jei neprisilogines ismeta lauk
    redirect("login.php");   

$tpl_main = & new template("settings/templates/{$_SESSION['interface_lng']}/content.tpl");

$tpl_main->setVar('tree_reload', '');

if(isset($_GET['page'])){
    $template_name = "settings/templates/".$_SESSION['interface_lng']."/".$_GET['page'].".tpl";
    $script_name = "settings/".$_GET['page'].".php";
}else{
    $template_name = "settings/templates/".$_SESSION['interface_lng']."/index.tpl";
    $script_name = "settings/index.php";    
}
$tpl = & new template($template_name);

$tpl->setVar('active_1', '');
$tpl->setVar('active_2', '');
$tpl->setVar('active_3', '');
$tpl->setVar('active_4', '');

$tpl->setVar('module', $_GET['module']);

require($script_name);

$tpl_main->setVar('inner_content', $tpl->parse());

$tpl_main->setVar('id', $_GET['id']);

echo $tpl_main->parse();
ob_end_flush();

?>
