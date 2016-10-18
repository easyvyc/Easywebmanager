<?php

include_once(APP_CLASSDIR."model.class.php");
class model_pages extends model {
	
	function __construct(){
		
		parent::__construct("pages");
		
                load_helpers("url");
                
		$this->table_text = Config::$val['sb_text'];
		$this->table_tpl = Config::$val['sb_template'];
		
	}
	
/*
 * OLD methods
 */
	
	function loadItem($id){
		$data = record::loadItem($id);
		//$data['page_url'] = $data['page_url'];
		return $data;
	}
	
	function loadList($parent_id = 0){
		return $this->listAdminRights(Config::$val['sb_admin_pages_rights'], $_SESSION['admin']['id'], $parent_id);
	}
	
	function getModulePageId($lng_id, $module){
		$path = $GLOBALS['id_path'];
		$sql = "SELECT P.id FROM $this->table_tpl T " .
				"LEFT JOIN $this->table P " .
				"ON (T.id=P.template) " .
				"WHERE T.name='$module'";
		$ids = $this->db->query($sql)->result_array();
		$n = count($ids);
		for($i=0; $i<$n; $i++){
			$this->getPath($ids[$i]['id']);
			if($GLOBALS['id_path'][0]['id']==$lng_id){
				return $ids[$i]['id'];
			}
		}
	}
	
	function loadTree($id){
		$arr = $this->loadBy(array('parent_id' => $id));
		$n = count($arr);
		for($i=0; $i<$n; $i++){
                    $arr[$i]['sub'] = $this->loadTree($arr[$i]['id']);
                    $tree[] = $arr[$i];
		}
		return $tree;
	}

	function saveItem($data){
		
		if($data['isNew'] != 1){
			$sql = "SELECT page_url FROM $this->table WHERE record_id={$data['id']} AND lng='$this->language'";
			$row = $this->db->query($sql)->row_array();
			$old_link = $row['page_url'];
		}
		
		//$data['page_url'] = substr($data['page_url'], 2);
		
		if($data['generate_page_title']==1){
			$data['page_title'] = $data['title'];
		}
		if($data['generate_header_title']==1){
			$data['header_title'] = $data['title'];
		}

		$id = record::saveItem($data);
		
		/*
		pa($data);
		$this->loadItem($id);
		pae($this->data);
		*/
		
		if($data['generate_url']==1){

			if(isset($data['isNew']) && $data['isNew']==1){
				$title = $data['title'];
				$page_url = $this->generateUrl($id, $title)."/";
				$sql = "UPDATE $this->table SET page_url='$page_url' WHERE record_id=$id";
				$this->db->query($sql);
				$data['page_url'] = $page_url;
			}else{
				$title = $data['title'];
				$page_url = $this->generateUrl($data['id'], $title)."/";
				$sql = "UPDATE $this->table SET page_url='$page_url' WHERE record_id=$id AND lng='$this->language'";
				$this->db->query($sql);
				$data['page_url'] = $page_url;
			}
		}
		
		/*// reikia persaugot i kitoki URL kitose kalbose
		if($data['isNew'] != 1){
			foreach(){
				
			}
		}else{
		// persaugot vidiniu puslapiu url
			$this->replaceInnerPageUrls($data['id'], $old_link, $data['page_url']);
		}*/
		
		// sukeisti visas senas nuoroda naujomis
		if($data['isNew'] != 1 && $data['page_url'] != "" && $data['parent_id'] != 0){
			$this->replaceOldLinks($this->language . $old_link, $this->language . $data['page_url']);
		}
		//pae($data);
	
		//if($this->xml_config['toggler']==1) $this->generateSEO($data);
		
		return $id;
		
	}
	
	function replaceOldLinks($old_link, $new_link){
		if($old_link != $new_link){
			$mod_list = $this->module->listModules();
			foreach($mod_list as $val){
				$table_fields = $this->module->listColumns($val['id']);
				foreach($table_fields as $t_val){
					if($t_val['elm_type'] == FRM_HTML){
						$sql = "UPDATE ".Config::$val['pr_code']."_{$val['table_name']} SET {$t_val['column_name']}=REPLACE({$t_val['column_name']}, '$old_link', '$new_link')";
						$this->db->query($sql);
					}
				}
			}
		}
	}
	
	function generateUrl($page_id, $title) {
		
		if ($page_id != '' && $page_id != 0) {

			$page_data = record::loadItem($page_id);
			$parent_id = $page_data['parent_id'];

			$url = url_slug($title);
			$page_data = record::loadItem($parent_id);
			$parent_url = (substr($page_data['page_url'], strlen($page_data['page_url'])-1)=="/"?$page_data['page_url']:$page_data['page_url']."/");
			//$title = $page_data['title'];
			$url = ($page_data['parent_id']!=0?$parent_url:"/").$url;
			$url = $this->checkUrl($url, $page_id);

		}
		return $url;
		
	}
	
	function checkUrl($url, $id=0){
		$sql = "SELECT id FROM $this->table WHERE page_url='$url/' AND record_id!=$id AND lng='$this->language'";
		if($this->db->query($sql)->num_rows() > 0){
			$url .= "_";
			$url = $this->checkUrl($url, $id);
		}
		else
			return $url;
		
		return $url;
	}
	
	///// TEMPLATES
	function deleteTemplate($tplID){
		$sql = "DELETE FROM $this->table_tpl WHERE id=$tplID";
		$this->db->query($sql);
	}

	function statusTemplate($tplID){
		$sql = "UPDATE $this->table_tpl SET disabled=IF(disabled=1, 0, 1) WHERE id=$tplID";
		$this->db->query($sql);
	}
	
	function getTemplatesList(){
		$sql = "SELECT id, CONCAT(id, ' - ', name) AS title, IF(disabled=1, 0, 1) AS active, name, defaultas, 1 AS editorship FROM $this->table_tpl";
		$arr = $this->db->query($sql)->result_array();
		return $arr;
	}

	function getTemplatesList_(){
		$arr = $this->db->select($this->table_tpl)
						->fields("name AS id, CONCAT(id, ' - ', name) AS title")
						->where("disabled!=1")
						->result_array();
		return $arr;
	}

	function getTemplateById($tplID){
		$sql = "SELECT id, name, file1, tmpl_image_map, defaultas FROM $this->table_tpl WHERE id='$tplID'";
		$row = $this->db->query($sql)->row_array();
		return $row;
	}
	
	function getTemplate($tplID){
		$sql = "SELECT id, name, file1, tmpl_image_map, defaultas FROM $this->table_tpl WHERE name='$tplID'";
		$row = $this->db->query($sql)->row_array();
		return $row;
	}
	
	function saveTemplate($data){
		if(isset($data['isNew']) && $data['isNew']==1){
			$sql = "INSERT INTO $this->table_tpl SET name='{$data['name']}', file1='{$data['file1']}', tmpl_image_map='{$data['tmpl_image_map']}', defaultas='{$data['defaultas']}'";
			$this->db->query($sql);
			$data['id'] = $this->db->insert_id();
		}else{
			$sql = "UPDATE $this->table_tpl SET name='{$data['name']}', file1='{$data['file1']}', tmpl_image_map='{$data['tmpl_image_map']}', defaultas='{$data['defaultas']}' WHERE id={$data['id']}";
			$this->db->query($sql);
		}	
		if($data['defaultas']==1){
			$sql = "UPDATE $this->table_tpl SET defaultas=0 WHERE id!={$data['id']}";
			$this->db->query($sql);
		}
		return $data['id'];	
	}
	
	function generateSEO($page_data){

		if($page_data['generate_keywords']==1 || $page_data['generate_description']==1){

			$curlVar = curl_init(Config::$val['site_url'].$this->language.$page_data['page_url']);
			curl_setopt(CURLOPT_RETURNTRANSFER, 0);
			curl_exec($curlVar);
			curl_close($curlVar);
			$string = ob_get_contents();
			ob_clean();

			include_once(CLASSDIR_."seo.class.php");
			$seo_obj = new seo();

		}
		
		if($page_data['generate_keywords']==1){

			$keywords_arr = $seo_obj->getKeywords($string);
					
			$keywords = addcslashes(implode(", ", $keywords_arr), "\\'");
			
			$sql = "UPDATE $this->table SET keywords='$keywords' WHERE record_id={$page_data['id']} AND lng='$this->language'";
			$this->db->query($sql);
			
			$page_data['keywords'] = $keywords;
			
		}
		
		if($page_data['generate_description']==1){

			$description = addcslashes($seo_obj->getDescription($string, $page_data, $this->getPageBlocks($page_data['id'])), "\\'");
					
			$sql = "UPDATE $this->table SET description='$description' WHERE record_id={$page_data['id']} AND lng='$this->language'";
			$this->db->query($sql);
			
			$page_data['description'] = $description;
			
		}		
		
	}
	
	function getPageBlocks($page_id){
    	$blocks_obj = $this->registry->model->create("blocks");
    	$blocks_obj->sqlQueryWhere = " page_id=$page_id AND ";
    	$arr = $blocks_obj->listSearchItems();
    	foreach($arr as $val){
    		$blocks[] = $val['title'];
    	}
    	return $blocks;
	}
	
	function getPagesTree($id, $selected=0){
		$this->sqlQueryWhere = " R.parent_id=$id AND ";
		$list = $this->listSearchItems();
		foreach($list as $i=>$val){
			$this->sqlQueryWhere = " R.parent_id={$val['id']} AND ";
			if(isset($selected) && is_numeric($selected)) $this->fields = " IF(R.id=$selected, 1, 0) AS selected, ";
			$list[$i]['sub'] = $this->listSearchItems();
		}
		return $list;
	}
	
    function listItemsElements($category=0, $order_by='R.sort_order', $order_direction='ASC', $offset=0, $paging=30){
    	$list = record::listItemsElements($category, $order_by, $order_direction, $offset, $paging);
    	if($this->xml_config['lng_in_url']==1){
    		foreach($list as $i=>$val){
    			$list[$i]['page_url'] = $this->language . $list[$i]['page_url'];
    		}
    	}
    	//pae($list);
    	return $list;
    }
    
    function get_languages($active_lng = ''){
        $list = array();
        foreach(Config::$val['default_page'] as $lng => $page_id){
            $list[] = array('value' => $lng, 'title' => strtoupper($lng), 'selected' => ($lng == $active_lng));
        }
        return $list;
    }

}

?>
