<div id="id_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
		<?php if(TPL::getVar("elm.show_error")){ ?><br><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">
		<select name='<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("elm.column_name"); ?>" class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(TPL::getVar("elm.list_values.multiple")){ ?>multiple size="6"<?php } ?> <?php echo TPL::getVar("elm.extra_params"); ?>>
		<option value="">-------------</option>
		<?php $list_iterator=1; foreach(TPL::getLoop("list") as $list_key => $list_val){ $list_val['_FIRST']=0; if($list_iterator==1) $list_val['_FIRST']=1; if($list_iterator%2==1) $list_val['_EVEN']=0; else $list_val['_EVEN']=1; $list_val['_INDEX']=$list_iterator++; ?><option value="<?php if(isset($list_val["value"])) echo $list_val["value"]; ?>" <?php if(isset($list_val["selected"]) && $list_val["selected"]){ ?>selected<?php } ?> ><?php if(isset($list_val["title"])) echo $list_val["title"]; ?></option><?php } ?>
		</select>
		
		<?php echo TPL::getVar("elm.extra_data"); ?>
		
	</div>	
</div>
