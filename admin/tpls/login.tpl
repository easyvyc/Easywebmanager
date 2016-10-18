<!DOCTYPE html> 
<html>
<head>
<title>easywebmanager {easyweb_version}</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta http-equiv="pragma" content="no-cache" >


<meta name="GOOGLEBOT" content="noindex,nofollow" >
<meta name="ROBOTS" content="noindex,nofollow" >
<meta name="GENERATOR" content="easywebmanager" >

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >

<style type="text/css">
{css}
</style>

<script type="text/javascript" src="{config.admin_dir}js/jquery.js"></script>

</head>

<script type="text/javascript">
if(self!=top){
	top.location.href = self.location.href;
}

function show(block){
	$('.login a').removeClass('a');
	$('.block').removeClass('show');

	$('#'+block+'_link').addClass('a');
	$('#'+block+'_form').addClass('show');
}

$(document).ready(function(){

	{block get.remind}
	show('login');
	{-block get.remind}
	{block get.remind no}
	show('login');
	{-block get.remind no}

	
});

function remind(){
	$obj = $('#remind_form form');
	$.ajax({
		  type: "POST",
		  async: true,
		  url: "{config.admin_url}?action=login&module=admins&method=remind&ajax=1",
		  cache: false,
		  data: $($obj).serialize(),
		  dataType: "json",
		  beforeSend: function(){
			  $('#remind_form input').attr('disabled', true);
			  $('#remind_form .message').removeClass('error');
			  $('#remind_form .message').html("<img src='{config.admin_dir}images/loading_watch.gif' alt='' > {phrases.login.loading}");
		  },
		  success: function(json){
			  $('#remind_form input').attr('disabled', false);
			  if(json.remind){
				$('#remind_form .message').removeClass('error');
			  }else{
				$('#remind_form .message').addClass('error');
			  }
			  $('#remind_form .message').html(json.message);
		  },
		  complete: function(html){
		    
		  }
	});
}

</script>

<body>

	<div id="gradient">
		  
	<div id="container">

		<div id="logo">
	  		<a href="http://www.easywebmanager.com" target="_blank"><img src="{config.admin_dir}images/logo.png" border="0" alt="" ></a>
		</div>

	
		<div class="login">
		  	<a href="javascript: void(show('login'));" id="login_link"><img src="{config.admin_dir}images/lock.gif" border="0" alt="" > {phrases.login.login}</a>
		  	<a href="javascript: void(show('remind'));" id="remind_link"><img src="{config.admin_dir}images/lock.gif" border="0" alt="" > {phrases.login.password_remind}</a>
		</div>
		
			<fieldset class="radius10">

			
			{login_form_content}
			 
			 <div class="block" id="remind_form">


			  <form method="post" action="javascript: void(remind());">
			  
			  	<p class="message center"></p>
			  		
				  <input type="hidden" name="action" value="remind">

					<div class="login_field">
						<input type="email" placeholder="{phrases.login.email}" name="email"  class="fo_text radius5" style="width:210px;margin-right:5px;">
						<input type="submit" name="submit" value="{phrases.login.remind_submit} »" class="fo_submit radius5" style="width:80px;">
					</div>
			  			
			  </form>
			 
			 </div>
			 

			  </fieldset>

			<div class="lang">	
				<a href="admin.php?lang=lt" {block lng_lt}class="a"{-block lng_lt}>LT</a>
				<a href="admin.php?lang=en" {block lng_lt no}class="a"{-block lng_lt no}>EN</a>
			</div>
			
		</div>
		
	</div>
			
</body>
</html>