<?php

define('EASYWEBMANAGER_VERSION', "4.4");

define('FP_SALT', 'E1!5r$3');

if($_SERVER['REMOTE_ADDR'] == '86.100.151.68' || $_SERVER['REMOTE_ADDR'] == '88.119.136.122'){
    define('TEST', true);
}else{
    define('TEST', false);
}


// 
define('DOCROOT', $_SERVER['DOCUMENT_ROOT'].Config::$val['project_dir']);
define('INCDIR', DOCROOT.'inc/');
define('CLASSDIR', DOCROOT."system/class/");
define('HELPERDIR', DOCROOT."system/helpers/");
define('DBDIR', DOCROOT."system/database/");
define('NUSOAPDIR', CLASSDIR."nusoap/lib/");

define('TPLDIR', DOCROOT.APP_NAME.'/tpls/');
define('MODULESDIR', DOCROOT.APP_NAME.'/modules/');
define('LANGUAGESDIR', DOCROOT.APP_NAME.'/lib/languages/');

define('APP_CLASSDIR', DOCROOT.APP_NAME.'/classes/');

//set files directories
define('FILESDIR', DOCROOT."files/");
define('FILESURL', Config::$val['site_url']."files/");

define('AJAXDIR', DOCROOT."xml/");
define('AJAXURL', Config::$val['site_url']."xml/");

define('FCKDIR', DOCROOT.Config::$val['admin_dir'].'lib/fcked/');
define('FCKBASEPATH', Config::$val['project_dir'].Config::$val['admin_dir'].'lib/fcked/');
define('FCKFILESBASEPATH', Config::$val['project_dir'].'files/f/');

define('CACHEDIR', FILESDIR."cache/");
define('CACHETPLDIR', CACHEDIR."tpl/");
define('CACHEDATADIR', CACHEDIR."data/");
define('CACHEIMGDIR', CACHEDIR."img/");

define('IMAGESDIR', FILESDIR."images/");
define('IMAGESURL', FILESURL."images/");

define('TEMPDIR', FILESDIR."temp/");
define('TEMPURL', FILESURL."temp/");

define('UPLOADDIR', FILESDIR."upload/");
define('UPLOADURL', FILESURL."upload/");

define('DOCUMENTSDIR', FILESDIR."documents/");
define('DOCUMENTSURL', FILESURL."documents/");

define('ICOTPLDIR', FILESDIR."ico_tpl/");
define('ICOTPLURL', FILESURL."ico_tpl/");

define('DATADIR', FILESDIR."data/");
define('DATAURL', FILESURL."data/");

define('KC_UPLOADDIR', FILESDIR."Main/");
define('KC_UPLOADURL', FILESURL."Main/");


$FORM_ELM_TYPES[] = array('value'=>'text', 'id'=>'text', 'superadmin'=>0, 'title'=>'TEXT(Trumpas tekstinis laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'textarea', 'id'=>'textarea', 'superadmin'=>0, 'title'=>'TEXTAREA(Išsamus tekstinis laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'html', 'id'=>'html', 'superadmin'=>0, 'title'=>'HTML(WYSIWYG redaktorius)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'date', 'id'=>'date', 'superadmin'=>0, 'title'=>'DATE(Datos laukelis)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'image', 'id'=>'image', 'superadmin'=>0, 'title'=>'IMAGE(Paveikslėlis)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'file', 'id'=>'file', 'superadmin'=>0, 'title'=>'FILE(Failas)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'radio', 'id'=>'radio', 'superadmin'=>0, 'title'=>'RADIO(Perjungiklių pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'checkbox', 'id'=>'checkbox', 'superadmin'=>0, 'title'=>'CHECKBOX(Pasirinkimas)', 'w'=>1);
$FORM_ELM_TYPES[] = array('value'=>'checkbox_group', 'id'=>'checkbox_group', 'superadmin'=>0, 'title'=>'CHECKBOX_GROUP(Daugybinis pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'select', 'id'=>'select', 'superadmin'=>0, 'title'=>'SELECT(Pasirinkimas iš sąrašo)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'autocomplete', 'id'=>'autocomplete', 'superadmin'=>0, 'title'=>'AUTOCOMPLETE(Pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'hidden', 'id'=>'hidden', 'superadmin'=>1, 'title'=>'HIDDEN(Paslėptas laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'password', 'id'=>'password', 'superadmin'=>1, 'title'=>'PASSWORD(Slaptažodis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'submit', 'id'=>'submit', 'superadmin'=>0, 'title'=>'SUBMIT(Formos patvirtinimo mygtukas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'button', 'id'=>'button', 'superadmin'=>1, 'title'=>'BUTTON(Mygtukas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'list', 'id'=>'list', 'superadmin'=>1, 'title'=>'LIST(Sąrašas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'tree', 'id'=>'tree', 'superadmin'=>1, 'title'=>'TREE(Medis)', 'w'=>2);
$n = count($FORM_ELM_TYPES);
for($i=0; $i<$n; $i++){
	define('FRM_'.strtoupper($FORM_ELM_TYPES[$i]['value']), $FORM_ELM_TYPES[$i]['value']);	
}


// TODO: move to admin
define('UPDATE_SERVER', "http://update.easywebmanager.com/update.php?wsdl");
define('RESULTS_PAGING', 5);
define('DEFAULT_PAGING', 20);
define('ADMIN_SESSION_TIMEOUT', 30);// minutes
define('ADMIN_LOGIN_STATS', 365);
$default['page'] = "list";




?>