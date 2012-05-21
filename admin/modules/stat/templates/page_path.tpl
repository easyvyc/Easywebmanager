<div style="margin:5px;margin-top:10px;">

	<table border="0" cellpadding="3" cellspacing="0">
		<tr>
			<td>{phrases.stat.ip_address_title}</td>
			<td>{visitor_data.ipaddress}</td>
		</tr>
		<tr>
			<td>{phrases.stat.referer_title}</td>
			<td>{visitor_data.referer_domain}</td>
		</tr>
		<tr>
			<td>{phrases.stat.country_title}</td>
			<td>{visitor_data.country}</td>
		</tr>
		<tr>
			<td>{phrases.stat.pages_count_title}</td>
			<td>{visitor_data.page_count}</td>
		</tr>
		<tr>
			<td>{phrases.stat.past_time_title}</td>
			<td>{visitor_data.past_time}</td>
		</tr>
	</table>
	
	<br /><br />
	
	<div>
	<loop name="path">
	{path.visit_time} » {path.url}<br />
	</loop name="path">
	</div>

</div>