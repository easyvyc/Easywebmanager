<?php 

function floordec($zahl,$decimals=2){    
     return floor($zahl/pow(10,$decimals))*pow(10,$decimals);
}

function ceildec($zahl,$decimals=2){    
     return ceil($zahl/pow(10,$decimals))*pow(10,$decimals);
}

function rounddec($zahl,$decimals=2){    
     return round($zahl/pow(10,$decimals))*pow(10,$decimals);
}

function eur($price){
    return number_format($price * 3.4528, 2, ".", "");
}

function parse___list_values($str){

    if(!isset($str) || $str=='') return array();

    $arr = explode("\n", $str);
    foreach($arr as $k=>$v){
            $arr_ = explode("=", $v);
            $arr1[$arr_[0]] = trim($arr_[1]);
    }
    return $arr1;

}

function parse___extra_params($string, $s1="::", $s2="||", $s3="="){

        $arr = explode($s1, $string);
        foreach($arr as $k1=>$v1){

                        $_arr = explode($s2, $v1);
                        //pa($arr);
                        foreach($_arr as $k2=>$v2){
                                $__arr = explode($s3, $v2);
                                if($__arr[0]=="size"){
                                        $___arr = explode("x", $__arr[1]);
                                        $params[$k1][$__arr[0].'_width'] = $___arr[0];
                                        $params[$k1][$__arr[0].'_height'] = $___arr[1];
                                }else{
                                        $params[$k1][$__arr[0]] = $__arr[1];	
                                }
                        }
        }
        return $params;

}

function get_elm_types(){
    global $FORM_ELM_TYPES;
    return $FORM_ELM_TYPES;
}
        
function html2text($document){ 
    $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript 
                   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags 
                   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly 
                   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
    ); 
    $text = preg_replace($search, ' ', $document); 
    return $text; 
}

?>