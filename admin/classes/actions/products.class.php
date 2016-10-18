<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_products extends actions {

    function __construct() {
    	
    	parent::__construct("products");
    	
    	//$this->mod_actions = array('edit'=>array(), 'translate'=>array(), 'module'=>array(), 'modif'=>array('title'=>array('lt'=>'Modifikacijos','en'=>'modifications'),'img'=>'modif'), 'recommend'=>array('title'=>array('lt'=>'Priskirtos','en'=>'Related'),'img'=>'export'), 'storage'=>array('title'=>array('lt'=>'Sandėlis','en'=>'Storage'),'img'=>'modif'), 'new'=>array(), 'pdf'=>array(), 'delete'=>array());

        $this->add("fields", array(
                                    'img'=>'fields',
                                    'name'=>'fields',
                                    'hide_when_zero'=>true,
                                    'title'=>cms::$phrases['products']['context_menu']['fields_title'],
                                    'action'=>"javascript: void(\$NAV.open_dialog('products_fields_values', '?module=products_fields_values&method=edit&id={id}&no_tree_reload=1&json=0', 'Edit item'));"
                                    ),
                                    2
        );        
        $this->add("modif", array(
                                    'img'=>'flag3',
                                    'name'=>'modif',
                                    'hide_when_zero'=>true,
                                    'title'=>cms::$phrases['products']['context_menu']['modif_title'],
                                    'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'modif', '{id}'));"
                                    ),
                                    3
        );        
        
//        $this->add("related", array(
//                                    'img'=>'flag2',
//                                    'name'=>'related',
//                                    'title'=>cms::$phrases['products']['context_menu']['related_title'],
//                                    'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'related', '{id}'));"
//                                    ),
//                                    2
//        );		
//        $this->add("modif", array(
//                                    'img'=>'modif',
//                                    'name'=>'modif',
//                                    'title'=>cms::$phrases['products']['context_menu']['modif_title'],
//                                    'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'modif', '{id}'));"
//                                    ),
//                                    3
//        );		
//        $this->add("discount", array(
//                                    'img'=>'star2',
//                                    'name'=>'discount',
//                                    'title'=>cms::$phrases['products']['context_menu']['discount_title'],
//                                    'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'discount', '{id}'));"
//                                    ),
//                                    4
//        );		
    	    	
    }
    
    function getContextMenu($item){
        if($item['module_id'] == 81){
            $context = array();
            $context[] = array(
                    'img'=>'app3', 
                    'name'=>'category', 
                    'title'=>cms::$phrases['products']['context_menu']['category_title'], 
                    'action'=>"javascript: void(\$NAV.get('?module=products&cid=" . $item['id'] . "'));", 
                    'main_action'=>"javascript: void(\$NAV.get('?module=products&cid=" . $item['id'] . "'));"
            );
            if($item['id'] != Config::$val['product_page'][$this->mod->language]){
                $context[] = array(
                        'img'=>'fields', 
                        'name'=>'filters', 
                        'title'=>cms::$phrases['products']['context_menu']['fields_title'], 
                        'action'=>"javascript: void(\$NAV.get('?module=products&method=filters&column=category_id&cid=" . $item['id'] . "'));", 
                        'main_action'=>"javascript: void(\$NAV.get('?module=products&method=filters&column=category_id&cid=" . $item['id'] . "'));"
                );
                $context[] = array(
                        'img'=>'plus', 
                        'name'=>'category_insert', 
                        'title'=>cms::$phrases['products']['context_menu']['category_item_insert'], 
                        'action'=>"javascript: void(\$NAV.get('?module=products&method=new_item&cid=" . $item['id'] . "'));", 
                        'main_action'=>"javascript: void(\$NAV.get('?module=products&method=new_item&cid=" . $item['id'] . "'));"
                );
            }
            return $context;
        }else{
            return parent::getContextMenu($item);
        }
    }
    
	
	function _recommend(){
    	global $easy_tpl, $cms_phrases, $module, $denied_save;

		$easy_tpl->setFile(MODULESDIR.$_GET['content']."/templates/action/block.tpl");
		
		include_once(CLASSDIR."forms.class.php");
		$form = new forms();
		$form->formName = 'EDIT';
		$form->debug = 0;
		
		$EDIT_FORM = true;
		
		$pr_obj = $this->registry->model->create("products");
		
		$pr_data = $this->registry->model->call("products", "loadItem", array($_GET['id']));
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