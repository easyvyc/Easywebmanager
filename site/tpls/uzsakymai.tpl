<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">

<h1>{item_data.title}</h1>

<div id="path">
<loop name="id_path">
<block name="id_path.first" no>
&nbsp;&nbsp;»&nbsp;&nbsp;
</block name="id_path.first" no>
<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
</loop name="id_path">
</div>										

<call code="name=uzsakymai::set=loop::module=orders::method=listUserItems::params={{loged_user.id}},{{get.offset}}">
<call code="name=paging::set=loop::module=orders::method=pagingItems::params={{get.offset}},10">
<call code="name=is_paging::set=var::module=orders::method=is_pagingItems::params=">

<table class="uzsakymai" cellpadding="5" cellspacing="1" border="0" width="100%">
	<tr>
		<th>{phrases.order_date}</th>
		<th>{phrases.order_sum}</th>
		<!-- th>{phrases.order_info}</th-->
		<th>{phrases.order_items}</th>
		<th>{phrases.order_payed}</th>
		<th>{phrases.order_pdf_download}</th>
	</tr>
	
	<loop name="uzsakymai">
	<tr>
		<td>{uzsakymai.order_date}</td>
		<td align="right">{uzsakymai.order_sum}&nbsp;{currency.title}</td>
		<!-- td>{uzsakymai.order_info}</td -->
		<td>{uzsakymai.ordered_items}</td>
		<td>
			<block name="uzsakymai.payed">{phrases.order_apmoketa}</block name="uzsakymai.payed">
			<block name="uzsakymai.payed" no>{phrases.order_not_apmoketa}</block name="uzsakymai.payed" no>
		</td>
		<td align="center">
			<a href="ajax.php?content=call&module=orders&method=downloadOrderPdf&params[id]={uzsakymai.id}"><img src="images/save1.gif" alt="{phrases.saskaita_apmokejimui}" class="vam" /></a>
			<block name="uzsakymai.sf">
			<a href="ajax.php?content=call&module=orders&method=downloadOrderSF&params[id]={uzsakymai.sf}"><img src="images/save2.gif" alt="{phrases.saskaita_faktura}" class="vam" /></a>
			</block name="uzsakymai.sf">
		</td>
	</tr>
	</loop name="uzsakymai">
	
</table>


<block name="is_paging">
<div class="paging">
{phrases.paging}&nbsp;&nbsp;
<loop name="paging">
<a href="{lng}{page_data.page_url}offset/{paging.value}/" <block name="paging.active">class="a"</block name="paging.active">>{paging.title}</a>
</loop name="paging">
</div>
</block name="is_paging">