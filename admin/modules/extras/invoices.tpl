<table class="invoice" width="700" cellpadding="10" cellspacing="2" border="0">
	<tr class="h">
		<td width="50%">{phrases.proforma_title}</td>
		<td width="50%">{phrases.invoice_title}</td>
	</tr>
	<tr>
		<td>
			<p><a href="ajax.php?get=proforma&id={order_data.id}">{phrases.download_proforma} {order_data.invoice_number}</a></p>
			
			<p>
				<a href="javascript: show('proforma_send_form');">{phrases.send_proforma}</a>
				<block name="order_data.last_send_date">
				<em>({phrases.last_send}: {order_data.last_send_date})</em> 
				</block name="order_data.last_send_date">
			</p>
			
			<div id="proforma_send_form" class="send_form hide">
			<form name="proforma_send" action="javascript: void(PageClass.submitForm_('{config.site_admin_url}ajax.php?get={get.content}/actions&action=pdf&content={get.content}&module={get.module}&id={get.id}', 'EDIT_area__action', document.forms['proforma_send']));" method="post">
				<input type="hidden" name="action" value="proforma_send" />
				<fieldset>
					<em>{phrases.invoice_to_email}</em>
					<input type="text" class="fo_text" name="email" value="{order_data.email}" />
				</fieldset>
				<fieldset>
					<em>{phrases.invoice_to_subject}</em>
					<input type="text" class="fo_text" name="subject" value="Invoice {order_data.invoice_number}" />
				</fieldset>
				<fieldset>
					<em>{phrases.invoice_to_text}</em>
					<textarea name="text" class="fo_textarea"></textarea>
				</fieldset>
				<fieldset>
					<input type="submit" class="fo_submit" value=" ok " />
				</fieldset>	
				
			</form>
			</div>
			
		</td>
		<td>
			<block name="order_data.is_invoice">
			<p><a href="file.php?module=saskaitos&column=invoice&id={order_data.is_invoice}&lng={get.lng}" target="_blank">{phrases.download_invoice} {invoice_data.title}</a></p>
			
			<p>
				<a href="javascript: show('invoice_send_form');">{phrases.send_invoice}</a>
				<block name="invoice_data.last_send_date">
				<em>({phrases.last_send}: {invoice_data.last_send_date})</em> 
				</block name="invoice_data.last_send_date">
			</p>
			
			<div id="invoice_send_form" class="send_form hide">
			<form name="invoice_send" action="javascript: void(PageClass.submitForm_('{config.site_admin_url}ajax.php?get={get.content}/actions&action=pdf&content={get.content}&module={get.module}&id={get.id}', 'EDIT_area__action', document.forms['invoice_send']));" method="post">
				<input type="hidden" name="action" value="invoice_send" />
				<fieldset>
					<em>{phrases.invoice_to_email}</em>
					<input type="text" class="fo_text" name="email" value="{order_data.email}" />
				</fieldset>
				<fieldset>
					<em>{phrases.invoice_to_subject}</em>
					<input type="text" class="fo_text" name="subject" value="Invoice {invoice_data.title}" />
				</fieldset>
				<fieldset>
					<em>{phrases.invoice_to_text}</em>
					<textarea name="text" class="fo_textarea"></textarea>
				</fieldset>
				<fieldset>
					<input type="submit" class="fo_submit" value=" ok " />
				</fieldset>	
				
			</form>
			</div>
			
			</block name="order_data.is_invoice">
			
			<block name="order_data.is_invoice" no>
			{phrases.invoice_not_exist}
			<p><a href="javascript: void(PageClass.getPageContent_action('{config.site_admin_url}ajax.php?get={get.content}/actions&action=pdf&content={get.content}&module={get.module}&id={get.id}&generate=1', 'EDIT_area__action', 'pdf'));">{phrases.generate_invoice}</a></p>
			</block name="order_data.is_invoice" no>
			
		</td>
	</tr>
</table>	