<?php
include_once(CLASSDIR."catalog.class.php");
class phrases extends catalog {

    function __construct() {
 		parent::__construct("phrases");
    }
    
    function loadPhrases(){
		$phrases_list = $this->listItems(0,0);
		$n = count($phrases_list);
		for($i=0; $i<$n; $i++){
			$phrases[$phrases_list[$i]['title']] = html_entity_decode(nl2br($phrases_list[$i]['translation']));
		}
		$phrases_list = $this->registry->modules->call("phrases_html", "listItems", array(0,0));
		$n = count($phrases_list);
		for($i=0; $i<$n; $i++){
			$phrases['_HTML_'][$phrases_list[$i]['title']] = $phrases_list[$i]['translation'];
		}
		return $phrases;
    }
    
}
?>
