<call code="name=cart::set=var::module=orders::method=loadCart::params=">

<block name="cart.is_cart">
<div id="cart_sum">
{phrases.all_items} <b>{cart.is_cart}</b><br />
{phrases.all_sum} <b>{cart.sum} Lt</b>
</div>

<div class="orange">
	<a href="{lng}/{reserved_url_words.order}/"><em class="l"></em><b>{phrases.order_title}<span>{phrases.order_title}</span></b><em class="r"></em></a>
</div>
</block name="cart.is_cart">

<block name="cart.is_cart" no>
{phrases.empty_cart}
</block name="cart.is_cart" no>