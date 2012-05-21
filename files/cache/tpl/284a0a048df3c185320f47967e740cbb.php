<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField" <?php if(TPL::getVar("elm.extra_block_style")){ ?>style="<?php echo TPL::getVar("elm.extra_block_style"); ?>"<?php } ?>>
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
		<?php if(TPL::getVar("elm.show_error")){ ?><br><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e frm_list">

		<div class="lst">
		<?php $items_iterator=1; foreach(TPL::getLoop("items") as $items_key => $items_val){ $items_val['_FIRST']=0; if($items_iterator==1) $items_val['_FIRST']=1; if($items_iterator%2==1) $items_val['_EVEN']=0; else $items_val['_EVEN']=1; $items_val['_INDEX']=$items_iterator++; ?>
			<div class="item">
				<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
				<input type='<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?>' alt="<?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?>" value='{items.<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>}' name='<?php echo TPL::getVar("elm.name"); ?>[<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>][]' class='<?php echo TPL::getVar("style"); ?>_<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?> vam <?php echo TPL::getVar("elm.style"); ?>' />
				<?php } ?>
				<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[id][]" value="<?php if(isset($items_val["id"])) echo $items_val["id"]; ?>" />
				<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[_OK_][]" value="1" class="h" />
			</div>
		
		<?php } ?>

			<div class="item">
				<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
				<input type='text' rel='<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?>' alt="<?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?>" value='' name='<?php echo TPL::getVar("elm.name"); ?>[<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>][]' class='<?php echo TPL::getVar("style"); ?>_<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?> vam <?php echo TPL::getVar("elm.style"); ?>' />
				<?php } ?>
				<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[id][]" value="0" />
				<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[_OK_][]" value="0" class="h" />
				<input type="button" class="radius3 btn vam" value="Add" onclick="javascript: _FRM_LIST_ADD('<?php echo TPL::getVar("elm.name"); ?>');" />
			</div>
		</div>
		
	</div>

	<div id="<?php echo TPL::getVar("elm.name"); ?>_LIST_H" style="display:none;">
	<div class="item">
		<?php $fields_iterator=1; foreach(TPL::getLoop("fields") as $fields_key => $fields_val){ $fields_val['_FIRST']=0; if($fields_iterator==1) $fields_val['_FIRST']=1; if($fields_iterator%2==1) $fields_val['_EVEN']=0; else $fields_val['_EVEN']=1; $fields_val['_INDEX']=$fields_iterator++; ?>
		<input type='text' rel='<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?>' alt="<?php if(isset($fields_val["title"])) echo $fields_val["title"]; ?>" value='' name='<?php echo TPL::getVar("elm.name"); ?>[<?php if(isset($fields_val["column_name"])) echo $fields_val["column_name"]; ?>][]' class='<?php echo TPL::getVar("style"); ?>_<?php if(isset($fields_val["elm_type"])) echo $fields_val["elm_type"]; ?> vam <?php echo TPL::getVar("elm.style"); ?>' />
		<?php } ?>
		<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[id][]" value="0" />
		<input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[_OK_][]" value="0" class="h" />
		<input type="button" class="radius3 btn vam" value="Add" onclick="javascript: _FRM_LIST_ADD('<?php echo TPL::getVar("elm.name"); ?>');" />
	</div>
	</div>

</div>

<script type="text/javascript">
$("#id_<?php echo TPL::getVar("elm.name"); ?> .frm_list .item input.<?php echo TPL::getVar("style"); ?>_date").datepicker({			
	changeMonth: true,
	changeYear: true,
	yearRange: '1990:2020'
});
</script>