<?php
/*
 * Created on 2007.3.20
 * visitor.inc.php
 * Vytautas
 */


$database = & Config::$val['DB'];

$WEB_ROBOT_WORDS[] = "robot";
$WEB_ROBOT_WORDS[] = "bot";
$WEB_ROBOT_WORDS[] = "spider";
$WEB_ROBOT_WORDS[] = "google";
$WEB_ROBOT_WORDS[] = "sitemap";
$WEB_ROBOT_WORDS[] = "yahoo";
$WEB_ROBOT_WORDS[] = "validator";
$WEB_ROBOT_WORDS[] = "crawler";
$WEB_ROBOT_WORDS[] = "ia_archiver";
$WEB_ROBOT_WORDS[] = "facebook";
$WEB_ROBOT_WORDS[] = "java";
$WEB_ROBOT_WORDS[] = "perl";
$WEB_ROBOT_WORDS[] = "findlinks";
$WEB_ROBOT_WORDS[] = "LWP";


$SEARCH_ENGINES[] = array('domain'=>".google.", 'key'=>'q');
$SEARCH_ENGINES[] = array('domain'=>".yahoo.", 'key'=>'p');
$SEARCH_ENGINES[] = array('domain'=>".live.", 'key'=>'q');
$SEARCH_ENGINES[] = array('domain'=>"search.delfi.lt", 'key'=>'q');


function if_visitor_robot($user_agent, $robots){
	foreach($robots as $val){
		if(ereg($val, strtolower($user_agent)))
			return 1;
	}
	return 0;
}

include_once(APP_CLASSDIR."stat.class.php");

$visitor_obj = new visitorInfo;
$visitor_obj->ExtractVInfo();
$visitor_info = $visitor_obj->GetVInfo();
foreach($visitor_info as $key => $val){
	$visitor_info[$key] = addcslashes($val, "'\\");
}


$sql = "SELECT * FROM ".Config::$val['sb_stat_visitor_temp']." WHERE ipaddress='{$visitor_info['IP']}' AND user_agent='{$visitor_info['UA']}'";
$database->exec($sql, __FILE__, __LINE__);
$visitor_row = $database->row();
	
if($database->count == 0){
	$robot = if_visitor_robot($visitor_info['UA'], $WEB_ROBOT_WORDS);
	
	$unique_user_mktime = mktime(date("H")-$XML_CONFIG['hours_unique_visitor'],date("i"),date("s"),date("m"),date("d"),date("Y"));
	
	$back_visitor_id = (is_numeric($back_visitor_row['id'])?$back_visitor_row['id']:0);
	
	if(!$robot){
		$visitor_obj->ExtractVInfoLocation();
	}
	$location = $visitor_obj->GetVInfoLocation();
	
	$sql = "INSERT INTO ".Config::$val['sb_stat_visitor'] .
			"SET ipaddress='{$visitor_info['IP']}', browser='{$visitor_info['Browser']}', browser_version='{$visitor_info['BrowserVersion']}', " .
			"os='{$visitor_info['OS']}', referer='{$visitor_info['Referer']}', referer_domain='{$visitor_info['RefererDomain']}', keyword='{$visitor_info['Keyword']}', user_agent='{$visitor_info['UA']}', " .
			"country='{$location['country']}', country_code='{$location['country_code']}', city='{$location['city']}', region='{$location['region']}', " .
			"latitude='{$location['latitude']}', longitude='{$location['longitude']}', back_id=$back_visitor_id, visit_time=NOW(), robot=$robot, session_id='".session_id()."'";
	$database->exec($sql, __FILE__, __LINE__);
	$visitor_row['id'] = $database->last_id;

	$sql = "INSERT INTO ".Config::$val['sb_stat_visitor_temp'] .
			"SET id={$visitor_row['id']}, ipaddress='{$visitor_info['IP']}', user_agent='{$visitor_info['UA']}', visit_time=NOW(), session_id='".session_id()."'";
	$database->exec($sql, __FILE__, __LINE__);
		
	$sql = "DELETE FROM ".Config::$val['sb_stat_visitor_temp']." WHERE visit_time < '".date("Y-m-d H:i:s", $unique_user_mktime)."'";
	$database->exec($sql, __FILE__, __LINE__);
	
	$mktime = mktime(date("H"),date("i"),date("s"),date("m")-$XML_CONFIG['months_count_storing_stat'],date("d"),date("Y"));
	$sql = "DELETE FROM ".Config::$val['sb_stat_visitor']." WHERE visit_time<'".date("Y-m-d H:i:s", $mktime)."'";
	$database->exec($sql, __FILE__, __LINE__);

	$mktime = mktime(date("H"),date("i"),date("s"),date("m"),date("d")-$XML_CONFIG['days_detail_count_storing_stat'],date("Y"));
	$sql = "DELETE FROM ".Config::$val['sb_stat_visitor_path']." WHERE visit_time<'".date("Y-m-d H:i:s", $mktime)."'";
	$database->exec($sql, __FILE__, __LINE__);
}

$sql = "INSERT INTO ".Config::$val['sb_stat_visitor_path']." SET visitor_id={$visitor_row['id']}, url='{$visitor_info['RequestPage']}', visit_time=NOW()";
$database->exec($sql, __FILE__, __LINE__);

$sql = "UPDATE ".Config::$val['sb_stat_visitor']." SET page_count=page_count+1 WHERE id={$visitor_row['id']}";
$database->exec($sql, __FILE__, __LINE__);

?>
