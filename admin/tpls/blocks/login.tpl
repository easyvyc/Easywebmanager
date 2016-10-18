<script type="text/javascript">
function login(){
	$obj = $('#login_form form');
	$.ajax({
		  type: "POST",
		  async: true,
		  url: "{config.admin_url}?action=login&module=admins&method=login&ajax=1",
		  cache: false,
		  data: $($obj).serialize(),
		  dataType: "json",
		  beforeSend: function(){
			  $('#login_form input').attr('disabled', true);
			  $('#login_form .message').removeClass('error');
			  $('#login_form .message').html("<img src='{config.admin_dir}images/loading_watch.gif' alt='' > {phrases.login.loading}");
		  },
		  success: function(json){
			  $('#login_form input').attr('disabled', false);
			  if(json.loged){
				{block get.ajax}
				$("#_LOGIN_").fadeOut(1000);
				loading_end();
				{-block get.ajax}
				{block get.ajax no}
				location = '{config.admin_url}';
				{-block get.ajax no}
			  }else{
				$('#login_form .message').addClass('error');
			  	$('#login_form .message').html(json.message);
			  }
		  },
		  complete: function(html){
		    
		  }
	});
}

$(document).ready(function(){
	{block get.ajax}
	$("#_LOGIN_").fadeIn(1000);
	{-block get.ajax}
});

</script>

<div class="block" id="login_form">
	<form method="post" action="javascript: void(login());">
	  	
	  	<p class="admin_session_timeout">{phrases.login.session_timeout}</p>
	  	
		<p class="message center">
			{block get.code}
			<?php if(cms::getInstance()->registry->model->admins->checkConfirmation($_GET['id'], $_GET['code'])){ ?>
			<?php cms::getInstance()->registry->model->admins->sendLoginData($_GET['id']); ?>
			{phrases.login.login_data_sent}
			<?php }else{ ?>
			{phrases.login.wrong_confirm_code}
			<?php } ?>
			{-block get.code}
		</p>
		
		{block sites}
			<div class="login_field">
				<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='{config.admin_url}?site='+this.options[this.selectedIndex].value;">
				<loop name="sites">
				<option value="{sites._INDEX}" {block sites.selected}selected{-block sites.selected}>{sites.title}</option>
				</loop name="sites">
				</select>
			</div>
		{-block sites}
		  
		<div class="login_field">
			<input type="text" placeholder="{phrases.login.login_name}" {block post.login}value="{post.login}"{-block post.login} name="login"  class="fo_text radius5">
		</div>
		<div class="login_field">
			<input type="password" placeholder="{phrases.login.password}" name="pass"  class="fo_text radius5" style="width:210px;margin-right:5px;">
			<input type="submit" name="submit" value="{phrases.login.submit} »" class="fo_submit radius5" style="width:80px;">
		</div>
		<input type="hidden" name="action" value="login">
	</form>
</div>