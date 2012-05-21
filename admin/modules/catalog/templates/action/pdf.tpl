<form style="margin:0px;" method="post" name="export_pdf" action="main.php?content={get.content}&module={module.table_name}&page=pdf&parent_id={get.id}" target="_blank">
<b>{phrases.main.catalog.select_fields2use}:</b><br />
<loop name="fields">
<div class="float" style="float:left;width:200px;">
<input type="checkbox" name="chk[{fields.column_name}]" id="chk__{fields.column_name}" class="fo_checkbox vam" checked />
<label for="chk__{fields.column_name}">{fields.title}</label>
</div>
</loop name="fields">

<div class="clear"></div>

<input type="submit" value="{phrases.main.catalog.generate_pdf_print}" class="fo_submit vam" />

</form>

<block name="get.filters">
<script type="text/javascript">
parent.document.getElementById('list_iframe_<?php echo $_SESSION['filter_item'][$_GET['filters']]['get_column_name']['value']; ?>').height = '' + (document.documentElement.scrollHeight+10) + 'px';
</script>
</block name="get.filters">
