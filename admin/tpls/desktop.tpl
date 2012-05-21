<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="GENERATOR" content="" />
	<title>easywebmanager {easyweb_version}</title>
	
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/forms.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/layout_1.css" />
	<link rel="stylesheet" type="text/css" href="css/calendar.css" />
	<link rel="stylesheet" type="text/css" href="css/tree.css" />
	
	<link rel="stylesheet" type="text/css" href="css/{get.content}.css" />
	
	<script language="javascript" src="js/cookie.js" type="text/javascript"></script>
	<script language="javascript" src="js/admin.js" type="text/javascript"></script>
	<script language="javascript" src="js/window.js" type="text/javascript"></script>
	<script language="javascript" src="js/xmlhttprequest.js" type="text/javascript"></script>

	<script language="JavaScript" type="text/javascript" src="js/tree.js"></script>
	
	<script language="JavaScript" src="js/sorting/prototype.js"></script>
	<script language="JavaScript" src="js/sorting/scriptaculous.js"></script>
	
	<script language="JavaScript" src="js/popup.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="js/nav.js"></script>
	
	<script language="javascript">
	
	var languageCode = '{config.admin_interface_language}';
	
	var overRowColor = '#E9E9E9';
	var outRowColor = '#F3F3F3';
	
	var CONFIG_SITE_URL = '{config.site_url}';
	
	SKIRTUMAS = 0;
	
	</script>
	
	<script language="JavaScript" src="js/calendar.js" type="text/javascript"></script>
	
<head/>
<body class="main" scroll="auto">


<div class="tbltop" id="languagesBar" style="position:fixed;z-index:100;top:0;left:0;width:100%;">
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="10"></td>
		<td>{phrases.title}&nbsp;</td>
		<td width="10"></td>
	</tr>
</table>
</div>



<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
	<tr>
		<td height="25"></td>
	</tr>
	<tr>
		<td align="left" valign="top" style="padding:10px;" id="inner_content">

<a href="javascript: void($('add_shortcut_area').style.display='block'); PageClass.getPageContent('{config.site_admin_url}ajax.php?get=desktop/modules', 'add_shortcut_content');"><img src="images/add_shortcut.gif" class="vam" alt="" border="0" /> {phrases.add_shortcut}</a>

<loop name="items">
<div id="item___{items.id}" class="desktop_item">

</div>
</loop name="items">

		</td>
	</tr>
</table>


<div id="add_shortcut_area">

	<div class="tbltop" id="add_shortcut_top">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{phrases.add_shortcut}</span>
			</td>
			<td align="right">
		<a href="javascript: void($('add_shortcut_area').style.display='none');"><img src="images/close.gif" class="vam" alt="" border="0" style="margin-right:10px;" /></a>
			</td>
		</tr>
	</table>
	</div>
	
	
	<div class="editZone" id="add_shortcut_content" style="padding:15px;">

	</div>
	
</div>

<script type="text/javascript">
popup_show('add_shortcut_area', 'add_shortcut_top', '', 'screen-center', 0, 0);
document.getElementById('add_shortcut_area').style.display='none';
</script>

<div id="LOADING_overlay" style="display:none;">
<br /><br /><br /><br />
{phrases.common.loading}
</div>

</body>

</html>