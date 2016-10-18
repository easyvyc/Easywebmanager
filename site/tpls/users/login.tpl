<script>
 
$(document).ready(function(){
    $('#submit_login').submit(function(){
        if(validate_form($(this))){
            post_ajax_dialog('index.php?module=users&method=login&ajax=1', $(this).serialize());
        }else{
        
        }
        return false;
    });
    
    {block login_wrong}
    alert('{phrases.login_wrong}');
    $('[name=email]').addClass('err');
    $('[name=password]').addClass('err');
    {-block login_wrong}
    
});
    
</script>


<form class="purchase" id="submit_login">

    <input type="hidden" name="action" value="login">
    
    <fieldset>
        <input type="email" name="email" placeholder="{phrases.login_dialog_email}" required>
    </fieldset>

    <fieldset>
        <input type="password" name="password" placeholder="{phrases.login_dialog_password}" required style="width:400px;">
    </fieldset>

    <div class="submit">
        
        <input type="submit" value="{phrases.login_dialog_submit}" class="add2cart">
        
    </div>
        
    <div class="login">
        
        <a href="javascript: void(forget());">{phrases.login_dialog_forget_password}</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript: void(register());">{phrases.login_dialog_register}</a>
        
    </div>        
    
</form>