<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_articles extends controller {
	
	public function __construct() {
            parent::__construct ("articles");
	}
	
        public function create_newsletter(){
            
            load_helpers("url");
            
            $news_data = $this->mod->loadItem($this->get['id']);
            $news_page = $this->registry->model->pages->loadBy(array('template'=>'news'));
            
            if(!empty($news_page) && isset($news_page[0]['page_url']))
                $news_link = Config::$val['site_url'] . $this->language . $news_page[0]['page_url'] . url_slug($news_data['title']) . "-" . $news_data['id'] . ".html";
            else
                $news_link = Config::$val['site_url'] . "index.php?module=pages&method=article&_ID_=" . $news_data['id'];
            
            $message = "<a href='" . $news_link . "'><img src=\"" . Config::$val['site_url'] . "index.php?module=articles&method=show_image&column=image&id=" . $news_data['id'] . "&w=200&h=200&t=auto\" style='margin-right:10px;margin-bottom:10px;' align='left'></a>";
            $message .= "<p>" . nl2br($news_data['short_description']) . "<p>";
            $message .= "<a href='" . $news_link . "'>" . $news_link . "</a>";
            $_SESSION['create_from']['newsletters'] = array('title'=>$news_data['title'], 'mail_body'=>$message);
            
            redirect("admin.php?module=newsletters&method=create_from&ajax=1");
            
        }
        
}

?>