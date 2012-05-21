<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="GENERATOR" content="" />
	<title>easywebmanager {easyweb_version}</title>
	
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css" />
	<script language="javascript" src="js/admin.js"></script>
	<script language="javascript" src="js/window.js"></script>

<base target="content">

<style>
#top {
	border:1px solid #CBC9C9;
	height:50px;
	background:#f4f4f4;
}
.w {
	white-space:nowrap;
	margin-top:6px;
	margin-left:20px;
}
.w div {
	white-space:nowrap;
	position:relative;
	top:-10px;
	text-align:center;
	display:block;
	color:#666;
}
.w img {
	margin-left:10px;
	margin-right:10px;
	vertical-align:top;
}
</style>

<head/>
<body style="margin:2px;">

<div id="top">

	<div class="float" style="width:300px;text-align:center;">	
	<img src="images/logo.png" style="margin-top:14px;" alt="" class="png" />
	</div>
	<div class="float w">
		<a href="main.php?content=search"><img src="images/top/search.gif" border="0" alt="{phrases.search_alt}"  />
		<div>
		{phrases.search}
		</div>
		</a>
	</div>
	<div class="float w">
	<a href="main.php?content=stat">
		<img src="images/top/stat.gif" border="0" alt="{phrases.stat_alt}" />
		<div>{phrases.stat}</div>
	</a>
	</div>
	<div class="float w">
	<a href="main.php?content=catalog&module=admins&page=list&id={admin.id}#edit"><img src="images/top/profile.gif" border="0" alt="{phrases.administrator_alt}" />
	<div>{phrases.administrator}</div>
	</a>
	</div>
	<div class="float w">
	<a href="main.php?content=settings">
	<img src="images/top/settings.gif" border="0" alt="{phrases.settings_alt}" />
	<div>{phrases.settings}</div>
	</a>
	</div>
	<div class="float w">
	<a style="cursor:pointer;" onclick="javascript: openCenteredWindow('http://help.easywebmanager.com/', 'manual', 950, 650, 0, 0, 'resizable', '');">
	<img src="images/top/manual.gif" border="0" alt="{phrases.manual_alt}" />
	<div>{phrases.manual}</div>
	</a>
	</div>
	<div class="float w">
	<a href="main.php?content=trash&page=list&by=R.last_modif_date&order=DESC">
	<img src="images/top/trash.gif" border="0" alt="{phrases.trash_alt}" />
	<div>{phrases.trash}</div>
	</a>
	</div>
	
	<block name="zend_optimizer">
	<div class="float w">
	<a href="update.php">
	<img src="images/top/update.gif" border="0" alt="{phrases.update_alt}" id="upd_img" />
	<div>{phrases.update}</div>
	</a>
	</div>
	</block name="zend_optimizer">
	
	<block name="no">
	<block name="is_super_admin_prm">
	<div class="float w">
	<a href="setup.php">
	<img src="images/debug.gif" border="0" alt="{phrases.setup_alt}" /><br />{phrases.setup}</a>
	</div>
	</block name="is_super_admin_prm">
	</block name="no">
	
	
	<div class="w" style="right:20px;position:absolute;">
	<a href="index.php?logout=1" target="_parent">
	<img src="images/top/logout.gif" border="0" alt="{phrases.logout_alt}" />
	<div>{phrases.logout}</div>
	</a>
	</div>


</div>

<!--[if lte IE 6]> 
<script type="text/javascript" src="js/png.js"></script>
<![endif]--> 						

</body>
</html>

<block name="content_reload">
<script type="text/javascript">

parent.content.location.reload();

<loop name="module_list">
if(parent.modules.TreeObj_{module_list.table_name}_s){
	if(parent.modules.TreeObj_{module_list.table_name}_s.opened){
		if(parent.modules.TreeObj_{module_list.table_name}_s.opened==1){
			parent.modules.parent.modules.TreeObj_{module_list.table_name}_s.lng = '{lng}';
			parent.modules.parent.modules.TreeObj_{module_list.table_name}_s.create(parent.modules.parent.modules.TreeObj_{module_list.table_name}_s.currentItem);	
		}
	}
}
</loop name="module_list">
</script>
</block name="content_reload">