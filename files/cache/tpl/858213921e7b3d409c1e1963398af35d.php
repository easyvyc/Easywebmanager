<form action="javascript: void($FB_APP.menu.add($('#_menu_rss_url').val(), $('#_menu_rss_title').val()));">

<div class="frm">
	<label for="_menu_rss_url">RSS url: </label><input type="url" class="fo_text" id="_menu_rss_url" name="rss_url" value="" /> 
</div>

<div class="frm">
	<label for="_menu_rss_title">RSS name: </label><input type="text" class="fo_text" id="_menu_rss_title" name="rss_title" value="" /> 
</div>

<div class="frm">
	<input type="submit" class="fo_submit radius5" value=" Add ">
</div>

</form>


<form action="javascript: void($FB_APP.menu.save());">
<ol id="menu_sorting">

</ol>

<div class="frm">
	<input type="submit" class="fo_submit radius5" value=" Apply ">
</div>

</form>

<script type="text/javascript">
$FB_APP.menu.loadEdit('#menu_sorting');
</script>