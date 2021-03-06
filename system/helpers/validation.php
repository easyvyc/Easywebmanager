<?php
function required($val){
	if(strlen($val)==0) return true;
	return false;
}

function valid_email($email){
	if (preg_match("/^.+@.+\\..+$/", $email))
		return false;
	else
		return true;
}

function valid_login($login){
	if (preg_match("/^[a-zA-Z0-9]{4,15}$/", $login))
		return false;
	else
		return true;
}

function valid_time($time){
	if (preg_match("/^[0-9]{1,2}(:[0-9]{2}){1,2}$/", $time))
		return false;
	else
		return true;
}

function valid_number($time){
	//echo $time; exit;
	if (preg_match("/^[0-9]{1,}$/", $time))
		return false;
	else
		return true;
}

function valid_price($time){
	if (preg_match("/^[0-9]{1,}+(\.+[0-9]{1,2}){0,1}$/", $time))
		return false;
	else
		return true;
}

function valid_float($time){
	if (preg_match("/^[0-9]{1,}+(\.+[0-9]{1,}){0,1}$/", $time))
		return false;
	else
		return true;
}

function valid_table_name($value){
	if (preg_match("/^[0-9a-zA-Z_]{1,}$/", $value))
		return false;
	else
		return true;
}

function valid_banner($filename){
	
	$arr = explode(".", $filename);
	$VALID_BANNER_FORMAT[] = "jpg";
	$VALID_BANNER_FORMAT[] = "swf";
	$VALID_BANNER_FORMAT[] = "jpeg";
	$VALID_BANNER_FORMAT[] = "gif";
	$VALID_BANNER_FORMAT[] = "png";
	$VALID_BANNER_FORMAT[] = "bmp";
	if (in_array($arr[(count($arr)-1)], $VALID_BANNER_FORMAT))
		return false;
	else
		return true;
}

function valid_banner_size($time){
	if (preg_match("/^[0-9]{1,}+x{1}+[0-9]{1,}$/", $time))
		return false;
	else
		return true;
}

function valid_url($url){
  if (!preg_match("/^((ht|f)tp://)((([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))|(([0-9]{1,3}\.){3}([0-9]{1,3})))((/|\?)[a-z0-9~#%&'_\+=:\?\.-]*)*)$/i", $url)) { 
    return 1; 
  } else { 
    return 0; 
  } 
}

function valid_page_url($url){
  if(!preg_match("/^([a-zA-Z0-9\.\-]|_|\/){1,}$/", $url)){ 
    return 1; 
  } else { 
    return 0; 
  } 
}

function valid_card_number($time){
	if (preg_match("/^[0-9]{4}+\-[0-9]{4}+\-[0-9]{4}+\-[0-9]{4}$/", $time))
		return false;
	else
		return true;
}

function valid_card_expire_date($time){
	if (preg_match("/^20+[0-9]{2}+\-[0|1]{1}+[0-9]{1}$/", $time))
		return false;
	else
		return true;
}

function checkFloat($value){
	$val = is_array($value)?$value['value']:$value;
	if(!preg_match("/^(\d+)\.(\d+)$/", $val)
	&&	!preg_match("/^\d+$/", $val)) 			return 1;
	else										return 0;
}

function checkNumber($val){
	$val = is_array($value)?$value['value']:$value;
	if(!preg_match("/^\d+$/", $val))	return 1;
	else								return 0;
}

function isUploadedFile($value){
	$val = is_array($value)?$value['name']:$value;
	if(!is_uploaded_file($_FILES[$val]['tmp_name'])&&!file_exists(DOCUMENTSDIR."dump.sql"))
		return 1;
	else
		return 0;
}

function valid_year_month($date){
    if (preg_match("/^[0-9]{4}\-[0-9]{2}$/", $date))
        return false;
    else
        return true;
}


?>