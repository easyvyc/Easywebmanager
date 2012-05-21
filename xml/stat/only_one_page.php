<?php
/*
 * Created on 2010.05.15
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

$sql = "SELECT COUNT(V.id) AS cnt, V.visit_time AS title, LEFT(V.visit_time, 10) AS day " .
		" FROM {$configFile->variable['sb_stat_visitor']} V " .
		" WHERE V.robot!=1 AND V.page_count<2 ".
		" GROUP BY LEFT(V.visit_time, 10) " .
		" ORDER BY day ";
$database->exec($sql, __FILE__, __LINE__);
$arr1 = $database->arr();
foreach($arr1 as $i=>$val){
	$arr2[$val['day']] = $val['cnt'];
}

$sql = "SELECT COUNT(V.id) AS cnt, V.visit_time AS title, LEFT(V.visit_time, 10) AS day " .
		" FROM {$configFile->variable['sb_stat_visitor']} V " .
		" WHERE V.robot!=1 ".
		" GROUP BY LEFT(V.visit_time, 10) " .
		" ORDER BY day ";
$database->exec($sql, __FILE__, __LINE__);
$arr3 = $database->arr();


foreach($arr3 as $key => $val){
	echo "{$val['day']},".($arr2[$val['day']]*100/$val['cnt'])."\r\n";
}

?>
<?php
exit;
?>