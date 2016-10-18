<?php 

class mysql extends DB {

	private $_stmt;
        private $already_in_transaction = false;

	function __construct($db_host, $db_name, $db_user, $db_pass, $db_port=null){
		
		DB::__construct();
		
		try {
    		$dsn = "mysql:dbname=".$db_name.";host=".$db_host.($db_port?";port=".$db_port:"");
			$this->_connection = new PDO($dsn, $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
			$this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			trigger_error('Connection failed: ' . $e->getMessage(), E_USER_ERROR);
		}		

	}

	/**
	 * execute sql query
	 */ 	
	protected function exec($sql, $args=array()){
		try{
			$this->_stmt = $this->_connection->prepare($sql);
			$this->_stmt->execute($args);
		}catch(PDOException $e){

			echo $e->getMessage().$this->getRealQuery($sql, $this->sql->get_params());
			trigger_error($e->getMessage().$this->getRealQuery($sql, $this->sql->get_params()), $e->getFile(), $e->getLine(), $e->getTrace());
			
			//$this->_error->errorHandler($e->getCode(), $e->getMessage().$this->getRealQuery($sql, $this->sql->get_params()), $e->getFile(), $e->getLine(), $e->getTrace());
			//throw new 
			//echo 'Query execute failed: ' . $e->getMessage().' Query: '. ;
		}
	}
	
	public function select($table){
		$this->sql->create("SELECT");
		$this->sql->tables($table);
		return $this->sql;
	}

	public function update($table){
		$this->sql->create("UPDATE");
		$this->sql->tables($table);
		return $this->sql;
	}
	
	public function insert($table){
		$this->sql->create("INSERT");
		$this->sql->tables($table);
		return $this->sql;
	}
	
	public function delete($table){
		$this->sql->create("DELETE");
		$this->sql->tables($table);
		return $this->sql;
	}
	
	/**
	 * 
	 */
	public function escape($string){
		return mysql_escape_string($string);
	}
	
	/**
	 * return mysql query results as array
	 */ 
	public function result_array($sql=''){
		if($sql!='') $this->query($sql);
		$arr = $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
		$this->_stmt->closeCursor();
		return $arr;
	}
	
	/**
	 * return mysql query results as one row
	 */ 
	public function row_array($sql=''){
		if($sql!='') $this->query($sql);
		$row = $this->_stmt->fetch(PDO::FETCH_ASSOC);
		$this->_stmt->closeCursor();
		return $row;
	}
	
	/**
	 * return last insert id  
	 */
	public function last_insert_id(){
		return $this->_connection->lastInsertId();
	}

	/**
	 * return selected or affected rows count  
	 */
	public function num_rows(){
		return $this->_stmt->rowCount();
	}
	
	public function version(){
		return $this->_connection->getAttribute(PDO::ATTR_CLIENT_VERSION);
	}
        
        public function checkIsInTransaction(){
            return $this->_connection->inTransaction();
        }
	
	public function startTransaction(){
		//if($this->_connection->inTransaction) return false;
            try {
                $this->_connection->beginTransaction();
                return true;
            } catch (PDOException $e) {
                $this->already_in_transaction = true;
                return false;
            }
	}
	
	public function commitTransaction(){
		return $this->_connection->commit();
	}
	
	public function rollbackTransaction(){
		return $this->_connection->rollBack();
	}
	
	public function __destruct(){
		//mysql_close($this->_connection);
		//echo $this->debug();
	}
	
	
}

?>