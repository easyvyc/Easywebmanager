<?php

include_once(APP_CLASSDIR."model.class.php");
class model__easy_updates extends basic {
	
	// constructor inherit record class
	function __construct(){
		
		parent::__construct();
		
		$this->soap_param = array(	'date' => date('Y-m-d'),
						'version' => EASYWEBMANAGER_VERSION,
						'domain' => $this->config['pr_url'],
						'license' => $this->config['license'],
						'project_id' => 0);
		
		
		require_once(CLASSDIR.'nusoap/lib/nusoap.php');
		$this->nusoap_client = new nusoapclient($this->config['update_server'], "wsdl");
		
	}
	
	function getListingItems(){
		
		$res = $this->nusoap_client->call("getUpdatesList", $this->soap_param);
		
		if($res[0]['value']!=false){
			if($res[0]['value']['item']['id']){
				$upd_arr = array($res[0]['value']['item']);
			}else{
				$upd_arr = $res[0]['value']['item'];
			}
			foreach($upd_arr as $i => $val){
				$upd_arr[$i]['description'] = nl2br($val['description']);
				$upd_arr[$i]['id'] = $val['record_id'];
			}
			return $upd_arr;
		}else{
			return false;
		}		
		
	}
	
	function startUpdate($update_id){
		$soap_params = $this->soap_param;
		$soap_params['update_id'] = $update_id;
		$_updateExist = $this->nusoap_client->call('startUpdate', $soap_params);
		return ($updateExist['value']!=false?true:false);
	}
	
	function endUpdate($update_id){
		$soap_params = $this->soap_param;
		$soap_params['update_id'] = $update_id;
		$this->nusoap_client->call('endUpdate', $soap_params);
	}
	
	function getUpdateFilesList($update_id){
		$soap_params = $this->soap_param;
		$soap_params['update_id'] = $update_id;
		$list = $this->nusoap_client->call('getUpdateFilesList', $soap_params);
		if($list[0] && $list[0]['value'] != false){
			if(isset($list[0]['value']['item']['id'])){
				return array($list[0]['value']['item']);
			}
			return $list[0]['value']['item'];
		}
	}
	
	function getUpdateFile($file, $update_id){
		$soap_params = $this->soap_param;
		$soap_params['update_id'] = $update_id;
		$soap_params['file'] = $file;
		return $this->nusoap_client->call('getUpdateFile', $soap_params);
	}
	
	function listUpdateFilesList(){

		$soap_params = $this->soap_param;
		$soap_params['update_id'] = $update_id;
				
		$list = $this->nusoap_client->call('getUpdateFilesList', $soap_params);
		$updateList = $list[0];

		if($updateList['value']!=false){
			if(isset($updateList['value']['item']['id'])){
				return array($updateExist['value']['item']);
			}else{
				return $updateList;
			}
		}
		
	}
		
}

?>