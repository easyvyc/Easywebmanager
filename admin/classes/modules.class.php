<?php

include_once(CLASSDIR."record.class.php");
class modules extends record {

    protected $admin = array();
    
    function __construct($module) {
    	
    	parent::__construct($module);
    	
        // Module language
		$this->language = $_SESSION['site_lng'];
    	    	
		// Administrator
		$this->admin = $_SESSION['admin'];
		
		$this->loadAdminLanguage($_SESSION['admin_interface_language']);
		
    }
    
    /**
     * 
     * nustatoma ar irasas redaguotas visose kalbose
     * @param int $id
     */
    function getItemLangStatus($id){
    	if($id==0){
    		// Languages where admin dont have permissions
    		$dienied_admin_langs = $this->registry->modules->admins->loadLanguageRights($_SESSION['admin']['id']);
    		foreach(Config::$val['default_page'] as $key=>$val){
    			$arr[$key]['checked'] = (in_array($key, $dienied_admin_langs)?0:1);
    			$arr[$key]['disabled'] = 0;
    		}
    	}else{
	    	$sql = "SELECT lng_saved, lng FROM $this->table WHERE record_id=$id";
	    	$l_arr = $this->db->query($sql)->result_array();
	    	$saved_count = array();
    		foreach(Config::$val['default_page'] as $key=>$val){
    			$arr[$key]['checked'] = 0;
    			$arr[$key]['disabled'] = 0;
    			foreach($l_arr as $l_val){
    				if($l_val['lng']==$key){
		    			$arr[$key]['checked'] = $l_val['lng_saved']==1?0:1;
		    			$arr[$key]['disabled'] = $l_val['lng_saved'];
		    			if($l_val['lng_saved']==1) $saved_count[] = $key;
		    			break;
    				}
    			}
    		}
    		$cnt = count($saved_count);
    		if($cnt==1){
    			if(!in_array($this->language, $saved_count)){
	    			foreach($arr as $key=>$val){
	    				$arr[$key]['checked'] = 0;
	    			}
    			}
    		}
    	    if($cnt>1){
    			foreach($arr as $key=>$val){
    				$arr[$key]['checked'] = 0;
    			}
    		}
    	
    	}
    	return $arr;
    }    
    
    /**
     * 
     */
	function getListingSum(){

		$category = $this->listing_filter_data['parent_id'];
		if($this->module_info['no_record_table']!=1) $this->sqlQueryWhere .= " R.parent_id=$category AND ";
        return $this->getCountSearchItems();

	}
	
	/**
	 * Suformuojama sql uzklausa
	 * @param array $arr
	 */
    function setWhereClause($arr=array()){
    	$this->sqlQueryWhere = "";
    	foreach($arr as $key => $val){
    		if(strlen($arr[$key]['filter_value'])==0) continue;
    		if(is_array($arr[$key]['filter_value'])){
    			$filter_value = $arr[$key]['filter_value'];
    		}else{
    			$filter_value = ereg_replace("\*", "%", $arr[$key]['filter_value']);
    		}
    		switch($arr[$key]['elm_type']){
    			case FRM_HIDDEN :
    				$this->sqlQueryWhere .= "T.{$arr[$key]['column_name']} = $filter_value AND ";
    			break;
    			case FRM_TEXTAREA :
    			case FRM_TEXT :
    				$operation = "LIKE";

    				if(ereg("^=", $filter_value)) $operation = "=";
    				if(ereg("^>", $filter_value)) $operation = ">";
    				if(ereg("^<", $filter_value)) $operation = "<";
    				if(ereg(">$", $filter_value)) $operation = "<";
    				if(ereg("<$", $filter_value)) $operation = ">";
    				
    				if($operation == "LIKE"){
    					$this->sqlQueryWhere .= "T.{$arr[$key]['column_name']} $operation '%$filter_value%' AND ";
    				}else{
    					if(ereg("([0-9]+[\.]{0,1}[0-9]*)", $filter_value, $matches)){
    						$this->sqlQueryWhere .= "T.{$arr[$key]['column_name']} $operation $filter_value AND ";
    					}else{
    						$this->sqlQueryWhere .= "T.{$arr[$key]['column_name']} $operation '$filter_value' AND ";
    					}
    				}
    				
    			break;
    			case FRM_DATE :
    				if(strlen($val['filter_value_from'])) $this->sqlQueryWhere .= " T.{$arr[$key]['column_name']}>='{$val['filter_value_from']}' AND ";
	    			if(strlen($val['filter_value_to'])) $this->sqlQueryWhere .= " T.{$arr[$key]['column_name']}<='{$val['filter_value_to']}' AND ";
    			break;
    			case FRM_CHECKBOX :
    				if(strlen($filter_value)){
	    				$operation = "=";
	    				$chk_where_clause = "(T.{$arr[$key]['column_name']} $operation '$filter_value') AND ";
	    				$this->sqlQueryWhere.= $chk_where_clause;
    				}
    			break;
    			case FRM_RADIO :
    			case FRM_AUTOCOMPLETE :
    			case FRM_SELECT :
    			case FRM_CHECKBOX_GROUP :
    				$list_values = $this->_table_fields[$arr[$key]['column_name']]['list_values'];
    				if($list_values['source']=="DB"){
	    				$operation = "LIKE";
	    				$this->sqlQueryWhere .= "J1.title $operation '%$filter_value%' AND ";
	    				$this->sqlQueryJoins .= " LEFT JOIN ".Config::$val['pr_code']."_{$list_values['module']} J1 ON (J1.record_id=T.{$arr[$key]['column_name']} AND (J1.lng='' OR J1.lng IS NULL OR J1.lng='$this->language')) ";
    				}
    				break;
    			default: break;
    		}
    	}
    }
    
    function prepareListing($arr=array()){
    	
    	$this->listing_filter_data['parent_id'] = ($this->module_info['maxlevel']==0?0:(is_numeric($this->get['id'])&&$this->get['id']>0?$this->get['id']:0));
    	$this->listing_filter_data['order_by'] = $_SESSION['order'][$this->module_info['table_name']]['order_by'];
    	$this->listing_filter_data['order_direction'] = $_SESSION['order'][$this->module_info['table_name']]['order_direction'];
    	$this->listing_filter_data['offset'] = ($this->get['offset']<0?0:$this->get['offset'])*$_SESSION['order']['paging'];
    	$this->listing_filter_data['paging'] = $_SESSION['order']['paging'];
    	
    	$this->setWhereClause($arr);
    	
    }
    
    function filterListing(){
    	if(isset($this->post['action']) && $this->post['action']=='filter'){
			$this->get['offset'] = 0;
			unset($_SESSION['filters'][$this->module_info['table_name']]);
			foreach($this->table_list as $key=>$val){
				if(strlen($this->post['filteritem___'.$val['column_name']])){
					$_SESSION['filters'][$this->module_info['table_name']][$val['column_name']] = $this->post['filteritem___'.$val['column_name']];
				}
			}
		}    	
    	
		if(!isset($_SESSION['order'][$this->get['module']]['order_by'])){
			$_SESSION['order'][$this->get['module']]['order_by'] = strlen($this->module_info['default_sort'])>0?$this->module_info['default_sort']:"R.sort_order";
		}
		if(!isset($_SESSION['order'][$this->get['module']]['order_direction']) || strlen($_SESSION['order'][$this->get['module']]['order_direction'])==0){
			$_SESSION['order'][$this->get['module']]['order_direction'] = (strlen($this->module_info['default_sort_direction'])>0?$this->module_info['default_sort_direction']:"ASC");
		}
		
    }
    
    function listingActions(){
    	
    	if(isset($this->get['action']) && $this->get['action']=='delete' && isset($this->get['deleteid'])){
		    //$this->loadItem($this->get['deleteid']);
		    $this->delete($this->get['deleteid']);
		}
		
		if(isset($this->get['action']) && $this->get['action']=='change_order' && isset($this->get['firstid']) && isset($this->get['lastid'])){
		    $this->changeOrder($this->get['firstid'], $this->get['lastid']);
		    $this->loadItem($this->get['firstid']);
		}
		
		if(isset($this->get['action']) && $this->get['action']=='action_with_selected_items'){
			if($this->get['action_choice']=="delete"){
				foreach($this->post['chk'] as $key=>$val){
					$this->delete($this->post['chk'][$key]);
				}
			}
			if($this->get['action_choice']!="delete"){
				foreach($this->post['chk'] as $key=>$val){
					$this->changeFieldStatus($_SESSION['site_lng'], $this->get['action_choice'], $this->post['chk'][$key]);
				}
			}
		}    	
    }
    
    function getListingItems(){

    	$category = $this->listing_filter_data['parent_id'];
    	$order_by = $this->listing_filter_data['order_by'];
    	$order_direction = $this->listing_filter_data['order_direction'];
    	$offset = $this->listing_filter_data['offset'];
    	$paging = $this->listing_filter_data['paging'];
    	
    	if($order_by=='') $order_by = $this->module_info['default_sort'];
    	if($order_direction=='') $order_direction = $this->module_info['default_sort_direction'];
    	
    	if($this->module_info['no_record_table']==1 && $order_by=='R.sort_order'){
    		$order_by = "";
    	}
    	
        if($this->module_info['no_record_table']!=1) $this->sqlQueryWhere .= " R.parent_id=$category AND ";
        $this->sqlQueryLimit = " LIMIT $offset, $paging ";
        if($order_by!='') $this->sqlQueryOrder = " ORDER BY $order_by $order_direction ";
        $list = $this->listSearchItems();
		
		$n = count($list);
		for($i=0; $i<$n; $i++){

			$CONTENT = ($this->module_info['catalog']==1?'catalog':$this->module_info['table_name']);
			$list[$i]['main_action'] = "main.php?content=$CONTENT&module={$this->module_info['table_name']}&page=list&id={$list[$i]['id']}";	
			$list[$i]['action'] = "main.php?content=$CONTENT&module={$this->module_info['table_name']}&page=list&id={$list[$i]['id']}#edit";
			
			$list[$i]['context'] = $this->getContextMenu($list[$i]);
			if(!isset($list[$i]['parent_id'])) $list[$i]['parent_id'] = 0;
			
		}   
		
		return $list;     

    }
    
    /**
     * 
     * Returns checkbox list(languages) for delete item action
     * @param integer $id
     */
    function get_lngs_for_delete($id){
		$dienied_admin_langs = $this->registry->modules->admins->loadLanguageRights($_SESSION['admin']['id']);
		$lang_saved_arr = $this->getItemLangStatus($id);
		$lang_val = array();
		foreach(Config::$val['default_page'] as $key=>$val){
			if(!in_array($key, $dienied_admin_langs)) 
				$lang_val[] = array('title'=>strtoupper($key), 'value'=>$key, 'selected'=>true);
		}
		return $lang_val;
    }

	function loadAdminRights($admin_id, $record_id){
		
		if(RESTART_SESSION == 1) return;
		
		if(!isset($admin_id)) return 0;
		
		// always have permission to change owner account
		if($admin_id==$record_id) return 1;
		
		$sql = "SELECT * FROM ".Config::$val['sb_record']." WHERE id=$record_id";
		$row = $this->db->query($sql)->row_array();

		if(is_numeric($row['module_id'])){
			$sql = "SELECT * FROM ".Config::$val['sb_module']." WHERE id={$row['module_id']}";
			$mod = $this->db->query($sql)->row_array();
		}
		//if($row['is_category']==0) $record_id = $row['parent_id'];
		
		// Put admin rights to array 
		$arr = strlen($this->admin['mod_rights'])?explode("::", $this->admin['mod_rights']):array();
		// If item module is disabled
		if($mod['disabled']==1 || $this->module_info['disabled']==1){
			if(in_array($_SESSION['filter_item']['list_values']['get_category']['value'], $arr)){
				return 0;
			}
		}else{
			// If module blocks then always have permission
			if($this->module_info['table_name']=='blocks'){
				return 1;
			}
			if(in_array($this->module_info['id'], $arr) && is_numeric($this->module_info['id'])){
				return 0;
			}
		}
		
		// If item is new
		if(!isset($record_id)) return 1;
		
		$sql = "SELECT * FROM ".Config::$val['sb_admin_module_rights']." WHERE admin_id=$admin_id AND record_id=$record_id ";
		$arr = $this->db->query($sql)->row_array();
		if(empty($arr)) return 1;
		else return 0;
		
	}
	
	function listAdminRights($rights_table, $admin_id, $module_id, $parent_id=0, $offset=0, $paging=20){

		global $RESTART_SESSION;
		if($RESTART_SESSION == 1) return;

        $n = count($this->table_fields); $fields="";
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= " T.".$this->table_fields[$i]['column_name'].", ";
        }

		$start = $offset * $paging;
		$sql = "SELECT R.parent_id, R.id, $fields U.rights, IF(U.rights IS NULL, 0, U.rights) AS prm, T.lng_saved " .
				" FROM {$this->tables['record']} R " .
				" LEFT JOIN {$this->table} T " .
				" ON (R.id=T.record_id) " .
				" LEFT JOIN $rights_table U " .
				" ON (R.id=U.record_id AND U.admin_id=$admin_id) " .
				" WHERE R.parent_id=$parent_id AND R.trash!=1 ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"")." ";
		if($this->module_info['no_record_table']!=1) $sql .= " ORDER BY R.sort_order ASC ";
		$sql .= " LIMIT $start, $paging ";
		$arr = $this->db->query($sql)->result_array();
		return $arr;
	}
	
	function getCountAdminRights($rights_table, $admin_id, $module_id, $parent_id=0){

		global $RESTART_SESSION;
		if($RESTART_SESSION == 1) return;

        $n = count($this->table_fields); $fields="";
        for($i=0, $fields=''; $i<$n; $i++){
            $fields.= " T.".$this->table_fields[$i]['column_name'].", ";
        }

		$sql = "SELECT R.parent_id, R.id, U.rights, IF(U.rights IS NULL, 0, U.rights) AS prm, T.lng_saved " .
				" FROM {$this->tables['record']} R " .
				" LEFT JOIN {$this->table} T " .
				" ON (R.id=T.record_id) " .
				" LEFT JOIN $rights_table U " .
				" ON (R.id=U.record_id AND U.admin_id=$admin_id) " .
				" WHERE R.parent_id=$parent_id AND R.trash!=1 ".($this->module_info['multilng']==1?" AND T.lng='$this->language' ":"")." ";
		$q = $this->db->query($sql);
		return $q->num_rows();		
	}	

    function getContextMenu($item){
    
		$CONTENT = ($this->module_info['tree']!=1?$this->module_info['table_name']:'catalog');
    	
    	$z_arr = array('edit','module','delete','translate');
    	
    	foreach($this->mod_actions as $key=>$val){
    		if($item['id']==0 && in_array($key, $z_arr)) continue;
    		if($_GET['page']=='filters'){
    			if($item['id']==$_SESSION[$_GET['filters']]['filter']['category_id'] && in_array($key, $z_arr)) continue;
    		}
    		$act = "getContextMenuContent(\'".Config::$val['site_admin_url']."\', \'$CONTENT\',\'{$this->module_info['table_name']}\',\'".(($_GET['page']=='filters')?"filters":"list")."\',\'{$item['id']}\',\'$key\'".(($_GET['page']=='filters')?",\'{$_GET['filters']}\'":"").");";
    		$context[] = array('img'=>$key, 'name'=>$key, 'title'=>$this->cmsPhrases['modules']['context_menu'][$key.'_title'], 'action'=>$act, 'main_action'=>$act);
    	}

		return $context;
		
    }	
	
}
?>