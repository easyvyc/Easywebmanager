<?php

abstract class DB {

	private static $_instances = array();
        
        private $get_last_query = false;
	private $last_query = array();
        
	protected $_config;
	protected $_error;
	protected $_connection;
	protected $_db;
	protected $queriesCount = 0;
	protected $queriesTime = 0;
	protected $trace = array();
	
	public $debug = true;
	public $sql;
	
	protected function __construct(){
//		$this->_config = Config::getInstance();
//		$this->_error = exceptionErrorHandler::getInstance($this->_config->get("show_error_context"));
		$this->sql = new SQL($this);
	}
	
	public static function getInstance($db, $db_host, $db_name, $db_user, $db_pass){
		$db_inst = $db.":".$db_name.":".$db_user;
		if (is_null (self::$_instances[$db_inst])) {
			include_once(CLASSDIR."db/".$db.".class.php");
			self::$_instances[$db_inst] = new $db($db_host, $db_name, $db_user, $db_pass);
		}
		return self::$_instances[$db_inst];
	}

        public function last_query(){
            $this->get_last_query = true;
        }
        
        public function get_last_query(){
            return $this->last_query;
        }
        
	/*
	 * insert query
	 * table
	 * data = array()
	 * */

	abstract protected function exec($sql, $args=array());
	
	
	abstract public function select($table);
	
	abstract public function update($table);
	
	abstract public function insert($table);
	
	abstract public function delete($table);
	
	
	abstract public function last_insert_id();
	
	abstract public function num_rows();
	
	abstract public function startTransaction();
	
	abstract public function commitTransaction();
	
	abstract public function rollbackTransaction();
	
	abstract public function version();
	
	
	public function query($sql){
		
		if($this->debug){
			$startTime = microtime(true);
		}
		
		$this->exec($sql, $this->sql->get_params());
		
		if($this->debug){
			$this->queriesCount++;
			$endTime = microtime(true);
			$time = round($endTime - $startTime, 6);
			$this->queriesTime += $time;
			$sql = $this->getRealQuery($sql, $this->sql->get_params());
			$this->trace['queries'][] = array('query'=>$sql, 'execute_time'=>$time);
			benchmark::mark($sql);
		}
		
                if($this->get_last_query){
                    $this->last_query['pre'] = $sql;
                    $this->last_query['sql'] = $this->getRealQuery($sql, $this->sql->get_params());
                    $this->last_query['arg'] = $this->sql->get_params();
                }
                
		$this->sql->reset();
		
		return $this;
	
	}
	
	protected function getRealQuery($sql, $args=array()){
		foreach($args as $key=>$val){
			$sql = preg_replace("/(:$key([\,\s\)]{1,})|(:$key$))/", (is_numeric($val)?$val."\\2":"'$val'\\2"), $sql);
		}
		return $sql;
	}
	
	public function debug(){
		if($this->debug) return "<pre>Queries count: $this->queriesCount".PHP_EOL."Queries time: $this->queriesTime".PHP_EOL."All queries:".PHP_EOL.print_r($this->trace['queries'], true)."</pre>";
	}
	
	function __destruct(){
		//echo nl2br($this->debug);
	}
	
}

?>