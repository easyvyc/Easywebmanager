<?php
/*
 * Created on 2007.4.29
 * all_visitors.php
 * Vytautas
 */

$xml = '<chart>';

$sql = "SELECT COUNT(DISTINCT V.id) AS cnt, V.visit_time AS title, LEFT(V.visit_time, 7) AS month " .
		" FROM {$configFile->variable['sb_stat_visitors']} V " .
		" WHERE V.visit_time >= '{$_GET['from_date']}' AND V.visit_time <= '{$_GET['to_date']}' AND V.robot!=1 " .
		" GROUP BY LEFT(V.visit_time, 7) " .
		" ORDER BY month ";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->arr();

$sql = "SELECT COUNT(DISTINCT V.id) AS ref_cnt, LEFT(V.visit_time, 7) AS month " .
		" FROM {$configFile->variable['sb_stat_visitors']} V " .
		" WHERE V.visit_time >= '{$_GET['from_date']}' AND V.visit_time <= '{$_GET['to_date']}' AND robot!=1 AND V.referer_domain!='' " .
		" GROUP BY LEFT(V.visit_time, 7) " .
		" ORDER BY month ";
$database->exec($sql, __FILE__, __LINE__);
$ref_arr = $database->arr();

//pae($arr);
$counter = count($arr);
for($i=0; $i<$counter; $i++){
	$arr[$i]['title'] = substr($arr[$i]['month'], 0, 4)." ".$cms_phrases['main']['common']['months'][(int) (substr($arr[$i]['month'], 5, 2))];
	$n_arr[$arr[$i]['month']] = $arr[$i];
}

$counter = count($ref_arr);
for($i=0; $i<$counter; $i++){
	$n_arr[$ref_arr[$i]['month']]['ref_cnt'] = $ref_arr[$i]['ref_cnt'];
}

$index = 0; $series = ""; $graph1 = ""; $graph2 = "";
foreach($n_arr as $key => $val){
	$series .= "<value xid=\"$index\">{$val['title']}</value>";
	$graph1 .= "<value xid=\"$index\">{$val['cnt']}</value>";
	$graph2 .= "<value xid=\"$index\">{$val['ref_cnt']}</value>";
	$index++;
}
$xml .= "<series>";
$xml .= $series;
$xml .= "</series>";

$xml .= "<graphs>";
$xml .= "<graph gid=\"0\">";
$xml .= "<title>Unikalūs lankytojai sadfdsfdsf</title>";
$xml .= $graph1;
$xml .= "</graph>";
$xml .= "<graph gid=\"1\">";
$xml .= "<title>Apsilankymai per nuorodą</title>";
$xml .= $graph2;
$xml .= "</graph>";
$xml .= "</graphs>";

$xml .= "</chart>";

echo $xml;

?>
<?php
exit;
?>