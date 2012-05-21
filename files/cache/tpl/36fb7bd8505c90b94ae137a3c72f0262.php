<?php if(TPL::getVar("no")){ ?>
<script type="text/javascript">

	var params = { dragndrop:"<?php echo TPL::getVar("elm.property.dragndrop"); ?>",checkbox:"<?php echo TPL::getVar("elm.property.checkbox"); ?>",context:"<?php echo TPL::getVar("elm.property.context"); ?>" };
	var phrases = {move_confirm_text:"<?php echo TPL::getVar("phrases.move_confirm_text1"); ?>"};
	var TreeObj_<?php echo TPL::getVar("elm.property.module"); ?>_<?php echo TPL::getVar("elm.name"); ?> = _TreeClass('<?php echo TPL::getVar("config.site_url"); ?>', '<?php echo TPL::getVar("config.admin_dir"); ?>', '<?php echo TPL::getVar("elm.property.script"); ?>', '<?php echo TPL::getVar("elm.property.module"); ?>', '<?php echo TPL::getVar("elm.name"); ?>', '<?php echo TPL::getVar("lng"); ?>', params, phrases, <?php if(TPL::getVar("elm.property.click_handler")){ ?>'<?php echo TPL::getVar("elm.property.click_handler"); ?>'<?php } ?><?php if(!TPL::getVar("elm.property.click_handler")){ ?>null<?php } ?>);
	
	<?php if(TPL::getVar("elm.property.active")){ ?>
	TreeObj_<?php echo TPL::getVar("elm.property.module"); ?>_<?php echo TPL::getVar("elm.name"); ?>.create(id);
	<?php } ?>
	
</script>


<script type="text/javascript">

		var form_tree_visible_<?php echo TPL::getVar("elm.name"); ?> = 0;
		
		//createFormTree_<?php echo TPL::getVar("elm.name"); ?>('<?php echo TPL::getVar("lng"); ?>', <?php echo TPL::getVar("elm.value"); ?>);

		function sh_tree_<?php echo TPL::getVar("elm.name"); ?>(){
			TreeObj_<?php echo TPL::getVar("elm.property.module"); ?>_<?php echo TPL::getVar("elm.name"); ?>.show_hide_tree('<?php echo TPL::getVar("elm.name"); ?>', '<?php echo TPL::getVar("elm.value"); ?>');
		}

		<?php if(TPL::getVar("elm.property.expanded")){ ?>
		sh_tree_<?php echo TPL::getVar("elm.name"); ?>();
		<?php } ?>
		
</script>
<?php } ?>

<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" <?php if(TPL::getVar("elm.extra_block_style")){ ?>style="<?php echo TPL::getVar("elm.extra_block_style"); ?>"<?php } ?>>
	<div class="t">
		
		<span class="<?php echo TPL::getVar("elm.style"); ?><?php if(!TPL::getVar("elm.editorship")){ ?> readonly<?php } ?>"><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.require")){ ?>*<?php } ?></span>
		<div id="<?php echo TPL::getVar("elm.name"); ?>_tree_hide_button" <?php if(!TPL::getVar("elm.property.expanded")){ ?>style="display:none;"<?php } ?>>
		<input type="button" value="<?php echo TPL::getVar("phrases.form.hide_tree"); ?>" class="<?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>" id="btn_id_<?php echo TPL::getVar("elm.name"); ?>_hide" >
		</div>
		<div id="<?php echo TPL::getVar("elm.name"); ?>_tree_show_button" <?php if(TPL::getVar("elm.property.expanded")){ ?>style="display:none;"<?php } ?>>
			<input type="button" value="<?php echo TPL::getVar("phrases.form.show_tree"); ?>" class="<?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>" id="btn_id_<?php echo TPL::getVar("elm.name"); ?>_show" >
		</div>	
		
			
	</div>
	<div class="e">

	<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><br /><?php } ?>
	<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>" id="<?php echo TPL::getVar("elm.name"); ?>" value="<?php echo TPL::getVar("elm.value"); ?>" class="FRM">
		<div id="<?php echo TPL::getVar("elm.name"); ?>_tree_id" style="display:none;">
		
<div id="module_tree_<?php echo TPL::getVar("elm.property.module"); ?>_<?php echo TPL::getVar("elm.name"); ?>"  class="module_tree_box"></div>

		</div>

		<input type="hidden" id="edited_field_<?php echo TPL::getVar("elm.name"); ?>" name="edited_field_<?php echo TPL::getVar("elm.name"); ?>" <?php if(!TPL::getVar("elm.edited")){ ?>value="0"<?php } ?><?php if(TPL::getVar("elm.edited")){ ?>value="1"<?php } ?> />
		
	</div>
	
</div>

<?php if(TPL::getVar("no")){ ?>
<script type="text/javascript">
<?php if(TPL::getVar("elm.editorship")){ ?>
document.getElementById('btn_id_<?php echo TPL::getVar("elm.name"); ?>_hide').onclick = sh_tree_<?php echo TPL::getVar("elm.name"); ?>;
document.getElementById('btn_id_<?php echo TPL::getVar("elm.name"); ?>_show').onclick = sh_tree_<?php echo TPL::getVar("elm.name"); ?>;
<?php } ?>		
</script>
<?php } ?>