<table border="0" cellpadding="5" cellspacing="0" width="100%" align="left">
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">
			
			<?php include $tpl_menu->cacheFile; ?>
			
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;" colspan="3">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
				<tr>
					<td class="pathcell">
			<a href="main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=list" class="path"><?php echo $templateVariables->vars["module.title"]; ?></a> → 
			<?php foreach($templateVariables->loops["path"] as $path_key => $path_val){ ?><?php echo $path_val["title"]; ?> → <?php } ?> <?php echo $templateVariables->vars["data.title"]; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	

	
	<tr>
		<td colspan="3">
	
	<a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.trash.reset_confirm"]; ?>')){ window.location = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=<?php echo $templateVariables->vars["get.page"]; ?>&action=reset&resetid=<?php echo $templateVariables->vars["data.id"]; ?>&id=<?php echo $templateVariables->vars["data.id"]; ?>'; }"><img src="images/reset.gif" border="0" align="absmiddle">&nbsp;&nbsp;<?php echo $templateVariables->vars["phrases.trash.reset_title"]; ?></a>
	&nbsp;&nbsp;&nbsp;
	<a href="javascript: if(confirm('<?php echo $templateVariables->vars["phrases.common.delete_confirm"]; ?>')){ window.location = 'main.php?content=<?php echo $templateVariables->vars["get.content"]; ?>&page=<?php echo $templateVariables->vars["get.page"]; ?>&action=delete&deleteid=<?php echo $templateVariables->vars["data.id"]; ?>&id=<?php echo $templateVariables->vars["data.id"]; ?>'; }"><img src="images/delete.gif" border="0" align="absmiddle">&nbsp;&nbsp;<?php echo $templateVariables->vars["phrases.common.delete_title"]; ?></a>
	
		</td>
	</tr>
	
	<tr>
		<td colspan="3">
					
	
				<?php echo $templateVariables->vars["form"]; ?>

			
		</td>
	</tr>
	
	<?php if(!$templateVariables->vars["data.isNew"]){ ?>
	<tr>
		<td colspan="3" style="background-color:#EFEFEF;border:1px solid #CCCCCC;">
		
		<?php echo $templateVariables->vars["phrases.common.created"]; ?>: <?php echo $templateVariables->vars["data.create_date"]; ?> (<?php echo $templateVariables->vars["data.create_by_ip"]; ?>)
		<?php if($templateVariables->vars["record_author_create.id"]){ ?><?php echo $templateVariables->vars["record_author_create.id"]; ?> - <?php echo $templateVariables->vars["record_author_create.title"]; ?> (<?php echo $templateVariables->vars["record_author_create.module_title"]; ?>)<?php } ?>
		<?php if(!$templateVariables->vars["record_author_create.id"]){ ?> - <?php echo $templateVariables->vars["phrases.common.anonymous_record_author"]; ?><?php } ?>
		<br>
		<?php echo $templateVariables->vars["phrases.common.modificated"]; ?>: <?php echo $templateVariables->vars["data.last_modif_date"]; ?> (<?php echo $templateVariables->vars["data.last_modif_by_ip"]; ?>)
		<?php if($templateVariables->vars["record_author_modify.id"]){ ?><?php echo $templateVariables->vars["record_author_modify.id"]; ?> - <?php echo $templateVariables->vars["record_author_modify.title"]; ?> (<?php echo $templateVariables->vars["record_author_modify.module_title"]; ?>)<?php } ?>
		<?php if(!$templateVariables->vars["record_author_modify.id"]){ ?><?php echo $templateVariables->vars["phrases.common.anonymous_record_author"]; ?><?php } ?>
		
		</td>
	</tr>
	<?php } ?>
	
	
</table>