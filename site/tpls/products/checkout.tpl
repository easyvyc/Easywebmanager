<script>
 
$(document).ready(function(){
    $('#submit_checkout').submit(function(){
        if(validate_form($(this))){
            post_ajax_dialog('index.php?module=products&method=checkout&ajax=1', $(this).serialize());
        }else{
        
        }
        return false;
    });
});
    
</script>

<form id="submit_checkout" class="purchase" >

    <input type="hidden" name="action" value="checkout">
    
    <div class="input">
        <input type="text" name="title" placeholder="{phrases.buy_dialog_name}" value="{logged_user.title}" required>
    </div>

    <div class="input">
        <input type="email" name="email" placeholder="{phrases.buy_dialog_email}" value="{logged_user.email}" required>
    </div>

    <div class="input">
        <input type="tel" name="phone" placeholder="{phrases.buy_dialog_phone}" value="{logged_user.phone}" required>
    </div>
    
    <div class="input">
        <input type="text" name="address" placeholder="{phrases.buy_dialog_address}" value="{logged_user.address}" required>
    </div>

    <div class="input payment">
        
        <select name="payment" class="dd" style="width:460px;" required>
        
            {loop payments}
            <option value="{payments.id}" data-image="index.php?module=payments&method=show_image&column=image&id={payments.id}&w=100&h=50&t=landscape">{payments.title}</option>
            {-loop payments}
            
        </select>
        
        <script>
        $(document).ready(function(){
            $(".dd").msDropdown({roundedBorder:false});
        });
        </script>
        
    </div>

    <div class="submit">
        
        <input type="submit" value="{phrases.checkout_dialog_submit}">
        
    </div>
        
    {block logged_user.id no}
    <div class="login">
        
        <a href="javascript: void(login());">{phrases.checkout_dialog_login}</a>
        
    </div>
    {-block logged_user.id no}
    
</form>