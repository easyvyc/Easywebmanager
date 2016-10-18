<?php
/** config.inc.php
*/


error_reporting(E_ALL);

ini_set('display_errors', true);
ini_set('magic_quotes_gpc', 'off');

// nuimt magic quotes 	
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

class Config {

	static public $val;

	static public function loadConfig($file){
		
		if(!file_exists($file)){
			trigger_error("Config file $file not exist.");
		}
		
		include($file);
		
		self::$val = $variable;
		
		self::setVal('site_url', "http".(self::$val['https']?"s":"")."://".self::$val['pr_url'].self::$val['project_dir']);
		self::setVal('site_admin_url', self::$val['site_url'].self::$val['admin_url']);
		self::setVal('sb_template', self::$val['pr_code']."_template");
		self::setVal('sb_stat_visitor', self::$val['pr_code']."_stat_visitors");
		self::setVal('sb_stat_visitor_temp', self::$val['pr_code']."_stat_visitors_temp");
		self::setVal('sb_stat_visitor_path', self::$val['pr_code']."_stat_visitor_path");
		self::setVal('sb_admin_module_rights', self::$val['pr_code']."_admin_module_rights");
		self::setVal('sb_admin_lang_rights', self::$val['pr_code']."_admin_lang_rights");
		self::setVal('sb_admin_stat', self::$val['pr_code']."_admin_stat");
		self::setVal('sb_module', self::$val['pr_code']."_module");
		self::setVal('sb_module_info', self::$val['pr_code']."_module_info");
		self::setVal('sb_module_categories', self::$val['pr_code']."_module_category");
		self::setVal('sb_record', self::$val['pr_code']."_record");
                self::setVal('sb_record_lang', self::$val['pr_code']."_record_lang");
		self::setVal('sb_relations', self::$val['pr_code']."_relations");
		
	}
	
	static public function setVal($key, $val){
		self::$val[$key] = $val;
	}
	
}

// load configuration file
Config::loadConfig(dirname(__FILE__).'/settings.inc.php');


include(dirname(__FILE__).'/defines.inc.php');
include(dirname(__FILE__).'/systemfunc.inc.php');

//// TODO: padaryti cache
//include_once(CLASSDIR."xmlfile.class.php");
//$xmlFile = DATADIR.'search.xml';
//$xmlFileObj = new File;
//$XML_CONFIG = $xmlFileObj->xmlFileToArray($xmlFile);

include_once(CLASSDIR."benchmark.class.php");
include_once(CLASSDIR."TPL.class.php");
include_once(CLASSDIR."cache.class.php");

// Cache object
$cache_obj = cache::getInstance();


?>