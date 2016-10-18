<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>&nbsp;
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
                <?php if(TPL::getVar("elm.value")){ ?>
                <a href="<?php echo TPL::getVar("config.site_url"); ?><?php echo TPL::getVar("site_lng"); ?><?php echo TPL::getVar("elm.value"); ?>" target="_blank">Open Link</a>
                <?php } ?>
	</div>
	<div class="e">
            
		<span class='<?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' style="padding-right:0px;overflow:hidden;">
                    <span class="FRM_input_text" style="padding-right:0px;border-right:none;vertical-align:middle;display:inline-block;width:auto;white-space:nowrap;"><?php echo TPL::getVar("config.site_url"); ?><?php echo TPL::getVar("site_lng"); ?></span><span id="ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable" class="editable FRM_input_text" style="padding-left:0px;border-left:none;max-width:500px;overflow:hidden;vertical-align:middle;display:inline-block;width:auto;white-space:nowrap;"><?php echo TPL::getVar("elm.value"); ?></span>
                    <input type='hidden' name='<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_<?php echo TPL::getVar("elm.column_name"); ?>" value='<?php echo TPL::getVar("elm.value"); ?>' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' style="border:none;margin-top:-3px;margin-right:-3px;" <?php if(!TPL::getVar("elm.editable")){ ?>readonly<?php } ?> >
                </span>
                
		<input type="checkbox" <?php if(!TPL::getVar("elm.editorship")){ ?>checked<?php } ?> value="1" name="generate_url" id="gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id" style="vertical-align:middle;" /> <label for="gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id">Auto URL</label>
                
	</div>
</div>

<script type="text/javascript">
    
$("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable").dblclick(function(){
	$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").attr('checked', false);
        pageurl = $("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable");
        pageurl.attr('contenteditable', true);
        pageurl.css({ background: '#FFF'});
});

$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").change(function(){
	bool = $(this).is(':checked');
	pageurl = $("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable");
	if(bool){
		pageurl.attr('contenteditable', false);
                pageurl.css({ background: 'none'});
	}else{
		pageurl.attr('contenteditable', true);
                pageurl.css({ background: '#FFF'});
	}
});

$('#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable').keypress(function(e) {
    if(e.keyCode == 13){
        return false;
    }
});

$('#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable').keyup(function(e) {
    if(!$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").is(':checked')){
        $('#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>').val($('#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable').html());
    }
});

<?php if(TPL::getVar("_form_data.generate_url.value")){ ?>
$("#gen_<?php echo TPL::getVar("elm.column_name"); ?>_auto_id").attr('checked', true);
<?php } ?>
<?php if(!TPL::getVar("_form_data.generate_url.value")){ ?>
pageurl = $("#ELMID_<?php echo TPL::getVar("elm.column_name"); ?>_editable");
pageurl.attr('contenteditable', true);
pageurl.css({ background: '#FFF'});
<?php } ?>
</script>