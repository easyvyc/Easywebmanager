<?php

include_once(APP_CLASSDIR."actions.class.php");
class actions_articles extends actions {

    function __construct() {
    	
    	parent::__construct("articles");
    	
    	//$this->mod_actions = array('module'=>array(), 'edit'=>array(), 'translate'=>array(), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array());
    	
        if($this->registry->model->newsletters->module_info['disabled'] != 1){
            $this->add("newsletter", array(
                                    'title'=>cms::$phrases['news']['context_menu']['create_newsletter'], 
                                    'img'=>'star1',
                                    'action'=>"javascript: void(\$NAV.select_context_action('{$this->mod->module_info['table_name']}', 'create_newsletter', '{id}'));"
                                ),
            2);
        }
        
    }

}

?>