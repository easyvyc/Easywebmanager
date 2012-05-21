<!DOCTYPE html> 
<html>
<head>
<title>easywebmanager <?php echo TPL::getVar("easyweb_version"); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta http-equiv="pragma" content="no-cache" >


<meta name="GOOGLEBOT" content="noindex,nofollow" >
<meta name="ROBOTS" content="noindex,nofollow" >
<meta name="GENERATOR" content="easywebmanager" >

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >

<style type="text/css">
<?php echo TPL::getVar("css"); ?>
</style>

<script type="text/javascript" src="fb/js/jquery.js"></script>
<script type="text/javascript" src="fb/js/jquery-ui.js"></script>
<script type="text/javascript" src="fb/js/jquery.json.js"></script>
<script type="text/javascript" src="fb/js/jquery.timer.js"></script>
<script type="text/javascript" src="fb/js/scripts.js"></script>
<script type="text/javascript" src="fb/js/dialog.js"></script>
<script type="text/javascript" src="fb/js/nav.js"></script>
<script type="text/javascript" src="fb/js/listing.js"></script>
<script type="text/javascript" src="fb/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="fb/js/jquery.swfupload.js"></script>


</head>

<body>

	<div id="_SYSTEM_MSG"></div>

	<div id="top">
		
		<div id="lang">
			<?php $languages_iterator=1; foreach(TPL::getLoop("languages") as $languages_key => $languages_val){ $languages_val['_FIRST']=0; if($languages_iterator==1) $languages_val['_FIRST']=1; if($languages_iterator%2==1) $languages_val['_EVEN']=0; else $languages_val['_EVEN']=1; $languages_val['_INDEX']=$languages_iterator++; ?>
			<a href="javascript: void($NAV.change_language('<?php if(isset($languages_val["lng"])) echo $languages_val["lng"]; ?>'));" class="<?php if(isset($languages_val["lng"])) echo $languages_val["lng"]; ?> <?php if(isset($languages_val["active"]) && $languages_val["active"]){ ?>a<?php } ?>"><?php if(isset($languages_val["lng"])) echo $languages_val["lng"]; ?></a>
			<?php } ?>
		</div>
		
		<div class="top">
			<div class="fleft"><a href="http://www.easywebmanager.com" target="_blank"><img src="admin/images/logo.png" alt="easywebmanager" /></a></div>
			<div class="fright ico">
				<img src="admin/images/top/help.gif" alt="<?php echo TPL::getVar("phrases.top.manual_alt"); ?>" >&nbsp;<a href="http://help.easywebmanager.com" target="_blank"><?php echo TPL::getVar("phrases.top.manual"); ?></a>
				<img src="admin/images/top/user.gif" alt="<?php echo TPL::getVar("phrases.top.profile_alt"); ?>" >&nbsp;<a href="#"><?php echo TPL::getVar("admin.login"); ?> (<?php echo TPL::getVar("admin.firstname"); ?> <?php echo TPL::getVar("admin.lastname"); ?>)</a>
				<img src="admin/images/top/logout.gif" alt="<?php echo TPL::getVar("phrases.top.logout_alt"); ?>" >&nbsp;<a href="admin.php?logout=1"><?php echo TPL::getVar("phrases.top.logout"); ?></a>
			</div>
		</div>
	
		<div class="oln"></div>
		
		<nav>
		
			<ul>

				<li>
					<a href="javascript: void(select_module_folder('mod_APP'));">Aplikacijos valdymas</a>
					<div id="mod_APP">
					<ul>
						<li><a href="javascript: void($NAV.select_module('fb_app'));">Aplikacija</a></li>
						<li><a href="javascript: void($NAV.select_module('fb_app_likegate'));">Like gate</a></li>
						<li><a href="javascript: void($NAV.select_module('fb_app_tab'));">Tab</a></li>
						<li><a href="javascript: void($NAV.select_module('rss'));">RSS kanalai</a></li>
						<li><a href="javascript: void($NAV.select_module('fb_settings'));">Nustatymai</a></li>
					</ul>
					</div>
				</li>
	
				<li>
					<a href="javascript: void(select_module_folder('mod_DATA'));">Duomenys</a>
					<div id="mod_DATA">
					<ul>
						<li><a href="javascript: void($NAV.select_module('fb_users'));">Aplikacijos naudotojai</a></li>
					</ul>
					</div>
				</li>
	
				<li>
					<a href="javascript: void(select_module_folder('mod_ADMINS'));">Administravimas</a>
					<div id="mod_ADMINS">
					<ul>
						<li><a href="javascript: void($NAV.select_module('admins'));">Aplikacijos administratoriai</a></li>
					</ul>
					</div>
				</li>

				<?php if(TPL::getVar("super_admin")){ ?>
				<li>
					<a href="javascript: void(select_module_folder('mod_SUPERADMIN'));"><?php echo TPL::getVar("phrases.modules.catalogs"); ?></a>
					<div id="mod_SUPERADMIN">
					<ul>
						<li><a href="javascript: void($NAV.select_module('modules'));"><?php echo TPL::getVar("phrases.main.settings.modules_title"); ?></a></li>
						<li><a href="javascript: void($NAV.select_module('modules_category'));"><?php echo TPL::getVar("phrases.main.settings.modules_category_title"); ?></a></li>
						<li><a href="javascript: void($NAV.select_module('templates'));"><?php echo TPL::getVar("phrases.main.settings.templates_title"); ?></a></li>
					</ul>
					</div>
				</li>
				<?php } ?>

			</ul>
			
		</nav>
		<div id="module_folder"></div>
	
	</div>
	
	<div id="center">
	
		<div id="left">
			
			<div class="overflow">
			
				<div id="search"></div>
				
				<div id="tree">
				

				
				</div>
				
				<div id="module_actions">

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
