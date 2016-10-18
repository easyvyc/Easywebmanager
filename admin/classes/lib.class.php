<?php

class lib {

    private $name;
    
    function __construct($name) {
        $this->name = $name;
    }
    
    function getName(){
        return $this->name;
    }

    function get($attr_name){
        return $this->$attr_name;
    }
    
    function set($attr_name, $attr_value){
        $this->$attr_name = $attr_value;
    }
    
}

?>