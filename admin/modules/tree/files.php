<?php
/*
 * Created on 2009.03.09
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
//error_reporting(E_ALL);
include_once(CLASSDIR."tpl.class.php");

if(!isset($_SESSION['admin']['permission'])) exit;

include_once(CLASSDIR."filemanager.class.php");
$filemanager_obj = new filemanager();


if(isset($_GET['action'])){
	
	if($_GET['action']=='delete' && isset($_GET['deletefolder'])){
		$filemanager_obj->removeDir($_GET['deletefolder']."/");
	}
	
	if($_GET['action']=='edit' && isset($_GET['editfolder'])){
		if($_GET['fid']==0){
			mkdir($filemanager_obj->dir.$_GET['editfolder']."/".$_GET['newname']);
			chmod($filemanager_obj->dir.$_GET['editfolder']."/".$_GET['newname'], 0777);
		}else{
			$arr = explode("/", $_GET['editfolder']);
			$arr[count($arr)-1] = $_GET['newname'];
			$new_name = implode("/", $arr);
			rename($filemanager_obj->dir.$_GET['editfolder'], $filemanager_obj->dir.$new_name);
		}
	}

	/*if($_GET['action']=='drag'){

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
		
	}*/

	
}

//$path = $record->getPath($id);

$tpl_file = MODULESDIR."tree/templates/filemanager_tree.tpl";

function _itemsTree($main_dir, $current_folder="", $level=0){
	
	global $filemanager_obj, $configFile, $tpl_file, $path, $cms_phrases;
	
	$level++;
	$list_ = $filemanager_obj->listFolders($main_dir.$current_folder, $level);
	$n = count($list_);
	for($j=0, $i=0; $j<$n; $j++){
		
		if($level==1 && $main_dir.$current_folder.$list_[$j]['title']."/"!=$filemanager_obj->dir."Main/") {
			continue;
		}
		$list[$i] = $list_[$j];
		
		$tpl_sub  = & new template($tpl_file);
		
		$tpl_sub->setVar('config', $configFile->variable);
		$tpl_sub->setVar('phrases', $cms_phrases);
		$tpl_sub->setVar('mod', array('table_name'=>'files', 'id'=>0));
		$tpl_sub->setVar('lng', $_SESSION['site_lng']);
		$tpl_sub->setVar('get', $_GET);
		
		$sub = _itemsTree($main_dir, $current_folder.$list[$i]['title']."/", $level); 
		$item_in_path = false;
		/*foreach($record->path as $key=>$val){
			if($val['id']==$list[$i]['id']) $item_in_path = true; 
		}*/
		$list[$i]['display'] = ($level==1?1:0);
		
		$list[$i]['path'] = urlencode($current_folder.$list[$i]['title']);
		$list[$i]['id'] = str2ascii($current_folder.$list[$i]['title']);
		//$list[$i]['id'] = $level.(strlen($i)==2?$i:"0".$i);
		
		$tpl_sub->setVar('data', $list[$i]);
		$tpl_sub->setLoop('items', $sub);
		$list[$i]['submenu'] = $tpl_sub->parse();
		
		//$list[$i]['sub_count'] = count($sub);
		//if($list[$i]['sub_count']>20) $list[$i]['items_paging'] = 1;
		
		$list[$i]['ico'] = 'blank';
		if(!empty($sub)){
			$list[$i]['sub'] = 1;
			if($list[$i]['display']==1)
				$list[$i]['ico'] = 'minus';
			else
				$list[$i]['ico'] = 'plus';
		} 
		
		$list[$i]['img'] = 'folder';
		/*if($list[$i]['prm'] == 1){
			$list[$i]['img'] = 'leaf_secure';
		}
		if($list[$i]['active']!=1){

			if($list[$i]['prm'] == 1){
				$list[$i]['img'] = 'secure_disabled';
			}else{
				$list[$i]['img'] = 'disabled';
			}

		}*/
		
		//echo $list[$i]['title']."<br>";
		//$list[$i]['title'] = iconv("windows-1257", "UTF-8", $list[$i]['title']);
		//echo $list[$i]['title']."<br>";
		
		$list[$i]['a'] = ($_GET['id']==$list[$i]['id']?1:0);
		$CONTENT = 'files';
		//$list[$i]['main_action'] = "main.php?content=$CONTENT&page=files&path={$list[$i]['title']}";	
		//$list[$i]['action'] = "main.php?content=$CONTENT&page=files&path={$list[$i]['title']}";
		
		
		$list[$i]['context'][] = array("action"=>"javascript: parent.frmResourcesList.location='main.php?content=filemanager&page=files&path={$list[$i]['path']}';", "img"=>"preview", "title"=>$cms_phrases['modules']['context_menu']['show']);
		$list[$i]['context'][] = array("action"=>"javascript: editTreeItem('{$list[$i]['path']}', '{$list[$i]['id']}');", "img"=>"edit", "title"=>$cms_phrases['modules']['context_menu']['edit']);
		$list[$i]['context'][] = array("action"=>"javascript: createTreeItem('{$list[$i]['path']}', '{$list[$i]['id']}');", "img"=>"new_element", "title"=>$cms_phrases['modules']['context_menu']['create_inner']);
		if($level>1){
			$list[$i]['context'][] = array("action"=>"javascript: if(confirm('{$cms_phrases['modules']['context_menu']['delete_confirm']}')) deleteTreeItem('{$list[$i]['path']}');", "img"=>"delete", "title"=>$cms_phrases['modules']['context_menu']['delete']);
		}
		
		if(!empty($list[$i]['context'])){
			$list[$i]['context_menu'] = 1;
		}

		$list[$i]['drop_inner'] = 0;
		$list[$i]['level'] = $level;
		
		$i++;
		
	}
	
	return $list;
	
}


$tpl = & new template($tpl_file);

$tpl->setVar('data', array('id'=>0, 'display'=>'block'));
$items = _itemsTree(FILESDIR);
//pae($items);
$tpl->setLoop('items', $items);

$tpl->setVar('config', $configFile->variable);
$tpl->setVar('mod', array('table_name'=>'files', 'id'=>0));
$tpl->setVar('lng', $_SESSION['site_lng']);
$tpl->setVar('get', $_GET);

echo $tpl->parse();

?>