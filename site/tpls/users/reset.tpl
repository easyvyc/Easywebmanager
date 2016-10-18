<script>
 
$(document).ready(function(){
    $('#submit_reset').submit(function(){
        if(validate_form($(this))){
            post_ajax_dialog('index.php?module=users&method=reset&code={reset_user_data.confirm_code}&ajax=1', $(this).serialize());
        }else{
        
        }
        return false;
    });
});
    
</script>


<form class="purchase" id="submit_reset">

    <input type="hidden" name="action" value="reset">
    
    <fieldset>
        <input type="email" name="email" value="{reset_user_data.email}" disabled>
    </fieldset>
    
    <fieldset>
        <input type="password" name="pswd_1" placeholder="{phrases.reg_dialog_pswd1}" data-valid-repeat="pswd_2" required>
    </div>

    <fieldset>
        <input type="password" name="pswd_2" placeholder="{phrases.reg_dialog_pswd2}" data-valid-repeat="pswd_1" required>
    </fieldset>    

    <div class="submit">
        
        <input type="submit" value="{phrases.reset_dialog_submit}" class="add2cart">
        
    </div>
        
    <div class="login">
        
        <a href="javascript: void(login());">{phrases.login}</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript: void(register());">{phrases.login_dialog_register}</a>
        
    </div>        
    
</form>