<?php

include_once(APP_CLASSDIR."model.class.php");
class model_tags extends model {
	
    function __construct(){

        parent::__construct("tags");
        load_helpers("url");

    }

    function saveItem($data){

        $data['item_url'] = url_slug($data['title']);
        $id = parent::saveItem($data);
        return $id;

    }

}

?>
