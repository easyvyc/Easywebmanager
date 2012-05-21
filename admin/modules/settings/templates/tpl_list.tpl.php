<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			<?php include $tpl_menu->cacheFile; ?>
		</td>
	</tr>
	<tr>
		<td height="30" valign="middle"><a href="main.php?content=settings&page=template&tpl_id=0" class="path"><img src="images/new_element.gif" border="0" align="absmiddle"> Naujas šablonas</a></td>
	</tr>
		
	<?php if(!$templateVariables->vars["empty"]){ ?>
	<tr>
		<td>
	<table border="0" cellpadding="2" cellspacing="2" width="100%" align="left">
	<tr class="tblheader">
		<td width="5%">Redaguoti</td>
		<td>Pavadinimas</td>
		<td width="5%">Rodoma</td>
		<td width="5%">Trinti</td>
	</tr>
	<?php foreach($templateVariables->loops["templates"] as $templates_key => $templates_val){ ?>
	<tr class="tblcontent" id="row<?php echo $templates_val["id"]; ?>" onmouseover="javascript: change_row_color(overRowColor,<?php echo $templates_val["id"]; ?>);" onmouseout="javascript: change_row_color(outRowColor,<?php echo $templates_val["id"]; ?>);">
		<td align="center"><a href="main.php?content=settings&page=template&tpl_id=<?php echo $templates_val["id"]; ?>"><img src="images/edit.gif" border="0"></a></td>
		<td style="cursor:pointer;" onclick="javscript: location='main.php?content=settings&page=template&tpl_id=<?php echo $templates_val["id"]; ?>'">&nbsp;<?php echo $templates_val["title"]; ?></td>
		<td align="center"><a href="main.php?content=settings&page=tpl_list&action=status&statusid=<?php echo $templates_val["id"]; ?>"><img src="images/status_<?php echo $templates_val["active"]; ?>.gif" border="0"></a></td>
		<td align="center"><a href="javascript: if(confirm('Ar tikrai norite ištrinti šį įrašą?')){ window.location = 'main.php?content=settings&page=tpl_list&action=delete&deleteid=<?php echo $templates_val["id"]; ?>'; }"><img src="images/delete.gif" border="0"></a></td>
	</tr>
	<?php } ?>
	</table>
		</td>
	</tr>
	<?php } ?>

	<?php if($templateVariables->vars["empty"]){ ?>
	<tr>
		<td height="30" valign="middle">Įrašų nėra.</td>
	</tr>	
	<?php } ?>
</table>