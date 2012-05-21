<?php

define('APP_NAME', 'site');

// Config
include("inc/config.inc.php");

load_helpers('debug', 'error_handler', 'paging', 'url', 'languages', 'database', 'css');

// Main object
include_once(CLASSDIR."main_object.class.php");
$main_object = main_object::getInstance();

// detect current language
$lng = detect_language();


// Underconstruction
if($XML_CONFIG['toggler']!=1/* site disabled */ && !isset($_SESSION['admin']['id']) /* view website for admin */){
	TPL::setVar('underconstruction', $XML_CONFIG['underconstruction']);
	TPL::setVar('lang_lt', $lng=='lt'?1:0);
	TPL::setVar('config', Config::$val);
	include TPL::parse(TPLDIR."underconstruction.tpl");
	exit;
}


$page_data = $main_object->pages->getPageByUrl(website_path_info($_SERVER['PATH_INFO']));
$page_id = $page_data['id'];

if(isset($_GET['page_id'])){
	$page_id = $_GET['page_id'];
}
if(isset($_GET['content'])){
	$content = $_GET['content'];
}

// TODO:
foreach($reserved_url_words as $key=>$val){
	if(ereg("^(/".$val."/)", $_SERVER['PATH_INFO'])){
		$content = $key;
		$page_id = Config::$val['default_page'][$lng];
	}
}

$main_object->users->loadUserStatus();

if(!$main_object->pages->checkPageExist($page_id)){
	redirect(Config::$val['site_url']);
}


if(isset($page_data['page_redirect']) && is_numeric($page_data['page_redirect']) && $page_data['page_redirect']>0 && $page_data['page_redirect']!=$page_data['id']){
	$redirect_page_data = $main_object->pages->loadItem($page_data['page_redirect']);
	if(strlen($redirect_page_data['page_url'])>0 && $redirect_page_data['page_redirect']!=$page_data['id'] && !isset($content)){
		redirect(Config::$val['site_url'].$redirect_page_data['lng'].$redirect_page_data['page_url']);
	}
}

$main_object->pages->getPath($page_id);
$id_path = $main_object->pages->path;


// TODO:
//include(INCDIR."scripts/currencies.php");


// Languages loop
TPL::setVar('languages', load_languages($XML_CONFIG['languages']));
TPL::setVar('lng', $lng);
TPL::setVar('lng_'.$lng, 1);

// TODO: 
//include(SCRIPTS_."rss.php");
//include("ajax/cart.php");

TPL::setVar('currency', $main_object->products->currency);
TPL::setVar('loged_user', $_SESSION['user']);
TPL::setVar('phrases', $main_object->phrases->loadPhrases());
TPL::setVar('upload_url', UPLOADURL);
TPL::setVar('id_path', $id_path);
TPL::setVar('config', Config::$val);
TPL::setVar('get', $_GET);
TPL::setVar('xml_config', $XML_CONFIG);
TPL::setVar('page_data', $page_data);


if(!isset($content)){
	$content = $page_data['template'];
}	

if (file_exists(PHPDIR_.$content.".php")) {
	include(PHPDIR_.$content.".php");
}

TPL::setVar('css', generate_css('', array('normalize','style','main','lightbox')));

TPL::setVar('page_content', TPL::parse(TPLDIR.$content.".tpl"));
include TPL::parse(TPLDIR."content.tpl");

// statistics
if(!isset($_SESSION['admin']['id'])) include("inc/visitor.inc.php");


echo $benchmark->result();

ob_flush();

?>
