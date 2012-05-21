<?php

include_once(CLASSDIR_."basic.class.php");
class seo extends basic {

	var $MAXIMUM_KEYWORDS_COUNT = 20;
	var $MAXIMUM_STR_LENGTH = 200;

	var $search_HTML_TAGS = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
				"'<a[^>]*?>.*?</a>'si",				
				"'<form[^>]*?>.*?</form>'si",
				"'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n\t])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&#(\d+);'e",
                 "'\r'",
                 "'\n'");                    // evaluate as php

	var $replace_HTML_TAGS = array ("",
				" ",                  
				" ",
				" ",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  "chr(\\1)",
                  " ",
                  " ");
                  
    var $config_keywords = array();

    function seo() {
    	basic::basic();
    	$this->config_keywords = explode(",", $this->XML_CONFIG['keywords']);
    }
    
	function get_htmltag_inner_text($string, $tag_name){
		
		$pos=0;
		$tag_name = mb_strtolower($tag_name, "UTF-8");
		$_tag_inner_text = array();
		while(($_tag_start_pos = mb_strpos($string, "<$tag_name", $pos)) !== false){
			
			if(($_tag_end_pos = mb_strpos($string, "</$tag_name>", $_tag_start_pos))===false) return $_tag_inner_text;
			$tag_length = mb_strpos($string, ">", $_tag_start_pos) - $_tag_start_pos + 1;
			
			$text = mb_substr($string, $_tag_start_pos + $tag_length, $_tag_end_pos - ($_tag_start_pos + $tag_length));
			//$text = strip_tags($text);
			$text = preg_replace($this->search_HTML_TAGS, $this->replace_HTML_TAGS, $text);
			/*$text = ereg_replace("~!#\$\%\^\&\*\(\)\_\+\{\}|\"\:\?><,.\';\[\]=-`\/", "", $text);*/
			
			$_tag_inner_text[] = $text;
			
			$pos = $_tag_end_pos;
			
		}
		
		return $_tag_inner_text;
		
	}

	function keyword_position_description($arr){
		
		$pos = 0;
		if($arr['intitle']) $pos += $arr['intitle']*5;
		if($arr['config']) $pos += $arr['config']*3;
		if($arr['inkeywords']) $pos += $arr['inkeywords']*3;
		
		return $pos;
		
	}

	function keyword_position($arr){
		
		if($arr['count']) $pos = $arr['count'];
		if($arr['intitle']) $pos += 5;
		if($arr['config']) $pos += 3;
		if($arr['inh1']) $pos += 3;
		if($arr['inh2']) $pos += 2;
		
		return $pos;
		
	}
	
	function keywords_compare($arr1, $arr2){
		$place1 = $arr1['pos'];//keyword_position($arr1);
		$place2 = $arr2['pos'];//keyword_position($arr2);
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

	function getKeywords($string){

		$string = mb_strtolower($string, "UTF-8");
		
		list($TITLE_TEXT) = $this->get_htmltag_inner_text($string, "title");
		list($BODY_TEXT) = $this->get_htmltag_inner_text($string, "body");
		list($H1_TEXT) = $this->get_htmltag_inner_text($string, "h1");
		list($H2_TEXT) = $this->get_htmltag_inner_text($string, "h2");
		
		//list($DESCRIPTION_TEXT) = get_htmltag_inner_text($string, "body");
		
		$_h1_array_ =  preg_split("/[\s,]+/", $H1_TEXT);
		$_h2_array_ =  preg_split("/[\s,]+/", $H2_TEXT);
		
		$_title_array_ =  preg_split("/[\s,]+/", $TITLE_TEXT);
		//pa($_title_array_);
		$_words_array_ =  preg_split("/[\s,]+/", $BODY_TEXT);
		//pa($_words_array_);
		$_words_array_count = count($_words_array_); $config_keywords_count = count($this->config_keywords);
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
			if(in_array($_words_array[$i], $this->config_keywords)){
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
			$arr['pos'] = $this->keyword_position($arr);
			if(mb_strlen($arr['word'])>2 && !ereg("[`@#$%^&*()_+|{}:\"<>?/.,';\\=-`]", $arr['word']))
				$_keywords[] = $arr;
		}
		//pa($_keywords);
		$keywords_count = count($_keywords);
		for($i=0; $i<$keywords_count; $i++){
			for($j=0; $j<$i; $j++){
				if($this->keywords_compare($_keywords[$j], $_keywords[$i])){
					$tmp = $_keywords[$j];
					$_keywords[$j] = $_keywords[$i];
					$_keywords[$i] = $tmp;
				}
			}
		}
		
		for($i=0; $i<$this->MAXIMUM_KEYWORDS_COUNT && $i<$keywords_count; $i++){
			$keywords_in_use[] = $_keywords[$i]['word'];
		}
		
		//$keywords = implode(", ", $keywords_in_use);
		
		return $keywords_in_use;
		
	}
	
	function getDescription($string, $page_data, $blocks){
		
		$string = mb_strtolower($string, "UTF-8");
		
//		list($TITLE_TEXT) = $this->get_htmltag_inner_text($string, "title");
//		list($BODY_TEXT) = $this->get_htmltag_inner_text($string, "body");
		//list($DESCRIPTION_TEXT) = get_htmltag_inner_text($string, "body");
		
		$TITLE_TEXT = $page_data['page_title'];
		$H1_TEXT = $page_data['title'];
		$_h1_array_ =  preg_split("/[\s,]+/", $H1_TEXT);
		foreach($blocks as $block){
			$blocks1[] = preg_replace($this->search_HTML_TAGS, $this->replace_HTML_TAGS, $block);
		}
		$BODY_TEXT = implode(" ", $blocks1);
		
		//pa($arr); exit;
		
		$_title_array_ =  preg_split("/[\s,]+/", $TITLE_TEXT);
		//pa($_title_array_);
		$_words_array_ =  preg_split("/[\(\)\[\]\{\}\.\?\!]+/", $BODY_TEXT);
		//pa($_words_array_);
		$_words_array_count = count($_words_array_); $config_keywords_count = count($this->config_keywords);
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
			foreach($this->config_keywords as $key=>$val){
				if(mb_ereg($val, $arr['word'])){
					$arr['config'] += 1;
				}
			}
		
			foreach($_title_array_ as $key=>$val){
				if(mb_ereg($val, $arr['word'])){
					$arr['intitle'] += 1;
				}
			}
			
			$keywords_arr = explode(",", $page_data['keywords']);
			foreach($keywords_arr as $key=>$val){
				if(mb_ereg(trim($val), $arr['word'])){
					$arr['inkeywords'] += 1;
				}
			}

			foreach($_h1_array_ as $key=>$val){
				if(mb_ereg(trim($val), $arr['word'])){
					$arr['inh1'] += 1;
				}
			}
			
			$arr['pos'] = $this->keyword_position_description($arr);
			if(mb_strlen($arr['word'])>10)
				$_keywords[] = $arr;
		}
		
		$keywords_count = count($_keywords);
		for($i=0; $i<$keywords_count; $i++){
			for($j=0; $j<$i; $j++){
				if($this->keywords_compare($_keywords[$j], $_keywords[$i])){
					$tmp = $_keywords[$j];
					$_keywords[$j] = $_keywords[$i];
					$_keywords[$i] = $tmp;
				}
			}
		}
		
		//pae($_keywords);
		
		for($i=0, $description=""; $i<$keywords_count && mb_strlen($description)<$this->MAXIMUM_STR_LENGTH; $i++){
			$description .= $_keywords[$i]['word'];
		}		
		
		return htmlspecialchars($description);
		
	}   
	 
}

?>