<?php

include_once(APP_CLASSDIR . "controller.class.php");
class controller_users extends controller {
	
    public static $phrases;

    function __construct(){
        parent::__construct("users");
        self::$phrases = $this->registry->controller->phrases->loadPhrases();
        TPL::setVar('phrases', self::$phrases);
    }

    function getUserId(){
        return ($_SESSION['logged_user']['id'] ? $_SESSION['logged_user']['id'] : 0);
    }

    function login(){
        if($_POST['action'] == 'login'){
            if($user_id = $this->mod->try_login($_POST['email'], $_POST['password'])){
                $_SESSION['logged_user'] = $this->mod->loadItem($user_id);
                $arr = array('title' => self::$phrases['login_dialog_title'], 'content' => TPL::parse(TPLDIR."users/login_success.tpl"));
                return json_encode($arr);
            }else{
                TPL::setVar('login_wrong', true);
            }
        }
        $arr = array('title' => self::$phrases['login_dialog_title'], 'content' => TPL::parse(TPLDIR."users/login.tpl"));
        return json_encode($arr);
    }

    function logout(){
        unset($_SESSION['logged_user']);
        $arr = array('title' => '', 'content' => TPL::parse(TPLDIR."users/logout.tpl"));
        return json_encode($arr);
    }
    
    function register(){
        if($_POST['action'] == 'register'){
            if($_POST['usertype'] == 'company'){
                $_POST['city'] = $_POST['city_company'];
                $_POST['address'] = $_POST['address_company'];
            }
            if(!$this->mod->checkExists('email', $_POST['email'], 0)){
                $_POST['active'] = 1;
                $_POST['pswd'] = md5($_POST['pswd_1']);
                $id = $this->mod->insert($_POST);
                $_SESSION['logged_user'] = $this->mod->loadItem($id);
                TPL::setVar('continue_checkout', (!empty($_SESSION['cart']) ? true : false));
                $html = TPL::parse(TPLDIR."users/register_success.tpl");
            }else{
                TPL::setVar('email_exists', true);
                $_POST['usertype_' . $_POST['usertype']] = true;
                TPL::setVar('cart_user', $_POST);
                $html = TPL::parse(TPLDIR."users/register.tpl");
            }
            $arr = array('title' => self::$phrases['register_dialog_title'], 'content' => $html);
            return json_encode($arr);
        }
        $arr = array('title' => self::$phrases['register_dialog_title'], 'content' => TPL::parse(TPLDIR."users/register.tpl"));
        return json_encode($arr);        
    }
    
    function forget(){
        if($_POST['action'] == 'forget'){
            if($this->mod->checkExists('email', $_POST['email'])){
                
                $user_data = $this->mod->loadBy(array('email' => $_POST['email']));
                $user_data = $user_data[0];
                
                $confirm_code = md5(date('YmdHis'));
                $this->mod->update(array('confirm_code'=>$confirm_code, 'confirm_date'=>date('Y-m-d H:i:s')), array('record_id'=>$user_data['id']));
                
                TPL::setVar('forget_user_data', $user_data);
                TPL::setVar('confirm_code', $confirm_code);
                
                $this->registry->lib->email->set('settings', array('content_type'=>'text/html', 'charset'=>'UTF-8'));
                $this->registry->lib->email->send($user_data['email'],  self::$phrases['forget_email_subject'], TPL::parse(TPLDIR."users/forget_email.tpl", Config::$val['pr_url'], "no-reply@" . Config::$val['pr_url']));
                // create confirm code
                // send email to change password
                
                $arr = array('title' => self::$phrases['forget_dialog_title'], 'content' => TPL::parse(TPLDIR."users/forget_success.tpl"));
                return json_encode($arr);
            }else{
                TPL::setVar('login_wrong', true);
            }
        }
        $arr = array('title' => self::$phrases['forget_dialog_title'], 'content' => TPL::parse(TPLDIR."users/forget.tpl"));
        return json_encode($arr);
    }
    
    function reset(){
        
        $data = $this->mod->loadBy(array('confirm_code'=>$_GET['code'], 'confirm_date' => array('op'=>' > ', 'value' => date(0,0,0,date("m"),date("d")-3,date("Y")))));
        
        if(empty($data)){
            
            $arr = array('title' => self::$phrases['reset_dialog_title'], 'content' => TPL::parse(TPLDIR."users/reset_wrong.tpl"));
            return json_encode($arr);
            
        }else{
            
            $user_data = $data[0];
            TPL::setVar('reset_user_data', $user_data);
            
            if($_POST['action'] == 'reset'){
                
                $this->mod->update(array('pswd' => md5($_POST['pswd_1']), 'confirm_code'=>'', 'confirm_date'=>null), array('record_id'=>$user_data['record_id']));
                
                $arr = array('title' => self::$phrases['forget_dialog_title'], 'content' => TPL::parse(TPLDIR."users/reset_success.tpl"));
                return json_encode($arr);
            }
            
            $arr = array('title' => self::$phrases['reset_dialog_title'], 'content' => TPL::parse(TPLDIR."users/reset.tpl"));
        }
        
        return json_encode($arr);
        
    }
    
        
}

?>
