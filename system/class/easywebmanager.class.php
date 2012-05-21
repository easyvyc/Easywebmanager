<?php

include_once (CLASSDIR.'basic.class.php');
abstract class easywebmanager extends basic {
	
	private static $instance;
	
	private $output_gziped = false;
	
	protected function __construct() {
		
		$old_error_handler = set_error_handler("errorHandler");
		
		// sesijos uzkrovimas per get (swfupload)
		if(isset($_POST['_SESSION_ID_'])){
			$this->loadNewSession($_POST['_SESSION_ID_']);
		}
		
		session_start();
		
		$this->ob_start();
		
		$_SESSION['_FINGERPRINT_'] = $this->fingerprint();

		parent::__construct();
		
		benchmark::mark('construct_easywebmanager', 'Easywebmanager construktorius');
		
	}
	
	abstract function process();
	
	function ob_start(){
		ob_start();
	}
	
	function output($out){
		ob_end_clean();
		$this->ob_start_gzip();
		echo $out;
		ob_flush();
	}
	
	function ob_start_gzip() {
	
	    //If no encoding was given - then it must not be able to accept gzip pages
	    if( empty($_SERVER['HTTP_ACCEPT_ENCODING']) ) { 
	    	ob_start();
	    }
	
	    //If zlib is not ALREADY compressing the page - and ob_gzhandler is set
	    if (( ini_get('zlib.output_compression') == 'On'
	        OR ini_get('zlib.output_compression_level') > 0 )
	        OR ini_get('output_handler') == 'ob_gzhandler' ) {
	        ob_start();
	    }
	
	    //Else if zlib is loaded start the compression.
	    if ( extension_loaded( 'zlib' ) AND (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE) ) {
	        ob_start('ob_gzhandler');
	        $this->output_gziped = true;
	    }
	
	}
	
	function loadNewSession($session_id){
		$old_session_id = session_id();
		session_id($session_id);
		if(!$this->checkFingerprint()){
			// back to old session id
			//session_id($old_session_id);
			//trigger_error(".");
		}
	}
	
	function checkFingerprint(){
		return ($_SESSION['_FINGERPRINT_']==$this->fingerprint());
	}
	
	function fingerprint(){
		return md5($_SERVER['REMOTE_ADDR'].FP_SALT);
	}
	
	function ob_get_contents(){
		$buffer = ob_get_contents();
		ob_clean();
		return $buffer;
	}
	
	function is_ob_gzip(){
		return $this->output_gziped;
	}
	
}

?>