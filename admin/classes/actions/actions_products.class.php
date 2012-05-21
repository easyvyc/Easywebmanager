<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_products extends actions {

    function __construct() {
    	
    	parent::__construct();
    	
    	$this->mod_actions = array('edit'=>array(), 'translate'=>array(), 'module'=>array(), 'modif'=>array('title'=>array('lt'=>'Modifikacijos','en'=>'modifications'),'img'=>'modif'), 'recommend'=>array('title'=>array('lt'=>'Priskirtos','en'=>'Related'),'img'=>'export'), 'storage'=>array('title'=>array('lt'=>'Sandėlis','en'=>'Storage'),'img'=>'modif'), 'new'=>array(), 'pdf'=>array(), 'delete'=>array());
    	    	
    }
    
    function _storage(){

    	global $easy_tpl, $cms_phrases, $module, $denied_save;
		
		if(!empty($_POST) && isset($_POST['action'])){
			if(is_numeric($_POST['kiekis'])){
				$res = $this->registry->modules->call("storage", "change", array($_POST['item_id'], $_POST['kombinacija'], $_POST['kiekis'], $_POST['action']));
				$new_count = $this->registry->modules->call("storage", "loadItem", array($_POST['item_id'], $_POST['kombinacija']));
				if($res){
					echo "<script type=\"text/javascript\">" .
						"parent.document.getElementById('item___kiekis___{$_POST['kombinacija']}').innerHTML='$new_count';" .
						"parent.closeItemCombination_kiekis();" .
						"</script>";
				}else{
					echo "<script type=\"text/javascript\">" .
						"parent.closeItemCombination_kiekis();" .
						"alert('{$cms_phrases['main']['products']['wrong_storage']}');" .
						"</script>";
				}
			} 
			exit;
		}
		
		$easy_tpl->setFile(MODULESDIR."extras/storage.tpl");
		
		$product_obj = $this->registry->modules->create("products");
		$modif_obj = $this->registry->modules->create("products_modif");
		$record_modifications = $this->registry->modules->create("modifications");
		$storage_obj = $this->registry->modules->create("storage");
		
		$item_data = $product_obj->loadItem($_GET['id']);
		$modif_data = $modif_obj->loadItem($_GET['id']);
		
		$fields_list = $record_modifications->getFields($item_data['category']);
		
		// Jei nera prekiu modifikaciju
		if(empty($fields_list)){

			$arr = array();
			$arr['title'] = $cms_phrases['main']['products']['items_count'];
			$arr['id'] = $arr['kombinacija'] = "0";
			$arr['kiekis'] = $this->registry->modules->call("storage", "loadItem", array($_GET['id'], "0"));
			$arr['context'][] = array('action'=>"showItemCombination_kiekis(\'{$_GET['id']}\', \'{$arr['kombinacija']}\', \'{$arr['title']}\', \'+\')", 'title'=>'Pridėti prekių', 'img'=>'plus');
			if($arr['kiekis']>0) $arr['context'][] = array('action'=>"showItemCombination_kiekis(\'{$_GET['id']}\', \'{$arr['kombinacija']}\', \'{$arr['title']}\', \'-\')", 'title'=>'Nurašyti prekių', 'img'=>'minus');
			
			$list_items[] = $arr;
			
		}else{
			
			if($modif_data['isNew']==1){
				echo "<p>{$cms_phrases['main']['products']['no_modifications']}</p>";
				exit;
			}
			
			foreach($fields_list as $i=>$val){
				//$__modif_data[] = array('arr'=>explode("::", $modif_data[$val['column_name']]), 'field'=>$val);
				$comb[] = explode("::", $modif_data[$val['column_name']]);
				$fields_list[$i]['no_sort'] = 1;
				$fields_list[$i]['w'] = 1;
			}
			
			$combinations = combi($comb);
			
			foreach($combinations as $i=>$v1){
				$title = " - ";
				foreach($v1 as $j=>$v2){
					if(is_numeric($v2)){
						$s_val_data = $this->registry->modules->call($fields_list[$j]['list_values']['object'], "loadItem", $v2);
						$list_items[$i][$fields_list[$j]['column_name']] = $s_val_data['title'];
						$title .= $s_val_data['title']." - ";
					} 
				}
				$values_arr = $v1;
				sort($values_arr);
				$list_items[$i]['title'] = $title;
				$list_items[$i]['id'] = $list_items[$i]['kombinacija'] = implode("::", $values_arr);
				$list_items[$i]['kiekis'] = $this->registry->modules->call("storage", "loadItem", array($_GET['id'], implode("::", $values_arr)));
				$list_items[$i]['context'][] = array('action'=>"showItemCombination_kiekis(\'{$_GET['id']}\', \'{$list_items[$i]['kombinacija']}\', \'{$list_items[$i]['title']}\', \'+\')", 'title'=>'Pridėti prekių', 'img'=>'plus');
				if($list_items[$i]['kiekis']>0) $list_items[$i]['context'][] = array('action'=>"showItemCombination_kiekis(\'{$_GET['id']}\', \'{$list_items[$i]['kombinacija']}\', \'{$list_items[$i]['title']}\', \'-\')", 'title'=>'Nurašyti prekių', 'img'=>'minus');
			}
			
		}
		
		$fields_list[] = array('column_name'=>'kiekis', 'title'=>'Kiekis', 'w'=>5, 'no_sort'=>1);
		
    	global $templateVariables;
    	
    	if(isset($_POST['action']) && $_POST['action']=='paging'){
			$_GET['offset'] = 0;
			$_SESSION['order']['paging'] = $_POST['paging_items'];
		}    	
    	
		include_once(CLASSDIR."grid.class.php");
		$grid_obj = & new grid();
		$grid_obj->setTpl(DOCROOT.$this->config->variable['admin_dir']."templates/grid.tpl", "templateVariables");
		$grid_obj->setColumns($fields_list);
		
		$count = count($list_items);
		
		$grid_obj->setItems($list_items);
		$grid_obj->setItemsCount($count);
		$grid_obj->paging_items = $count;
		$grid_obj->paging(0);
		$grid_obj->pagingSelect($GLOBALS['IN_ONE_PAGE_LIST']);
		
		
		$grid_obj->grid_data['edit_button'] = 0;
		$grid_obj->grid_data['dublicate_button'] = 0;
		$grid_obj->grid_data['delete_button'] = 0;
		$grid_obj->grid_data['select_button'] = 0;
		$grid_obj->grid_data['filter_form'] = 0;
		$grid_obj->grid_data['dragndrop'] = 0;
		$grid_obj->grid_data['no_paging'] = 1;
		
		$grid_obj->grid_data['grid_name'] = 'products_storage';
		$grid_obj->grid_data['list_page'] = 'storage';
		$grid_obj->grid_data['edit_page'] = 'storage';
		
		
		$grid_obj->tpl->setVar('module', $this->module_info);
		$grid_obj->tpl->setVar('parent_id', $_GET['id']);
		
		$grid_obj->generate();
		echo "<div id='{$grid_obj->grid_data['grid_name']}_grid' style='margin:15px;'>";
		include $grid_obj->tpl->cacheFile;
		echo "</div>" .
				"<div id='storage_actions_area' style='display:none;' class='contextMenu'>" .
				"<div class='title'><table width='100%'><tr><td id='storage_title'></td><td align='right'><img src='images/close.gif' class='vam' style='cursor:pointer' onclick='javascript: closeItemCombination_kiekis();' /></td></tr></table></div>" .
				"<div class='text' style='padding:10px;'>" .
				"<form target='formSumbitFrame_storage' action=\"ajax.php?get=catalog/actions&action={$_GET['action']}&content={$_GET['content']}&module={$_GET['module']}&id={$_GET['id']}\" method=\"post\" onsubmit=\"javascript: openLoading();\">" .
				"<input type='hidden' name='item_id' value='{$_GET['id']}'>" .
				"<input type='hidden' name='kombinacija' id='storage_kombinacija' value=''>" .
				"<input type='hidden' name='action' id='storage_action' value=''>" .
				"Kiekis: <span id='storage_action_title'></span><input type='text' name='kiekis' value='' class='fo_text vam' style='width:80px;'> <input type='submit' class='fo_submit vam' value='  ok  ' />" .
				"</form>" .
				"<iframe src=\"\" name=\"formSumbitFrame_storage\" style=\"display:none;\" onload=\"javascript: closeLoading();\" width=\"100%\" height=\"250\"></iframe>" .
				"</div>" .
				"</div>";
		exit;
		
		
		$easy_tpl->setVar('config', $configFile->variable);
		$easy_tpl->setVar('get', $_GET);
		$easy_tpl->setVar('module', $record->module_info);
		$easy_tpl->setVar('phrases', $cms_phrases['main']);
		    	
    }
    
	function _module(){
    	global $easy_tpl, $cms_phrases, $module, $denied_save;

		$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/block.tpl");
		
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		$form->formName = 'EDIT';
		$form->debug = 0;
		
		$product_obj = $this->registry->modules->create("products");
		$record = $this->registry->modules->create("products_fields");
		$record_fields = $this->registry->modules->create("fields");
		//$record_modifications = $this->registry->modules->create("modif");
		
		$item_data = $product_obj->loadItem($_GET['id']);
		$fields_list = $record_fields->getFields($item_data['category']);
		$record->setTableFields($fields_list);
		
		$pr_data = $record->loadItem($_GET['id']);
		
		
		$EDIT_FORM = true;
		
		$n = count($fields_list);
		for($i=0; $i<$n; $i++){
		    $form->addField($fields_list[$i]['column_name'], $fields_list[$i]);
		}
		
		
		$m = count($fields_list);
		for($j=0; $j<$m; $j++){
		    $fields_list[$j]['value'] = ($pr_data['isNew']==1 && !isset($_GET['duplicate']))?$form->elements[$fields_list[$j]['column_name']]['default_value']:$pr_data[$fields_list[$j]['column_name']];
		  	$fields_list[$j]['name'] = $fields_list[$j]['column_name'];
		  	
		  	$form->editField($fields_list[$j]['column_name'], $fields_list[$j]);
		}
		$form->addField("submit", array('elm_type'=>FRM_SUBMIT, "title"=>"Saugoti"));
		
		$form->formHTML = $record->module_info['area_html'];
		
		if(!empty($_POST)){
			if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
			    
			    $form->validate($_POST);
			    
			    if($form->error!=1){
				   
				    $rid = $record->saveItem($_POST);
		
			    }else{
			    	$_POST = $form->elements;
			    }
			    
			}
			$lng = $_POST['language'];
		}
		  
		
		$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');
		
		
		$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
		$form->addField("id", array('elm_type'=>FRM_HIDDEN, "value"=>$_GET['id']));
		$form->addField("isNew", array('elm_type'=>FRM_HIDDEN, "value"=>$pr_data['isNew']));
		$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));
		
		$form->formAction = "ajax.php?get=catalog/actions&action={$_GET['action']}&content={$_GET['content']}&module={$_GET['module']}&id={$_GET['id']}";	
		
		if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
			header("Content-Type: text/html; charset=utf-8");
			if($form->error!=1){
				$easy_tpl->setVar('success', 1);
			}else{
				$form_data = $form->construct_form();
			}
		}else{
			$form_data = $form->construct_form();
		}
		
		echo "<div style='display:none'>$form->create_in_iframe</div>";
		//echo $form_data; exit;
		
		$easy_tpl->setVar('form', $form_data);
		
		$easy_tpl->setVar('data', $item_data);
		
		$easy_tpl->setVar('config', $configFile->variable);
		$easy_tpl->setVar('get', $_GET);
		$easy_tpl->setVar('module', $record->module_info);
		$easy_tpl->setVar('phrases', $cms_phrases['main']);
		$easy_tpl->setVar('form_name', $form->formName);

	}


	function _modif(){
    	global $easy_tpl, $cms_phrases, $module, $denied_save;

		$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/block.tpl");
		
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		$form->formName = 'EDIT';
		$form->debug = 0;
		
		$product_obj = $this->registry->modules->create("products");
		$record = $this->registry->modules->create("products_modif");
		//$record_fields = $this->registry->modules->create("fields");
		$record_modifications = $this->registry->modules->create("modifications");
		
		$item_data = $product_obj->loadItem($_GET['id']);
		$pr_data = $record->loadItem($_GET['id']);
		
		$EDIT_FORM = true;
		
		$fields_list = $record_modifications->getFields($item_data['category']);
		//pae($fields_list);
		$n = count($fields_list);
		for($i=0; $i<$n; $i++){
		    $form->addField($fields_list[$i]['column_name'], $fields_list[$i]);
		}
		
		$m = count($fields_list);
		for($j=0; $j<$m; $j++){
		    $fields_list[$j]['value'] = ($pr_data['isNew']==1 && !isset($_GET['duplicate']))?$form->elements[$fields_list[$j]['column_name']]['default_value']:$pr_data[$fields_list[$j]['column_name']];
		  	$fields_list[$j]['name'] = $fields_list[$j]['column_name'];
		  	
		  	$form->editField($fields_list[$j]['column_name'], $fields_list[$j]);
		}		
		
		$form->addField("submit", array('elm_type'=>FRM_SUBMIT, "title"=>"Saugoti"));
		
		$form->formHTML = $record->module_info['area_html'];
		
		if(!empty($_POST)){
			if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
			    
			    $form->validate($_POST);
			    
			    if($form->error!=1){
				   
				    $rid = $record->saveItem($_POST);
		
			    }else{
			    	$_POST = $form->elements;
			    }
			    
			}
			$lng = $_POST['language'];
		}
		  
		
		$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');
		
		
		$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
		$form->addField("id", array('elm_type'=>FRM_HIDDEN, "value"=>$_GET['id']));
		$form->addField("isNew", array('elm_type'=>FRM_HIDDEN, "value"=>$pr_data['isNew']));
		$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));
		
		$form->formAction = "ajax.php?get=catalog/actions&action={$_GET['action']}&content={$_GET['content']}&module={$_GET['module']}&id={$_GET['id']}";	
		
		if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
			header("Content-Type: text/html; charset=utf-8");
			if($form->error!=1){
				$easy_tpl->setVar('success', 1);
			}else{
				$form_data = $form->construct_form();
			}
		}else{
			$form_data = $form->construct_form();
		}
		
		echo "<div style='display:none'>$form->create_in_iframe</div>";
		//echo $form_data; exit;
		
		$easy_tpl->setVar('form', $form_data);
		
		$easy_tpl->setVar('data', $item_data);
		
		$easy_tpl->setVar('config', $configFile->variable);
		$easy_tpl->setVar('get', $_GET);
		$easy_tpl->setVar('module', $record->module_info);
		$easy_tpl->setVar('phrases', $cms_phrases['main']);
		$easy_tpl->setVar('form_name', $form->formName);

	}    
	
	function _recommend(){
    	global $easy_tpl, $cms_phrases, $module, $denied_save;

		$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/block.tpl");
		
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		$form->formName = 'EDIT';
		$form->debug = 0;
		
		$EDIT_FORM = true;
		
		$pr_obj = $this->registry->modules->create("products");
		
		$pr_data = $this->registry->modules->call("products", "loadItem", array($_GET['id']));
		//pae($pr_data);
		$form->addField("recommend", array('elm_type'=>FRM_AUTOCOMPLETE, "value"=>$pr_data['recommend'], "title"=>"Rekomenduojamų prekių sąrašas", "extra_params"=>"multiple", "list_values"=>array("module"=>"products", "columns"=>"id,title,short_description"), "extra_data"=>""));
		
		$form->addField("submit", array('elm_type'=>FRM_SUBMIT, "title"=>"Saugoti"));
		
		$form->formHTML = $record->module_info['area_html'];
		
		if(!empty($_POST)){
			
			if(isset($_POST['action']) && $_POST['action']=='save' && $denied_save!=1){
			    
			    $form->validate($_POST);
			    
			    if($form->error!=1){
				   
				    $sql = "UPDATE $pr_obj->table SET recommend='{$_POST['recommend']}' WHERE record_id={$_GET['id']}";
				    $pr_obj->db->exec($sql);
		
			    }else{
			    	$_POST = $form->elements;
			    }
			    
			}
			$lng = $_POST['language'];
		}
		  
		
		$arr = array('title'=>'&lt; EMPTY &gt;', 'id'=>'NULL');
		
		
		$form->addField("action", array('type'=>'hidden', 'value'=>'save'));
		$form->addField("id", array('elm_type'=>FRM_HIDDEN, "value"=>$_GET['id']));
		$form->addField("isNew", array('elm_type'=>FRM_HIDDEN, "value"=>0));
		$form->addField("language", array('type'=>'hidden', 'value'=>$_SESSION['site_lng']));
		
		$form->formAction = "ajax.php?get=catalog/actions&action={$_GET['action']}&content={$_GET['content']}&module={$_GET['module']}&id={$_GET['id']}";	
		
		if($form->create_in_iframe==1 && isset($_POST['action']) && $_POST['action']=='save'){
			header("Content-Type: text/html; charset=utf-8");
			if($form->error!=1){
				$easy_tpl->setVar('success', 1);
			}else{
				$form_data = $form->construct_form();
			}
		}else{
			$form_data = $form->construct_form();
		}
		
		echo "<div style='display:none'>$form->create_in_iframe</div>";
		//echo $form_data; exit;
		
		$easy_tpl->setVar('form', $form_data);
		
		$easy_tpl->setVar('data', $item_data);
		
		$easy_tpl->setVar('config', $configFile->variable);
		$easy_tpl->setVar('get', $_GET);
		$easy_tpl->setVar('module', $record->module_info);
		$easy_tpl->setVar('phrases', $cms_phrases['main']);
		$easy_tpl->setVar('form_name', $form->formName);

	}	
	
    
}

?>