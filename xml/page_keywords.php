<?php
//error_reporting(E_ALL);
$MAXIMUM_KEYWORDS_COUNT = 20;

$search_HTML_TAGS = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e",
                 "'\r'",
                 "'\n'");                    // evaluate as php

$replace_HTML_TAGS = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)",
                  " ",
                  " ");


$lng = $_GET['lng'];

include_once(CLASSDIR."xmlini.class.php");
$xml = & new xmlIni();
//$xmlNode = new xmlIni();

ob_start();
$pages_obj = $main_object->create("pages");

$page_data = $pages_obj->loadItem($_GET['id']);

//$page_data = $pages->data;
$curlVar = curl_init($configFile->variable['site_url'].$lng."/".$page_data['page_url']);
curl_setopt(CURLOPT_RETURNTRANSFER, 0);
curl_exec($curlVar);
curl_close($curlVar);
$string = ob_get_contents();
ob_clean();


/*
include_once(CLASSDIR_."catalog.class.php");
$keywords_obj = & new catalog("keywords");


$arr = $keywords_obj->listItems(0,0);//preg_split("/[\s,]+/", $search_engines['page_keywords'][$_SESSION['site_lng']]);
foreach($arr as $key => $val){
	$config_keywords[] = $val['title'];
}
*/



function get_htmltag_inner_text($string, $tag_name){
	
	global $search_HTML_TAGS, $replace_HTML_TAGS;
	
	$pos=0;
	$tag_name = mb_strtolower($tag_name, "UTF-8");
	
	while(($_tag_start_pos = mb_strpos($string, "<$tag_name", $pos)) !== false){
		
		$_tag_end_pos = mb_strpos($string, "</$tag_name>", $pos);
		$tag_length = mb_strpos($string, ">", $_tag_start_pos) - $_tag_start_pos;
		
		$text = mb_substr($string, $_tag_start_pos + $tag_length, $_tag_end_pos - ($_tag_start_pos + $tag_length));
		//$text = strip_tags($text);
		$text = preg_replace($search_HTML_TAGS, $replace_HTML_TAGS, $text);
		/*$text = ereg_replace("~!#\$\%\^\&\*\(\)\_\+\{\}|\"\:\?><,.\';\[\]=-`\/", "", $text);*/
		
		$_tag_inner_text[] = $text;
		
		$pos = $_tag_end_pos;
		
	}
	
	return $_tag_inner_text;
	
}

function keyword_position($arr){
	
	if($arr['count']) $pos = $arr['count'];
	if($arr['intitle']) $pos += 5;
	if($arr['config']) $pos += 3;
	if($arr['inh1']) $pos += 3;
	if($arr['inh2']) $pos += 2;
	
	return $pos;
	
	/*if($arr['intitle'] && $arr['config'] && $arr['count']){
		return 1;
	}
	if($arr['intitle'] && $arr['config']){
		return 3;
	}
	if($arr['config'] && $arr['count']){
		return 4;
	}
	if($arr['intitle'] && $arr['count']){
		return 2;
	}
	if($arr['intitle']){
		return 6;
	}
	if($arr['count']){
		return 5;
	}*/
}

function keywords_compare($arr1, $arr2){
	$place1 = keyword_position($arr1);
	$place2 = keyword_position($arr2);
	if($place1 > $place2){
		return false;
	}
	if($place1 < $place2){
		return true;
	}
	if($place1 == $place2){
		if($arr1['count'] < $arr2['count']){
			return true;
		}
	}

}


$string = mb_strtolower($string, "UTF-8");

list($TITLE_TEXT) = get_htmltag_inner_text($string, "title");
list($BODY_TEXT) = get_htmltag_inner_text($string, "body");
list($H1_TEXT) = get_htmltag_inner_text($string, "h1");
list($H2_TEXT) = get_htmltag_inner_text($string, "h2");

//list($DESCRIPTION_TEXT) = get_htmltag_inner_text($string, "body");

$_h1_array_ =  preg_split("/[\s,]+/", $H1_TEXT);
$_h2_array_ =  preg_split("/[\s,]+/", $H2_TEXT);

$_title_array_ =  preg_split("/[\s,]+/", $TITLE_TEXT);
//pa($_title_array_);
$_words_array_ =  preg_split("/[\s,]+/", $BODY_TEXT);
//pa($_words_array_);
$_words_array_count = count($_words_array_); $config_keywords_count = count($config_keywords);
for($i=0; $i<$_words_array_count; $i++){
	$_words_array_[$i] = trim($_words_array_[$i]);
	if(strlen($_words_array_[$i])>3){
		$_words_array[] = $_words_array_[$i];
	}
}

$_words_array_count = count($_words_array);
for($i=0; $i<$_words_array_count; $i++){
	$counter = 1; $arr = array();
	$arr['word'] = $_words_array[$i];
	for($j=$i+1; $j<$_words_array_count; $j++){
		if($_words_array[$i]==$_words_array[$j]){
			$counter++;
			unset($_words_array[$j]);
		}
	}
	$arr['count'] = $counter;
	if(in_array($_words_array[$i], $config_keywords)){
		$arr['config'] = true;
	}
	if(in_array($_words_array[$i], $_title_array_)){
		$arr['intitle'] = true;
	}
	if(in_array($_words_array[$i], $_h1_array_)){
		$arr['inh1'] = true;
	}
	if(in_array($_words_array[$i], $_h2_array_)){
		$arr['inh2'] = true;
	}
//	if(in_array($_words_array[$i], $_description_array_)){
//		$arr['indescription'] = true;
//	}
	if(mb_strlen($arr['word'])>3 && !ereg("[`@#$%^&*()_+|{}:\"<>?/.,';\\=-`]", $arr['word']))
		$_keywords[] = $arr;
}
//pa($_keywords);
$keywords_count = count($_keywords);
for($i=0; $i<$keywords_count; $i++){
	for($j=0; $j<$i; $j++){
		if(keywords_compare($_keywords[$j], $_keywords[$i])){
			$tmp = $_keywords[$j];
			$_keywords[$j] = $_keywords[$i];
			$_keywords[$i] = $tmp;
		}
	}
}

for($i=0; $i<$MAXIMUM_KEYWORDS_COUNT && $i<$keywords_count; $i++){
	$keywords_in_use[] = $_keywords[$i]['word'];
}

$keywords = implode(", ", $keywords_in_use);
//echo $keywords; exit;
/*
$xml->xmlTree->name = "keywords";
$xml->xmlTree->content = $keywords;

$xml_source = $xml->objToXml($xml->xmlTree);
*/

echo $keywords;
exit;

?>