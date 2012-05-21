<?php
/*
 * Created on 2008.02.28
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

//$mod_info = $this->main_object->get("pages", "module_info");
//if($mod_info['xml_settings']['generate_url']['value']==1){
//	$v['require'] = 0;
//	$v['editorship'] = 0;
//	if($this->elements['isNew']['value']==1){
//		$v['value'] = '/';
//	}
//}

if($this->elements['generate_header_title']['value']==1 || $this->elements['isNew']['value']==1){
	$v['editorship'] = 0;
}else{
	$v['editorship'] = 1;
}

if($this->elements['isNew']['value']==1 && strlen($v['value'])>0 && $this->elements['generate_header_title']['value']==0){
	$v['editorship'] = 1;
}

if($this->elements['isNew']['value']==1 && strlen($v['value'])==0){
	$v['value'] = '';
}

//if($this->xml_config['lng_in_url']==1) $v['value'] = $_SESSION['site_lng'].$v['value'];

?>