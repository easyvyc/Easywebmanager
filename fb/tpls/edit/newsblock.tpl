<form action="javascript: void(setNewsblock());" method="post">

<script type="text/javascript">

if(typeof($FB_APP.info.data.{id})!='undefined'){
	if(typeof($FB_APP.info.data.{id}.name)!='undefined'){
		$('#column_name').val($FB_APP.info.data.{id}.name);
	}
	if(typeof($FB_APP.info.data.{id}.link)!='undefined'){
		$('#hiperlink').val($FB_APP.info.data.{id}.link);
	}
}

function setNewsblock(){
	$FB_APP.change("{id}", "name", $('#column_name').val());
	$FB_APP.change("{id}", "link", $('#hiperlink').val());
	$FB_APP.save();
	$FB_APP.load_block_info($FB_APP.info.data.{id}.type, '{id}');
	eDIALOG.closeDialog();
}

</script>

	<div class="frm">
		<label for="column_name">Column name:</label><input type="text" class="fo_text" name="name" id="column_name" value="" />
	</div>

	<div class="frm">
		<label for="hiperlink">RSS link:</label><input type="url" class="fo_text" name="hiperlink" id="hiperlink" value="" />
	</div>
	
	<div class="frm">
		<input type="submit" class="fo_submit radius5" value="Apply" />
	</div>

</form>