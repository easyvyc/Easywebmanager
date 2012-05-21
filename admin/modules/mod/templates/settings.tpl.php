<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">

	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			
			<?php include $tpl_menu->cacheFile; ?>
			
		</td>
	</tr>

	<tr>
		<td align="left" valign="top" height="20" style="width:100%;" colspan="3">


<div style="width:100%;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="pathcell">
				<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=modules" class="path"><?php echo $templateVariables->vars["phrases.settings.modules_title"]; ?></a> → <a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=edit&id=<?php echo $templateVariables->vars["module.id"]; ?>" class="path"><?php echo $templateVariables->vars["module.title"]; ?> (<?php echo $templateVariables->vars["module.table_name"]; ?>)</a> → <?php echo $templateVariables->vars["phrases.catalog.mod_settings"]; ?>
			</td>
			
		</tr>
	</table>
</div>	


		</td>
	</tr>
	<tr>
		<td colspan="3">


			<?php echo $templateVariables->vars["form"]; ?>

			
		</td>
	</tr>
</table>