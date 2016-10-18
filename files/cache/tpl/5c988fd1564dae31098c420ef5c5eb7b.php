<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">
		<select <?php if(!TPL::getVar("elm.editable")){ ?>readonly disabled<?php } ?> name='<?php echo TPL::getVar("elm.name"); ?><?php if(TPL::getVar("elm.list_values.multiple")){ ?>[]<?php } ?>' id="ELMID_<?php echo TPL::getVar("elm.column_name"); ?>" class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(TPL::getVar("elm.list_values.multiple")){ ?>multiple size="10"<?php } ?> <?php echo TPL::getVar("elm.extra_params"); ?>>
		<option value="">-------------</option>
		<?php $tpl_data_iterator=1; foreach(TPL::getLoop("tpl_data") as $tpl_data_key => $tpl_data_val){ if(!is_array($tpl_data_val)){ $tmp_val=$tpl_data_val; $tpl_data_val=array(); $tpl_data_val['_VALUE']=$tmp_val; } $tpl_data_val['_FIRST']=0; if($tpl_data_iterator==1) $tpl_data_val['_FIRST']=1; if($tpl_data_iterator%2==1) $tpl_data_val['_EVEN']=0; else $tpl_data_val['_EVEN']=1; $tpl_data_val['_INDEX']=$tpl_data_iterator++; $tpl_data_val['_KEY']=$tpl_data_key; ?>
                    <optgroup label="<?php if(isset($tpl_data_val["title"])) echo $tpl_data_val["title"]; ?>">
                    <?php $tpl_data_sub_iterator=1; if(isset($tpl_data_val["sub"])){ foreach($tpl_data_val["sub"] as $tpl_data_sub_key => $tpl_data_sub_val){ if(!is_array($tpl_data_sub_val)){ $tmp_val=$tpl_data_sub_val; $tpl_data_sub_val=array(); $tpl_data_sub_val['_VALUE']=$tmp_val; } $tpl_data_sub_val['_FIRST']=0; if($tpl_data_sub_iterator==1) $tpl_data_sub_val['_FIRST']=1; if($tpl_data_sub_iterator%2==1) $tpl_data_sub_val['_EVEN']=0; else $tpl_data_sub_val['_EVEN']=1; $tpl_data_sub_val['_INDEX']=$tpl_data_sub_iterator++; $tpl_data_sub_val['_KEY']=$tpl_data_sub_key;  ?>
                        <option value="<?php if(isset($tpl_data_sub_val["id"])) echo $tpl_data_sub_val["id"]; ?>" ><?php if(isset($tpl_data_sub_val["title"])) echo $tpl_data_sub_val["title"]; ?></option>
                        
                        <?php $tpl_data_sub_sub_iterator=1; if(isset($tpl_data_sub_val["sub"])){ foreach($tpl_data_sub_val["sub"] as $tpl_data_sub_sub_key => $tpl_data_sub_sub_val){ if(!is_array($tpl_data_sub_sub_val)){ $tmp_val=$tpl_data_sub_sub_val; $tpl_data_sub_sub_val=array(); $tpl_data_sub_sub_val['_VALUE']=$tmp_val; } $tpl_data_sub_sub_val['_FIRST']=0; if($tpl_data_sub_sub_iterator==1) $tpl_data_sub_sub_val['_FIRST']=1; if($tpl_data_sub_sub_iterator%2==1) $tpl_data_sub_sub_val['_EVEN']=0; else $tpl_data_sub_sub_val['_EVEN']=1; $tpl_data_sub_sub_val['_INDEX']=$tpl_data_sub_sub_iterator++; $tpl_data_sub_sub_val['_KEY']=$tpl_data_sub_sub_key;  ?>
                            <option value="<?php if(isset($tpl_data_sub_sub_val["id"])) echo $tpl_data_sub_sub_val["id"]; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($tpl_data_sub_sub_val["title"])) echo $tpl_data_sub_sub_val["title"]; ?></option>
                            
                            <?php $tpl_data_sub_sub_sub_iterator=1; if(isset($tpl_data_sub_sub_val["sub"])){ foreach($tpl_data_sub_sub_val["sub"] as $tpl_data_sub_sub_sub_key => $tpl_data_sub_sub_sub_val){ if(!is_array($tpl_data_sub_sub_sub_val)){ $tmp_val=$tpl_data_sub_sub_sub_val; $tpl_data_sub_sub_sub_val=array(); $tpl_data_sub_sub_sub_val['_VALUE']=$tmp_val; } $tpl_data_sub_sub_sub_val['_FIRST']=0; if($tpl_data_sub_sub_sub_iterator==1) $tpl_data_sub_sub_sub_val['_FIRST']=1; if($tpl_data_sub_sub_sub_iterator%2==1) $tpl_data_sub_sub_sub_val['_EVEN']=0; else $tpl_data_sub_sub_sub_val['_EVEN']=1; $tpl_data_sub_sub_sub_val['_INDEX']=$tpl_data_sub_sub_sub_iterator++; $tpl_data_sub_sub_sub_val['_KEY']=$tpl_data_sub_sub_sub_key;  ?>
                                <option value="<?php if(isset($tpl_data_sub_sub_sub_val["id"])) echo $tpl_data_sub_sub_sub_val["id"]; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($tpl_data_sub_sub_sub_val["title"])) echo $tpl_data_sub_sub_sub_val["title"]; ?></option>
                            <?php }} ?>
                            
                        <?php }} ?>
                        
                    <?php }} ?>
                    </optgroup>
                <?php } ?>
		</select>
		
		<?php echo TPL::getVar("elm.extra_data"); ?>
		
	</div>	
</div>

<script>
$(document).ready(function(){

<?php if(!TPL::getVar("elm.list_values.multiple")){ ?>
<?php if(TPL::getVar("elm.value")){ ?>
$('#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>').val('<?php echo TPL::getVar("elm.value"); ?>');
<?php } ?>
<?php } ?>

<?php if(TPL::getVar("elm.list_values.multiple")){ ?>
<?php $elm_values_iterator=1; foreach(TPL::getLoop("elm_values") as $elm_values_key => $elm_values_val){ if(!is_array($elm_values_val)){ $tmp_val=$elm_values_val; $elm_values_val=array(); $elm_values_val['_VALUE']=$tmp_val; } $elm_values_val['_FIRST']=0; if($elm_values_iterator==1) $elm_values_val['_FIRST']=1; if($elm_values_iterator%2==1) $elm_values_val['_EVEN']=0; else $elm_values_val['_EVEN']=1; $elm_values_val['_INDEX']=$elm_values_iterator++; $elm_values_val['_KEY']=$elm_values_key; ?>
$("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?> option[value='" + <?php if(isset($elm_values_val["_VALUE"])) echo $elm_values_val["_VALUE"]; ?> + "']").prop('selected', true);
<?php } ?>
<?php } ?>


});
    
</script>