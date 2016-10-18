<?php

include_once(APP_CLASSDIR."lib.class.php");
class lib_email extends lib {
	
    private $mailer;
    
    protected $clear_before_send = true;
    protected $smtp = array();    
    protected $settings = array('content_type'=>'text/html', 'charset'=>'UTF-8');
	
    function __construct(){
        parent::__construct("email");
        include_once(CLASSDIR."phpmailer.class.php");
        $this->mailer = new PHPMailer();
    }

    function send($email, $subject, $message, $from_name, $from_email, $attachements = array()){
        
        if($this->clear_before_send){
            $this->mailer->ClearAllRecipients();
            $this->mailer->ClearAttachments();
            $this->mailer->ClearCustomHeaders();
            $this->mailer->ClearReplyTos();
        }
        
        if(!empty($this->smtp)){
            $this->mailer->IsSMTP();
            $this->mailer->Host = $this->smtp['host'];
            if($this->smtp['port']){
                $this->mailer->Port = $this->smtp['port'];
            }
            if($this->smtp['username']){
                $this->mailer->SMTPAuth = true;  
                $this->mailer->Username = $this->smtp['username'];
                $this->mailer->Password = $this->smtp['password'];      
            }
        }
        
        $this->mailer->CharSet = $this->settings['charset'];//"UTF-8";

        $this->mailer->ContentType = $this->settings['content_type'];//"text/plain";
        foreach($attachements as $file){
            if(is_array($file)){
                if(file_exists($file['file'])){
                    $this->mailer->AddAttachment($file['file'], $file['name']);
                }elseif($file['str']){
                    $this->mailer->AddStringAttachment($file['str'], $file['name']);
                }
            }else{
                if(file_exists($file)){
                    $this->mailer->AddAttachment($file, basename($file));
                }
            }
        }


        $this->mailer->Subject = $subject;

        $this->mailer->Body = $message;

        $this->mailer->AddAddress($email);

        $this->mailer->From = $from_email;
        $this->mailer->FromName = $from_name;
        
        $return = $this->mailer->Send();

        return $return;
        
    }    
	
}

?>
