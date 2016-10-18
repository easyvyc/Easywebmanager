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
	
	// form validation status
	private $validate_success = false;
	
        // forma data before submit
        private $data_values = array();
        
	// form submited data ($_POST, $_GET)
	private $data = array();
	
	//
	private $default_secret = "save_action";
	
	// 
	private $return;
	
	function __construct($attr, $fields=array(), $data=array()) {
		
		parent::__construct();
		
		$this->settings['form_submit_btn_title'] = "Submit";
		$this->settings['form_error_message'] = "Error.";
		$this->settings['form_success_message'] = "Success.";
		
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
	
	function get($name, $value){
		return $this->settings[$name];
	}
		
	function add($name, $element){
		$this->fields[$name] = $this->createElement($name, $element, $this);
	}
	
	function add_array($array){
		foreach($array as $name=>$element){
			$this->add($name, $element);
		}
	}
	
	function add_data_values($data){
		foreach($data as $key=>$val){
			$this->edit($key, array('value'=>$val));
                        $this->data_values[$key] = $val;
		}
	}
        
	function get_data_values(){
		return $this->data_values;
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
                TPL::setVar('_form_data_values', $this->data_values);
		TPL::setVar('_form_data', $this->to_Array($this->fields));
		TPL::setVar('_hiddens', $this->settings['hiddens']);
		TPL::setVar('form_settings', $this->settings);

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
		$html = "";
		if($this->validate_error){
			$html .= "<p class=\"msg formerror\">" . $this->settings['form_error_message'] . "</p>";
		}
		if(!$this->validate_error && $this->validate_success){
			$html .= "<p class=\"msg formsuccess\">" . $this->settings['form_success_message'] . "</p>";
		}
		$html .= "<form name=\"{$this->settings['name']}\" id=\"{$this->settings['id']}\" action=\"{$this->settings['action']}\" method=\"post\" enctype=\"multipart/form-data\">";
		return $html;
		
	}
	
	function end(){
		$hiddens = "";
		// hidden fields like isNew, id, parent_id etc.
		foreach($this->settings['hiddens'] as $name=>$value){
			$hiddens .= "<input type='hidden' name='$name' value='$value' />";
		}
                if($this->settings['hide_submit'] == true){
                    $submit = "";
                }else{
                    $submit = "<div class=\"submit_block\"><input type=\"submit\" value=\"" . $this->settings['form_submit_btn_title'] . "\" class=\"fo_submit\"></div>";
                }
		$script = "<script type=\"text/javascript\"> eFORM.load('{$this->settings['id']}'); </script>";
		return $submit.$hiddens."<input name='_SECRET_' type='hidden' value='{$this->settings['_SECRET_']}' /></form>".$script;
	}
	
	function getData(){
		return $this->data;
	}
	
	function set_data_value($field, $value){
		$this->data[$field] = $value;
	}
	
	function process($data){
		$this->data = $data;
		// set default values for fields
		if($this->settings['hiddens']['isNew']==1){
			foreach($this->fields as $name=>$elm){
				$elm->set('value', $elm->get('default_value'));
			}
		}
		if(isset($this->data['_SECRET_']) && $this->data['_SECRET_']==$this->settings['_SECRET_']){
			$this->validate();
			$this->set('validate_error', $this->validate_error);
			if($this->validate_error!=1){
				$this->validate_success = true;
				$this->set('validate_success', $this->validate_success);
				if(is_array($this->settings['target'])){
					$return = array();
					foreach($this->settings['target'] as $key=>$val){
						$return[$val] = $this->registry->controller->{$this->settings['table_name']}->{"_FORM_".$val}($this);
					}
				}elseif($this->settings['target']){
					$module = $this->settings['table_name'];
					$method = "_FORM_".$this->settings['target'];
					$return = $this->registry->controller->$module->$method($this);
				}
				$this->return_val($return);
			}
			
		}
		return $this->generate();
	}
	
	static function createElement($name, $element, $form=null){
		if(file_exists(CLASSDIR."forms/{$element['type']}.class.php")){
			include_once(CLASSDIR."forms/{$element['type']}.class.php");
			$elm_type = "element_" . $element['type'];
			return new $elm_type($name, $element, $form);
		}else{
			return new Element($name, $element, $form);
		}
	}
	
	function to_Array($fields){
		$array = array();
		foreach($fields as $name=>$elm){
			$array[$name] = $elm->getAll();
		}
		return $array;
	}
	
	function return_val($return = ''){
		if($return){
			$this->return = $return;
		}
		return $this->return;
	}
	
	function redirect(){
		if($this->settings['redirect']!='')
			redirect(Config::$val['site_url'].$this->settings['redirect']);
	}	
}

?>