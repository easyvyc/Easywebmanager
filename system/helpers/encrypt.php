<?php
function str_crypt($str,$ky='eent!@354'){ 
	
	if($ky=='') return $str; 

	$ky = str_replace(chr(32),'',$ky); 

	if(strlen($ky)<8)exit('key error');
	 
	$kl=strlen($ky)<32?strlen($ky):32;
	 
	$k=array();
	for($i=0;$i<$kl;$i++){ 
		$k[$i]=ord($ky{$i})&0x1F;
	} 
	$j=0;
	for($i=0;$i<strlen($str);$i++){ 
		$e=ord($str{$i}); 
		$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e); 
		$j++;$j=$j==$kl?0:$j;
	} 
	return $str;
	 
}

function str2ascii($str){
	$n = strlen($str);
	for($i=0, $new_str=""; $i<$n; $i++){
		$new_str .= ord($str{$i});
	}
	return $new_str;
}
?>