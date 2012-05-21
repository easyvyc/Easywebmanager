<header id="inner_tpl"></header>

<?php TPL::setVar('item_data', $main_object->call("pages", "loadPage", array({{page_data.id}}))); ?>
<div id="data_text">

	<h1>{item_data.title}</h1>
	
	<div id="path">
	{loop id_path}
	{block id_path.first no}
	&nbsp;&nbsp;»&nbsp;&nbsp;
	{-block id_path.first no}
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	{-loop id_path}
	</div>										
	
	{item_data.description}
	
</div>

<div id="left_text">
	
	<?php TPL::setVar('submenu', $main_object->call("pages", "listMenu", array({{id_path.1.id}}))); ?>
	<ul>
		{loop submenu}
		<li {block submenu.selected2}class="a"{-block submenu.selected2}><a href="{lng}{submenu.page_url}" title="{submenu.page_title}">{submenu.title}</a></li>
		{-loop submenu}
	</ul>
	
	<div class="inner_contacts">
		<call code="name=contacts::set=var::module=blocks::method=loadItem_byPageId::params=0,'contacts'">
		{contacts}
	</div>
	
</div>

<div class="clear"></div>