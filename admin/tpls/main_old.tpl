<block name="xhtml" no>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
</block name="xhtml" no>

<block name="xhtml">
<html>
</block name="xhtml">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="GENERATOR" content="" />
	<title>easywebmanager {easyweb_version}</title>
	
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/layout_1.css" />
	<link rel="stylesheet" type="text/css" href="css/calendar.css" />
	<link rel="stylesheet" type="text/css" href="css/dhtmlXTree.css" />
	
	<script language="javascript" src="js/cookie.js" type="text/javascript"></script>
	<script language="javascript" src="js/admin.js" type="text/javascript"></script>
	<script language="javascript" src="js/window.js" type="text/javascript"></script>
	<script language="javascript" src="js/xmlhttprequest.js" type="text/javascript"></script>
	
	<script language="javascript" src="js/xmlsax/xmlsax.js" type="text/javascript"></script>
	<script language="javascript" src="js/xmlsax/scripts.js" type="text/javascript"></script>
	<script language="javascript" src="js/ajax.js" type="text/javascript"></script>
	<script language="javascript" src="js/listChangeFields.js" type="text/javascript"></script>

	<script language="JavaScript" src="js/tree/dhtmlXCommon.js"></script>
	<script language="JavaScript" src="js/tree/dhtmlXTree.js"></script>
	<script language="JavaScript" src="js/tree/treeEventFunctions.js"></script>
	
	<script language="JavaScript" src="js/sorting/prototype.js"></script>
	<script language="JavaScript" src="js/sorting/scriptaculous.js"></script>
	
	<script language="javascript">
	
	var edited_element = <block name="is_edited_element" no>false</block name="is_edited_element" no><block name="is_edited_element">true</block name="is_edited_element">;
	var languageCode = '{config.admin_interface_language}';

	var selected = (sel=getCookie('selected')) ? sel : false;
	var first_id = (fid=getCookie('first_id')) ? fid : 0;
	//var parent_id = (pid=getCookie('parent_id')) ? pid : 0;
	
	var overRowColor = '#E9E9E9';
	var outRowColor = '#F3F3F3';
	
	</script>
	
	<script language="JavaScript" src="js/calendar.js" type="text/javascript"></script>
	
<head/>
<body class="main" scroll="auto" onbeforeunload="javascript: is_edited_element('{phrases.before_unload_text}');">

<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
	<tr height="32">
		<td class="tbltop">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="10"></td>
				<td>{module.title}</td>
				<td></td>
				
				<loop name="languages">
				<td class="lang<block name="languages.active"> round</block name="languages.active">">
				<block name="filter_module">
				<a href="main.php?{QUERY_STRING}&filter_lang={languages.lng}">{languages.lng}</a>
				</block name="filter_module">
				
				<block name="filter_module" no>
				<a href="top.php?lng={languages.lng}" target="top">{languages.lng}</a>
				</block name="filter_module" no>
				
				</td>
				</loop name="languages">
				
				<td width="10"></td>
			</tr>
		</table>
		
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" style="padding:10px;">
{inner_content}
		</td>
	</tr>
</table>

</body>

</html>

<block name="filter_module" no>
<block name="refresh_tree">
<script language="javascript">
if(parent.frames.modules.document.getElementById('treeboxbox_tree')){
	parent.frames.modules.createTree('{lng}');
}
</script>
</block name="refresh_tree">
</block name="filter_module" no>

<block name="restart_session">
<script type="text/javascript">
	window.showModalDialog("frame.php?url=login.php?session_restart=1", "", "dialogWidth:370px; dialogHeight:300px; center:yes");
</script>
</block name="restart_session">