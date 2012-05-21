<form method="get" style="margin:0px;">
<input type="hidden" name="content" value="search" />
<div id="area_id_q" class="formElementsField" style="padding:5px;">
	<div class="e">
<input type="text" class="fo_text vam" value="{get.q}" name="q" style="width:150px;height:16px;" /> <input type="submit" class="fo_submit vam" value="   ok   " />
	</div>
</div>
</form>


<div style="height:5px;"></div>

<block name="get.q">
<block name="short_key">
<div class="formElementsField" style="padding:5px;">
Per trumpas paieškos žodis
</div>
</block name="short_key">

<block name="short_key" no>
<block name="no_results">
<div class="formElementsField" style="padding:5px;">
Paieškos rezultatų nėra
</div>
</block name="no_results">

<loop name="search_results">
<div>

	<div class="tbltop" ondblclick="javascript: javascript: togglePannelAnimatedStatus('search_area_{search_results.table_name}',10,40);" id="referers_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{search_results.title}</span>
			</td>
		</tr>
	</table>
	</div>	
	
	<div id="search_area_{search_results.table_name}" class="search_results">
		<loop name="search_results.mod_list_items">
		<div>
		<a href="main.php?content=<block name="search_results.tree">catalog</block name="search_results.tree"><block name="search_results.tree" no>{search_results.main_module}</block name="search_results.tree" no>&module={search_results.main_module}&page=list&id={search_results.mod_list_items.id}#{search_results.action}" class="links">{search_results.mod_list_items.title} »</a>
		{search_results.mod_list_items.description}
		</div>
		</loop name="search_results.mod_list_items">
	</div>
</div>
</loop name="search_results">


</block name="short_key" no>
</block name="get.q">