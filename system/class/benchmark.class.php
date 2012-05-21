<?php

benchmark::mark(benchmark::$start_mark, 'Start benchmark');

/** 
 * @author Vytautas
 * 
 * 
 */
class benchmark {
	
	public static $start_mark = '_START_';
	private static $marker = array();
	private static $mode = false;
	
	static function mark($name = '', $msg = ''){
		if(!self::$mode) return false;
		$arr = array();
		$arr['msg'] = $msg;
		$arr['timer'] = microtime();
		$arr['memory'] = memory_get_usage(true);
		if($name!=''){
			self::$marker[$name] = $arr;
		}else{
			self::$marker[] = $arr;
		}
	}
	
	// Elapsed time
	static function time($mark1 = '', $mark2 = '', $decimals = 4){
		
		if($mark1 == ''){
			$mark1 = self::$start_mark;
		}
		
		if(!isset(self::$marker[$mark1])){
			return '';
		}

		if(!isset(self::$marker[$mark2])){
			self::$marker[$mark2]['timer'] = microtime();
		}

		list($sm, $ss) = explode(' ', self::$marker[$mark1]['timer']);
		list($em, $es) = explode(' ', self::$marker[$mark2]['timer']);

		return number_format(($em + $es) - ($sm + $ss), $decimals);
	}

	// amount of memory, that's currently being allocated to PHP script.
	static function memory($mark){
		
		if(!isset($mark) || !isset(self::$marker[$mark])){
			$size = memory_get_usage(true);
		}else{
			$size = self::$marker[$mark]['memory'];
		}		
		
		$unit=array('b','kb','mb','gb','tb','pb');
    	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    	
	}
	
	static function result(){
		if(!self::$mode) return '';
		
		$b_str = "<div class='rel'>";
		$b_str.= "<div class='abs close' onclick=\"javascript: $('#benchmark').remove();\">x</div>";
		$b_str.= "<div>REQUEST_URI: {$_SERVER['REQUEST_URI']}</div>";
		$b_str.= "<table id='_DEBUG_' width='100%' border='1'>";
		foreach(self::$marker as $mark=>$val){
			if(isset($prev)){
				$time = self::time($prev, $mark);
				$memory = self::memory($mark);
				$b_str .= "<tr><td>Time: $time</td><td>Memory: $memory</td><td>{$val['msg']}</td></tr>";
			}
			$prev = $mark;
		}

		$time = self::time();
		$memory = self::memory();
		$b_str .= "<tr><th>Time: $time</th><th>Memory: $memory</th><th></th></tr>";
		$b_str .= "</table></div>";
		
		return $b_str;
		
	}
	
}

?>