<?php
/*
 * Created on 2009.02.23
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

if($this->elements['generate_description']['value']==1 || $this->elements['isNew']['value']==1){
	$v['editorship'] = 0;
}else{
	$v['editorship'] = 1;
}

if($this->elements['isNew']['value']==1 && strlen($v['value'])>0 && $this->elements['generate_description']['value']==0){
	$v['editorship'] = 1;
}

if($this->elements['isNew']['value']==1 && strlen($v['value'])==0){
	$v['value'] = '';
}

?>