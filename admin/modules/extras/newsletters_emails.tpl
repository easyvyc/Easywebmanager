<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}" >
	<div class="t">
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">


		<table border="0" width="100%">
			<tr>
				<td valign="top" width="330">
		{block elm.show_error}<span class="error_message">{elm.error_message}</span><br>{-block elm.show_error}
		
		<input type="hidden" name="test" value="1" id="test_emails" />

<div style="padding-top:8px;padding-bottom:8px;">
<a style="cursor:pointer;padding:4px;background:#CCC;" onclick="javascript: $('test_emails_{elm.name}').style.display='block'; $('real_emails_{elm.name}').style.display='none'; $('test_emails').value=1; this.style.background='#CCC'; $('parinkti_emails').style.background='none';" id="irasyti_emails">{phras.emails_simple}</a>
&nbsp;&nbsp;&nbsp;
<a style="cursor:pointer;padding:4px;" onclick="javascript: $('test_emails_{elm.name}').style.display='none'; $('real_emails_{elm.name}').style.display='block'; $('test_emails').value=0; this.style.background='#CCC'; $('irasyti_emails').style.background='none';" id="parinkti_emails">{phras.emails_from_db}</a>
</div>
	
		<div id="test_emails_{elm.name}">
			<textarea name='{elm.name}' class='{style}_{elm.elm_type}{block elm.editorship no} readonly{-block elm.editorship no}' onchange="javascript: setEdited('{elm.name}');" {block elm.editorship no}readonly{-block elm.editorship no} {elm.extra_params}></textarea>
		</div>
		
		<div id="real_emails_{elm.name}" style="display:none;">
			<!--input type="hidden" name="emails_categories" id="emails_categories" value="" -->
			{loop categories}
			<div><input type="checkbox" name="emails_categories[]" id="emails_categories_{categories.category_id}" value="{categories.category_id}" class="vam" /> <label for="emails_categories_{categories.category_id}" >{categories.category} ({categories.emails_count})</label></div>
			{-loop categories}
		</div>
		
		<!--input type="button" class="fo_submit" value="Įkrauti el. paštus" onclick="javascript: get_subscribers(event, '{config.site_url}', '{elm.name}', form_tree_{elm.name}.getAllChecked());" /-->

		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" {block elm.edited no}value="0"{-block elm.edited no}{block elm.edited}value="1"{-block elm.edited}>

				</td>
				<td valign="top">

		<div id="newsletters_loading"></div>
		<div id="mail_results" style="height:130px;overflow:hidden;"></div>
		
				</td>
			</tr>
		</table>
		

	</div>
</div>