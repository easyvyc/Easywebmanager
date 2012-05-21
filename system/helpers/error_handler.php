<?php
function errorHandler($errno, $errmsg, $filename, $linenum, $vars){
	
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are 2,8,256,512 and 1024
    $errortype = array (
                1    =>  "Error",
                2    =>  "Warning",
                4    =>  "Parsing Error",
                8    =>  "Notice",
                16   =>  "Core Error",
                32   =>  "Core Warning",
                64   =>  "Compile Error",
                128  =>  "Compile Warning",
                256  =>  "User Error",
                512  =>  "User Warning",
                1024 =>  "User Notice",
                2048 =>  "Strict"
                );
    
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

	if($errno!=8 && $errno!=1024 && $errno!=2048 && $errno!=2 && $errno!=512){
		
		if(Config::$val['send_error_email']==1){
			
			if(!in_array($_SERVER['REQUEST_URI'], $_SESSION['debug_errors'])){
				include_once(CLASSDIR."phpmailer.class.php");
				$mailer = new PHPMailer();
				$mailer->CharSet = "UTF-8";
				$mailer->ContentType = "text/plain";
				$mailer->Subject = "ERROR ".Config::$val['pr_url'];
				$mailer->Body = "Date: $dt\nErrornum: $errno\nUrl: {$_SERVER['REQUEST_URI']}\nReferer: {$_SERVER['HTTP_REFERER']}\nErrortype: {$errortype[$errno]}\nErrormsg: $errmsg\nScriptname: $filename\nScriptlinenum: $linenum\n\nDebugtrace:\n".print_r(debug_backtrace(), true);
				$mailer->From = "no-reply@easywebmanager.com";
				$mailer->FromName = "Easywebmanager";
				$mailer->AddAddress(Config::$val['error_email']);
				$mailer->Send();
				$_SESSION['debug_errors'][] = $_SERVER['REQUEST_URI'];
			}
						
			if(APP_NAME=='site') redirect(Config::$val['site_url']);
			
		}else{

		    $err = "<errorentry>\n";
		    $err .= "\t<datetime>" . $dt . "</datetime>\n";
		    $err .= "\t<errornum>" . $errno . "</errornum>\n";
		    $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
		    $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
		    $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
		    $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";
		
		    /*if (in_array($errno, $user_errors))
		        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";*/
		    $err .= "</errorentry>\n\n";		

			ob_clean();
			header("Content-type: text/xml");
			header("Cache-Control: no-store, no-cache");
			header("Pragma: no-cache");
			header("Expires: 0");
		    echo $err;
		    exit;
		}
	}
	
}
?>