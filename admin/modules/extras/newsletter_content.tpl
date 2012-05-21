<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}" >
	<div class="t">
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">

<div style="padding-top:8px;padding-bottom:8px;">
<a style="cursor:pointer;padding:4px;background:#CCC;" onclick="javascript: $('html_text_{elm.name}').style.display='block'; $('plain_text_{elm.name}').style.display='none'; this.style.background='#CCC'; $('parinkti_emails').style.background='none';" id="irasyti_emails">HTML turinys</a>
&nbsp;&nbsp;&nbsp;
<a style="cursor:pointer;padding:4px;" onclick="javascript: $('html_text_{elm.name}').style.display='none'; $('plain_text_{elm.name}').style.display='block'; this.style.background='#CCC'; $('irasyti_emails').style.background='none';" id="parinkti_emails">Paprastas tekstas</a>
</div>
	
		<div id="html_text_{elm.name}" style="width:100%;height:400px;">
			{elm.editor}
		</div>
		
		<div id="plain_text_{elm.name}" style="display:none;">
			<textarea name='plain_text' style="width:100%;height:250px;" class='{style}_textarea{block elm.editorship no} readonly{-block elm.editorship no}' onchange="javascript: setEdited('{elm.name}');" {block elm.editorship no}readonly{-block elm.editorship no} >{data.plain_text.value}</textarea>
		</div>

		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" {block elm.edited no}value="0"{-block elm.edited no}{block elm.edited}value="1"{-block elm.edited}>


	</div>
</div>
