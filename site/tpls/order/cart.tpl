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
	<td width="120">
		<input type="text" name="kiekis_{cart_items.id_mod_x}" id="kiekis_{cart_items.id_mod_x}" value="{cart_items.kiekis}" class="fo_text vam radius3" style="width:50px;text-align:center;" />
		<a href="javascript: void(add2cart('{config.site_url}ajax.php?content=cart&add={cart_items.id_mod}&ajax=1&order=1&kiekis='+$('#kiekis_{cart_items.id_mod_x}').val(), 'center', addSuccess_order));">{phrases.perskaiciuoti}</a>
	</td>
	<td width="80" class="price">
		<b>{cart_items.price} Lt</b>
	</td>
	<td width="80" align="right">
		<a href="javascript: void(add2cart('{config.site_url}ajax.php?content=cart&remove={cart_items.id_mod}&ajax=1&order=1', 'center', addSuccess_order));">{phrases.remove}</a>
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
	<td width="120">
		<input type="text" value="{cart_items.sub.kiekis}" readonly disabled class="fo_text vam radius3" style="width:50px;text-align:center;" />
	</td>
	<td width="80" class="price">
		<b>{cart_items.sub.price} Lt</b>
	</td>
	<td >
		
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

<form name="cart" action="{lng}/order/step/{get.step}/" method="post">
<input type="hidden" name="step" value="user" />
<table class="order_next">
	<tr>
		<td align="right">
		
{phrases.order_next_step_title} 		
		
<input type="submit" value="{phrases.order_next_step}" class="btn" />

		</td>
	</tr>
</table>
</form>

</block name="cart.is_cart">

<block name="cart.is_cart" no>
{phrases.empty_cart}
</block name="cart.is_cart" no>	