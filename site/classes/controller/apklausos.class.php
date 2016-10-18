<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_apklausos extends controller {
	
    function __construct(){
        parent::__construct("apklausos");
    }
        
    function get_apklausa($is_voted = false){
        
        $apklausa = $this->mod->get_top();
        
        $user_votes = unserialize($_COOKIE['_polls_voted']);
        if(in_array($apklausa['id'], $user_votes)){
           $apklausa['voted'] = true;
        }
        
        $variantai = $this->registry->model->apklausos_variantai->list_variantai($apklausa['id']);
        
        if($apklausa['voted'] || $is_voted){
            foreach($variantai as $i => $val){
                if(!$variantai[$i]['vote_count']) $variantai[$i]['vote_count'] = 0;
                $variantai[$i]['result'] = number_format($val['vote_count'] * 100 / $apklausa['vote_count'], 2, ".", "");
            }
            $apklausa['voted'] = true;
        }
        
        $return['data'] = $apklausa;
        $return['variantai'] = $variantai;
        
        return $return;
        
    }
    
    function vote(){

        $user_votes = unserialize($_COOKIE['_polls_voted']);
        
        if(!in_array($this->get['apklausa_id'], $user_votes)){
            $user_votes[] = $this->get['apklausa_id'];
            $this->registry->model->apklausos->add_vote($this->get['apklausa_id']);
            $this->registry->model->apklausos_variantai->add_vote($this->get['variantas_id']);
            setcookie('_polls_voted', serialize($user_votes), time() + 3600 * 24 * 365);
            $_COOKIE['_polls_voted'] = $user_votes;
            
            $apklausa = $this->get_apklausa(true);
            TPL::setVar('apklausa_data', $apklausa['data']);
            TPL::setVar('apklausa', $apklausa['variantai']);
            TPL::setVar('phrases', $this->registry->controller->phrases->loadPhrases());

            return TPL::parse(TPLDIR."blocks/apklausa.tpl");
        }
        
    }
    
}

?>
