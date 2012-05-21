<?php
/*
 * Created on 2007.2.5
 * servicses.php
 * Vytautas
 */

include_once(CLASSDIR."module.class.php");
include_once(CLASSDIR."catalog.class.php");
include_once(CLASSDIR."forms.class.php");
include_once(CLASSDIR."files.class.php");

$return_array = array(	
						'value'=>true,
						'error'=> & $database->errorNumber, 
						'error_message'=> & $database->errorMessage 
				);


$RECORD_TABLE_FIELDS = array('id', 'module_id', 'parent_id', 'is_category', 'create_by_ip', 'create_by_admin', 'create_date', 'last_modif_by_ip', 'last_modif_by_admin', 'last_modif_date', 'trash');


function getUser($login, $pass, $module_id){

	$soap_users_obj = new catalog("soap_users");
	$soap_users_obj->sqlQueryWhere = " T.loginname='$login' AND T.userpass='$pass' AND " .
	" (T.modules LIKE '$module_id::%' OR T.modules LIKE '%::$module_id::%' OR T.modules LIKE '%::$module_id' OR T.modules LIKE '$module_id') AND ";
	$list = $soap_users_obj->listSearchItems();
	if(!empty($list)){
		return $list[0];
	}else{
		return false;
	}

}


function saveItem($login, $pass, $module, $data_array){
	
	//global $record;
	$GLOBALS['record'] = new catalog($module);
	$GLOBALS['record']->getTableFields(0);
	$file_obj = & new files();
	$forms_obj = & new forms();
	
	$tmp = array();
	foreach($GLOBALS['record']->table_fields as $key=>$val){
		foreach($data_array as $k1 => $v1){
			if($val['column_name']==$v1['name']) $tmp[] = $val;
		}
	}
	$GLOBALS['record']->table_fields = $tmp;
	
	//$data = $data[0];
	foreach($data_array as $key => $val){
		$data[$val['name']] = $val['value'];
		if($val['type']=='file' || $val['type']=='image'){
			if($val['binary']!=''){
				$file_content = base64_decode($val['binary']);
				$filename = $file_obj->setFilename($data[$val['name']]);
				$handle = fopen(UPLOADDIR.$filename, "w");
				fwrite($handle, $file_content);
				fclose($handle);
				chmod(UPLOADDIR.$filename, 0777);
				$error = UPLOADDIR.$filename;
				$GLOBALS['_FILES']['file_'.$val['name']]['tmp_name'] = UPLOADDIR.$filename;
				$GLOBALS['_FILES']['file_'.$val['name']]['name'] = $filename;
				$GLOBALS['_FILES']['file_'.$val['name']]['error'] = 0;
				$GLOBALS['_FILES']['file_'.$val['name']]['size'] = filesize(UPLOADDIR.$filename);
				if($val['type']=='image'){
					$data['noresize_'.$val['name']] = 1;
					$data['small_resize_height_'.$val['name']] = 30;
					$data['small_resize_width_'.$val['name']] = 100;
					$data['big_resize_height_'.$val['name']] = 500;
					$data['big_resize_width_'.$val['name']] = 500;
				}
				$data[$val['name']] = $filename;
			}
		}
	}	
	if(!getUser($login, $pass, $GLOBALS['record']->module_info['id'])){
		$error = "Nera teisiu";
		return array($error);
	}
	if(!isset($data['isNew'])){
		$data['isNew'] = ($data['id']==0?1:0);
	}
	if(!isset($data['id']) || !is_numeric($data['id'])){
		$error = "Blogai nurodyta id";
		return array($error);
	}
	foreach(Config::$val['default_page'] as $key=>$val){
		$lang_arr[] = $key;
	}
	/*if(!isset($data['language']) || !in_array($data['language'], $lang_arr)){
		$error = "Blogai nurodyta language";
		return false;
	}*/
	if(!isset($data['is_category']) || !is_numeric($data['is_category'])){
		$error = "Blogai nurodyta is_category";
		return array($error);
	}
	
	foreach($GLOBALS['record']->table_fields as $key=>$val){
		$forms_obj->addField($val['column_name'], $val);
	}
	
	
	$forms_obj->validate(&$data);
	
	if($forms_obj->error != 1){
		$GLOBALS['record']->language = $data['language'];
		$id = $GLOBALS['record']->saveItem($data);
		$data['id'] = $id;
		$data['data_array'] = $data_array;
		//$data['files'] = $_FILES;
		//$data['form_fields'] = $forms_obj;
		//$data['table_fields'] = $GLOBALS['record']->table_fields;
	}else{
		foreach($forms_obj->elements as $key => $val){
			if($val['show_error'] == 1){
				$data['error'][$val['column_name']] = $val['error_message'];
			}
		}
	}
	
	$data['error']['__ERR__'] = $error;

	$soapval_obj = new soapval('return', 'array', $data);
	return $soapval_obj->serialize(true);
	
//	return array($data);
	
}

/*
function saveItem($login, $pass, $module, $data){
	
	$catalog_obj = & new catalog($module);
	
	$data = $data[0];
	
	if(!$soap_user = getUser($login, $pass, $catalog_obj->module_info['id'])){
		$error = "Nera teisiu";
		return false;
	}
	if(!isset($data['isNew'])){
		$data['isNew'] = ($data['id']==0?1:0);
	}
	if(!isset($data['id']) || !is_numeric($data['id'])){
		$error = "Blogai nurodyta id";
		return false;
	}
	foreach(Config::$val['default_page'] as $key=>$val){
		$lang_arr[] = $key;
	}
	if(!isset($data['language']) || !in_array($data['language'], $lang_arr)){
		$error = "Blogai nurodyta language";
		return false;
	}
	if(!isset($data['is_category']) || !is_numeric($data['is_category'])){
		$error = "Blogai nurodyta is_category";
		return false;
	}
	
	$catalog_obj->language = $data['language'];
	$catalog_obj->author['id'] = $soap_user['id'];
	$id = $catalog_obj->saveItem($data);

//	$soapval_obj = new soapval('return', 'array', $data);
//	return $soapval_obj->serialize(true);
	
	return $id;
	
}
*/

function getItem($login, $pass, $module, $lng, $id){
	
	$catalog_obj = & new catalog($module);
	if(!getUser($login, $pass, $catalog_obj->module_info['id'])){
		$error = "Nera teisiu";
		return false;
	}
	$catalog_obj->language = $lng;
	$item_data = $catalog_obj->loadItem($lng, $id);
	$soapval_obj = new soapval('return', 'array', $item_data);
	return $soapval_obj->serialize(true);

}


function getItemsList($login, $pass, $module, $lng, $parent_id, $is_category){
	
	$catalog_obj = & new catalog($module);
	if(!getUser($login, $pass, $catalog_obj->module_info['id'])){
		$error = "Nera teisiu";
		return false;
	}
	$catalog_obj->language = $lng;
	$list = $catalog_obj->listItems($parent_id, $is_category);
	
	//$soapval_obj = new soapval('return', 'array', $list);
	return $list;//$soapval_obj->serialize(true);	
	
}

/*function getItemsList($login, $pass, $module, $lng, $parent_id, $is_category){
	
	$catalog_obj = & new catalog($module);
	if(!getUser($login, $pass, $catalog_obj->module_info['id'])){
		$error = "Nera teisiu";
		return false;
	}
	$catalog_obj->language = $lng;
	$list = $catalog_obj->listItems($parent_id, $is_category);
	
	$soapval_obj = new soapval('return', 'array', $list);
	return $soapval_obj->serialize(true);	
	
}*/


function getSearchItemsList($login, $pass, $module, $lng, $search=array(), $order=array(), $group=array(), $limit=array()){
	
	global $RECORD_TABLE_FIELDS;
	
	$catalog_obj = & new catalog($module);
	if(!getUser($login, $pass, $catalog_obj->module_info['id'])){
		$error = "Nera teisiu";
		return false;
	}
	$catalog_obj->language = $lng;
	
	foreach($search as $key=>$val){
		if(in_array($key, $RECORD_TABLE_FIELDS)) $field_name = "R.$key";
		else{
			if(is_in_table_fields($key, $catalog_obj->table_fields))
				$field_name = "T.$key";
			else{
				$error = "$key : tokio laukelio nėra sistemoje";
				return false;
			}
		} 
		$val = addcslashes($val, "'");
		$catalog_obj->sqlQueryWhere .= " $field_name LIKE '%$val%' AND ";
	}
	foreach($order as $key=>$val){
		if(in_array($key, $RECORD_TABLE_FIELDS)) $field_name = "R.$key";
		else{
			if(is_in_table_fields($key, $catalog_obj->table_fields))
				$field_name = "T.$key";
			else{
				$error = "$key : tokio laukelio nėra sistemoje";
				return false;
			}
		}
		if($val=='ASC' || $val=='DESC'){
			 $order_arr[] = " $field_name $val ";
		}else{
			$error = "$val : netinkama reikšmė, gali būti 'ASC' arba 'DESC'";
			return false;
		}
	}
	if(!empty($order_arr)) $catalog_obj->sqlQueryOrder = implode(", ", $order_arr);
	
	foreach($group as $val){
		if(in_array($val, $RECORD_TABLE_FIELDS)) $field_name = "R.$val";
		else{
			if(is_in_table_fields($val, $catalog_obj->table_fields))
				$field_name = "T.$val";
			else{
				$error = "$val : tokio laukelio nėra sistemoje";
				return false;
			}
		}
		$group_arr[] = " $field_name ";
	}
	if(!empty($order_arr)) $catalog_obj->sqlQueryOrder = " ORDER BY ".implode(", ", $order_arr);
	if(!empty($group_arr)) $catalog_obj->sqlQueryGroup = " GROUP BY ".implode(", ", $group_arr);
	
	if(!empty($limit)){
		if(is_numeric($limit[0]) && is_unmeric($limit[1]) && $limit[0]>=0 && $limit[1]>0){
			$catalog_obj->sqlQueryLimit = " LIMIT {$limit[0]}, {$limit[1]} ";
		}else{
				$error = "limit reikšmės turi būti teigiami skaičiai";
				return false;
		}
	}
	
	$list = $catalog_obj->listSearchItems();
	
	$soapval_obj = new soapval('return', 'array', $list);
	return $soapval_obj->serialize(true);	
	
}


function getFields($login, $pass, $module){
	
	
	
}

function getModules($login, $pass){
	
	
	
}


?>
