<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_phrases extends controller {
	
        private $ph_cache = array();
	
	function __construct(){
		parent::__construct("phrases");
	}
	
	function loadPhrases(){
		
            if(empty($this->ph_cache)){
		$list = $this->mod->listItems();
		$phrases = array();
		foreach($list as $val){
			$phrases[$val['title']] = nl2br($val['translation']);
		}
		$this->ph_cache = $phrases;
            }
            
            return $this->ph_cache;
		
	}
        
        function get($key){
            if(empty($this->ph_cache)){
                $this->loadPhrases();
            }
            return $this->ph_cache[$key];
        }
	
}

?>
