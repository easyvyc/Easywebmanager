<div class="block_title" ondblclick="javascript: switchMode('last_visitors');" style="padding:4px;margin:2px;">
&nbsp;<a style="cursor:pointer;" onclick="javascript: switchMode('last_visitors');">{phrases.stat.day_visitors} ({day_stat_count})</a>
</div>
		
<div class="stat_content" id="last_visitors" style="display:block">



<block name="empty" no>


<div class="paging" id="paging" style="overflow:auto;">
<loop name="paging">
	<a onclick="javascript: if(this.className!='paging_1'){ ajaxContentReload(event, '{config.admin_site_url}ajax.php?date={get.date}&date_to={get.date_to}&ipaddress={filters_data.ipaddress}&referer_domain={filters_data.referer_domain}&offset={paging.number}', 'detail_visitors'); } " class="paging_{paging.active}">{paging._INDEX}</a>
</loop name="paging">
</div>



<form name="detail_stat" method="post" style="margin:0px;" action="javascript: ajaxContentReload(event, '{config.admin_site_url}ajax.php?date={get.date}&date_to={get.date_to}&ipaddress='+document.getElementById('ipaddress').value+'&referer_domain='+document.getElementById('referer_domain').value, 'detail_visitors');">
<table border="0" cellpadding="2" cellspacing="2" width="100%" style="border-collapse:collapse;">

<tr class="tblheader">
	<td nowrap>{phrases.stat.ip_address_title}</td>
	
	<td nowrap>{phrases.stat.browser_title}</td>
	<td nowrap>{phrases.stat.os_title}</td>

	<td nowrap>{phrases.stat.referer_title}</td>
	<td nowrap>{phrases.stat.country_title}</td>
	<td nowrap>{phrases.stat.enter_time_title}</td>
	<td nowrap>{phrases.stat.past_time_title}</td>
	<td nowrap>{phrases.stat.pages_count_title}</td>
</tr>

<tr class="tblheader">
	<td nowrap><input type="text" name="ipaddress" id="ipaddress" value="{filters_data.ipaddress}" class="fo_text" style="width:99%;"></td>
	
	<td nowrap><input type="text" name="browser" id="browser" value="{filters_data.browser}" class="fo_text" style="width:99%;"></td>
	<td nowrap><input type="text" name="os" id="os" value="{filters_data.os}" class="fo_text" style="width:99%;"></td>

	<td nowrap><input type="text" name="referer_domain" id="referer_domain" value="{filters_data.referer_domain}" class="fo_text" style="width:99%;"></td>
	<td nowrap><input type="submit" name="country" value="  ok  " class="fo_submit" style="width:99%;"></td>
	<td nowrap>&nbsp;</td>
	<td nowrap>&nbsp;</td>
	<td nowrap>&nbsp;</td>
</tr>

<loop name="items">
<tr title="{items.user_agent}" class="tblcontent" id="row{items._INDEX}" onmouseover="javascript: change_row_color(overRowColor,{items._INDEX});" onmouseout="javascript: change_row_color(outRowColor,{items._INDEX});">
	
	<td>{items.ipaddress}</td>

	<td>{items.browser} {items.browser_version}</td>
	<td>{items.os}</td>

	<td><a href="{items.referer}" target="_blank" title="{items.referer}">{items.referer_domain}</a></td>
	<td><img src="images/countries/{items.country}.gif" border="0" alt="{items.country}"></td>
	<td>{items.visit_time}</td>
	<td>{items.past_time}</td>
	<td align="center">{items.page_count} <img src="images/path.gif" border="0" align="absmiddle" style="cursor:pointer;" onclick="javascript: openCenteredWindow('{config.admin_site_url}main.php?content=stat&module=stat&page=path&id={items.id}', 'path', 400,400,0,0);"></td>
	
</tr>
</loop name="items">
</table>
</form>




</block name="empty" no>

<block name="empty">
<center>
{phrases.stat.no_data}
</center>
</block name="empty">



</div>
