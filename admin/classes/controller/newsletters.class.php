<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_newsletters extends controller {
	
    public function __construct() {
        parent::__construct ("newsletters");
    }
    
    function format_email_message($mail_body, $newsletter_id, $encrypted_email){
        
        $site_url = Config::$val['site_url'];
        
        $head = "<head><style> body { font-family:Arial; } p { margin:0px; } </style>\n";
        $head .= "<base href=\"" . $site_url . "\">\n";
        $head .= "</head>\n";

        $message = "<body>" . $mail_body . "</body>";
        $message = preg_replace("/<(.)>/", "\n</$1>", $message);

        $url_regex = "[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+";
        $message = preg_replace("/href=\"($url_regex)\"/", "href=\"" . $site_url . "index.php?module=newsletters&method=location&n=" . $newsletter_id . "&loc=\\1&v=" . $encrypted_email . "\"", $message, -1);
        $message = preg_replace("/href='($url_regex)'/", "href=\"" . $site_url . "index.php?module=newsletters&method=location&n=" . $newsletter_id . "&loc=\\1&v=" . $encrypted_email . "\"", $message, -1);

        $message .= "\n<div style=\"clear:both;\"></div><div style=\"text-align:center;\"><br /><br /><span style=\"color:#999;font-size:11px;\">Jei nebenorite gauti mūsų naujienų, spauskite pateiktą nuorodą. <a href=\"" . $site_url . "index.php?module=newsletters&method=unsubscribe&lng=lt&v=" . $encrypted_email . "\">Atsisakyti</a></span>\n";
        $message .= "<br /><span style=\"color:#999;font-size:11px;\">If you do not want to receive newsletters anymore, then press <a href=\"" . $site_url . "index.php?module=newsletters&method=unsubscribe&lng=en&v=" . $encrypted_email . "\">here</a></span>";
        $message .= "<img src=\"" . $site_url . "index.php?module=newsletters&method=view&n=" . $newsletter_id . "&v=" . $encrypted_email . "\" width=\"1\" height=\"1\" alt=\"\" /></div>";

        return "<html>" . $head . $message . "</html>";
        
    }
    
    
    public function sender(){
        
        $id = $this->get['id'];
        $categories = $this->get['c'];
        $data = $this->mod->loadItem($id);
        
        $message = $this->format_email_message($data['mail_body']);
        
        $emails_list = $this->registry->model->subscribers->listForSend($categories, $offset);
        
        foreach($emails_list as $email_data){
            //$this->registry->lib->email->settings = array('content_type'=>'text/html', 'charset'=>'UTF-8');
            $this->registry->lib->email->send($email_data['title'], $data['title'], $message, $data['email_from_name'], $data['email_from_email']);
        }
        
    }
    
    public function _FORM_do_send($form_obj){
        
        $data = $form_obj->getData();
        $hiddens = $form_obj->get("hiddens");
        
        $id = $hiddens['id'];
        $groups = $data['emails_groups'];

        $offset = 0;
        $emails_list = $this->registry->model->subscribers->listForSend($groups, $offset);
        
        $n_data = $this->mod->loadItem($id);
        
        $this->mod->updateField($id, "sent_date", date("Y-m-d H:i:s"));
        
        ini_set('max_execution_time', 0);
        
        load_helpers('encrypt');
        
        $count = 0;
        foreach($emails_list as $email_data){
            $email = trim($email_data['title']);
            if(!valid_email($email)){
                $encrypted_email = urlencode(str_crypt($email));
                $message = $this->format_email_message($n_data['mail_body'], $n_data['id'], $encrypted_email);
                if($this->registry->lib->email->send($email, $n_data['title'], $message, $n_data['email_from_name'], $n_data['email_from_email'])){
                    $count++;
                }
            }
        }
        return $count;
        
        
        return "<script> 
                    $('#action_area_$id').html('<p align=left><img src=\"admin/images/loading.gif\" alt=\"Loading...\" style=\"vertical-align:middle\">  " . cms::$phrases['newsletters']['send_loading'] . "<p>'); 
               </script>";
        
    }
    
    function something_after_success_send($form_return_val){
        return $form_return_val;
    }

    public function send(){
        
        $id = $this->get['id'];
        
        $data = $this->mod->loadItem($id);
        $mod = $this->mod->module_info;

        $mod['name'] = 'send';
        $mod['id'] = '_FORM_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=send&id=$id', $('#{$mod['id']}')));";
        $mod['redirect'] = "admin.php?module={$mod['table_name']}&method=send&id=$id&ajax=1&form_success=1";

        $mod['hiddens']['id'] = $id;
        $mod['hiddens']['isNew'] = 0;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];
        
        $fields = array();
        //$fields['emails_text'] = array('name'=>'emails_text', 'type'=>FRM_TEXTAREA, 'title'=>cms::$phrases['newsletters']['emails_text'], 'editable'=>true);
        $emails_groups_list_values = $this->registry->model->subscribers_group->listItemsForNewsletter();//array('source'=>'DB', 'module'=>'subscribers_group', 'parent_id'=>0);
        $fields['emails_groups'] = array('name'=>'emails_groups', 'type'=>FRM_CHECKBOX_GROUP, 'title'=>cms::$phrases['newsletters']['emails_groups'], 'list_values'=>$emails_groups_list_values, 'editable'=>true, 'required'=>true);
        
        $form_obj = new Form($mod, $fields, array());

        // set action to custom method
        $form_obj->set('target', 'do_send');

        $form_obj->set('form_error_message', cms::$phrases['newsletters']['error_send']);
        $form_obj->set('form_success_message', cms::$phrases['newsletters']['success_send']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['newsletters']['submit_send']);

        $form_content = $form_obj->process($this->post) . $this->something_after_success_send($form_obj->return_val());
        
        return $this->actions($id) . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        
    }
    
    public function _FORM_do_test($form_obj){
        
        $data = $form_obj->getData();
        $hiddens = $form_obj->get("hiddens");
        
        $id = $hiddens['id'];
        $emails_list = preg_split("/[\s,;]/", $data['emails_text']);

        $n_data = $this->mod->loadItem($id);
        
        load_helpers('encrypt');
        
        $count = 0;
        foreach($emails_list as $email){
            $email = trim($email);
            if(!valid_email($email)){
                $encrypted_email = urlencode(str_crypt($email));
                $message = $this->format_email_message($n_data['mail_body'], $n_data['id'], $encrypted_email);
                if($this->registry->lib->email->send($email, $n_data['title'], $message, $n_data['email_from_name'], $n_data['email_from_email'])){
                    $count++;
                }
            }
        }
        return $count;
        
//        return "<script> 
//                    $('#action_area_$id').html('<p class='msg'>" . cms::$phrases['newsletters']['sended_test_ok'] . " ($count)</p>'); 
//               </script>";
        
    }
    
    public function test(){
        
        $id = $this->get['id'];
        
        $data = $this->mod->loadItem($id);
        $mod = $this->mod->module_info;

        $mod['name'] = 'send';
        $mod['id'] = '_FORM_' . $id;
        $mod['action'] = "javascript: void(\$NAV.post_enctype('?module={$mod['table_name']}&method=test&id=$id', $('#{$mod['id']}')));";
        $mod['redirect'] = "admin.php?module={$mod['table_name']}&method=test&id=$id&ajax=1&form_success=1";

        $mod['hiddens']['id'] = $id;
        $mod['hiddens']['isNew'] = 0;
        $mod['hiddens']['language'] = $this->language;
        $mod['hiddens']['module'] = $this->mod->module_info['table_name'];
        
        $fields = array();
        $fields['emails_text'] = array('name'=>'emails_text', 'type'=>FRM_TEXTAREA, 'title'=>cms::$phrases['newsletters']['emails_text'], 'editable'=>true);
        
        $form_obj = new Form($mod, $fields, array());

        // set action to custom method
        $form_obj->set('target', 'do_test');

        $form_obj->set('form_error_message', cms::$phrases['newsletters']['error_send']);
        $form_obj->set('form_success_message', cms::$phrases['newsletters']['success_send']);
        $form_obj->set('form_submit_btn_title', cms::$phrases['newsletters']['submit_send']);

        $form_content = $form_obj->process($this->post) . $this->something_after_success_send($form_obj->return_val());
        
        return $this->actions($id) . "<div id='action_area_$id' class='action_area'>" . $form_content . "</div>";
        
    }
    
}

?>