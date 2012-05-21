<?php
/*
 * Created on 2007.4.23
 * month_visitors.php
 * Vytautas
 */


$xml = '<chart>';

$sql = "SELECT COUNT(DISTINCT V.id) AS cnt, V.visit_time AS title, SUBSTRING(V.visit_time, 9, 2) AS day, COUNT(DISTINCT P.id) AS pg_cnt " .
		" FROM {$configFile->variable['sb_stat_visitors']} V " .
		" LEFT JOIN {$configFile->variable['sb_stat_visitor_path']} P " .
		" ON (V.id=P.visitor_id) " .
		" WHERE V.visit_time >= '{$_GET['from_date']}' AND V.visit_time < '{$_GET['to_date']}' AND robot!=1 " .
		" GROUP BY LEFT(V.visit_time, 10)";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->arr();

$sql = "SELECT COUNT(DISTINCT V.id) AS ref_cnt, V.visit_time AS title, SUBSTRING(V.visit_time, 9, 2) AS day " .
		" FROM {$configFile->variable['sb_stat_visitors']} V " .
		" WHERE V.visit_time >= '{$_GET['from_date']}' AND V.visit_time < '{$_GET['to_date']}' AND robot!=1 AND V.referer_domain!='' " .
		" GROUP BY LEFT(V.visit_time, 10)";
$database->exec($sql, __FILE__, __LINE__);
$ref_arr = $database->arr();

//pae($arr);
$counter = count($arr);
for($i=0; $i<31; $i++){
	$n_arr[(int) ($arr[$i]['day'])] = $arr[$i];
}

for($i=0; $i<31; $i++){
	$n_arr[(int) ($ref_arr[$i]['day'])]['ref_cnt'] = $ref_arr[$i]['ref_cnt'];
}

for($i=0; $i<32; $i++){
	$xml_xaxis[] = trim("<value xid=\"$i\">".($i)."</value>");
	if($counter > $i){
		//$arr[$i]['cnt'] = (isset($arr[$i]['cnt'])?$arr[$i]['cnt']:"0");
		$xml_graph1[] = trim("<value xid=\"$i\">".$n_arr[$i]['cnt']."</value>");
		$xml_graph2[] = trim("<value xid=\"$i\">".$n_arr[$i]['pg_cnt']."</value>");
		$xml_graph3[] = trim("<value xid=\"$i\">".$n_arr[$i]['ref_cnt']."</value>");
	}else{
		$xml_graph1[] = trim("<value xid=\"$i\">".$n_arr[$i]['cnt']."</value>");
		$xml_graph2[] = trim("<value xid=\"$i\">".$n_arr[$i]['pg_cnt']."</value>");
		$xml_graph3[] = trim("<value xid=\"$i\">".$n_arr[$i]['ref_cnt']."</value>");
	}
}


include(LANGUAGESDIR.$_SESSION['admin_interface_language'].".php");

$xml .= "<xaxis>";
$xml .= implode("", $xml_xaxis);
$xml .= "</xaxis>";

$xml .= "<graphs>" .
		"<graph color=\"#CC0000\" title=\"{$cms_phrases['main']['stat']['unique_visitors']}\">";
$xml .= implode("", $xml_graph1);
$xml .= "</graph>";

$xml .= "<graph color=\"#0000CC\" title=\"{$cms_phrases['main']['stat']['page_visits']}\">";
$xml .= implode("", $xml_graph2);
$xml .= "</graph>";

$xml .= "<graph color=\"#00CC00\" title=\"{$cms_phrases['main']['stat']['referer_visitors']}\">";
$xml .= implode("", $xml_graph3);
$xml .= "</graph>" .
		"</graphs>";

$xml .= "</chart>";

//echo $xml;

$xml_source = $xml;

?>
<?php 
//exit; 
?>