<table style="margin:5px;border-collapse:collapse;" border="1" bordercolor="#AAA" cellpadding="3">
{loop stat_visitors_path}
<tr>
    <td>{stat_visitors_path.url}</td>
    <td>{stat_visitors_path.visit_time}</td>
</tr>
{-loop stat_visitors_path}
</table>