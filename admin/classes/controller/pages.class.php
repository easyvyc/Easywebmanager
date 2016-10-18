<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_pages extends controller {
	
	public function __construct() {
		parent::__construct ("pages");
	}
	
	function validateUrl($url, $column_name, $data=array()){
		if($data['generate_url']!=1){
			$error=0;
			if(isset($data['id']) && is_numeric($data['id'])){
				$row = $this->db->select($this->mod->table)
								->where("page_url=:page_url AND record_id!=:record_id AND lng=:lng")
								->bind('page_url', $url)
								->bind('record_id', $data['id'])
								->bind('lng', $this->language)
								->row_array();
			}else{
				$row = $this->db->select($this->mod->table)
								->where("page_url=:page_url AND lng=:lng")
								->bind('page_url', $url)
								->bind('lng', $this->language)
								->row_array();
			}
			
			if(empty($row)) $error = 1;
			return $error;
		}else{
			return 1;
		}

	}
	
	function something_after_success_submit($return_val){
		$data = $this->mod->loadItem($return_val);
		$parent_id = $data['parent_id'];
		return parent::something_after_success_submit($return_val).($return_val?"<script> _TREE_pages.list('$parent_id'); \$('.formElementsField').removeClass('edited'); </script>":"");
	}
	
	function something_after_success_delete($return_val){
		$data = $this->mod->loadItem($return_val);
		$parent_id = $data['parent_id'];
		return parent::something_after_success_delete($return_val).($return_val?"<script> _TREE_pages.list('$return_val'); </script>":"");
	}
	
        function inner_list(){
            $this->mod->get['id'] = $this->get['cid'];
            return $this->listing($this->get['cid']);
        }
        
	/**
	 * website page edit 
	 */
	function blocks(){
		$id = $this->get['id'];
		$data = $this->mod->loadItem($id);
		$iframe = "<iframe id=\"iframe_$id\" width=\"100%\" height=\"100%\" style=\"min-height:500px;box-shadow:0 0 5px #666;background:#FFF;\" frameborder=\"0\" src=\"" . $this->config['site_url'] . $this->language . "/" . ltrim($data['page_url'], "/") . "?edit=1" . "\"></iframe>";
		$resize_script = "<script> $('#iframe_$id').ready( function(){ $('#iframe_$id').css('height', $(document).height()-200+'px'); } ); </script>";
		
		//$resize_script = "<script> $('#_POPUP_ .content').html('$iframe'); $('#_POPUP_').height($(document).height()-80).show(); $('#iframe_$id').ready( function(){ $('#iframe_$id').css('height', $(document).height()-50+'px'); } ); </script>";
		//return $this->actions($id)."<div id='action_area_$id' class='action_area'>Loading...</div>".$resize_script;
		
		return $this->actions($id) . "<div id='action_area_$id' class='action_area'>" . $iframe . "</div>" . $resize_script;
	}	

	function tree(){
		
		if(is_numeric($this->get['parent_id'])){
			$pid = $this->get['parent_id'];
			$nav = "";
		}else{
			$pid = 0;
			$nav = parent::tree();
		}
		
		$this->mod->listing_filter_data['parent_id'] = $pid;
		$sum  = $this->mod->getListingSum();
		$list = $this->addContextToList($this->mod->getListingItems($pid));
		
		foreach($list as $i=>$val){
			$list[$i]['sub'] = $this->mod->isSub($val['id']);
		}
		if(!empty($list)){
			$list[(count($list)-1)]['_LAST'] = true;
		}
		
		TPL::setVar('tree_id', $pid);
		TPL::setVar('module', $this->mod->module_info);
		TPL::setVar('tree_list', $list);
		//TPL::setVar('paging', $paging);
		
		return $nav.TPL::parse(TPLDIR."blocks/tree.tpl");		
		
	}
		
}

?>