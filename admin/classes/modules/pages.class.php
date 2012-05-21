<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_pages extends modules {
	
	//var $mod_actions = array('module'=>array(), 'edit'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
	
	function __construct(){
		
		parent::__construct("pages");
		
		$this->table_text = Config::$val['sb_text'];
		$this->table_tpl = Config::$val['sb_template'];
		
	}
	
	function loadItem($id){
		$data = record::loadItem($id);
		$data['page_url'] = $this->language.$data['page_url'];
		return $data;
	}
	
	function loadList($parent_id = 0){
		return $this->listAdminRights(Config::$val['sb_admin_pages_rights'], $_SESSION['admin']['id'], $parent_id);
	}
	
	function loadHTML($page_id, $area_id){
		$sql = "SELECT text FROM $this->table_text WHERE page_id=$page_id AND area=$area_id";
		$row = $this->db->query($sql)->row_array();
		return $row;
	}

	function saveHTML($page_id, $area_id, $html){
		
	    if($this->loadAdminRights($this->admin['id'], $page_id)!=1) return $page_id;
	    
		$sql = "SELECT id FROM $this->table_text WHERE page_id=$page_id AND area=$area_id";
		$row = $this->db->query($sql)->row_array();
		if(empty($row)){
			$html = stripslashes($html);
			$html = addcslashes($html, "'");
			$sql = "INSERT INTO $this->table_text SET text='$html', page_id=$page_id, area=$area_id";
			$row = $this->db->query($sql);		
		}else{
			$html = stripslashes($html);
			$html = addcslashes($html, "'");
			$sql = "UPDATE $this->table_text SET text='$html' WHERE page_id=$page_id AND area=$area_id";
			$row = $this->db->query($sql);
		}
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
	
	function loadTree($id, &$tree=array(), $level=0, $index=-1){
		$sql = "SELECT id, parent_id, title, template, page_redirect, $level AS level, 0 AS sub, module_id, disabled, page_url, last_modif_date " .
				" FROM {$this->table} WHERE parent_id=$id ORDER BY order_id";
		$arr = $this->db->query($sql)->result_array();
		$n = count($arr);
		if($index!=-1){
			$tree[$index]['sub'] = ($n>0?1:0);
			$tree[$index]['space'] = str_repeat("&nbsp;", ($level-2)*4);
			$tree[$index]['opt_space'] = str_repeat("&nbsp;", ($level-1)*6);
		}
		for($i=0; $i<$n; $i++){
			$index = count($tree);
			$tree[$index] = $arr[$i];
			$this->loadTree($arr[$i]['id'], $tree, ++$level, $index);
			--$level;
		}
		return $tree;
	}

	function saveItem($data){
		
		if($data['isNew'] != 1){
			$sql = "SELECT page_url FROM $this->table WHERE record_id={$data['id']} AND lng='$this->language'";
			$row = $this->db->query($sql)->row_array();
			$old_link = $row['page_url'];
		}
		
		$data['page_url'] = substr($data['page_url'], 2);
		
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
		
		if($data['isNew'] != 1 && $data['page_url']!="") $this->replaceOldLinks($this->language.$old_link, $this->language.$data['page_url']);
		//pae($data);
	
		if($this->xml_config['toggler']==1) $this->generateSEO($data);
		
		return $id;
		
	}
	
	function replaceOldLinks($old_link, $new_link){
		if($old_link != $new_link){
			$mod_list = $this->module->listModules();
			foreach($mod_list as $val){
				$table_fields = $this->module->listColumns($val['id']);
				foreach($table_fields as $t_val){
					if($t_val['elm_type']==FRM_HTML){
						$sql = "UPDATE ".Config::$val['pr_code']."_{$val['table_name']} SET {$t_val['column_name']}=REPLACE({$t_val['column_name']}, '$old_link', '$new_link')";
						$this->db->query($sql);
					}
				}
			}
		}
	}
	
	function replaceLetters($str) {

		$str = ereg_replace("&#39;", "'", $str);
		$str = ereg_replace("[\'\<\>\"{`\!\%\(\);\{\}\+\-\*\&\#]", "-", $str);
		$str = ereg_replace("[\-]{1,}", "-", $str);

		$search_arr = array	("#", "ą", "č", "ę", "ė", "į", "š", "ų", "ū", "ž", " ", /* LT */ 
							"й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ", "э", "ж", "д", "л", "о", "р", "п", "а", "в", "ы", "ф", "я", "ч", "с", "м", "и", "т", "ь", "б", "ю", /* Russki */
							"ī", "ņ", "ā", "ē", "ļ", "ģ", /* Latviesu */
							"ä", "ö", "ü", "õ", "å", /* Eesti Swedish Suomi */
							"ç", "ë", "í", "ñ", "é", "è", "á", "à",  
							"ć", "ł", "ń", "ó", "ś", "ź", "ż", /* Poland */
							"ß", /* Deutche unliaut */
							"æ", "ø", "ê", "ò", "â", "ô" /* Norway */
							);
							
		$replace_arr = array("-", "a", "c", "e", "e", "i", "s", "u", "u", "z", "-", 
							"j", "c", "u", "k", "e", "n", "g", "s", "t", "z", "x", "j", "e", "z", "d", "l", "o", "r", "p", "a", "v", "i", "f", "a", "h", "s", "m", "i", "t", "j", "b", "j",
							"i", "n", "a", "e", "l", "g",
							"a", "o", "u", "o", "a", /* Eesti Swedish Suomi */
							"c", "e", "i", "n", "e", "e", "a", "a",  
							"c", "l", "n", "o", "s", "z", "z", /* Poland */
							"s", /* Deutche unliaut */
							"e", "o", "e", "o", "a", "o" /* Norway */
							);

		$str = stripslashes(mb_strtolower($str, "utf-8"));
		$n = mb_strlen($str, "utf-8");
		for ($i = 0; $i < $n; $i ++) {
			$let = mb_substr($str, $i, 1, "utf-8");
			if (in_array($let, $search_arr)) {
				$key = array_search($let, $search_arr);
				$str = mb_substr($str, 0, $i, "utf-8").$replace_arr[$key].mb_substr($str, $i +1, $n - $i, "utf-8");
			}
			elseif (preg_match("/[0-9a-zA-Z_.,-]/", $let) == 0) { //neatitinka
				$str = mb_substr($str, 0, $i, "utf-8").mb_substr($str, $i +1, $n - $i, "utf-8");
				$n --;
			}
		}
		$str = preg_replace("/\s/", "", $str);
		$str = ereg_replace("\.", "", $str);
		$str = ereg_replace(",", "", $str);
		$str = preg_replace("/-{2,}/", "-", $str);
		return $str;
	}

	function generateUrl($page_id, $title) {
		
		if ($page_id != '' && $page_id != 0) {

			$page_data = record::loadItem($page_id);
			$parent_id = $page_data['parent_id'];

			$url = $this->replaceLetters($title);
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
		if($this->db->query($sql)->num_rows()>0){
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
		$sql = "SELECT name AS id, CONCAT(id, ' - ', name) AS title FROM $this->table_tpl WHERE disabled!=1";
		$arr = $this->db->query($sql)->result_array();
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
    	$blocks_obj = $this->registry->modules->create("blocks");
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
	
    function getContextMenu($item){
    
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit','module','delete','fields','translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		if($item['parent_id']==0 && $_SESSION['admin']['permission']!=1 && $key=='delete') continue;
    		if($key=='fields' && ($item['template']!='products' || ($item['template']=='products' && (/*$item['parent_id']==3757 || */$item['id']==3757)))) continue;
    		$act = "getContextMenuContent(\'".Config::$val['site_admin_url']."\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'list\',\'{$item['id']}\',\'$key\');";
    		$context[] = array('img'=>(isset($val['img'])?$val['img']:$key), 'name'=>$key, 'title'=>(isset($val['title'][$_SESSION['admin_interface_language']])?$val['title'][$_SESSION['admin_interface_language']]:$this->cmsPhrases['modules']['context_menu'][$key.'_title']), 'action'=>$act, 'main_action'=>$act);
    	}
		
		return $context;
		
    }
    
    function listItemsElements($category=0, $order_by='R.sort_order', $order_direction='ASC', $offset=0, $paging=30){
    	$list = record::listItemsElements($category, $order_by, $order_direction, $offset, $paging);
    	if($this->xml_config['lng_in_url']==1){
    		foreach($list as $i=>$val){
    			$list[$i]['page_url'] = $this->language.$list[$i]['page_url'];
    		}
    	}
    	//pae($list);
    	return $list;
    }
    
}

?>
