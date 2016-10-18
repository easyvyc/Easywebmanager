<table id="order_steps" align="center">
        <tr>
	{loop steps}
	<td class="step step_{steps._INDEX}{block steps.complited}_a{-block steps.complited}{block steps.active} a{-block steps.active}">
		<span class="img">{steps._INDEX}</span> {steps.title}
	</td>
	{-loop steps}
        </tr>
</table>