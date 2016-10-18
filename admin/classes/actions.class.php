<?php

include_once (CLASSDIR."basic.class.php");
class actions extends basic {

	protected $mod_actions = array(
		'edit'=>array(), 
                'copy'=>array(), 
		//'translate'=>array(), 
		//'pdf'=>array(), 
		'delete'=>array(),
                'info'=>array(), 
                'note'=>array(), 
	);
	
	protected $mod_action_new = array(
		'new_item'=>array()
	);
	
    function __construct($module) {
    	
    	parent::__construct();
    	
    	$this->mod = $this->registry->model->$module;
    	
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
		
    	// Detects translate action
    	if($this->mod->module_info['multilng']!=1 || count(Config::$val['default_page'])==1){
    		$this->remove('translate');
    	}

    	// Detects translate action
    	if($this->mod->module_info['no_record_table']==1){
    		$this->remove('note');
    	}
        
        foreach($this->mod_actions as $key=>$val){
                $this->mod_actions[$key]['img'] = $key;
                $this->mod_actions[$key]['name'] = $key;
                $this->mod_actions[$key]['title'] = cms::$phrases['modules']['context_menu'][$key.'_title'];
                $this->mod_actions[$key]['action'] = "javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', '$key', '{id}'));";
                
                $this->mod_actions[$key]['frm_list_action'] = "javascript: void(\$NAV.open_dialog('{$this->mod->module_info['table_name']}_{$this->get['column']}_{$this->get['cid']}', '?module={$this->mod->module_info['table_name']}&method={$key}_from_listing&id={id}&column={$this->get['column']}&cid={$this->get['cid']}&area={$this->get['area']}&no_tree_reload=1&json=0', ''));";
        }

        $this->mod_action_new['new_item']['img'] = 'new';
        $this->mod_action_new['new_item']['name'] = 'new_item';
        $this->mod_action_new['new_item']['title'] = cms::$phrases['modules']['context_menu']['new_title'];
        $this->mod_action_new['new_item']['action'] = "javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=new_item'));";

        $this->mod_action_new['settings']['img'] = 'settings';
        $this->mod_action_new['settings']['name'] = 'settings';
        $this->mod_action_new['settings']['title'] = cms::$phrases['modules']['context_menu']['settings_title'];
        $this->mod_action_new['settings']['action'] = "javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=settings'));";

        $this->mod_action_new['export']['img'] = 'export';
        $this->mod_action_new['export']['name'] = 'export';
        $this->mod_action_new['export']['title'] = cms::$phrases['modules']['context_menu']['export_title'];
        $this->mod_action_new['export']['action'] = "javascript: void(\$NAV.get('?module={$this->mod->module_info['table_name']}&method=export'));";
		
    }
    
    function getContextMenu($item){
    
        if(empty($this->mod_actions)) return false;
        
	$CONTENT = ($this->mod->module_info['tree']!=1?$this->mod->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit', 'copy', 'info', 'notes', 'module', 'delete', 'translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
                if($item['id']==0 && $val['hide_when_zero']) continue;
    		$act = str_replace("{id}", $item['id'], ($this->get['column'] && $this->get['cid'] ? $val['frm_list_action'] : $val['action']));
    		$context[] = array(
    			'img'=>($val['img'] ? $val['img'] : $key), 
    			'name'=>$key, 
    			'title'=>$val['title'], 
    			'action'=>$act, 
    			'main_action'=>$act
    		);
    	}

	return $context;
		
    }

    /**
     * add item context menu action
     * @param string $name
     * @param array $action_params
     * @param int $index sort number in context menu items
     */
    function add($name, $action_params, $index=null){
    	if($index === null){
    		$this->mod_actions[$name] = $action_params;
    	}else{
    		$first_slice = array_slice($this->mod_actions, 0, $index - 1);
    		$last_slice = array_slice($this->mod_actions, $index - 1);
    		$this->mod_actions = array_merge($first_slice, array($name=>$action_params), $last_slice);
    	}
    	
    }
    
    function edit($name, $action_params){
    	foreach($action_params as $key => $val){
    		$this->mod_actions[$name][$key] = $val;
    	}
    }
    
    function remove($name){
    	unset($this->mod_actions[$name]);
    }
    
    function listItems($id){
    	if($id==0){
    		$items = array();
    		$items[] = $this->mod_action_new['new_item'];
    		if($this->mod->module_info['additional_settings']){
    			$items[] = $this->mod_action_new['settings'];
    		}
    		if($this->mod->module_info['export']){
    			$items[] = $this->mod_action_new['export'];
    		}
    		foreach($items as $i=>$val){
    			if($val['name'] == $this->get['method']) $items[$i]['active'] = 1;
    		}
    		return $items;
        }else{
            $item_data = $this->mod->loadItem($id);
            return $this->getContextMenu($item_data);
        }
    	return $this->mod_actions;
    }
    
    function __call($func, $args){
    	trigger_error("Method ".__CLASS__."::$func() not exist.");
    }
    
}
?>