<script>
 
$(document).ready(function(){
    $('#submit_forget').submit(function(){
        if(validate_form($(this))){
            post_ajax_dialog('index.php?module=users&method=forget&ajax=1', $(this).serialize());
        }else{
        
        }
        return false;
    });
    
    {block login_wrong}
    alert('{phrases.forget_wrong}');
    $('[name=email]').addClass('err');
    {-block login_wrong}
    
});
    
</script>


<form class="purchase" id="submit_forget">

    <input type="hidden" name="action" value="forget">
    
    <fieldset>
        <input type="email" name="email" placeholder="{phrases.login_dialog_email}" required>
    </fieldset>

    <div class="submit">
        
        <input type="submit" value="{phrases.forget_dialog_submit}" class="add2cart">
        
    </div>
        
    <div class="login">
        
        <a href="javascript: void(login());">{phrases.login_dialog_submit}</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript: void(register());">{phrases.login_dialog_register}</a>
        
    </div>        
    
</form>