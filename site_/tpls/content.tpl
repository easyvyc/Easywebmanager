<!DOCTYPE html> 
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta http-equiv="pragma" content="no-cache" >

<title>{block page_data.id}{page_data.page_title}{-block page_data.id}{block page_data.id no}{site.title}{-block page_data.id no}</title>


<meta name="description" content="{page_data.description}" >
<meta name="abstract" content="{page_data.description}" >
<meta name="keywords" content="{page_data.keywords}" >
<meta name="GOOGLEBOT" content="index,follow" >
<meta name="ROBOTS" content="index,follow" >
<meta name="revisit_after" content="3 Days" >
<meta name="GENERATOR" content="easywebmanager" >

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >

<base href="{config.site_url}" >

<style type="text/css">
{css}
</style>

<call code="name=rss::set=loop::module=_main::method=listRss::params=">
{loop rss}
<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php?module={rss.table_name}&amp;lng={lng}" >
{-loop rss}

{xml_config.google}

</head>
<body>

<div id="main">
	
	<div id="top">
		<a href="{lng}/"><img src="images/logo.jpg" alt="{phrases.logo_alt}" id="logo" /></a>
		<nav>
			<ul>
				
				<li><a href="{lng}/" id="home" class="png{block id_path.1.id no} a{-block id_path.1.id no}"></a></li>
				
				<?php TPL::setVar('bmenu', $main_object->pages->listMenu(3345)); ?>
				{loop bmenu}
				<li {block bmenu.selected}class="a"{-block bmenu.selected}><a href="{lng}{bmenu.page_url}" title="{bmenu.page_title}">{bmenu.title}</a></li>
				{-loop bmenu}
			</ul>
		</nav>
		<div class="clear"></div>
		<div id="lang">
			{loop languages}
			<a href="{languages.value}/" {block languages.active}class="a png"{-block languages.active}>{languages.title}</a>
			{-loop languages}			
		</div>
	</div>
	
	<?php include {{page_content}}; ?>	

	<footer>
		<div class="fleft">
			<call code="name=copyrights_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'copyrights'">
			{copyrights_data}		
		</div>
		<div class="fright">
		
			<a href="http://www.adme.lt" target="_blank" title="Interneto svetainių kūrimas">Interneto svetainių kūrimas adme</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			{block lng_lt}
			<a href="http://www.easywebmanager.lt" target="_blank" title="Turinio Valdymo Sistema">Turinio valdymo sistema easywebmanager</a>
			{-block lng_lt}
			{block lng_lt no}
			<a href="http://www.easywebmanager.com" target="_blank" title="Content Management System">Content management system easywebmanager</a>
			{-block lng_lt no}
		
		</div>
	</footer>

</div>


<!--[if lte IE 6]> 
<script type="text/javascript" src="js/png.js"></script>
<![endif]-->

</body>
</html>