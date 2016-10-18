<?php

include_once (APP_CLASSDIR.'controller.class.php');
class controller_stat_visitors extends controller {
	
	public function __construct() {
		parent::__construct ("stat_visitors");
	}
	
	function listing(){
            
            benchmark::mark('start_listing', 'Listingo pradzia');

            include_once(APP_CLASSDIR."listing.class.php");
            $listing_obj = new listing("stat_visitors");

            $listing_obj->set('edit_button', 0);
            $listing_obj->set('delete_button', 0);
            $listing_obj->set('select_button', 0);
            $listing_obj->set('dragndrop', 0);
            $listing_obj->set('actions_button', 0);
            $listing_obj->set('filter_form', 1);
            $listing_obj->set('base_url', 'module=' . $this->get['module'] . '&method=' . $this->get['method'] . '&area=' . $this->get['area'] . '&cid=' . $this->get['cid'] . ($this->get['column'] ? '&column=' . $this->get['column'] : '') . ($this->get['no_tree_reload'] ? '&no_tree_reload=1' : ''));

            $this->mod->filterListing();
            
            if(!$_SESSION['filters'][$this->get['module']]){
                $_SESSION['filters'][$this->get['module']]['visit_time']['from'] = date("Y-m-d");
                $_SESSION['filters'][$this->get['module']]['visit_time']['to'] = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+1,date("Y")));
            }
            
            $listing_obj->setFilters($_SESSION['filters'][$this->get['module']]);
            $listing_obj->setColumns($this->mod->table_list);
            
            $this->mod->prepareListing($listing_obj->columns);

            if($this->mod->sqlQueryWhere['country']){
                $this->mod->sqlQueryWhere['country'] = " (T.country LIKE :country OR T.city LIKE :country)";
            }
            
            if($this->mod->sqlQueryWhere['past_time']){
                $this->mod->sqlQueryWhere['past_time'] = "";
            }
            
            $sum_data = $this->mod->getListingSum();
            $list_items = $this->mod->getListingItems();

            foreach($list_items as $i=>$val){
                
                    $list_items[$i]['ipaddress'] = "<a href=\"javascript: void(ajaxItemContextMenu('admin.php?module=stat_visitors&method=get_visitor_path&visitor_id={$val['id']}&ajax=1'));\"><img src='admin/images/path".($val['conversion_id']>0?"_goal":"").".gif' alt='' class='vam' border=0 /></a>&nbsp;<a href=\"javascript: void(gridObject___stat_visitors.setFilters({ipaddress:'{$list_items[$i]['ipaddress']}',visit_time___from:'',visit_time___to:''}));\">".$list_items[$i]['ipaddress']."</a>";
                    $list_items[$i]['ipaddress_ALT'] = "IP: ".$val['ipaddress']."\n" . cms::$phrases['main']['stat']['page_visits'] . ": ".$val['page_count'].($val['conversion_id']>0?"\n". cms::$phrases['main']['stat']['conversion_goal']:"");
                    if($list_items[$i]['user_id']){
                        $list_items[$i]['ipaddress'] .= "&nbsp;<a href=\"javascript: ;\"><img src=\"admin/images/user.png\" class=\"vam\" alt=\"\" ></a>";
                        $list_items[$i]['ipaddress_ALT'] .= "\n" . cms::$phrases['main']['stat']['registered_user_id'] . ": {$list_items[$i]['user_id']}";
                    }

                    if($val['country_code']){
                            $list_items[$i]['country'] = "<img src=\"admin/images/countries/{$val['country_code']}.gif\" class=\"vam\" alt=\"{$val['country']}\" /> {$val['city']}";
                    }
                    $list_items[$i]['country_ALT'] = $val['country']." ".$val['city'];
                    
                    $list_items[$i]['user_agent'] = "<img src='admin/images/browsers/{$val['browser']}.png' alt='' height='20' class='vam'> {$val['browser']} {$val['browser_version']} / {$val['os']}";
                    $list_items[$i]['user_agent_ALT'] = $val['user_agent'];
                    
                    $list_items[$i]['referer_domain'] = "<a target=\"_blank\" href=\"{$val['referer']}\" >{$val['referer_domain']}</a>".($list_items[$i]['keyword']?"({$list_items[$i]['keyword']})":"");
                    $list_items[$i]['referer_domain_ALT'] = ($val['referer'] ? $val['referer'] : " ");

                    $list_items[$i]['device'] = "<center><img src='admin/images/device_{$val['device']}.png' alt='' align='center'></center>";
                    $list_items[$i]['device_ALT'] = cms::$phrases['main']['stat']['device_type_' . $val['device']];

            }
            
            $listing_obj->setItemsData($sum_data);
            $listing_obj->setItems($list_items);
            $listing_obj->paging($this->get['offset']);
            $listing_obj->pagingSelect();
            
            if(empty($list_items)){
                    $_count = 0;
            }else{
                    $_count = count($list_items);
            }

            benchmark::mark('end_listing', 'Listingo pabaiga');

            return $listing_obj->generate();
	
        
        }
        
        function get_visitor_path(){
            $visitor_id = $this->get['visitor_id'];
            $list = $this->registry->model->stat_visitors_path->loadBy(array('visitor_id'=>$visitor_id), true);
            TPL::setVar('stat_visitors_path', $list);
            return TPL::parse(TPLDIR . "blocks/stat_visitors_path.tpl");
        }
	
	function tree(){
		return;
	}
	
}

?>