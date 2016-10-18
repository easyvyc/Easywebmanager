<?php

class model_languages {
    
    function __construct(){
        $this->language = cms::$language;
    }
    
    function get_list(){
        $phrases = cms::getInstance()->registry->controller->phrases->loadPhrases();
        $list = array();
        $module_xml_settings = cms::getInstance()->registry->model->pages->getSettings();
        foreach(Config::$val['default_page'] as $lng => $page_id){
            if(in_array($lng, $module_xml_settings['languages'])){
                $list[] = array('value' => $lng, 'title' => ($phrases[$lng] ? $phrases[$lng] : strtoupper($lng)), 'selected' => ($lng == $this->language));
            }
        }
        return $list;
    }

    function get_current(){
        $list = $this->get_list();
        foreach($list as $val){
            if($val['value'] == $this->language){
                return $val;
            }
        }
    }
    
}