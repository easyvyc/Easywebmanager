<?php

function load_helpers(){
	foreach(func_get_args() as $val){
		if(file_exists(HELPERDIR.$val.".php"))
			include_once(HELPERDIR.$val.".php");
		else
			trigger_error("File ".HELPERDIR.$val.".php not exist.");
	}
}

function redirect($str){
	if($str){
		header("Location: ".$str);
	}else{
		redirect("http://".Config::$val['pr_url'].$_SERVER['REQUEST_URI']);
	}
	exit;
}

function log_message($level = 'error', $message, $php_error = FALSE){
	trigger_error($message);	
}

?>