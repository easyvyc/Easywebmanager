<?php

class Element extends basic {
	
	// 
	private $message;
	
	//
	protected $attr;
	
	//
	protected $validate_error_css_class = "error";
	
	function __construct($name, $element, $form_obj = null){
		parent::__construct ();

		foreach($element as $key=>$value){
			$this->set($key, $value);
		}
		$this->set('name', $name);

		if(is_object($form_obj)){
			$this->set('form', $form_obj);
		}		
		
		if(!$element['type']) trigger_error("Form element attribute type must be defined");
		
	}
	
	function set($key, $value){
		if(in_array($key, array('list_values', 'validator')) && !is_array($value)){
			$value = parse___list_values($value);
		}
		$this->attr[$key] = $value;
		if($key == 'type'){
			$this->attr['elm_type'] = $value;
		}
		if($key == 'elm_type'){
			$this->attr['type'] = $value;
		}
	}
	
	function get($key){
		return $this->attr[$key];
	}
	
	function getAll(){
		return $this->attr;
	}
	
	function validate($data){
		$value = $data[$this->get('name')];
		$this->set('value', $value);
		$this->set('state', $data["ELM_state_".$this->get('name')]);
		if($this->attr['required']){
			if(!isset($value) || $value==''){
				$this->set('style', $this->validate_error_css_class);
				$this->set('show_error', true);
				$this->set('error_message', cms::$phrases['main']['common']['empty_field']);
				return false;
			}
		}
                
		if(is_array($this->attr['validator']) && !empty($this->attr['validator'])){
                        if($this->attr['validator']['module'] && method_exists($this->registry->controller->{$this->attr['validator']['module']}, $this->attr['validator']['method'])){
                            if(!$this->registry->controller->{$this->attr['validator']['module']}->{$this->attr['validator']['method']}($value, $this->get('name'), $data)){
                                    $this->set('style', $this->validate_error_css_class);
                                    $this->set('show_error', true);
                                    $this->set('error_message', $this->attr['validator']['admin_error_msg']);
                                    return false;
                            }
                        }
                        if($this->attr['validator']['function'] && function_exists($this->attr['validator']['function'])){
                            if(call_user_func($this->attr['validator']['function'], $value)){
                                    $this->set('style', $this->validate_error_css_class);
                                    $this->set('show_error', true);
                                    $this->set('error_message', $this->attr['validator']['admin_error_msg']);
                                    return false;
                            }			
                        }
		}
		return true;
	}
	
	function getHTML(){
		TPL::setVar('elm', $this->attr);
		TPL::setVar('style', 'fo');
                $elm_tpl = TPLDIR."forms/".$this->get('type').".tpl";
		if(isset($this->attr['list_values']['tpl_controller']) && isset($this->attr['list_values']['tpl_method'])){
                    $c = $this->attr['list_values']['tpl_controller'];
                    $m = $this->attr['list_values']['tpl_method'];
                    $tpl_data = $this->registry->controller->$c->$m($this);
                    TPL::setVar('tpl_data', $tpl_data);
		}
		if(isset($this->attr['list_values']['tpl_file']) && file_exists(TPLDIR . ltrim($this->attr['list_values']['tpl_file'], "/"))){
                    $elm_tpl = TPLDIR . ltrim($this->attr['list_values']['tpl_file'], "/");
		}
		return TPL::parse($elm_tpl).$this->elm_stateHTML($this->get('state'));
	}
	
	/**
	 * Set element is edited after post data
	 */
	function elm_stateHTML($state = 0){
		return "<input type=\"hidden\" id=\"ELM_state_" . $this->get('form')->get('name') . "_{$this->attr['name']}\" name=\"ELM_state_{$this->attr['name']}\" rel=\"{$this->attr['name']}\" class=\"ELM_state\" value=\"$state\">";
	}
	
	function getMessage(){
		return $this->message;
	}
	
}

?>