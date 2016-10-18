<?php 

class SQL {
	
	private $_where=array();
	private $_fields=array();
	private $_order=array();
	private $_group=array();
	private $_limit=array();
	private $_joins=array();
	private $_tables=array();
	private $_values=array();
	private $_params=array();
	
	private $_command="";

	function __construct($db){
		$this->db = $db;
	}
	
	function create($command){
		$this->_command = strtoupper($command);
		return $this;
	}
	
	function where_in($column, $values){
		if(is_array($values)){
			$index = 0;
			foreach($values as $val){
				$bind_column_name = $column."_".$index++;
				$this->bind($bind_column_name, $val);
				$binded_columns[] = ":".$bind_column_name;
			}
			$this->where("$column IN (" . implode(" , ", $binded_columns) . ")");
		}
		return $this;
	}
	
	// 'both', 'left', 'right', 'none'
	function like($column, $match, $_='both'){
		switch($_){
			case 'left':
				$value = "%".$match;
			break;
			case 'right':
				$value = $match."%";
			break;
			case 'both':
				$value = "%".$match."%";
			break;
			case 'none':
				$value = $match;
			break;
		}
		$bind = $column."_like";
		$this->bind($bind, $value);
		$this->where("$column=:$bind");
		return $this;
	}
	
	function where($where){
		if(is_array($where)){
			foreach($where as $val){
				$this->where($val);
			}
		}else{
			$where = trim($where);
			if(strlen($where)){
				if(!in_array($where, $this->_where)){
					$this->_where[] = $where;
				}
			}
		}
		return $this;
	}
	
	function fields($fields){
		if(is_array($fields)){
			foreach($fields as $val){
				$this->fields($val);
			}
		}else{
			$fields = trim($fields);
			if(strlen($fields)){
				if(!in_array($fields, $this->_fields)){
					$this->_fields[] = $fields;
				}
			}
		}
		return $this;
	}
	
	function order($order){
		if(is_array($order)){
			foreach($order as $val){
				$this->order($val);
			}
		}else{
			$order = trim($order);
			if(strlen($order)){
				if(!in_array($order, $this->_order)){
					$this->_order[] = $order;
				}
			}
		}
		return $this;
	}
	
	function group($group){
		if(is_array($group)){
			foreach($group as $val){
				$this->group($val);
			}
		}else{
			$group = trim($group);
			if(strlen($group)){
				if(!in_array($group, $this->_group)){
					$this->_group[] = $group;
				}
			}
		}
		return $this;		
	}
	
	function limit($start, $paging=null){
		if(is_numeric($start)){
			if(isset($paging) && is_numeric($paging)){
				$this->_limit = " $start, $paging ";
			}else{
				$this->_limit = " $start ";
			}
		}else{
			$this->_limit = $start;
		}
		return $this;
	}
	
	function joins($joins){
		if(is_array($joins)){
			foreach($joins as $val){
				$this->joins($val);
			}
		}else{
			$joins = trim($joins);
			if(strlen($joins)){
				if(!in_array($joins, $this->_joins)){
					$this->_joins[] = $joins;
				}
			}
		}
		return $this;		
	}
	
	function tables($tables){
		if(is_array($tables)){
			foreach($tables as $val){
				$this->tables($val);
			}
		}else{
			$tables = trim($tables);
			if(strlen($tables)){
				if(!in_array($tables, $this->_tables)){
					$this->_tables[] = $tables;
				}
			}
		}
		return $this;		
	}
	
	function values($values, $bind = false){
		if(is_array($values)){
			foreach($values as $key => $val){
                            if($bind){
                                $this->values("$key = :$key");
                                $this->bind($key, $val);
                            }else{
                                $this->values($val);
                            }
			}
		}else{
			$values = trim($values);
			if(strlen($values)){
				if(!in_array($values, $this->_values)){
					$this->_values[] = $values;
				}
			}
		}
		return $this;		
	}
	

	private function get_where(){
		return ($this->_where?"WHERE ".implode(" AND ", $this->_where):"");
	}
	
	private function get_fields(){
		return ($this->_fields?implode(", ", $this->_fields):"*");
	}
	
	private function get_order(){
		return ($this->_order?"ORDER BY ".implode(", ", $this->_order):"");
	}
	
	private function get_group(){
		return ($this->_group?"GROUP BY ".implode(",", $this->_group):"");
	}
	
	private function get_limit(){
		return ($this->_limit?"LIMIT ".$this->_limit:"");
	}
	
	private function get_joins(){
		return ($this->_joins?implode(" ", $this->_joins):"");
	}
	
	private function get_tables(){
		return ($this->_tables?implode(", ", $this->_tables):"");
	}
	
	private function get_values(){
		return ($this->_values?implode(", ", $this->_values):"");
	}	
	
	
	private function construct(){
		switch($this->_command){
			case "SELECT":
				$sql = "$this->_command ".$this->get_fields()." FROM ".$this->get_tables()." ".$this->get_joins()." ".$this->get_where()." ".$this->get_group()." ".$this->get_order()." ".$this->get_limit();
			break;
			case "UPDATE":
				$sql = "$this->_command ".$this->get_tables()." SET ".$this->get_values()." ".$this->get_where();
			break;
			case "INSERT":
				$sql = "$this->_command INTO ".$this->get_tables()." SET ".$this->get_values();
			break;
			case "DELETE":
				$sql = "$this->_command FROM ".$this->get_tables()." ".$this->get_where();
			break;
		}
		return $sql;
	}
	
	function bind($key, $val=null){
                if(empty($key)) return $this;
		if(is_array($key)){
			foreach($key as $arr_key=>$arr_val){
				$this->bind($arr_key, $arr_val);
			}
		}else{
			$this->_params[$key] = $val;
		}
		return $this;
	}
	
	function get_params(){
		return $this->_params;
	}
	
	function reset(){
		$this->_where="";
		$this->_fields="";
		$this->_order="";
		$this->_group="";
		$this->_limit="";
		$this->_joins="";
		$this->_tables="";
		$this->_values="";
		$this->_command="";	
		$this->_params=array();	
	}
	
	function result_array(){
		return $this->db->result_array($this->construct());
	}

	function row_array(){
		return $this->db->row_array($this->construct());
	}
	
	function query(){
		return $this->db->query($this->construct());
	}
	
	function escape($str){
		return $this->db->escape($str);
	}
	
}

?>