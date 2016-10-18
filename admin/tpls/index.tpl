<!DOCTYPE html> 
<html>
<head>
<title>easywebmanager {easyweb_version}</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta http-equiv="pragma" content="no-cache" >


<meta name="GOOGLEBOT" content="noindex,nofollow" >
<meta name="ROBOTS" content="noindex,nofollow" >
<meta name="GENERATOR" content="easywebmanager" >

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >

<style type="text/css">
{css}
</style>

<script type="text/javascript" src="admin/js/jquery.js"></script>
<script type="text/javascript" src="admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="admin/js/datepicker/{cms_lng}.js"></script>
<script type="text/javascript" src="admin/js/jquery.lightbox.js"></script>
<script type="text/javascript" src="admin/js/jquery.timers.js"></script>
<script type="text/javascript" src="admin/js/jquery.upload.js"></script>
<script type="text/javascript" src="admin/js/scripts.js"></script>
<script type="text/javascript" src="admin/js/dialog.js"></script>
<script type="text/javascript" src="admin/js/nav.js"></script>
<script type="text/javascript" src="admin/js/listing.js"></script>
<script type="text/javascript" src="admin/js/forms.js"></script>
<script type="text/javascript" src="admin/js/tree.js"></script>

<script type="text/javascript" src="admin/lib/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="admin/lib/ckeditor/config.js"></script>

<script type="text/javascript">
var _CNF = new Object;
_CNF.lng = '{cms_lng}';
_CNF.cms = true;
</script>

</head>

<body>

	<div id="top">
		
		<div id="lang">
			{loop languages}
			<a href="javascript: void($NAV.change_language('{languages.lng}'));" class="{languages.lng} {block languages.active}a{-block languages.active}">{languages.lng}</a>
			{-loop languages}
		</div>
		
		<div class="top">
			<div class="fleft"><a href="http://www.easywebmanager.com" target="_blank"><img src="admin/images/logo.png" alt="easywebmanager" /></a></div>
			<div class="fright ico">
				<img src="admin/images/top/update.gif" alt="{phrases.top.update_alt}" >&nbsp;<a href="javascript: void($NAV.get('?module=_easy_updates&ajax=1'));">{phrases.top.update}</a>
				<!--img src="admin/images/top/debug.gif" alt="{phrases.top.debug_alt}" >&nbsp;<a href="javascript: void($NAV.get('?module=stat&ajax=1'));">{phrases.top.debug}</a-->
				<img src="admin/images/top/help.gif" alt="{phrases.top.manual_alt}" >&nbsp;<a href="http://help.easywebmanager.com/?v=4" target="_blank">{phrases.top.manual}</a>
				<img src="admin/images/top/user.gif" alt="{phrases.top.profile_alt}" >&nbsp;<a href="javascript: void($NAV.get('?module=admins&method=edit&id={admin.id}&ajax=1'));">{admin.login} ({admin.firstname} {admin.lastname})</a>
				<img src="admin/images/top/logout.gif" alt="{phrases.top.logout_alt}" >&nbsp;<a href="admin.php?logout=1">{phrases.top.logout}</a>
			</div>
		</div>
	
		<div class="oln"></div>
		
		<nav id="easy_main_navigation">
		
			<ul>
			<?php TPL::setVar('modules', cms::getInstance()->registry->model->modules->list_menu()); ?>
			{loop modules}
			<li>
				<a href="javascript: void(select_module_folder('mod_{modules.id}'));">{modules.title}</a>
				<div class="mod_cat" id="mod_{modules.id}" rel="{modules.id}">
				<ul>
					{loop modules.sub}
					<li rel="{modules.sub.table_name}"><a href="javascript: void($NAV.select_module('{modules.sub.table_name}'));">{modules.sub.title}</a></li>
					{-loop modules.sub}
				</ul>
				</div>
			</li>
			{-loop modules}

			{block super_admin}
			<li>
				<a href="javascript: void(select_module_folder('mod_SUPERADMIN'));">{phrases.modules.catalogs}</a>
				<div id="mod_SUPERADMIN">
				<ul>
					<li><a href="javascript: void($NAV.select_module('modules'));">{phrases.main.settings.modules_title}</a></li>
					<li><a href="javascript: void($NAV.select_module('module_category'));">{phrases.main.settings.modules_category_title}</a></li>
					<li><a href="javascript: void($NAV.select_module('templates'));">{phrases.main.settings.templates_title}</a></li>
				</ul>
				</div>
			</li>
			{-block super_admin}

			</ul>
			
		</nav>
		<div id="module_folder"></div>
	
	</div>
	
	<div id="center">
	
		<div id="left">
			
			<div class="overflow">
			
				<div id="tree">
				

				
				</div>
				
			</div>
			
			<div class="resizer_v">&nbsp;</div>
		</div>
		
		<div id="content">
		
		
		</div>
		
	</div>
	
	<div class="clear"></div>
	
	<div id="bottom">
		
	</div>

</body>
</html>

<script>
$(document).ready(function(){
        select_module_folder('mod_1');
        $NAV.select_module('pages');
});
</script>