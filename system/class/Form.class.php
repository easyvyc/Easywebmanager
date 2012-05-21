<?php

class Form extends basic {
	
	// form settings
	private $settings = array();
	
	// form fields array
	private $fields = array();
	
	// form validation status
	private $validate_error = false;
	
	// form validation error messages
	private $validation_errors = array();
	
	// form submited data ($_POST, $_GET)
	private $data = array();
	
	//
	private $default_secret = "save_action";
	
	function __construct($attr, $fields=array(), $data=array()) {
		parent::__construct();
		if(!is_array($attr)) trigger_error("Form attributes must be array type");
		if(!($attr['name'])) trigger_error("Form attribute 'name' must exist");
		if(!($attr['action'])) trigger_error("Form attribute 'action' must exist");
		if(!$attr['_SECRET_']) $attr['_SECRET_'] = $this->default_secret;
		foreach($attr as $key=>$val){
			$this->set($key, $val);
		}
		if(!empty($fields)) $this->add_array($fields);
		if(!empty($data)) $this->add_data_values($data);
	}
	
	function set($name, $value){
		$this->settings[$name] = $value;
	}
	
	function add($name, $element){
		$this->fields[$name] = $this->createElement($name, $element);
	}
	
	function add_array($array){
		foreach($array as $name=>$element){
			$this->add($name, $element);
		}
	}
	
	function add_data_values($data){
		foreach($data as $key=>$val){
			$this->edit($key, array('value'=>$val));
		}
	}
	
	function edit($name, $element){
		foreach($element as $key=>$val){
			if(is_object($this->fields[$name])) 
				$this->fields[$name]->set($key, $val);
		}
	}
	
	function validate(){
		foreach($this->fields as $name=>$elm){
			if(!$elm->validate($this->data)){
				$this->validate_error = true;
				$this->validation_errors[$name] = $elm->getMessage();
			}
		}
		return ($this->validate_error?false:true);
	}
	
	function generate(){
		$form_str = ($this->settings['form_tpl']?$this->settings['form_tpl']:"");
		foreach($this->fields as $name=>$elm){
			$elm_html = $elm->getHTML();
			if($this->settings['form_tpl']){
				$form_str = str_replace("{tpl.$name}", $elm_html, $form_str);
			}else{
				$form_str .= $elm_html;
			}
		}
		$form_content = $this->start().$form_str.$this->end();
		return $form_content;
	}
	
	function start(){
		return "<form name=\"{$this->settings['name']}\" id=\"{$this->settings['id']}\" action=\"{$this->settings['action']}\" method=\"post\">";
	}
	
	function end(){
		$hiddens = "";
		foreach($this->settings['hiddens'] as $name=>$value){
			$hiddens .= "<input type='hidden' name='$name' value='$value' />";
		}
		$script = "<script type=\"text/javascript\"> eFORM.load('{$this->settings['id']}'); </script>";
		return $hiddens."<input name='_SECRET_' type='hidden' value='{$this->settings['_SECRET_']}' /></form>".$script;
	}
	
	function getData(){
		return $this->data;
	}
	
	function process($data){
		$this->data = $data;
		if(isset($this->data['_SECRET_']) && $this->data['_SECRET_']==$this->settings['_SECRET_']){
			$this->validate();
			if($this->validate_error!=1){
				if(is_array($this->settings['target'])){
					foreach($this->settings['target'] as $key=>$val){
						call_user_method("_".$val, $this);
					}
				}else{
					call_user_method("_".$this->settings['target'], $this);
				}
				$this->redirect();
			}
			
		}
		return $this->generate();
	}
	
	static function createElement($name, $element){
		if(file_exists(CLASSDIR."forms/{$element['type']}.class.php")){
			include_once(CLASSDIR."forms/{$element['type']}.class.php");
			$elm_type = $element['type'];
			return new $elm_type($name, $element);
		}else{
			return new Element($name, $element);
		}
	}
	
	function _mailto(){

		include_once(CLASSDIR_."phpmailer.class.php");
		$mailer = new PHPMailer();
		
		$mailer->CharSet = "UTF-8";
		$mailer->Subject = "{$this->settings['title']} ".Config::$val['pr_url'];
		$message = date('Y-m-d')."\r\n";
		$mailer->ContentType = "text/plain";
		foreach($this->fields as $key=>$val){
			if($val['elm_type']==FRM_SELECT || $val['elm_type']==FRM_RADIO || $val['elm_type']==FRM_CHECKBOX_GROUP){
				$val['value'] = $this->data[$key];
				if($val['list_values']['source']=='DB'){
					unset($filters_record);
					$filters_record = $this->registry->modules->{$val['list_values']['module']};
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

		$mailto = (strlen($this->settings['emails'])>0?$this->settings['emails']:Config::$val['pr_email']);
		$mailer->AddAddress($mailto);
		$mailer->From = isset($this->data['email'])?$this->data['email']:$mailto;
		$mailer->FromName = Config::$val['pr_url'];
		$mailer->Send();
		
	}
	
	function _database(){
		
		$c_obj = $this->registry->modules->create($this->settings['module']);
		
		$data['isNew'] = $this->settings['isNew'];
		$data['is_category'] = $this->settings['is_category'];
		$data['id'] = $this->settings['id'];
		$data['parent_id'] = $this->settings['parent_id'];
		$data['language'] = $c_obj->language;
		
		$c_obj->author['id'] = (isset($this->settings['author_id'])?$this->settings['author_id']:0);
		
		foreach($this->form->elements as $key=>$val){
			$data[$val['column_name']] = $val['value'];
		}
		
		$r_id = $c_obj->saveItem($data);
		
	}
	
	function _session(){
		$_SESSION[$this->settings['variable']] = $this->data;
	}
	
	function _soap(){
		
	}
	
	function _curl(){
		
	}
	
	function redirect(){
		if($this->settings['redirect']!='')
			redirect(Config::$val['site_url'].$this->settings['redirect']);
	}	
}

?>