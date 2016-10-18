<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField" <?php if(TPL::getVar("elm.extra_block_style")){ ?>style="<?php echo TPL::getVar("elm.extra_block_style"); ?>"<?php } ?>>
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
                <a class="new_listing" href="javascript: void($NAV.open_dialog('<?php echo TPL::getVar("elm.list_values.module"); ?>_<?php echo TPL::getVar("elm.list_values.column"); ?>_<?php echo TPL::getVar("frm_list_CID"); ?>', '?module=<?php echo TPL::getVar("elm.list_values.module"); ?>&method=create_from_listing&column=<?php echo TPL::getVar("elm.list_values.column"); ?>&cid=<?php echo TPL::getVar("frm_list_CID"); ?>&area=id_frm_list_area_<?php echo TPL::getVar("elm.name"); ?>&no_tree_reload=1&json=0', '<?php echo TPL::getVar("phrases.main.catalog.new_element"); ?>'));"><img src="admin/images/actions/new.gif"> <?php echo TPL::getVar("phrases.main.catalog.new_element"); ?></a>
		<?php if(TPL::getVar("elm.show_error")){ ?><br><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e frm_list" id="id_frm_list_area_<?php echo TPL::getVar("elm.name"); ?>">

            

	</div>

</div>
<script>

$NAV.get('?module=<?php echo TPL::getVar("elm.list_values.module"); ?>&method=<?php if(TPL::getVar("elm.list_values.method")){ ?><?php echo TPL::getVar("elm.list_values.method"); ?><?php } ?><?php if(!TPL::getVar("elm.list_values.method")){ ?>listing<?php } ?>&column=<?php echo TPL::getVar("elm.list_values.column"); ?>&cid=<?php echo TPL::getVar("frm_list_CID"); ?>&area=id_frm_list_area_<?php echo TPL::getVar("elm.name"); ?>&no_tree_reload=1');

</script>