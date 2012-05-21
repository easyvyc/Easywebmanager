<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">
	<div class="t">
	
		<span class="{elm.style}{block elm.editorship no} readonly{-block elm.editorship no}">{elm.title}:{block elm.require}*{-block elm.require}</span>&nbsp;
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
			
	</div>
	<div class="e">

		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top">

		<textarea name='{elm.name}' class='{style}_{elm.elm_type}{block elm.editorship no} readonly {-block elm.editorship no}' onchange="javascript: setEdited('{elm.name}');" >{elm.value}</textarea>

				</td>
				<td valign="top" style="padding-left:10px;">
		
		<input type="button" value=" Auto " class="fo_submit" onclick="javascript: get_page_description(event, '{config.site_url}', '{elm.name}', {data.id.value})" />
		
<script type="text/javascript"> 
var no_keywords_found_on_page = '{phrases.pages.no_description_found_on_page}'; 
var keywords_exist_on_page='{phrases.pages.description_exist_on_page}'; 
</script>

		<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}"  value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />

				</td>
			</tr>
		</table>


	</div>
</div>