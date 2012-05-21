<?php


$lang['lt']['done'] = "Siuntimas baigtas";
$lang['lt']['choose_category'] = "Nepasirinkta kategorija";

$lang['en']['done'] = "Done";
$lang['en']['choose_category'] = "Choose category";


echo "<script type=\"text/javascript\"> top.content.document.getElementById('LOADING_overlay').style.display = 'none'; </script>";

$rid = $_GET['id'];

if(!is_numeric($rid)){

}

include_once(CLASSDIR."phpmailer.class.php");




$record = $main_object->create($_GET['module']);

$item_data = $record->loadItem($rid);
			
$paging = 100;
if(!isset($_GET['offset'])) $_GET['offset'] = 0;
$start = $_GET['offset']*$paging;
$end = $start + $paging;


//$_POST['emails_categories'] = 1;
$emails_arr = array();
if($_POST['test']==1){
	$e_arr = explode(",", $_POST['emails']);
	foreach($e_arr as $i=>$val){
		$emails_arr[] = array('title'=>trim($val));
	}
	$emails_arr = array_slice($emails_arr, 0, 5);
	$count = count($emails_arr);
}else{
	$sub_obj = $main_object->create("subscribers");
	
	$e_arr = $_POST['emails_categories'];
	$cat_arr = array();
	if(empty($_POST['emails_categories'])){
		echo "<script type=\"text/javascript\"> " .
				" alert('".($lang[$_SESSION['admin_interface_language']]['choose_category'])."') " .
			"</script>";
		exit;		
	}
	foreach($e_arr as $i=>$val){
		$cat_arr[] = "T.category=$val";
	}
	$sub_obj->sqlQueryWhere = " (".implode(" OR ", $cat_arr).") AND ";

	//$sub_obj->sqlQueryWhere .= " T.wrong_email=0 AND ";
	
	$count = 5;//$sub_obj->getCountSearchItems();
	//$sub_obj->sqlQueryLimit = " LIMIT $start, $paging ";
	$sub_obj->sqlQueryLimit = " LIMIT 0, 5 ";
	$emails_arr = $sub_obj->listSearchItems();
	$sub_obj->db->sql;
}
//pae($emails_arr);
//echo $count; exit;
			
$counter = 1;
$cnt = $count;//count($emails_arr);
$emails = array();
//echo count($emails_arr)."<br><br>";
for($i=0, $j=1; $i<$cnt && $i<$paging; $i++){
	
	$val = $emails_arr[$i]['title'];
	if(!isset($val)) continue;

	$mail_address = ereg_replace(";", "", trim($val));

	if($_POST['test']!=1){
		$sql = "SELECT * FROM $record->table_stats WHERE email='$mail_address' AND n_id={$item_data['id']}";
		$database->exec($sql, __FILE__, __LINE__);
		$row = $database->row();
		if(strlen($row['email'])>0){
			continue;
		}
	}
	
	//$mail_address = "vytautas@idp.lt";
	if(strlen($mail_address)>0){

		$mailer = new PHPMailer();

		//$mailer->IsSendmail();
		$encrypted_email = urlencode(str_crypt($mail_address));		
		
		$mailer->CharSet = "UTF-8";
		$mailer->ContentType = "text/html";

		$head = "<head><style> body { font-family:Arial; } p { margin:0px; } </style>\n";
		$head .= "<base href=\"{$configFile->variable['site_url']}\">\n";
		$head .= "</head>\n";
					
		$message = "<body>".$item_data['mail_body']."</body>";
					
		$url_regex = "[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+";
		$message = preg_replace("/href=\"($url_regex)\"/", "href=\"{$configFile->variable['site_url']}emails.php?action=redirect&n={$item_data['id']}&loc=\\1&v=".$encrypted_email."\"", $message, -1);
		$message = preg_replace("/href='($url_regex)'/", "href=\"{$configFile->variable['site_url']}emails.php?action=redirect&n={$item_data['id']}&loc=\\1&v=".$encrypted_email."\"", $message, -1);


		$message .= "<center><br /><br /><span style=\"color:#999;font-size:11px;\">Jei nebenorite gauti mūsų naujienų, spauskite pateiktą nuorodą. <a href=\"{$configFile->variable['site_url']}emails.php?action=cancel&lng=lt&v=".$encrypted_email."\">Atsisakyti</a></span><img src=\"{$configFile->variable['site_url']}emails.php?action=view&n={$item_data['id']}&v=".$encrypted_email."\" width=\"1\" height=\"1\" alt=\"\" />";
		$message .= "<br /><span style=\"color:#999;font-size:11px;\">If you do not want to receive newsletters anymore, then press <a href=\"{$configFile->variable['site_url']}emails.php?action=cancel&lng=en&v=".$encrypted_email."\">here</a></span><img src=\"{$configFile->variable['site_url']}emails.php?action=view&n={$item_data['id']}&v=".$encrypted_email."\" width=\"1\" height=\"1\" alt=\"\" /></center>";
					
		$mailer->Subject = $item_data['title'];
		$mailer->Body = "<html>".$head.$message."</html>";
		$mailer->AltBody = $item_data['plain_text'];
					
		$mailer->From = $item_data['email_from_email'];
		$mailer->FromName = $item_data['email_from_name'];

		//$mailer->AddAddress("vytautas@idp.lt");
		$mailer->AddAddress($mail_address);

		//if($counter%1000==0) mail("vytautas@idp.lt", $counter, $counter);

		//$mailer->Sender = $item_data['return_path'];
		
		if($mailer->Send()){
			
			$emails[] = addcslashes($mail_address, "'");
			$sended_mails = ($_GET['offset']*$paging)+$j++;

			$sql = "INSERT INTO $record->table_stats SET email='$mail_address', n_id='{$item_data['id']}'";
			$database->exec($sql, __FILE__, __LINE__);
			
		}	
		
		/*	echo "$mail_address - ".($counter++)."<br />";
			
		else
			echo "<span style='color:#F00;'>$mail_address</span><br />";*/

	}
	

				
}



//if($cnt>$end) redirect("main.php?content=newsletters&module=newsletters&page=send&id={$_GET['id']}&offset=".($_GET['offset']+1)."&ce=0");

//echo "{$configFile->variable['site_admin_url']}main.php?content={$_GET['content']}&module={$_GET['module']}&page=send&id={$_GET['id']}&offset=".($_GET['offset']+1)."";
//echo implode("<br />", $emails);

if($cnt>$end){
	echo "<script type=\"text/javascript\"> " .
			" top.content.PageClass.submitForm_('{$configFile->variable['site_admin_url']}ajax.php?get=extras/send_newsletter&module={$_GET['module']}&id={$_GET['id']}&offset=".($_GET['offset']+1)."', 'newsletters_loading', top.content.document.forms['mail'], 1); " .
			" top.content.document.getElementById('mail_results').innerHTML = '".(implode(" ", $emails))."'; " .
		"</script>";
}else{
	echo "<script type=\"text/javascript\"> " .
			" top.content.document.getElementById('mail_results').innerHTML = '".(implode(" ", $emails))."'; " .			
			" top.content.document.getElementById('newsletters_loading').innerHTML = '<b>".($lang[$_SESSION['admin_interface_language']]['done'])."</b>'; " .
		"</script>";
	
}


exit;

/*echo "Išsiųsta $cnt laiškų.";
exit;*/

	
?>
