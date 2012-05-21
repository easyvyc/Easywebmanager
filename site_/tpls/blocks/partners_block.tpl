<block name="get.forget" no>
<div>
<form name="login_{get.prefix}" action="javascript: void(post('{config.site_url}ajax.php?content=login&lng={lng}&target={get.target}&prefix={get.prefix}', '{get.target}', document.forms['login_{get.prefix}']));">
	
	<input type="hidden" name="action" value="login" />
	
	<block name="bad_login">
	<p class="error_message" >{phrases.wrong_login}</p>
	</block name="bad_login">
	
	<table border="0" cellpadding="5" cellspacing="0" class="form1" width="200">
		<tr>
			<td>
	<input type="text" name="email" class="vam fo_text radius3" style="width:180px;" value="{phrases.email_field}"  onfocus="if(this.value=='{phrases.email_field}'){this.value=''}" onblur="if(this.value==''){this.value='{phrases.email_field}'}" />
			</td>
		</tr>
		<tr>
			<td>
	<input type="password" name="password" class="vam fo_text radius3" style="width:180px;" value="password" onfocus="if(this.value=='password'){this.value=''}" onblur="if(this.value==''){this.value='password'}" />
			</td>
		</tr>
		<tr>
			<td align="right">
			
				<input type="submit" value="{phrases.login_submit}" class="btn" />

			</td>
		</tr>
	</table>

</form>	
</div>


<block name="loged_user.id">
<block name="reload">
<script type="text/javascript">
location.reload();
</script>
</block name="reload">
</block name="loged_user.id">

</block name="get.forget" no>


<block name="get.forget">
<block name="remind_ok" no>
<form name="forget" action="javascript: void(post('{config.site_url}ajax.php?content=login&forget=1&lng={lng}&target={get.target}', '{get.target}', document.forms['forget']));">
	
	<input type="hidden" name="action" value="forget" />
	
	<block name="bad_email">
	<p class="error_message">{phrases.wrong_email}</p>
	</block name="bad_email">
	
	<table border="0" cellpadding="5" cellspacing="0" class="form1" width="200">
		<tr>
			<td width="175" >
	<input type="text" name="email" class="vam fo_text radius3" style="width:180px;" value="{phrases.email_field}" onfocus="if(this.value=='{phrases.email_field}'){this.value=''}" onblur="if(this.value==''){this.value='{phrases.email_field}'}" />
			</td>
		</tr>
		<tr>
			<td align="right">
			
			<input type="submit" value="{phrases.submit_forget}" class="btn" />
			
			</td>
		</tr>
	</table>

<a href="javascript: void($.ajax({ type:'GET', url:'ajax.php?content=login&lng={lng}&target=order_user', beforeSend: function(){ $('#order_user').html('<img src=images/loading.gif />'); }, success:function(html){ $('#order_user').html(html);} }));">{phrases.login}</a>
	
</form>	
</block name="remind_ok" no>

<block name="remind_ok">
<p align="center">{phrases.forget_email_ok}</p>
</block name="remind_ok">

</block name="get.forget">
