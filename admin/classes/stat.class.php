<?php

include_once(CLASSDIR_."basic.class.php");
class stat extends basic {

    function stat() {
    
    	basic::basic();
    	
    	$this->tables['country2ip'] = $this->config->variable['sb_stat_country2ip'];
    	$this->tables['visitor_path'] = $this->config->variable['sb_stat_visitor_path'];
    	$this->tables['visitors'] = $this->config->variable['sb_stat_visitor'];
    
    }
    
    
    function setWhere($search){
		foreach($search as $key=>$val){
			if(strlen($val) || is_array($val)){
				if($key=='start_visit_time'){
					//$val = addcslashes($val, "'\\");
					if(strlen($val['from']))
						$where[] = " V.visit_time>'{$val['from']}' ";
					if(strlen($val['to']))
						$where[] = " V.visit_time<'{$val['to']}' ";
				}else{
					$val = addcslashes($val, "'\\");
					$where[] = " V.$key LIKE '%$val%' ";
				}
			}
		}
		$where_str = implode(" AND ", $where).(count($where)?" AND ":"");
    	return $where_str; 
    }
    
    function getDayVisitorsCount($search=array()){
    
		$where_str = $this->setWhere($search);
		$sql = "SELECT COUNT(id) AS cnt FROM {$this->tables['visitors']} V WHERE $where_str robot!=1 ";		
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->row();
    	return $arr['cnt'];
    	
    }
    
    function getDayVisitors($offset, $paging, $search=array()){
    
    	$where_str = $this->setWhere($search);
    	$sql = "SELECT V.*, SUBSTRING(MIN(P.visit_time), 12, 5) AS visit_time_, SEC_TO_TIME(TIME_TO_SEC(MAX(P.visit_time))-TIME_TO_SEC(MIN(P.visit_time))) AS past_time, MIN(P.visit_time) AS start_visit_time FROM {$this->tables['visitors']} V " .
    			" LEFT JOIN {$this->tables['visitor_path']} P " .
    			" ON (P.visitor_id=V.id) " .
    			" WHERE $where_str robot!=1 " .
    			" GROUP BY V.id " .
    			" ORDER BY start_visit_time DESC " .
    			" LIMIT ".($offset*$paging).", ".$paging." ";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->arr();
    	return $arr;
    
    }
    
    function getVisitorPath($id){
    	
    	$sql = "SELECT * FROM {$this->tables['visitor_path']} WHERE visitor_id=$id ORDER BY visit_time ASC";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->arr();
    	return $arr;
    	
    }
    
    function getVisitor($id){
    	$sql = "SELECT V.*, SUBSTRING(MIN(P.visit_time), 12, 5) AS visit_time_, SEC_TO_TIME(TIME_TO_SEC(MAX(P.visit_time))-TIME_TO_SEC(MIN(P.visit_time))) AS past_time, MIN(P.visit_time) AS start_visit_time FROM {$this->tables['visitors']} V " .
    			" LEFT JOIN {$this->tables['visitor_path']} P " .
    			" ON (P.visitor_id=V.id) " .
    			" WHERE V.id=$id " .
    			" GROUP BY V.id ";
    	$this->db->exec($sql, __FILE__, __LINE__);
    	$arr = $this->db->row();
    	return $arr;    	
    }

    function getMarkers($search=array()){
    	global $cms_phrases; 
		unset($search['country']);
		unset($search['city']);
		$where_str = $this->setWhere($search);
    	$sql = "SELECT V.longitude, V.latitude, V.country, V.country_code, V.city, COUNT(V.id) AS visits FROM {$this->tables['visitors']} V " .
    			" WHERE $where_str robot!=1 " .
    			" GROUP BY V.latitude, V.longitude ";
    	$this->db->exec($sql);
    	$arr = $this->db->arr();
		$n = count($arr);
		for($i=0, $n_arr=array(), $j=0; $i<$n; $i++){
			if(is_numeric($arr[$i]['latitude']) && is_numeric($arr[$i]['longitude'])){
				$arr[$i]['index'] = $j++;
				$arr[$i]['text'] = "<img src='images/countries/{$arr[$i]['country_code']}.gif' class='vam' alt='' /> {$arr[$i]['country']}, {$arr[$i]['city']}<br /><a href=\\\"javascript: void( get_geoipStat('{$arr[$i]['country']}', '{$arr[$i]['city']}'));\\\">{$cms_phrases['main']['stat']['unique_visitors']} - {$arr[$i]['visits']}</a>";
				$n_arr[] = $arr[$i];
			}
		}
    	return $n_arr;
    }
    
}
?>