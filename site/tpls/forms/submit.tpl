<div id="id_{elm.name}" class="formElementsField" {elm.extra_params}>
	<div class="t">
		&nbsp;
	</div>
	<div class="e">

		{block elm.captcha}
		{block elm.show_error}<span class="error_message">{elm.error_message}</span><br>{-block elm.show_error}
		<input type="text" name="{elm.name}" class="fo_text vam" style="width:50px;" />
		<img src="securimage_show.php" alt="" class="vam" />
		<br />
		{-block elm.captcha}


		<input type="submit" value="{elm.title}" class="btn">
	</div>
</div>	
