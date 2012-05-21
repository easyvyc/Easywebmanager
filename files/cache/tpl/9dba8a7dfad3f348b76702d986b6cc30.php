<!DOCTYPE html> 
<html>
<head>
<title>easywebmanager <?php echo TPL::getVar("easyweb_version"); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta http-equiv="pragma" content="no-cache" >


<meta name="GOOGLEBOT" content="noindex,nofollow" >
<meta name="ROBOTS" content="noindex,nofollow" >
<meta name="GENERATOR" content="easywebmanager" >

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >

<style type="text/css">
<?php echo TPL::getVar("css"); ?>
</style>

<script type="text/javascript" src="admin/js/jquery.js"></script>

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

	<?php if(TPL::getVar("get.remind")){ ?>
	show('login');
	<?php } ?>
	<?php if(!TPL::getVar("get.remind")){ ?>
	show('login');
	<?php } ?>

	
});

function remind(){
	$obj = $('#remind_form form');
	$.ajax({
		  type: "POST",
		  async: true,
		  url: "admin.php?action=login&module=admins&method=remind&ajax=1",
		  cache: false,
		  data: $($obj).serialize(),
		  dataType: "json",
		  beforeSend: function(){
			  $('#remind_form input').attr('disabled', true);
			  $('#remind_form .message').removeClass('error');
			  $('#remind_form .message').html("<img src='images/loading.gif' alt='' > <?php echo TPL::getVar("phrases.login.loading"); ?>");
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
	  		<a href="http://www.easywebmanager.com" target="_blank"><img src="admin/images/logo.png" border="0" alt="" ></a>
		</div>

	
		<div class="login">
		  	<a href="javascript: void(show('login'));" id="login_link"><img src="admin/images/lock.gif" border="0" alt="" > <?php echo TPL::getVar("phrases.login.login"); ?></a>
		  	<a href="javascript: void(show('remind'));" id="remind_link"><img src="admin/images/lock.gif" border="0" alt="" > <?php echo TPL::getVar("phrases.login.password_remind"); ?></a>
		</div>
		
			<fieldset class="radius10">

			
			<?php echo TPL::getVar("login_form_content"); ?>
			 
			 <div class="block" id="remind_form">


			  <form method="post" action="javascript: void(remind());">
			  
			  	<p class="message center"></p>
			  		
				  <input type="hidden" name="action" value="remind">

					<div class="login_field">
						<input type="email" placeholder="<?php echo TPL::getVar("phrases.login.email"); ?>" name="email"  class="fo_text radius5" style="width:210px;margin-right:5px;">
						<input type="submit" name="submit" value="<?php echo TPL::getVar("phrases.login.remind_submit"); ?> »" class="fo_submit radius5" style="width:80px;">
					</div>
			  			
			  </form>
			 
			 </div>
			 

			  </fieldset>

			<div class="lang">	
				<a href="admin.php?lang=lt" <?php if(TPL::getVar("lng_lt")){ ?>class="a"<?php } ?>>LT</a>
				<a href="admin.php?lang=en" <?php if(!TPL::getVar("lng_lt")){ ?>class="a"<?php } ?>>EN</a>
			</div>
			
		</div>
		
	</div>
			
</body>
</html>