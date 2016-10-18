<?php

include_once(APP_CLASSDIR . "model.class.php");

class model_news extends model {

    function __construct() {

        parent::__construct("news");

        //$this->mod_actions = array('edit'=>array(), 'send'=>array('title'=>array('lt'=>'Siųsti', 'en'=>'Send'), 'img'=>'mail'), 'new'=>array(), 'import'=>array(), 'export'=>array(), 'pdf'=>array(), 'delete'=>array(), 'settings'=>array());
    }

}

?>