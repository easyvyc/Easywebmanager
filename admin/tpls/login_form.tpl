<h5>{phrases.session_timeout}</h5>
<block name="bad_login">
<div class="error" style="text-align:center">{phrases.wrong_login}&nbsp;</div>
</block name="bad_login">
  
<form method="post" name="login" action="javascript: void(top.content.PageClass.submitForm_('{config.admin_site_url}login.php?session_restart=1', 'SysMsg', document.forms['login'], 1));">
  		

<div class="title" align="left"><img src="images/lock.gif" border="0" style="float:left;margin-right:3px;"> {phrases.login}&nbsp;</div>
	  
	  <input type="hidden" name="action" value="login">
	  
<div>
	<input type="hidden" id="login_" value="0" />
	<input type="text" value="{phrases.login_name}" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '{phrases.login_name}'); " name="login"  class="fo_text" style="width:200px;">
</div>
<div>
	<input type="hidden" id="pass_" value="0" />
	<input type="password" value="{phrases.password}" onfocus="javascript: inputFocus(this); " onblur="javascript: inputBlur(this, '{phrases.password}'); " name="pass"  class="fo_text" style="width:200px;">
</div>
<div><input type="submit" name="submit" value="{phrases.submit} »" class="fo_submit" style="width:70px;"></div>
</form>
<block name="login_ok">
<script type="text/javascript">
closeSystemMessage();
</script>
</block name="login_ok">