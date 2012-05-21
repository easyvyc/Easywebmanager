<script type="text/javascript">
function login(){
	$obj = $('#login_form form');
	$.ajax({
		  type: "POST",
		  async: true,
		  url: "admin.php?action=login&module=admins&method=login&ajax=1",
		  cache: false,
		  data: $($obj).serialize(),
		  dataType: "json",
		  beforeSend: function(){
			  $('#login_form input').attr('disabled', true);
			  $('#login_form .message').removeClass('error');
			  $('#login_form .message').html("<img src='images/loading.gif' alt='' > <?php echo TPL::getVar("phrases.login.loading"); ?>");
		  },
		  success: function(json){
			  $('#login_form input').attr('disabled', false);
			  if(json.loged){
				  location = 'admin.php';
			  }else{
				$('#login_form .message').addClass('error');
			  	$('#login_form .message').html(json.message);
			  }
		  },
		  complete: function(html){
		    
		  }
	});
}
</script>

<div class="block" id="login_form">
	<form method="post" action="javascript: void(login());">
	  	
		<p class="message center">
			<?php if(TPL::getVar("get.code")){ ?>
			<?php if(cms::getInstance()->registry->module->admins->checkConfirmation($_GET['id'], $_GET['code'])){ ?>
			<?php cms::getInstance()->registry->module->admins->sendLoginData($_GET['id']); ?>
			<?php echo TPL::getVar("phrases.login.login_data_sent"); ?>
			<?php }else{ ?>
			<?php echo TPL::getVar("phrases.login.wrong_confirm_code"); ?>
			<?php } ?>
			<?php } ?>
		</p>
		
		<?php if(TPL::getVar("sites")){ ?>
			<div class="login_field">
				<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='<?php echo TPL::getVar("config.admin_site_url"); ?>login.php?site='+this.options[this.selectedIndex].value;">
				<loop name="sites">
				<option value="<?php echo TPL::getVar("sites._INDEX"); ?>" <?php if(TPL::getVar("sites.selected")){ ?>selected<?php } ?>><?php echo TPL::getVar("sites.title"); ?></option>
				</loop name="sites">
				</select>
			</div>
		<?php } ?>
		  
		<div class="login_field">
			<input type="text" placeholder="<?php echo TPL::getVar("phrases.login.login_name"); ?>" <?php if(TPL::getVar("post.login")){ ?>value="<?php echo TPL::getVar("post.login"); ?>"<?php } ?> name="login"  class="fo_text radius5">
		</div>
		<div class="login_field">
			<input type="password" placeholder="<?php echo TPL::getVar("phrases.login.password"); ?>" name="pass"  class="fo_text radius5" style="width:210px;margin-right:5px;">
			<input type="submit" name="submit" value="<?php echo TPL::getVar("phrases.login.submit"); ?> »" class="fo_submit radius5" style="width:80px;">
		</div>
		<input type="hidden" name="action" value="login">
	</form>
</div>