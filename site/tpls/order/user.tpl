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

	<div class="loginblock">
		
		<h3>{phrases.login_title}</h3>
		
		<block name="loged_user.id">
		<p>{phrases.user_loged}: {loged_user.firstname} {loged_user.lastname} ({loged_user.email})</p>
		<a href="javascript:void($.ajax({ type:'GET', url:'ajax.php?content=login&lng={lng}&target=order_user&prefix=o', success:function(html){ $('#order_user').html(html);} }))">{phrases.login_other_account}</a>
		</block name="loged_user.id">

		<div id="order_user"></div>

		<block name="loged_user.id" no>
		
		<script type="text/javascript">
		$.ajax({ type:'GET', url:'ajax.php?content=login&lng={lng}&target=order_user&prefix=o', success:function(html){ $('#order_user').html(html);} })
		</script>
		
		</block name="loged_user.id" no>
		
	</div>
	
	<div class="shippingblock">
		
		<h3>{phrases.user_info_form_title}</h3>
		
		<call code="name=form_::set=var::module=orders::method=loadOrderForm_user::params=">
		{form_}
	
	</div>
	
	<div class="clear"></div>

</div>




<form name="cart" action="{lng}/order/step/{get.step}/" method="post">
<table class="order_next">
	<tr>
		<td>

<input type="button" onclick="javascript: location='{config.site_url}{lng}/order/step/cart/';" value="{phrases.order_prev_step}" class="btn" />

		</td>
		<td align="right">

<input type="button" onclick="javascript: document.forms['register'].submit();" value="{phrases.order_next_step}" class="btn" />
		
		</td>
	</tr>
</table>
</form>