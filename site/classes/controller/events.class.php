<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_events extends controller {
	
	function __construct(){
            parent::__construct("events");
	}
        
        function listCalendarMonthDates(){
            
            $year = $this->get['y'];
            $month = $this->get['m'];
            
            $query['where'] = "T.dates LIKE :month";
            $query['binds']['month'] = "%$year-$month-%";
            $list = $this->mod->listSearchItems($query);
            
            $dates = array();
            foreach($list as $val){
                $dates_arr = preg_split("/,\s/", $val['dates']);
                foreach($dates_arr as $dt){
                    list($y, $m, $d) = explode("-", $dt);
                    $d = (int) $d;
                    $dates[$d]['day'] = $d;
                    $dates[$d]['text'] .= $val['title'] . "\n";
                }
            }
            
            return json_encode($dates);
            
        }
        
        function showDayEvents(){
            
            $date = $this->get['date'];
            
            cms::getInstance()->load_view_variables();
            cms::getInstance()->add_css('news');
            $query['where'] = "T.dates LIKE :date";
            $query['binds']['date'] = "%$date%";
            $list = $this->mod->listSearchItems($query);
            
            load_helpers("url");
            
            foreach($list as $i => $val){
                $list[$i]['item_url'] = url_slug($val['title']);
            }
            
            TPL::setVar('events', $list);
            
            TPL::setVar('page_content', TPL::parse(TPLDIR."events/day_list.tpl"));
            return $this->frame();
            
        }
        
	function frame(){
            
            TPL::setVar('css', generate_css('site', cms::getInstance()->load_css()));

            TPL::setVar('page_data', $this->current_page);
            
            $buffer = TPL::parse(TPLDIR."index.tpl");
            cms::ob_start();
            return $buffer;
	}        
        	
}

?>
