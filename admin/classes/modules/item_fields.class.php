<?php

include_once(APP_CLASSDIR."modules.class.php");
class modules_item_fields extends modules {
	
	function __construct(){
		
		parent::__construct("item_fields");
		
	}
	
	function getFields(){
		$fields[] = array('id'=>FRM_TEXT, 'title'=>FRM_TEXT);
		$fields[] = array('id'=>FRM_TEXTAREA, 'title'=>FRM_TEXTAREA);
		$fields[] = array('id'=>FRM_SELECT, 'title'=>FRM_SELECT);
		$fields[] = array('id'=>FRM_CHECKBOX, 'title'=>FRM_CHECKBOX);
		$fields[] = array('id'=>FRM_RADIO, 'title'=>FRM_RADIO);
		$fields[] = array('id'=>FRM_IMAGE, 'title'=>FRM_IMAGE);
		$fields[] = array('id'=>FRM_DATE, 'title'=>FRM_DATE);
		return $fields;
	}	
	
}

?>