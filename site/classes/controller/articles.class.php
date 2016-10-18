<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_articles extends controller {
	
    function __construct(){
        parent::__construct("articles");
    }

    function add_comment($post){
        
        unset($post['captcha']);
        $post['active'] = 0;
        $post['c_date'] = date("Y-m-d H:i:s");
        $post['title'] = htmlspecialchars($post['title']);
        $this->registry->model->comments->insert($post);
        
        $page_settings = $this->registry->model->pages->getSettings();
        $articles_settings = $this->mod->getSettings();
        
        $this->registry->lib->email->send($articles_settings['email'], "Naujas komentaras " . $page_settings['page_title'], "Komentarą aktyvuoti galite prisijungę prie TVS skiltyje Blog'as -> Straipsniai<br><br>Komentaro turinys:<br>Vardas: {$post['author']}<br>El. paštas: {$post['email']}<br>Komentaras: {$post['title']}", $page_settings['page_title'], $articles_settings['email']);
        
        $ph = $this->registry->controller->phrases->loadPhrases();
        return $ph['comments_thanks'];
        
    }
		
}

?>
