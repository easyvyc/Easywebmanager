<?php
/*
 * Created on 2007.12.17
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


if(is_numeric($_GET['module_id'])){
	
	include_once(CLASSDIR."module.class.php");
	$mod_obj = & new module();
	$list = $mod_obj->listColumns($_GET['module_id']);
	
	foreach($list as $key=>$val){
		
		$html_value .= "<div class=\"formElementsFieldWYSIWYG\">{tpl.{$val['column_name']}}</div>";
		
	}
	
}

echo $html_value;
exit;

?>