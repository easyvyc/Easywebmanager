<?php
/*
 * Created on 2006.1.28
 * module_tree.php
 * Vytautas
 */


include_once(CLASSDIR."tpl.class.php");

if(!isset($_SESSION['admin']['permission'])) exit;
$record = $main_object->create($_GET['module']);
//$record->getTableFields(1);

$id = $_GET['id'];
if(!isset($id)) $id = 0;

if(isset($_GET['action'])){
	
	if($_GET['action']=='drag'){

		$arr = explode("_", $_GET['drag_item']);
		$drag_item_id = $arr[1];
		if(is_numeric($_GET['drag_to']) && is_numeric($drag_item_id)){
			
			$_d1 = $record->loadItem($drag_item_id);
			$record->data;
			$_d2 = $record->loadItem($_GET['drag_to']);
			$record->data;
			
			if($_d1['parent_id']!=$_d2['parent_id']){
				$record->changeParentId($drag_item_id, $_d2['parent_id']);
			}
			
			if($_d1['sort_order'] < $_d2['sort_order']){
				$sql = "SELECT R.id FROM {$record->tables['record']} R WHERE R.sort_order < {$_d2['sort_order']} AND R.parent_id={$_d2['parent_id']} ORDER BY R.sort_order DESC LIMIT 0, 1";
				$record->db->exec($sql, __FILE__, __LINE__);
				$item_2 = $record->db->row();
				$_GET['drag_to'] = $item_2['id'];
			}
			
			$record->changeOrder($drag_item_id, $_GET['drag_to']);
			
			$id = $_GET['id'] = $drag_item_id;
			
		}
		
	}

	if($_GET['action']=='parent'){

		$arr = explode("_", $_GET['drag_item']);
		$drag_item_id = $arr[1];
		if(is_numeric($_GET['drag_to']) && is_numeric($drag_item_id)){
			
			$record->changeParentId($drag_item_id, $_GET['drag_to']);
			
			$sql = "SELECT R.sort_order FROM {$record->tables['record']} R WHERE R.parent_id={$_GET['drag_to']} ORDER BY R.sort_order DESC LIMIT 0, 1";
			$record->db->exec($sql, __FILE__, __LINE__);
			$item_2 = $record->db->row();
			
			$sql = "UPDATE {$record->tables['record']} SET sort_order={$item_2['sort_order']}+1 WHERE id=$drag_item_id";
			$record->db->exec($sql, __FILE__, __LINE__);
			
			$id = $_GET['id'] = $drag_item_id;
			
		}
		
	}

	
}

$path = $record->getPath($id);

$tpl_file = MODULESDIR."tree/templates/tree.tpl";

function _itemsTree($id=0, $level=0){
	
	global $record, $configFile, $tpl_file, $path, $cms_phrases;
	
	$level++;
	$list = $record->listAdminRights($configFile->variable['sb_admin_module_rights'], $_SESSION['admin']['id'], $record->module_info['id'], $id);
	$n = count($list);
	for($i=0; $i<$n; $i++){
		
		$tpl_sub  = & new template($tpl_file);
		
		$tpl_sub->setVar('config', $configFile->variable);
		$tpl_sub->setVar('phrases', $cms_phrases);
		$tpl_sub->setVar('mod', $record->module_info);
		$tpl_sub->setVar('lng', $_SESSION['site_lng']);
		$tpl_sub->setVar('get', $_GET);
		
		$sub = _itemsTree($list[$i]['id'], $level); 
		$item_in_path = false;
		foreach($record->path as $key=>$val){
			if($val['id']==$list[$i]['id']) $item_in_path = true; 
		}
		$list[$i]['display'] = ($item_in_path?1:0);
		$tpl_sub->setVar('data', $list[$i]);
		$tpl_sub->setLoop('items', $sub);
		$list[$i]['submenu'] = $tpl_sub->parse();
		
		$list[$i]['sub_count'] = $record->getCountAdminRights($configFile->variable['sb_admin_module_rights'], $_SESSION['admin']['id'], $record->module_info['id'], $list[$i]['id']);
		if($list[$i]['sub_count']>20) $list[$i]['items_paging'] = 1;
		
		$list[$i]['ico'] = 'blank';
		if(!empty($sub)){
			$list[$i]['sub'] = 1;
			if($list[$i]['display']==1)
				$list[$i]['ico'] = 'minus';
			else
				$list[$i]['ico'] = 'plus';
		} 
		
		$list[$i]['img'] = 'leaf';
		if($list[$i]['prm'] == 1){
			$list[$i]['img'] = 'leaf_secure';
		}
		if($list[$i]['active']!=1){

			if($list[$i]['prm'] == 1){
				$list[$i]['img'] = 'secure_disabled';
			}else{
				$list[$i]['img'] = 'disabled';
			}

		}
		
		if($_SESSION['admin']['permission']==1){
			$list[$i]['title'] = $list[$i]['title']." (".$list[$i]['id'].")";
		}
		
		$list[$i]['a'] = ($_GET['id']==$list[$i]['id']?1:0);
		
		$list[$i]['context'] = $record->getContextMenu($list[$i]);
		$list[$i]['action'] = $list[$i]['context'][0]['action'];
		
		if(!empty($list[$i]['context'])){
			$list[$i]['context_menu'] = 1;
		}

		$list[$i]['drop_inner'] = ($level<$record->module_info['maxlevel']?1:0);
		$list[$i]['level'] = $level;
		
	}
	
	return $list;
	
}


$tpl = & new template($tpl_file);

$tpl->setVar('data', array('id'=>0, 'display'=>'block'));
$items = _itemsTree();
$tpl->setLoop('items', $items);

$tpl->setVar('config', $configFile->variable);
$tpl->setVar('mod', $record->module_info);
$tpl->setVar('lng', $_SESSION['site_lng']);
$tpl->setVar('get', $_GET);

echo $tpl->parse();
 
?>