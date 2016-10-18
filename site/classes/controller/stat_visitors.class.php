<?php

include_once(APP_CLASSDIR."controller.class.php");
class controller_stat_visitors extends controller {

    private $session_variable = "visitor";
    private $search_engines = array('google'=>'q', 'yahoo'=>'p', 'bing'=>'q', 'search.delfi.lt'=>'q');
    private $visitor;
    
    function __construct(){
        parent::__construct("stat_visitors");
    }

    function process(){
        $this->detectVisitor();
        if(empty($_SESSION[$this->session_variable]) && !$this->registry->model->stat_visitors_temp->check($this->visitor)){
            $this->detectVisitorDetail();
            if(!$this->visitor['robot']){
                $this->registry->model->stat_visitors_temp->insert($this->visitor);
                $this->registry->model->stat_visitors_temp->clear();
                $this->visitor['visitor_id'] = $this->registry->model->stat_visitors->insert($this->visitor);
                $_SESSION[$this->session_variable] = $this->visitor;
            }
        }
        if(!$this->visitor['robot']){
            $this->registry->model->stat_visitors_path->insert($this->visitor);
            $this->registry->model->stat_visitors->add_page($this->visitor);
            //$this->registry->model->stat_visitor->add_conversion($this->visitor);
        }
    }
    
    function detectVisitor(){
        
        $this->visitor['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->visitor['ipaddress'] = $_SERVER['REMOTE_ADDR'];
        $this->visitor['http_referer'] = $_SERVER['HTTP_REFERER'];
        $this->visitor['url'] = $_SERVER['REQUEST_URI'];
        $this->visitor['visit_time'] = date("Y-m-d H:i:s");
        $this->visitor['session_id'] = session_id();
        $this->visitor['user_id'] = $this->registry->controller->users->getUserId();
        
        if($_SESSION[$this->session_variable]){
            $_SESSION[$this->session_variable]['page_count'] += 1;
            $this->visitor['page_count'] = $_SESSION[$this->session_variable]['page_count'];
            $this->visitor['visitor_id'] = $_SESSION[$this->session_variable]['visitor_id'];
            if($this->visitor['user_id'] && !$_SESSION[$this->session_variable]['user_id']){
                $_SESSION[$this->session_variable]['user_id'] = $this->visitor['user_id'];
                $this->mod->update(array('user_id'=>$_SESSION[$this->session_variable]['user_id']), array('id'=>$this->visitor['visitor_id']));
            }
        }else{
            $this->visitor['page_count'] = 1;
        }
        
        if($_SESSION['conversion_id']){
            $this->visitor['conversion_id'] = $_SESSION['conversion_id'];
            unset($_SESSION['conversion_id']);
        }
        
    }
    
    function detectVisitorDetail(){
        
        $this->detect_useragent();
        
        if(!$this->visitor['robot']){
            $this->detect_geoip();
            $this->detect_device();
            $this->detect_referer();
        }
        
    }
    
    function detect_referer(){
        
        $referer = parse_url($this->visitor['http_referer']);
        if(ltrim($referer['host'], "www.") != ltrim(Config::$val['pr_url'], "www.")){

            $se_q_name = false;
            parse_str($referer['query'], $query_arr);
            foreach($this->search_engines as $se => $q_name){
                if(preg_match("/$se/i", $referer['host'])){
                    $se_q_name = $q_name;
                    break;
                }
            }
            
            if($se_q_name && $query_arr[$se_q_name]) $query = urldecode($query_arr[$se_q_name]);
            
            $this->visitor['referer'] = $this->visitor['http_referer'];
            $this->visitor['referer_domain'] = $referer['host'];
            $this->visitor['keyword'] = $query;
        }
    }
    
    function detect_useragent(){
        $data = array();
        if(ini_get("browscap")) {
            $data = get_browser(null, true);
        }else{
            load_helpers("php_user_agent");
            $userAgent = new phpUserAgent($this->visitor['user_agent']);
            $data['browser'] = $userAgent->getBrowserName();
            $data['version'] = $userAgent->getBrowserVersion();
            $data['platform'] = $userAgent->getOperatingSystem();
            $data['crawler'] = $userAgent->isUnknown();
        }
        
        $this->visitor['browser'] = $data['browser'];
        $this->visitor['browser_version'] = $data['version'];
        $this->visitor['os'] = $data['platform'];
        $this->visitor['robot'] = ($data['crawler'] ? 1 : 0);
    }
    
    function detect_device(){
	include_once(CLASSDIR . "Mobile_Detect.php");
	$device_detect = new Mobile_Detect();
	$this->visitor['device'] = "web";
	if($device_detect->isMobile()) $this->visitor['device'] = "mobile";
	if($device_detect->isTablet()) $this->visitor['device'] = "tablet";
    }
    
    function detect_geoip(){
        
        $serverName = $this->visitor['ipaddress'];
        
        if(function_exists("geoip_record_by_name") && $row = geoip_record_by_name($serverName)){

            $this->visitor['country_code']   = strtolower($row['country_code']);
            $this->visitor['country']   = $row['country_name'];
            $this->visitor['region']   = $row['region'];
            $this->visitor['city']   = $row['city'];
            $this->visitor['latitude']   = $row['latitude'];
            $this->visitor['longitude']   = $row['longitude'];

        }else{

            $url = "http://update.easywebmanager.com/ip2location.php?ip=";
            $ch = curl_init($url . $serverName);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);       
            curl_close($ch);

            load_helpers("xml");
            $row = XML_Array::xmlStringToArray($output);

            $this->visitor['country_code']   = strtolower($row['countrycode']);
            $this->visitor['country']   = $row['countryname'];
            $this->visitor['region']   = $row['regioncode'];
            $this->visitor['city']   = $row['city'];
            $this->visitor['latitude']   = $row['latitude'];
            $this->visitor['longitude']   = $row['longitude'];

        }
        
    }
        
}

?>