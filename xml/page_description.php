<?php
/*
 * Created on 2007.3.17
 * page_description.php
 * Vytautas
 */

$MAXIMUM_KEYWORDS_COUNT = 5;
$MAXIMUM_STR_LENGTH = 200;


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
                 "'&#(\d+);'e");                    // evaluate as php

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
                  "chr(\\1)");

include_once(CLASSDIR."xmlini.class.php");
$xml = & new xmlIni();
//$xmlNode = new xmlIni();

ob_start();
$pages = $main_object->create("pages");

$page_data = $pages->loadItem($_GET['id']);
//$page_data = $pages->data;
$curlVar = curl_init($configFile->variable['site_url'].$lng."/".$page_data['page_url']);
curl_setopt(CURLOPT_RETURNTRANSFER, 0);
curl_exec($curlVar);
curl_close($curlVar);
$string = ob_get_contents();
ob_clean();


//$xmlFile = 'files/data/search.xml';
//$search_engines = File::xmlFileToArray($xmlFile);

include_once(CLASSDIR_."catalog.class.php");
$keywords_obj = & new catalog("keywords");

$arr = $keywords_obj->listItems(0,0);//preg_split("/[\s,]+/", $search_engines['page_keywords'][$_SESSION['site_lng']]);
foreach($arr as $key => $val){
	$config_keywords[] = $val['title'];
}

function get_htmltag_inner_text($string, $tag_name){
	
	global $search_HTML_TAGS, $replace_HTML_TAGS;
	
	$pos=0;
	$tag_name = mb_strtolower($tag_name, "UTF-8");
	
	while(($_tag_start_pos = mb_strpos($string, "<$tag_name", $pos)) !== false){
		
		$_tag_end_pos = mb_strpos($string, "</$tag_name>", $pos);
		$tag_length = mb_strpos($string, ">", $_tag_start_pos) - $_tag_start_pos;
		
		$text = mb_substr($string, $_tag_start_pos + $tag_length + 1, $_tag_end_pos - ($_tag_start_pos + $tag_length) - 1);
		//$text = strip_tags($text);
		$text = preg_replace($search_HTML_TAGS, $replace_HTML_TAGS, $text);
		$text = preg_replace("/\r/", " ", $text);
		$text = preg_replace("/\n/", " ", $text);
		$text = preg_replace("/[\s]{2,}/", " ", $text);
		
		$_tag_inner_text[] = $text;
		
		$pos = $_tag_end_pos;
		
	}
	
	return $_tag_inner_text;
	
}

function keyword_position($arr){
	
	return ($arr['intitle'] + $arr['config'])*(-1); 
	
}

function keywords_compare($arr1, $arr2){
	$place1 = keyword_position($arr1);
	$place2 = keyword_position($arr2);
	if($place1 < $place2){
		return false;
	}
	if($place1 > $place2){
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
//list($DESCRIPTION_TEXT) = get_htmltag_inner_text($string, "body");

$_title_array_ =  preg_split("/[\s,]+/", $TITLE_TEXT);
//pa($_title_array_);
$_words_array_ =  preg_split("/[\.\?\!]+/", $BODY_TEXT);
//pa($_words_array_);
$_words_array_count = count($_words_array_); $config_keywords_count = count($config_keywords);
for($i=0; $i<$_words_array_count; $i++){
	$_words_array_[$i] = trim($_words_array_[$i]);
	if(strlen($_words_array_[$i])>10){
		$_words_array[] = $_words_array_[$i];
	}
}

$_words_array_count = count($_words_array);


for($i=0; $i<$_words_array_count; $i++){
	$counter = $i; $arr = array();
	$arr['word'] = $_words_array[$i];
	$arr['config'] = 0; $arr['intitle'] = 0;
	foreach($config_keywords as $key=>$val){
		if(mb_ereg($val, $arr['word'])){
			$arr['config'] += 1;
		}
	}

	foreach($_title_array_ as $key=>$val){
		if(mb_ereg($val, $arr['word'])){
			$arr['intitle'] += 1;
		}
	}
	
//	if(in_array($_words_array[$i], $_description_array_)){
//		$arr['indescription'] = true;
//	}
	if(mb_strlen($arr['word'])>10)
		$_keywords[] = $arr;
}

//pae($_keywords);

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

for($i=0, $keywords=""; $i<$MAXIMUM_KEYWORDS_COUNT && $i<$keywords_count && mb_strlen($keywords)<$MAXIMUM_STR_LENGTH; $i++){
	$keywords .= $_keywords[$i]['word'];
}

//$keywords = implode("", $keywords_in_use);
echo $keywords; exit;

$xml->xmlTree->name = "keywords";
$xml->xmlTree->content = $keywords;

$xml_source = $xml->objToXml($xml->xmlTree);
 
 
?>
