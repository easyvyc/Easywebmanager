<?php

include_once(CLASSDIR."catalog.class.php");
class events extends catalog {
	
	function __construct(){
		
		parent::__construct("events");

		if(isset($_GET['date'])){
			$arr = explode("-", $_GET['date']);
			$this->CALENDAR['year'] = $arr[0];
			$this->CALENDAR['month'] = $arr[1];
			$this->CALENDAR['day'] = $arr[2];
		}else{
			$this->CALENDAR['year'] = date("Y");
			$this->CALENDAR['month'] = date("m");
			$this->CALENDAR['day'] = date("d");
		}
		$this->CALENDAR['id'] = 'main';
		$this->CALENDAR['actions'] = array();
		$this->CALENDAR['action_url'] = "lt/p/kalendorius/";//$this->language.$GLOBALS['data']['page_url'];
		
	}
	
	function getActionDays($Y, $M){
		
		$M = strlen($M)==1?"0".$M:$M;
		$this->fields = " IF(SUBSTR(T.start_date, 6, 2)='$M', SUBSTR(T.start_date, 9, 2), 0) AS start_day_number, IF(T.end_date='0000-0-00', SUBSTR(T.start_date, 9, 2), IF(SUBSTR(T.end_date, 6, 2)='$M', SUBSTR(T.end_date, 9, 2), 32)) AS end_day_number, ";
		$this->sqlQueryWhere = " (T.start_date <= '$Y-$M-31' AND (T.end_date > '$Y-$M-00' OR T.end_date='0000-00-00')) AND ";
		$list = $this->listSearchItems();

		
		$n = count($list);
		for($i=0, $days=array(); $i<$n; $i++){
			$start_date = ereg_replace("-", "", $list[$i]['start_date']);
			$end_date = ereg_replace("-", "", $list[$i]['end_date']);
			$darr = array();
			if((int)$start_date < (int)$end_date){
				for($j=(int)$list[$i]['start_day_number']; $j<=(int)$list[$i]['end_day_number']; $j++){
					$darr[] = $j;
				}
			}else{
				$darr[] = $list[$i]['start_day_number'];
			}

			foreach($darr as $k=>$v){
				$days[(int)$v] = 1;
			}
		}
		return $days;
		
	}


	function loadCalendar(){
		
		$phrases = $this->main_object->call("phrases", "loadPhrases", array());
		
		include_once(CLASSDIR."tpl.class.php");
		$tpl_part_calendar = & new template(TPLDIR_."parts/calendar.tpl");

		$tpl_part_calendar->setVar('ajax', isset($_GET['get'])&&$_GET['get']=='calendar'?1:0);

		$tpl_part_calendar->setVar('config', Config::$val);

		$c_mktime = mktime(0,0,0,$this->CALENDAR['month'], $this->CALENDAR['day'], $this->CALENDAR['year']);
		$this->CALENDAR['year'] = (int) date("Y", $c_mktime);
		$this->CALENDAR['month'] = (int) date("m", $c_mktime);
		$this->CALENDAR['day'] = (int) date("d", $c_mktime);

		if(!isset($this->CALENDAR['ID'])) $this->CALENDAR['ID'] = 'block';

		$current_date['title'] = $this->CALENDAR['year']." ".$phrases['calendar.month.'.(((int) $this->CALENDAR['month'])-1)];
		$current_date['year'] = $this->CALENDAR['year'];
		$current_date['previous_year'] = $this->CALENDAR['year'] - 1;
		$current_date['next_year'] = $this->CALENDAR['year'] + 1;
		$current_date['month'] = (int) $this->CALENDAR['month'];
		$current_date['month_'] = (strlen($this->CALENDAR['month'])==1?"0".$this->CALENDAR['month']:$this->CALENDAR['month']);
		$current_date['previous_month'] = (int) $this->CALENDAR['month'] - 1;
		$current_date['next_month'] = (int) $this->CALENDAR['month'] + 1;
		$current_date['day'] = $this->CALENDAR['day'];
		
		$current_date['actions'] = $this->getActionDays($this->CALENDAR['year'], $this->CALENDAR['month']);
		//pae($current_date['actions']);
		$tpl_part_calendar->setVar('current_date', $current_date);

		$tpl_part_calendar->setVar('now', array('year'=>date("Y"), 'month'=>(int) date("m"), 'day'=>date("d")));

		for($i=0; $i<7; $i++){
			$weekdays[$i]['title'] = $phrases['weekdays.'.$i];
			$weekdays[$i]['name'] = mb_substr($phrases['weekdays.'.$i], 0, 3, "UTF-8");
			$weekdays[$i]['width'] = ($i>5?15:14);
		}
		$tpl_part_calendar->setLoop('weekdays', $weekdays);

		$mktime = mktime(0,0,0, $current_date['month'], 1, $current_date['year']);
		$number_of_days = date("t", $mktime); $day = 1;
		$weeks = array();
		while($day <= $number_of_days){
	
			$first_week_day = date("w", $mktime);
			$first_week_day = ($first_week_day==0?6:$first_week_day-1);
			for($i = 0, $week = array(); $i < 7; $i++){
				if($i >= $first_week_day && $day <= $number_of_days){
					$week[$i]['description'] = $this->CALENDAR['year']." ".$phrases['calendar.month.'.(((int) $this->CALENDAR['month'])-1)].", ".$day;
					$week[$i]['weekend'] = ($i==5||$i==6?"weekend":"");
					if(is_array($current_date['actions'][$day]) || $current_date['actions'][$day]==1){
						$week[$i]['action'] = 1;
						$week[$i]['text'] = $current_date['actions'][$day]['text'];
					}
					$week[$i]['day'] = (strlen($day)==1?"0".$day:$day);
					$week[$i]['value'] = $day++;
					$mktime = mktime(0,0,0, $current_date['month'], $day, $current_date['year']);
				}else{
					$week[$i]['value'] = '';
				}
		
			}
			$weeks[] = array('days'=>$week);
		}
		//pae($weeks);
		$tpl_part_calendar->setLoop('weeks', $weeks);

		$tpl_part_calendar->setVar('phrases', $phrases);

		$tpl_part_calendar->setVar('reserved_url_words', $GLOBALS['reserved_url_words']);

		$tpl_part_calendar->setVar('CAL', $this->CALENDAR);

		$tpl_part_calendar->setVar('config', Config::$val);
		return $tpl_part_calendar->parse();
		
	}
	

	function listItemsOffset($offset, $paging){

		//$this->sqlQueryGroup = " GROUP BY R.id ";
		//$this->sqlQueryOrder = " ORDER BY T.priority DESC, T.news_date DESC ";
		//pae($_GET);
		if(isset($_GET['date'])){
			$this->sqlQueryWhere .= " TO_DAYS(T.start_date)<=TO_DAYS('{$_GET['date']}') AND TO_DAYS(T.end_date)>=TO_DAYS('{$_GET['date']}') AND ";
		}else{
			$this->sqlQueryWhere .= " TO_DAYS(T.start_date)<=TO_DAYS(NOW()) AND TO_DAYS(T.end_date)>=TO_DAYS(NOW()) AND ";
		}
		if(isset($_GET['city']) && is_numeric($_GET['city'])){
			$this->sqlQueryWhere .= " T.city={$_GET['city']} AND ";
		}
		if(isset($_GET['pobudis']) && is_numeric($_GET['pobudis'])){
			$this->sqlQueryWhere .= " T.pobudis={$_GET['pobudis']} AND ";
		}
		
		$list = catalog::listItemsOffset($offset, $paging);
		foreach($list as $i=>$val){
			if($val['start_date']==$val['end_date'] || $val['end_date']=='0000-00-00') $list[$i]['end_date'] = 0;
		}
		return $list;
		
	}

	function loadNewEventForm(){
	
		error_reporting(E_ALL);
		global $lng, $reserved_url_words, $data;
		
		include_once(CLASSDIR_."formaction.class.php");
		$formaction_obj = & new formaction();
		
		$action_data['title'] = "Komentaras";
		$action_data['emails'] = "vytautas@idp.lt";
		$action_data['target'] = "database";
		$action_data['module'] = "events";
		$action_data['name'] = "events";
		$action_data['redirect'] = "$lng{$data['page_url']}new/2/thanks/";
		$action_data['isNew'] = 1;
		$action_data['is_category'] = 0;
		$action_data['id'] = 0;
		$action_data['parent_id'] = 0;
		$action_data['language'] = $lng;
		$action_data['author_id'] = $_SESSION['simple_user']['id'];
		
		$formaction_obj->setAction($action_data);
		$formaction_obj->setFields($this->table_fields);
		$formaction_obj->form->editField('active', array('elm_type'=>FRM_HIDDEN, 'value'=>1));
		
		$formaction_obj->form->editField('submit', array('captcha'=>0));
		
		$formaction_obj->setData($_POST);
		
		return $formaction_obj->process();
			
	}
	
	
}

?>