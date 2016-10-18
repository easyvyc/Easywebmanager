<?php

function my__autoload($class_name) {
    if(file_exists(APP_CLASSDIR.$class_name.".class.php")){
    	include_once(APP_CLASSDIR.$class_name.".class.php");
    	return true;
    }
    if(file_exists(CLASSDIR.$class_name.".class.php")){
    	include_once(CLASSDIR.$class_name.".class.php");
    	return true;
    }
    return true;
}

spl_autoload_register("my__autoload");

?>