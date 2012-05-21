<?php
function csv_to_arr($file, $separator=",", $encoding="windows-1257", $sep_title="***"){
	
	include_once(CLASSDIR.'csvreader/FileReader.php');
	include_once(CLASSDIR.'csvreader/CSVReader.php');

	$reader = new CSVReader( new FileReader($file) );

	$reader->setSeparator($separator);
	
	$row = 0; $_data = false;
	while( false != ( $cell = $reader->next() ) ){
		$n = count($cell);
		$csv_['error'] = "1";
		if($row == 0){
			for ($i=0; $i<$n; $i++ ){
				$columns[$i]['name'] = strtolower($cell[$i]);
//				if($encoding != "UTF-8")
//					$columns[$i]['name'] = iconv($encoding, "UTF-8", $columns[$i]['name']);
			}
		}
		if($row == 1){
			for ($i=0; $i<$n; $i++ ){
				if($encoding != "UTF-8")
					$columns[$i]['title'] = iconv($encoding, "UTF-8", $cell[$i]);
				else
					$columns[$i]['title'] = $cell[$i];
			}
		}
		if($_data === true){
			for ($i=0; $i<$n; $i++ ){
				if(isset($columns[$i]['name']) && strlen($columns[$i]['name']))
					if($encoding != "UTF-8")
						$data[$columns[$i]['name']] = iconv($encoding, "UTF-8", $cell[$i]);
					else
						$data[$columns[$i]['name']] = $cell[$i];
			}
			$csv[] = $data;
		}
		if($cell[0] == $sep_title){
			$_data = true;
			$csv_['error'] = "";
		}
		$row++;
		
	}
	$csv_['data'] = $csv;
	$csv_['cols'] = $columns;
	return $csv_;
}
?>