<div id="area_id_{elm.name}" class="formElementsField{block elm.edited} edited{-block elm.edited}">

	<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
		<tr>
			<td id="btn_{elm.name}">
			
	<input type="submit" value="{block elm.title no}{phrases.form.submit}{-block elm.title no}{block elm.title}{elm.title}{-block elm.title}" class="fo_submit" />
	<input type="reset" name="reset" value="{phrases.form.reset}" class="fo_submit" onclick="javascript: top.content.edited_element=false; " />

			</td>
			<td align="right" id="r_f_{elm.name}">
			<i>
	* - {phrases.form.required_fields}.
			</i>
			</td>
		</tr>
	</table>
			
	<input type="hidden" id="edited_field_{elm.name}" name="edited_field_{elm.name}" value="{block elm.edited no}0{-block elm.edited no}{block elm.edited}1{-block elm.edited}" />
	
</div>




	