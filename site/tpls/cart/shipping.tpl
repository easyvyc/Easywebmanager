<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">

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

<div id="order_user_login_step">

	<div class="shippingblock">
		
		<h3>{phrases.user_shipping_form_title}</h3>
		
		<call code="name=form_::set=var::module=orders::method=loadOrderForm_shipping::params=">
		{form_}
	
	</div>
	
	<div class="clear"></div>

</div>




<form name="cart" action="{lng}/order/step/{get.step}/" method="post">
<table class="order_next">
	<tr>
		<td>

<input type="button" onclick="javascript: location='{config.site_url}{lng}/order/step/user/';" value="{phrases.order_prev_step}" class="btn" />

		</td>
		<td align="right">

<input type="button" onclick="javascript: document.forms['shipping'].submit();" value="{phrases.order_next_step}" class="btn" />
		
		</td>
	</tr>
</table>
</form>