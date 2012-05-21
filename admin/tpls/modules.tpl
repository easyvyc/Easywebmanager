<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="GENERATOR" content="" />

	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css" />
	<link rel="stylesheet" type="text/css" href="css/layout_1.css" />
	<link rel="stylesheet" type="text/css" href="css/tree.css" />
	
	<base target="content">

	<script language="JavaScript" type="text/javascript" src="js/admin.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/nav.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/tree.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/sorting/prototype.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/sorting/scriptaculous.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/sorting/dragdrop.js"></script>
	
	<script type="text/javascript" src="js/collapse.js"></script>
	
	<script language="JavaScript" type="text/javascript">
		var language_state = '{lng}';
	</script>

<head/>
<body class="main" oncontextmenu="javascript: return false;">

		<ul class="modulesMain" id="secondlist">
		
		<loop name="mod_list_tree">

		<li class="dragLayer" id="secondlist_secondlist{mod_list_tree.id}">
		<div class="tbltop" <block name="mod_list_tree.is_categories">ondblclick="javascript: togglePannelAnimatedStatus('{mod_list_tree.table_name}_tree_id',10,40);"</block name="mod_list_tree.is_categories">>
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="10"></td>
				<td class="round"><img src="images/flag.png" class="png" alt="" class="vam" /></td>
				<td>
		&nbsp;<a style="cursor:pointer;" onclick="javascript: <block name="mod_list_tree.is_categories">togglePannelAnimatedStatus('{mod_list_tree.table_name}_tree_id',10,40); TreeObj_{mod_list_tree.table_name}_s.create(0);</block name="mod_list_tree.is_categories"> parent.content.location='main.php?content=<block name="mod_list_tree.tree">catalog</block name="mod_list_tree.tree"><block name="mod_list_tree.tree" no>{mod_list_tree.table_name}</block name="mod_list_tree.tree" no>&module={mod_list_tree.table_name}&page=list&id=0';">{mod_list_tree.title}</a>
				</td>
				<td align="right">
		<block name="mod_list_tree.is_categories">
		<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('{mod_list_tree.table_name}_tree_id',10,40); <block name="mod_list_tree.active" no>if(!TreeObj_{mod_list_tree.table_name}_s.opened) TreeObj_{mod_list_tree.table_name}_s.create(0);</block name="mod_list_tree.active" no>"><img id="img_{mod_list_tree.table_name}_tree_id" src="images/<block name="mod_list_tree.active" no>plus</block name="mod_list_tree.active" no><block name="mod_list_tree.active">minus</block name="mod_list_tree.active">.gif" border="0" align="absmiddle" vspace="0" hspace="0"></a>&nbsp;
		</block name="mod_list_tree.is_categories">
				</td>
			</tr>
		</table>
		</div>
		
		<block name="mod_list_tree.is_categories">
		<div id="{mod_list_tree.table_name}_tree_id" <block name="mod_list_tree.active" no>style="display:none;"</block name="mod_list_tree.active" no>>
		
		<div id="module_tree_{mod_list_tree.table_name}_s"  class="module_tree_box"></div>


		</div>
		</block name="mod_list_tree.is_categories">
		
		</li>

<block name="mod_list_tree.is_categories">
<script type="text/javascript">
	
	var TreeObj_{mod_list_tree.table_name}_s = new TreeClass('{config.site_url}', '{config.admin_dir}', 'module_tree', '{mod_list_tree.table_name}', 's', '{lng}');
	TreeObj_{mod_list_tree.table_name}_s.phrases.move_confirm_text = '{phrases.move_confirm_text1}';
	
	<block name="mod_list_tree.active">
	TreeObj_{mod_list_tree.table_name}_s.create(id);
	</block name="mod_list_tree.active">

	TreeObj_{mod_list_tree.table_name}_s.param.dragndrop = 1;
	TreeObj_{mod_list_tree.table_name}_s.param.checkbox = 0;
	TreeObj_{mod_list_tree.table_name}_s.param.context = 1;
	
	if($('{mod_list_tree.table_name}_tree_id')){
		if(document.body.addEventListener){
			document.body.addEventListener('contextmenu', TreeObj_{mod_list_tree.table_name}_s.mouseRightClick, true);
		}else{
			$('{mod_list_tree.table_name}_tree_id').oncontextmenu = TreeObj_{mod_list_tree.table_name}_s.mouseRightClick;
		}
	}
				
</script>
</block name="mod_list_tree.is_categories">

		</loop name="mod_list_tree">


		
<block name="is_admin_prm">
		<li class="dragLayer" id="secondlist_secondlist_catalog">
		<div class="tbltop" ondblclick="javascript: switchMode('catalog_tree_id');">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="10"></td>
				<td class="round"><img src="images/flag.png" class="png" alt="" class="vam" /></td>
				<td>
		&nbsp;<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('catalog_tree_id',10,40); TreeObj_catalog_c.create(0); parent.content.location='main.php?content=mod&page=modules';">{phrases.catalogs}</a>
				</td>
				<td align="right">
		<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('catalog_tree_id',10,40); if(!TreeObj_catalog_c.opened) TreeObj_catalog_c.create(0);"><img id="img_catalog_tree_id" src="images/plus.gif" border="0" align="absmiddle" vspace="0" hspace="0"></a>&nbsp;
				</td>
			</tr>
		</table>
		</div>
		
		<div id="catalog_tree_id" style="display:none;">
		
		<div id="module_tree_catalog_c"  class="module_tree_box"></div>


		</div>
		
		</li>


<script type="text/javascript">
	
	var TreeObj_catalog_c = new TreeClass('{config.site_url}', '{config.admin_dir}', 'catalog', 'catalog', 'c', '{lng}');
	//TreeObj_catalog_c.phrases.move_confirm_text = '{phrases.move_confirm_text1}';
	
	TreeObj_catalog_c.param.dragndrop = 0;
	TreeObj_catalog_c.param.checkbox = 0;
	TreeObj_catalog_c.param.context = 1;
	
	//TreeObj_catalog_c.create(id);
	
	if(document.body.addEventListener){
		document.body.addEventListener('contextmenu', TreeObj_catalog_c.mouseRightClick, true);
	}else{
		$('catalog_tree_id').oncontextmenu = TreeObj_catalog_c.mouseRightClick;
	}

	
				
</script>
</block name="is_admin_prm">

		
		</ul>


<pre id="secondlist_debug"></pre>

<script type="text/javascript">
 
Sortable.create("secondlist", {dropOnEmpty:true,handle:'tbltop',containment:["secondlist"],constraint:false, onChange:function(){}});

</script>


<div id="contextMenuArea" onmouseout="javascript: hideTreeItemContenxtMenu(event);"></div>

</body>

<block name="main_reload">
<script language="javascript">
parent.frames.content.location = 'main.php?content={easyweb.content}';
</script>
</block name="main_reload">
</html>
