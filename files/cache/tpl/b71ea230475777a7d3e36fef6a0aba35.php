<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
	<div class="t">
		<span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
		<?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
	</div>
	<div class="e">
	
		<?php if(TPL::getVar("elm.value")){ ?>
		<a id="lightbox_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>" target="_blank" href="admin.php?module=<?php echo TPL::getVar("_hiddens.module"); ?>&method=get_file&column=<?php echo TPL::getVar("elm.column_name"); ?>&id=<?php echo TPL::getVar("_hiddens.id"); ?>&t=download&rand=<?php echo TPL::getVar("random"); ?>" >
                    <?php echo TPL::getVar("elm.value"); ?>
		</a>
		<br />
                <label><input type='checkbox' name='delete_<?php echo TPL::getVar("elm.name"); ?>' value='1' id='id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_delete' <?php if(!TPL::getVar("elm.editorship")){ ?>disabled<?php } ?>>Delete</label>
                <br />
		<?php } ?>

		<input type='hidden' name='<?php echo TPL::getVar("elm.name"); ?>' value='<?php echo TPL::getVar("elm.value"); ?>'>
		
		<input type='hidden' name='<?php echo TPL::getVar("elm.name"); ?>_type' value='upload'>

		<div class="img_upload_types"><a class="upload" href="#">Upload</a>&nbsp;&nbsp;<a href="#" class="url">URL</a></div>
		
		<div class="image_upload_type" id="img_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>_upload">
		<input type='file' name='file_<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_upload_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>" value='' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(!TPL::getVar("elm.editable")){ ?>readonly<?php } ?> >
		</div>

		<div class="image_upload_type" id="img_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>_url" style="display:none">
		<input type='text' name='url_<?php echo TPL::getVar("elm.name"); ?>' id="ELMID_url_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>" value='' placeholder="Resource URL" class='FRM <?php echo TPL::getVar("style"); ?>_text' <?php if(!TPL::getVar("elm.editable")){ ?>readonly<?php } ?> ><br />
		</div>

		
		<span style="font-size:9px;"><?php echo TPL::getVar("phrases.main.common.max_file_size"); ?> - <?php echo TPL::getVar("max_file_size"); ?> Mb</span>

	</div>
</div>
<script>
$(document).ready(function(){
    $('#id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?> .img_upload_types .upload').click(function(){
        $("#id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?> .image_upload_type").hide();
        $("#img_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_upload").show();
        $("#id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?> [name=<?php echo TPL::getVar("elm.name"); ?>_type]").val('upload');
    });

    $('#id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?> .img_upload_types .url').click(function(){
        $("#id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?> .image_upload_type").hide();
        $("#img_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>_url").show();
        $("#id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?> [name=<?php echo TPL::getVar("elm.name"); ?>_type]").val('url');
    });

});
</script>
