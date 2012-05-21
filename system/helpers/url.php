<?php

// 
$reserved_url_words = array(
				'sitemap'=>'sitemap', 
				'search'=>'search', 
				'register'=>'register',
				'id'=>'id', 				
				'rss'=>'rss',
				'action'=>'action',
				'delete'=>'delete',
				'step'=>'step',
				'date'=>'date',
				'logout'=>'logout',
				'order'=>'order',
				'offset'=>'offset', 
				'thanks'=>'thanks'
);

function replaceLetters($str) {

	$str = ereg_replace("&#39;", "'", $str);
	$str = ereg_replace("[\'\<\>\"{`\!\%\(\);\{\}\+\-\*\&\#]", "-", $str);

	$search_arr = array	("#", "ą", "č", "ę", "ė", "į", "š", "ų", "ū", "ž", " ", /* LT */ 
						"й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ", "э", "ж", "д", "л", "о", "р", "п", "а", "в", "ы", "ф", "я", "ч", "с", "м", "и", "т", "ь", "б", "ю", /* Russki */
						"ī", "ņ", "ā", "ē", "ļ", "ģ", /* Latviesu */
						"ä", "ö", "ü", "õ", "å", /* Eesti Swedish Suomi */
						"ç", "ë", "í", "ñ", "é", "è", "á", "à",  
						"ć", "ł", "ń", "ó", "ś", "ź", "ż", /* Poland */
						"ß", /* Deutche unliaut */
						"æ", "ø", "ê", "ò", "â", "ô" /* Norway */
						);
						
	$replace_arr = array("-", "a", "c", "e", "e", "i", "s", "u", "u", "z", "-", 
						"j", "c", "u", "k", "e", "n", "g", "s", "t", "z", "x", "j", "e", "z", "d", "l", "o", "r", "p", "a", "v", "i", "f", "a", "h", "s", "m", "i", "t", "j", "b", "j",
						"i", "n", "a", "e", "l", "g",
						"a", "o", "u", "o", "a", /* Eesti Swedish Suomi */
						"c", "e", "i", "n", "e", "e", "a", "a",  
						"c", "l", "n", "o", "s", "z", "z", /* Poland */
						"s", /* Deutche unliaut */
						"e", "o", "e", "o", "a", "o" /* Norway */
						);

	$str = stripslashes(mb_strtolower($str, "utf-8"));
	$n = mb_strlen($str, "utf-8");
	for ($i = 0; $i < $n; $i ++) {
		$let = mb_substr($str, $i, 1, "utf-8");
		if (in_array($let, $search_arr)) {
			$key = array_search($let, $search_arr);
			$str = mb_substr($str, 0, $i, "utf-8").$replace_arr[$key].mb_substr($str, $i +1, $n - $i, "utf-8");
		}
		elseif (preg_match("/[0-9a-zA-Z_.,-]/", $let) == 0) { //neatitinka
			$str = mb_substr($str, 0, $i, "utf-8").mb_substr($str, $i +1, $n - $i, "utf-8");
			$n --;
		}
	}
	$str = ereg_replace("\.", "", $str);
	$str = ereg_replace(",", "", $str);
	return $str;
}

function website_path_info($path_info){ 
	if(!isset($path_info) || $path_info=='') $path_info = '/';
	$path_info = addcslashes($path_info, "'\\");
	if(ereg("\-([0-9]{1,})\.html$", $path_info, $regs)){
		$_GET['id'] = $regs[1];
		$arr = explode("/", $path_info);
		unset($arr[count($arr)-1]);
		$path_info = implode("/", $arr)."/";
	}
	return $path_info;
}


?>