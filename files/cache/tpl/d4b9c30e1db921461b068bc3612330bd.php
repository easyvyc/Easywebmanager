<script type="text/javascript">
function login(){
	$obj = $('#login_form form');
	$.ajax({
		  type: "POST",
		  async: true,
		  url: "<?php echo TPL::getVar("config.admin_url"); ?>?action=login&module=admins&method=login&ajax=1",
		  cache: false,
		  data: $($obj).serialize(),
		  dataType: "json",
		  beforeSend: function(){
			  $('#login_form input').attr('disabled', true);
			  $('#login_form .message').removeClass('error');
			  $('#login_form .message').html("<img src='<?php echo TPL::getVar("config.admin_dir"); ?>images/loading_watch.gif' alt='' > <?php echo TPL::getVar("phrases.login.loading"); ?>");
		  },
		  success: function(json){
			  $('#login_form input').attr('disabled', false);
			  if(json.loged){
				<?php if(TPL::getVar("get.ajax")){ ?>
				$("#_LOGIN_").fadeOut(1000);
				loading_end();
				<?php } ?>
				<?php if(!TPL::getVar("get.ajax")){ ?>
				location = '<?php echo TPL::getVar("config.admin_url"); ?>';
				<?php } ?>
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
	<?php if(TPL::getVar("get.ajax")){ ?>
	$("#_LOGIN_").fadeIn(1000);
	<?php } ?>
});

</script>

<div class="block" id="login_form">
	<form method="post" action="javascript: void(login());">
	  	
	  	<p class="admin_session_timeout"><?php echo TPL::getVar("phrases.login.session_timeout"); ?></p>
	  	
		<p class="message center">
			<?php if(TPL::getVar("get.code")){ ?>
			<?php if(cms::getInstance()->registry->model->admins->checkConfirmation($_GET['id'], $_GET['code'])){ ?>
			<?php cms::getInstance()->registry->model->admins->sendLoginData($_GET['id']); ?>
			<?php echo TPL::getVar("phrases.login.login_data_sent"); ?>
			<?php }else{ ?>
			<?php echo TPL::getVar("phrases.login.wrong_confirm_code"); ?>
			<?php } ?>
			<?php } ?>
		</p>
		
		<?php if(TPL::getVar("sites")){ ?>
			<div class="login_field">
				<select name="site" class="fo_select" style="width:100%;" onchange="javascript: location='<?php echo TPL::getVar("config.admin_url"); ?>?site='+this.options[this.selectedIndex].value;">
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