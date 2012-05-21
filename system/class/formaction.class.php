<?php

include_once(CLASSDIR."basic.class.php");
include_once(CLASSDIR."forms.class.php");
class formaction extends basic {

    function formaction() {
		
		basic::basic();
		$this->form = & new forms();
		
    }

	function setFields($fields){
		$this->form->setData($fields);
		if(empty($this->action_data)) { echo "First you have to set variable 'action_data' and parameter 'name'"; exit; }
		$this->form->addField('action', array('elm_type'=>FRM_HIDDEN, 'value'=>$this->action_data['name']));
	}
	
	function setData($data){
		$this->data = $data;
	}

	function setAction($action_data){
		$this->form->formData = $this->action_data = $action_data;
	}
	
	function process(){
		
//		pa($this->data);
//		pae($this->action_data);
		if(!empty($this->data) && $this->data['action']==$this->action_data['name']){
			$form_data = $this->form->validate($this->data);
			if($this->form->error!=1){
				if(is_array($this->action_data['target'])){
					foreach($this->action_data['target'] as $key=>$val){
						call_user_method($val, $this);
					}
				}else{
					call_user_method($this->action_data['target'], $this);
				}
				$this->redirect();
			}
		}
		return $this->form->constructForm($this->action_data['name']);
		
	}
	
	function mailto(){

		include_once(CLASSDIR_."phpmailer.class.php");
		$mailer = new PHPMailer();
		
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = "{$this->action_data['title']} ".Config::$val['pr_url'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		foreach($this->form->elements as $key=>$val){
			if($val['elm_type']==FRM_SELECT || $val['elm_type']==FRM_RADIO || $val['elm_type']==FRM_CHECKBOX_GROUP){
				$val['value'] = $this->data[$key];
				if($val['list_values']['source']=='DB'){
					unset($filters_record);
					$filters_record = & new catalog($val['list_values']['module']);
					if(!is_array($val['value'])) $arr_val = explode("::", $val['value']);
					else $arr_val = $val['value'];
					if(!empty($arr_val)) $val['value'] = "";
					foreach($arr_val as $k=>$v){
						if(is_numeric($v)){
							$filters_data = $filters_record->loadItem($v);
							$val['value'] .= $filters_data['title']."; ";//$_POST[$key];
						}
					}
				}
				
			}
			if($val['elm_type']!=FRM_HIDDEN && $val['elm_type']!=FRM_SUBMIT && $val['elm_type']!=FRM_BUTTON && $val['elm_type']!=FRM_FILE && $val['elm_type']!=FRM_IMAGE)
				$message .= "{$val['title']}: {$val['value']}\r\n";
			if($val['elm_type']==FRM_FILE || $val['elm_type']==FRM_IMAGE){
				if(file_exists($_FILES[$val['column_name']]['tmp_name'])){
					$mailer->AddAttachment($_FILES[$val['column_name']]['tmp_name'], $_FILES[$val['column_name']]['name']);
				}elseif(file_exists(UPLOADDIR.$val['value'])){
					$mailer->AddAttachment(UPLOADDIR.$val['value'], $val['value']);
				}
			}
			
			if($val['elm_type']==FRM_HTML){
				$mailer->ContentType = "text/html";
			}
		}
		if($mailer->ContentType == "text/html"){
			$message = ereg_replace("\r\n", "<br>", $message);
		}
		$mailer->Body = $message;

		$mailto = (strlen($this->action_data['emails'])>0?$this->action_data['emails']:Config::$val['pr_email']);
		$mailer->AddAddress($mailto);
		$mailer->From = isset($this->data['email'])?$this->data['email']:$mailto;
		$mailer->FromName = Config::$val['pr_url'];
		$mailer->Send();
		
//		if($mailer->Send()){
//			$this->redirect();
//		}
		
	}
	
	function database(){
		
		$c_obj = $this->registry->modules->create($this->action_data['module']);
		
		//$data = $this->data;
		$data['isNew'] = $this->action_data['isNew'];
		$data['is_category'] = $this->action_data['is_category'];
		$data['id'] = $this->action_data['id'];
		$data['parent_id'] = $this->action_data['parent_id'];
		$data['language'] = $c_obj->language;
		
		$c_obj->author['id'] = (isset($this->action_data['author_id'])?$this->action_data['author_id']:0);
		
		foreach($this->form->elements as $key=>$val){
			$data[$val['column_name']] = $val['value'];
		}
		
		//pae($this->form->elements);
		$r_id = $c_obj->saveItem($data);
		
//		$this->redirect();
		
	}
	
	function session(){
		
		$_SESSION[$this->action_data['variable']] = $this->data;
		//$this->redirect();

	}
	
	function soap(){
		
	}
	
	function curl(){
		
	}
	
	function redirect(){
		if($this->action_data['redirect']!='')
			redirect(Config::$val['site_url'].$this->action_data['redirect']);
	}
	
}


?>
