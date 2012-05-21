<call code="name=payments::set=var::module=orders::method=setPay::params=">

<h1>{phrases.order_title}</h1>

<div id="path">
<a href="{lng}/">{phrases.products_menu}</a>
&nbsp;&nbsp;»&nbsp;&nbsp;{phrases.order_title}
</div>											

<div id="order_steps">
	
	<call code="name=steps::set=loop::module=orders::method=loadSteps::params=">
	<loop name="steps">
	<div class="step<block name="steps.complited"> c</block name="steps.complited"><block name="steps.active"> a</block name="steps.active">">
		<div class="img png">{steps.num}</div>
		<p>{steps.title}</p>
	</div>
	</loop name="steps">

</div>										

	<form name="payment" action="{lng}/order/step/{get.step}/" method="post">
	<call code="name=payments::set=loop::module=payments::method=listPayments::params=0">
	<loop name="payments">
	<block name="payments.is_sub">
	<div class="pay_type">{payments.title}</div>
	<loop name="payments.sub">
	<div class="pay">
	<input type="radio" name="payment" value="{payments.sub.id}" id="id_{payments.sub.id}" class="fo_radio vam" <block name="payments.sub.selected">checked</block name="payments.sub.selected"> /><br /> 
	<block name="no">
	<img src="{upload_url}thumb_{payments.sub.image}" alt="" onclick="javascript: $('#id_{payments.sub.id}').attr('checked', true);" />
	</block name="no">
	<label for="id_{payments.sub.id}">{payments.sub.title}</label>
	{payments.sub.short_description}
	</div>
	</loop name="payments.sub">
	</block name="payments.is_sub">
	</loop name="payments">
	</form>

	<div class="clear"></div>
	
	
	<div id="payment_select_error">{phrases.please_select_payment}</div>
	


<form name="cart" action="{lng}/order/step/{get.step}/" method="post">
<table class="order_next">
	<tr>
		<td>

<input type="button" onclick="javascript: location='{config.site_url}{lng}/order/step/shipping/';" value="{phrases.order_prev_step}" class="btn" />

		</td>
		<td align="right">
	
<input type="button" onclick="if($('input:checked').val()) document.forms['payment'].submit(); else $('#payment_select_error').show(500);" value="{phrases.order_next_step}" class="btn" />
		
		</td>
	</tr>
</table>
</form>