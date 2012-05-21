<?php
/*
 * Created on 2007.4.23
 * pages.php
 * Vytautas
 */
 
 
$xml = '<Pie title="'.$cms_phrases['main']['stat']['referers_by_source'].'">';

$sql = "SELECT COUNT(P.id) AS cnt, P.url AS title FROM {$configFile->variable['sb_stat_visitor_path']} P " .
		"LEFT JOIN {$configFile->variable['sb_stat_visitor']} V ON (P.visitor_id=V.id) " .
		"WHERE P.visit_time >= '{$_GET['from_date']}' AND P.visit_time < '{$_GET['to_date']}' AND V.robot!=1 " .
		"GROUP BY P.url " .
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
