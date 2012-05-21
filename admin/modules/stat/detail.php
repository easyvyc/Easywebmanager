<?php
/*
 * Created on 2007.3.20
 * day.php
 * Vytautas
 */


if(!isset($_GET['offset']) || !is_numeric($_GET['offset'])) $_GET['offset'] = 0;

//////////////////////////////////////// lankytoju sasrasas ////////////////////////////////////////

if(isset($_POST['paging_items'])){
	$_SESSION['order']['paging'] = $_POST['paging_items'];
}


include_once(CLASSDIR."stat.class.php");
$stat_obj = & new stat();

$in_one_page = $stat_obj->xml_config['stat_day_visitors_paging_value'];

if(isset($_SESSION['order']['paging'])){
	$in_one_page = $_SESSION['order']['paging'];
}

$search_stat = array();
if(isset($_GET['ipaddress'])){
	$search_stat['ipaddress'] = $_GET['ipaddress'];
}
if(isset($_GET['referer_domain'])){
	$search_stat['referer_domain'] = $_GET['referer_domain'];
}
$tpl->setVar('filters_data', $search_stat);


include_once(CLASSDIR."grid.class.php");
$grid_obj = & new grid();
$grid_obj->sortParams = $_SESSION['order'][$_GET['module']];
$grid_obj->setTpl(DOCROOT.$configFile->variable['admin_dir']."templates/grid.tpl", "templateVariables");


$column_list[] = array('title'=>$cms_phrases['main']['stat']['ip_address_title'], 'column_name'=>'ipaddress', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>3);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['user_agent'], 'column_name'=>'user_agent', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>8);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['referer_title'], 'column_name'=>'referer_domain', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>5);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['country_title'], 'column_name'=>'country', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>1);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['city_title'], 'column_name'=>'city', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>1);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['enter_time_title'], 'column_name'=>'start_visit_time', 'elm_type'=>FRM_DATE, 'no_sort'=>1, 'w'=>2);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['past_time_title'], 'column_name'=>'past_time', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>2);
$column_list[] = array('title'=>$cms_phrases['main']['stat']['pages_count_title'], 'column_name'=>'page_count', 'elm_type'=>FRM_TEXT, 'no_sort'=>1, 'w'=>1);


if(isset($_POST['action']) && $_POST['action']=='filter'){
	$_GET['offset'] = 0;
	unset($_SESSION['filters']['stat']);
	foreach($column_list as $key=>$val){
		if(strlen($_POST['filteritem___'.$val['column_name']]) || is_array($_POST['filteritem___'.$val['column_name']])){
			$row = array();
			$row['value'] = $_POST['filteritem___'.$val['column_name']];
			$row['column'] = $val['column_name'];
			$row['type'] = $val['elm_type'];
			$_SESSION['filters']['stat'][$val['column_name']] = $_POST['filteritem___'.$val['column_name']];
		}
	}
}

//pae($_SESSION['filters']['stat']);

if(empty($_SESSION['filters']['stat']['start_visit_time'])){
	$_SESSION['filters']['stat']['start_visit_time']['from'] = date("Y-m-d");
	$_SESSION['filters']['stat']['start_visit_time']['to'] = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+1,date("Y")));
}

$grid_obj->set_filterParams($_SESSION['filters']['stat']);
$grid_obj->setColumns($column_list);


$count = $stat_obj->getDayVisitorsCount($_SESSION['filters']['stat']);
$grid_obj->setItemsCount($count);
$tpl->setVar('items_count', $count);
$list_items = $stat_obj->getDayVisitors($_GET['offset'], $in_one_page, $_SESSION['filters']['stat']);
//pae($list_items);

foreach($list_items as $i=>$val){
	if($val['country_code']){
		$list_items[$i]['country'] = "<img src=\"images/countries/{$val['country_code']}.gif\" class=\"vam\" alt=\"{$val['country']}\" />";
	}
	$list_items[$i]['country_ALT'] = $val['country'];
	$list_items[$i]['referer_domain'] = "<a target=\"_blank\" href=\"{$val['referer']}\" >{$val['referer_domain']}</a>";
	$list_items[$i]['referer_domain_ALT'] = $val['referer'];
	$list_items[$i]['page_count'] = "<a href=\"javascript: $('show_stat_item_main').style.display='block'; PageClass.getPageContent('{$configFile->variable['admin_site_url']}main.php?content=stat&page=page_path&id={$val['id']}&ajax=1&area=show_stat_item', 'show_stat_item', 1);\">{$val['page_count']} <img src='images/path.gif' alt='' class='vam' border=0 /></a>"; 
	$list_items[$i]['page_count_ALT'] = $val['page_count'];
}

$grid_obj->setItems($list_items);

$grid_obj->paging_items = $in_one_page;
$grid_obj->paging($_GET['offset']);
$grid_obj->pagingSelect($IN_ONE_PAGE_LIST);

//include $grid_obj->tpl->parse(); exit;
$tpl_grid = & $grid_obj->tpl;

$grid_obj->grid_data['edit_button'] = 0;
$grid_obj->grid_data['delete_button'] = 0;
$grid_obj->grid_data['select_button'] = 0;
$grid_obj->grid_data['dragndrop'] = 0;
$grid_obj->grid_data['list_page'] = 'detail';


$grid_obj->generate();
$tpl->setCodeBlock('detail_content', 'include $grid_obj->tpl->cacheFile;');

$markers = $stat_obj->getMarkers($_SESSION['filters']['stat']);
$tpl->setLoop('markers', $markers);
$tpl->setVar('stat_config', $stat_obj->xml_config);

////////////////////////////////////////////////////////////////////////////////////////////////////


include_once(dirname(__FILE__)."/menu.php");


$_GET['date_to'] = substr($_GET['date_to'],0, 10);


$tpl->setVar('get', $_GET);



?>
