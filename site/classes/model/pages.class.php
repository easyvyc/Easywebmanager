<?php

include_once(APP_CLASSDIR."model.class.php");
class model_pages extends model {
	
	function __construct(){
		
		parent::__construct("pages");
		
		$this->table_text = Config::$val['sb_text'];
		$this->table_tpl = Config::$val['sb_template'];
		
	}
        
        function getMenu($parent_id, $path_ids = array()){
            $query = array();
            $query['where'] = array('parent_id' => $parent_id);
            if(!empty($path_ids))
                $query['fields'] = 'T.*, R.*, T.record_id IN (' . implode(", ", $path_ids) . ') AS selected';
            $list = $this->listSearchItems($query);
            foreach($list as $i => $item){
                if($item['no_menu']!=1){
                    $list[$i]['sub'] = $this->getMenu($item['id'], $path_ids);
                }
            }
            return $list;
        }        
	
	function loadByUrl($path, $admin_edit_mode = 0){
            	$row = $this->db->select($this->table)
                                ->fields("*, record_id AS id")
                                ->where("page_url=:path")
                                ->where("lng=:lng")
                                ->where(($admin_edit_mode ? "" : "active=1"))
                                ->bind('path', $path)
                                ->bind('lng', $this->language)
                                ->row_array();
                if($path == '/' || empty($row)){
                    $row = $this->db->select($this->table)
                                    ->fields("*, record_id AS id")
                                    ->where("record_id=:main_page_id")
                                    ->where(($admin_edit_mode ? "" : "active=1"))
                                    ->where("lng=:lng")
                                    ->bind('main_page_id', Config::$val['default_page'][$this->language])
                                    ->bind('lng', $this->language)
                                    ->row_array();
                }
		if(is_numeric($row['id']) && $row['id'] != 0){
			$row['page_area'] = $this->getPageBlocks($row['id']);
		}
                if($row['image']){
                    $row['og_image'] = Config::$val['site_url'] . "index.php?module=pages&method=show_image&column=image&id={$row['id']}&w=300&h=300&t=auto";
                }
		return $row;
	}
        
	function loadByTemplate($tpl){
		$row = $this->db->select($this->table)
                                ->fields("record_id AS id")
                                ->where("template=:template")
                                ->where("active=1")
                                ->bind('template', $tpl)
                                ->row_array();
		if(is_numeric($row['id']) && $row['id'] != 0){
                    $row = $this->loadItem($row['id']);
		}
		return $row;
	}        
	
	function loadItem($id){
		$data = parent::loadItem($id);
		$data['page_url'] = $this->language . $data['page_url'];
                if($data['image']){
                    $data['og_image'] = "index.php?content=pages&method=show_image&column=image&id=$id&w=300&h=300&t=auto";
                }
		return $data;
	}
	
	function loadHTML($page_id, $area_id){
		$row = $this->db->select($this->table_text)
						->fields("text")
						->where("page_id=:page_id")
						->where("area=:area_id")
						->bind('page_id', $page_id)
						->bind('area_id', $area_id)
						->row_array();
		return $row;
	}
        
	function loadTree($id, &$tree=array(), $level=0, $index=-1){
                $arr = $this->listSearchItems(array('where' => array('parent_id' => $id)));

		$n = count($arr);
		if($index!=-1){
			$tree[$index]['sub'] = ($n>0?1:0);
                        $tree[$index]['level'] = $level - 1;
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
        
	
	function getPageBlocks($page_id){
    	$blocks_obj = $this->registry->model->create("blocks");
    	$arr = $blocks_obj->db->select($blocks_obj->table)
    					->where("page_id=:page_id")
    					->where("lng=:lng")
    					->bind('page_id', $page_id)
    					->bind('lng', $this->language)
    					->result_array();
    	foreach($arr as $val){
    		$blocks[$val['block_name']] = $val['description'];
    	}
    	return $blocks;
	}
    
    function get_languages($active_lng = ''){
        $list = array();
        $module_xml_settings = $this->getSettings();
        foreach(Config::$val['default_page'] as $lng => $page_id){
            if(in_array($lng, $module_xml_settings['languages'])){
                $list[] = array('value' => $lng, 'title' => strtoupper($lng), 'selected' => ($lng == $active_lng));
            }
        }
        return $list;
    }

        
}

?>
