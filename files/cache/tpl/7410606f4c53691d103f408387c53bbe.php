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

<script type="text/javascript" src="admin/js/jquery.js"></script>
<script type="text/javascript" src="admin/js/jquery-ui.js"></script>
<script type="text/javascript" src="admin/js/datepicker/<?php echo TPL::getVar("cms_lng"); ?>.js"></script>
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
_CNF.lng = '<?php echo TPL::getVar("cms_lng"); ?>';
_CNF.cms = true;
</script>

</head>

<body>

	<div id="top">
		
		<div id="lang">
			<?php $languages_iterator=1; foreach(TPL::getLoop("languages") as $languages_key => $languages_val){ if(!is_array($languages_val)){ $tmp_val=$languages_val; $languages_val=array(); $languages_val['_VALUE']=$tmp_val; } $languages_val['_FIRST']=0; if($languages_iterator==1) $languages_val['_FIRST']=1; if($languages_iterator%2==1) $languages_val['_EVEN']=0; else $languages_val['_EVEN']=1; $languages_val['_INDEX']=$languages_iterator++; $languages_val['_KEY']=$languages_key; ?>
			<a href="javascript: void($NAV.change_language('<?php if(isset($languages_val["lng"])) echo $languages_val["lng"]; ?>'));" class="<?php if(isset($languages_val["lng"])) echo $languages_val["lng"]; ?> <?php if(isset($languages_val["active"]) && $languages_val["active"]){ ?>a<?php } ?>"><?php if(isset($languages_val["lng"])) echo $languages_val["lng"]; ?></a>
			<?php } ?>
		</div>
		
		<div class="top">
			<div class="fleft"><a href="http://www.easywebmanager.com" target="_blank"><img src="admin/images/logo.png" alt="easywebmanager" /></a></div>
			<div class="fright ico">
				<img src="admin/images/top/update.gif" alt="<?php echo TPL::getVar("phrases.top.update_alt"); ?>" >&nbsp;<a href="javascript: void($NAV.get('?module=_easy_updates&ajax=1'));"><?php echo TPL::getVar("phrases.top.update"); ?></a>
				<!--img src="admin/images/top/debug.gif" alt="<?php echo TPL::getVar("phrases.top.debug_alt"); ?>" >&nbsp;<a href="javascript: void($NAV.get('?module=stat&ajax=1'));"><?php echo TPL::getVar("phrases.top.debug"); ?></a-->
				<img src="admin/images/top/help.gif" alt="<?php echo TPL::getVar("phrases.top.manual_alt"); ?>" >&nbsp;<a href="http://help.easywebmanager.com/?v=4" target="_blank"><?php echo TPL::getVar("phrases.top.manual"); ?></a>
				<img src="admin/images/top/user.gif" alt="<?php echo TPL::getVar("phrases.top.profile_alt"); ?>" >&nbsp;<a href="javascript: void($NAV.get('?module=admins&method=edit&id=<?php echo TPL::getVar("admin.id"); ?>&ajax=1'));"><?php echo TPL::getVar("admin.login"); ?> (<?php echo TPL::getVar("admin.firstname"); ?> <?php echo TPL::getVar("admin.lastname"); ?>)</a>
				<img src="admin/images/top/logout.gif" alt="<?php echo TPL::getVar("phrases.top.logout_alt"); ?>" >&nbsp;<a href="admin.php?logout=1"><?php echo TPL::getVar("phrases.top.logout"); ?></a>
			</div>
		</div>
	
		<div class="oln"></div>
		
		<nav id="easy_main_navigation">
		
			<ul>
			<?php TPL::setVar('modules', cms::getInstance()->registry->model->modules->list_menu()); ?>
			<?php $modules_iterator=1; foreach(TPL::getLoop("modules") as $modules_key => $modules_val){ if(!is_array($modules_val)){ $tmp_val=$modules_val; $modules_val=array(); $modules_val['_VALUE']=$tmp_val; } $modules_val['_FIRST']=0; if($modules_iterator==1) $modules_val['_FIRST']=1; if($modules_iterator%2==1) $modules_val['_EVEN']=0; else $modules_val['_EVEN']=1; $modules_val['_INDEX']=$modules_iterator++; $modules_val['_KEY']=$modules_key; ?>
			<li>
				<a href="javascript: void(select_module_folder('mod_<?php if(isset($modules_val["id"])) echo $modules_val["id"]; ?>'));"><?php if(isset($modules_val["title"])) echo $modules_val["title"]; ?></a>
				<div class="mod_cat" id="mod_<?php if(isset($modules_val["id"])) echo $modules_val["id"]; ?>" rel="<?php if(isset($modules_val["id"])) echo $modules_val["id"]; ?>">
				<ul>
					<?php $modules_sub_iterator=1; if(isset($modules_val["sub"])){ foreach($modules_val["sub"] as $modules_sub_key => $modules_sub_val){ if(!is_array($modules_sub_val)){ $tmp_val=$modules_sub_val; $modules_sub_val=array(); $modules_sub_val['_VALUE']=$tmp_val; } $modules_sub_val['_FIRST']=0; if($modules_sub_iterator==1) $modules_sub_val['_FIRST']=1; if($modules_sub_iterator%2==1) $modules_sub_val['_EVEN']=0; else $modules_sub_val['_EVEN']=1; $modules_sub_val['_INDEX']=$modules_sub_iterator++; $modules_sub_val['_KEY']=$modules_sub_key;  ?>
					<li rel="<?php if(isset($modules_sub_val["table_name"])) echo $modules_sub_val["table_name"]; ?>"><a href="javascript: void($NAV.select_module('<?php if(isset($modules_sub_val["table_name"])) echo $modules_sub_val["table_name"]; ?>'));"><?php if(isset($modules_sub_val["title"])) echo $modules_sub_val["title"]; ?></a></li>
					<?php }} ?>
				</ul>
				</div>
			</li>
			<?php } ?>

			<?php if(TPL::getVar("super_admin")){ ?>
			<li>
				<a href="javascript: void(select_module_folder('mod_SUPERADMIN'));"><?php echo TPL::getVar("phrases.modules.catalogs"); ?></a>
				<div id="mod_SUPERADMIN">
				<ul>
					<li><a href="javascript: void($NAV.select_module('modules'));"><?php echo TPL::getVar("phrases.main.settings.modules_title"); ?></a></li>
					<li><a href="javascript: void($NAV.select_module('module_category'));"><?php echo TPL::getVar("phrases.main.settings.modules_category_title"); ?></a></li>
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