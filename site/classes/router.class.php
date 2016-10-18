<?php

class router {
	
	public static $reserved_url_words = array(
					'sitemap'=>'sitemap', 
					'search'=>'search', 
					'advanced'=>'advanced',
					'id'=>'id', 				
					'products'=>'products',
					'pages'=>'pages',
					'add_page_tab'=>'add_page_tab',
					'lets_play'=>'lets_play',
					'info'=>'info',
                                        'user_info'=>'user_info',
                                        'pay_info'=>'pay_info',
                                        'confirm'=>'confirm',
					'list'=>'c_list',
					'step'=>'step',
					'date'=>'date',
					'logout'=>'logout',
                                        'cart'=>'cart',
                                        'checkout'=>'checkout',
					'offset'=>'offset'
	);	
	
	function __construct(){
		
		list($path, $query) = explode("?", $_SERVER['REQUEST_URI']);
		
		if($query){
			parse_str($query, $get);
			foreach($get as $key=>$val){
				$_GET[$key] = $val;
			}
		}
		
	}
	
	function detect_url_controller($path){

		$path_arr = explode("/", trim($path, "/"));
		$first = array_shift($path_arr);
		$second = array_shift($path_arr);
		if(isset(self::$reserved_url_words[$first])){
			if(isset($second) && $second)
				return array('c'=>self::$reserved_url_words[$first], 'm'=>$second, 'p'=>$path_arr);
			else 
				return self::$reserved_url_words[$first];
		}
		return false;
		
	}
	
	function website_path_info($path_info){
		if(!isset($path_info) || $path_info=='') $path_info = '/';
		$path_info = addcslashes($path_info, "'\\");
		if(preg_match("/\-([0-9]{1,})\.html$/", $path_info, $regs)){
			$_GET['_ID_'] = $regs[1];
			$arr = explode("/", $path_info);
			unset($arr[count($arr)-1]);
			$path_info = implode("/", $arr)."/";
		}
		return $path_info;
	}	
	
}

?>