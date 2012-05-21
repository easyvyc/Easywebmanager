<?php
/*
 * Created on 2007.07.04
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$xml = '<Pie title="'.$cms_phrases['main']['stat']['visitors_robots'].'">';

$sql = "SELECT COUNT(id) AS cnt, user_agent AS title FROM {$configFile->variable['sb_stat_visitor']} " .
		"WHERE visit_time >= '{$_GET['from_date']}' AND visit_time < '{$_GET['to_date']}' AND robot=1 " .
		"GROUP BY user_agent " .
		"ORDER BY cnt DESC";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->arr();

$counter = count($arr);
for($i=0; $i < $counter && $i < $XML_CONFIG['max_stat_items']; $i++){
	$xml_[] = trim("<Data title=\"".trim($arr[$i]['title'])."\" value=\"".trim($arr[$i]['cnt'])."\" pullOut=\"".($i==0?"true":"false")."\"/>");
	//$xml_[] = "<Data title=\"sdgsaddf\" value=\"5\" pullOut=\"false\" />";
}

$xml .= implode("", $xml_);


$xml .= "</Pie>";

echo $xml;

?>
<?php exit; ?>