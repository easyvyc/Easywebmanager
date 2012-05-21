<?php
function checkSendMail($post){
	
	$error = array();
	if($post['nm']=='') $error[] = array('column'=>'nm');
	if($post['em']=='') $error[] = array('column'=>'em');
	if($post['question']=='') $error[] = array('column'=>'question');
	return $error;
	
}

function sendMail($data){

	unset($data['post']['VIEWSTATE']);
	
	include_once(CLASSDIR_."phpmailer.class.php");
	$mailer = new PHPMailer();
	
	$mailer->CharSet = "windows-1257";
	$mailer->Subject = iconv('UTF-8', 'windows-1257', "\"{$data['params']['subject']}\" -> ".Config::$val['pr_url']);
	$message = date('Y-m-d H:i')."\r\n";
	$mailer->ContentType = "text/plain";
	foreach($data['post'] as $key=>$val){
		if($key!='action' && $key!='submit') $message .= "$key: $val\r\n";
	}
	foreach($data['files'] as $key=>$val){
		$mailer->AddAttachment($val['tmp_name'], $val['name']);
	}
	$mailer->Body = iconv('UTF-8', 'windows-1257', $message);
	
	$mailto = (strlen($data['params']['emails'])>0?$data['params']['emails']:Config::$val['pr_email']);
	$mailer->AddAddress($mailto);
	$mailer->From = isset($data['post']['em'])?iconv('UTF-8', 'windows-1257', $data['post']['em']):$mailto;
	$mailer->FromName = isset($data['post']['nm'])?iconv('UTF-8', 'windows-1257', $data['post']['nm']):Config::$val['pr_url'];
	$mailer->Send();			
	
	return "Užklausa išsiųsta sėkmingai.";
	
}
?>