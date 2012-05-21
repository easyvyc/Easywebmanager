<?php
/*
 * Created on 2008.04.23
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */



$record = $main_object->create("grafikai");
$cs_record = $main_object->create("country_stats");


$record->sqlQueryWhere = " R.is_category=1 AND T.category_column='{$_GET['column']}' AND T.category_id={$_GET['id']} AND ";
$list = $record->listSearchItems();


$record->fields = " DISTINCT R.id, FY.value AS year_val, FQ.value AS quarter_val, FM.value AS month_val, ";
$record->sqlQueryWhere = " R.is_category=0 AND R.parent_id={$list[0]['id']} AND ";
$record->sqlQueryOrder = " ORDER BY FY.value ASC, FQ.value ASC, FM.value ASC ";
$record->sqlQueryJoins .= " LEFT JOIN {$configFile->variable['pr_code']}_filters FY ON (T.metai=FY.record_id AND FY.lng='lt') ";
$record->sqlQueryJoins .= " LEFT JOIN {$configFile->variable['pr_code']}_filters FQ ON (T.ketvirtis=FQ.record_id AND FQ.lng='lt') ";
$record->sqlQueryJoins .= " LEFT JOIN {$configFile->variable['pr_code']}_filters FM ON (T.menuo=FM.record_id AND FM.lng='lt') ";
$arr = $record->listSearchItems();
//pae($arr);

foreach($arr as $key => $val){
	$month = ($cs_record->_table_fields[$_GET['column']]['list_values']['period']=='M'?$val['month_val']:$val['quarter_val']*3-2);
	if(strlen($val['month_val'])==0 && strlen($val['quarter_val'])==0) $month = "01";
	echo "{$val['metai']}-".(strlen($month)==1?"0".$month:$month)."-01,{$val['title']}\r\n";
}


//echo $xml;

exit;

?>
