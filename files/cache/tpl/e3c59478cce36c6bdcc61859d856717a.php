<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>" <?php echo TPL::getVar("elm.extra_params"); ?>>
	<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
	<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	<br>
		<?php $list_iterator=1; foreach(TPL::getLoop("list") as $list_key => $list_val){ if(!is_array($list_val)){ $tmp_val=$list_val; $list_val=array(); $list_val['_VALUE']=$tmp_val; } $list_val['_FIRST']=0; if($list_iterator==1) $list_val['_FIRST']=1; if($list_iterator%2==1) $list_val['_EVEN']=0; else $list_val['_EVEN']=1; $list_val['_INDEX']=$list_iterator++; $list_val['_KEY']=$list_key; ?>
		<div style="float:left;width:170px;">
		<input type='radio' name='<?php echo TPL::getVar("elm.name"); ?>' value='<?php if(isset($list_val["value"])) echo $list_val["value"]; ?>' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' id='id_<?php echo TPL::getVar("elm.name"); ?>_<?php if(isset($list_val["value"])) echo $list_val["value"]; ?>' <?php if(isset($list_val["selected"]) && $list_val["selected"]){ ?>checked<?php } ?> />
		<label for="id_<?php echo TPL::getVar("elm.name"); ?>_<?php if(isset($list_val["value"])) echo $list_val["value"]; ?>"><?php if(isset($list_val["title"])) echo $list_val["title"]; ?></label>
		</div>
		<?php } ?>	
		<div style="clear:left;"></div>	
</div>
