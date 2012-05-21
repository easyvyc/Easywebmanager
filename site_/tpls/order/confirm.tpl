<call code="name=confirm_order::set=var::module=orders::method=confirmOrder::params=">

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
										

<call code="name=cart::set=var::module=orders::method=loadCart::params=">

<block name="cart.is_cart">
<call code="name=cart_items::set=loop::module=orders::method=listCartItems::params=">

<div class="confirm_header">{phrases.cart_confirm_title} <span class="confirm_change">[<a href="{url_prefix}/{reserved_url_words.order}/step/cart/">{phrases.change}</a>]</span></div>

<div class="confirm_content">
	<table width="100%" class="order_cart_items">
	<loop name="cart_items">
	<tr>
		<td width="100">
			<div class="img" style="background:url('{upload_url}thumb_{cart_items.image}') center center no-repeat;"></div>
		</td>
		<td>
			<b>{cart_items.title}</b><br />
			{cart_items.short_description}
		</td>
		<td width="80" class="price">
			<b>{cart_items.kiekis} x {cart_items.price} Lt</b>
		</td>
	</tr>

	<block name="cart_items.is_sub">
	<loop name="cart_items.sub">
	<tr class="sub">
		<td width="100">
			<div class="img" style="background:url('{upload_url}thumb_{cart_items.sub.image}') center center no-repeat;"></div>
		</td>
		<td>
			<b>{cart_items.sub.title}</b><br />
			{cart_items.sub.short_description}
		</td>
		<td width="80" class="price">
			<b>{cart_items.sub.kiekis} x {cart_items.sub.price} Lt</b>
		</td>
	</tr>
	</loop name="cart_items.sub">
	</block name="cart_items.is_sub">
	
	</loop name="cart_items">
	
	</table>
	
	<div id="order_cart_sum">
		<p>{phrases.all_sum_no_pvm} <b>{cart.sum_no_pvm} Lt</b></p>
		<p>{phrases.all_sum_pvm} <b>{cart.pvm} Lt</b></p>
		<p>{phrases.all_sum} <b>{cart.sum} Lt</b></p>
	</div>
</div>

<div class="confirm_header">{phrases.user_confirm_title} <span class="confirm_change">[<a href="{url_prefix}/{reserved_url_words.order}/step/user/">{phrases.change}</a>]</span></div>

<div class="confirm_content">
	<table width="100%">
	<call code="name=user_info::set=loop::module=orders::method=getUserInfo::params=">
	<loop name="user_info">
	<tr>
		<td width="150">{user_info.title}</td>
		<td>{user_info.value}</td>
	</tr>
	</loop name="user_info">
	</table>
</div>

<div class="confirm_header">{phrases.user_shipping_form_title} <span class="confirm_change">[<a href="{url_prefix}/{reserved_url_words.order}/step/shipping/">{phrases.change}</a>]</span></div>

<div class="confirm_content">
	<table width="100%">
	<call code="name=shipping_info::set=loop::module=orders::method=getShippingInfo::params=">
	<loop name="shipping_info">
	<tr>
		<td width="150">{shipping_info.title}</td>
		<td>{shipping_info.value}</td>
	</tr>
	</loop name="shipping_info">
	</table>
</div>

<div class="confirm_header">{phrases.pay_confirm_title} <span class="confirm_change">[<a href="{url_prefix}/{reserved_url_words.order}/step/pay/">{phrases.change}</a>]</span></div>

<div class="confirm_content">
	<call code="name=pay_info::set=var::module=orders::method=getPayInfo::params=">
	{pay_info.title}
</div>

</block name="cart.is_cart">

<block name="cart.is_cart" no>
{phrases.empty_cart}
</block name="cart.is_cart" no>	


<form name="confirm" action="{config.site_url}{lng}/order/step/confirm/" method="post">
<input type="hidden" name="action" value="confirm" />
<table class="order_next">
	<tr>
		<td>

<input type="button" onclick="javascript: location='{config.site_url}{lng}/order/step/pay/'" value="{phrases.order_prev_step}" class="btn" />

		</td>
		<td align="right">
	
<input type="submit" value="{phrases.order_last_step}" class="btn" />
		
		</td>
	</tr>
</table>
</form>