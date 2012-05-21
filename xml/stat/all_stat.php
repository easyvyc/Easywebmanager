<?php
/*
 * Created on 2007.4.29
 * all_visitors.php
 * Vytautas
 */

$sql = "SELECT COUNT(DISTINCT V.id) AS cnt, V.visit_time AS title, LEFT(V.visit_time, 10) AS day " .
		" FROM {$configFile->variable['sb_stat_visitor']} V " .
		" WHERE V.robot!=1 " .($_GET['stat']=='referer'?" AND V.referer_domain!='' ":"").
		" GROUP BY LEFT(V.visit_time, 10) " .
		" ORDER BY day ";
$database->exec($sql, __FILE__, __LINE__);
$arr = $database->arr();


foreach($arr as $key => $val){
	echo "{$val['day']},{$val[cnt]}\r\n";
}

?>
<?php
exit;
?>