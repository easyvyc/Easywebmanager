<script>

function private_company_toggle(val){
    if(val == 'private'){
        $('#submit_register .usertype_company :input[required]').attr('data-required', true).removeAttr('required');
        $('#submit_register .usertype_private :input[data-required]').attr('required', true).removeAttr('data-required');
        $('#submit_register .usertype_company').hide();
        $('#submit_register .usertype_private').show();
    }else{
        $('#submit_register .usertype_private :input[required]').attr('data-required', true).removeAttr('required');
        $('#submit_register .usertype_company :input[data-required]').attr('required', true).removeAttr('data-required');
        $('#submit_register .usertype_company').show();
        $('#submit_register .usertype_private').hide();
    }    
}    
    
$(document).ready(function(){

    if($('#submit_register [name=usertype]:checked').size() == 0){
        $('#submit_register [name=usertype][value=private]').prop('checked', true);
    }
    
    private_company_toggle($('#submit_register [name=usertype]:checked').val());
    
    $('#submit_register [name=usertype]').click(function(){
        private_company_toggle($(this).val());
    });

    $('#submit_register').submit(function(){
        if(validate_form($(this))){
            post_ajax_dialog('index.php?module=users&method=register&ajax=1', $(this).serialize());
        }else{
        
        }
        return false;
    });
    
    {block email_exists}
    alert('{phrases.email_exists}');
    $('#submit_register [name=email]').addClass('err');
    {-block email_exists}
    
});
    
</script>

<form id="submit_register" class="purchase" >

    <input type="hidden" name="action" value="register">
    
    <fieldset class="cart_user_row">
        <div class="t">{phrases.cart_user_type} <sup>*</sup></div>
        <div class="v">
            <label><input type="radio" name="usertype" value="private" required {block cart_user.usertype_private}checked{-block cart_user.usertype_private}> {phrases.usertype_private}</label>
            <label><input type="radio" name="usertype" value="company" required {block cart_user.usertype_company}checked{-block cart_user.usertype_company}> {phrases.usertype_company}</label>
        </div>
    </fieldset>

    <fieldset class="cart_user_row usertype_company">
        <div class="t">{phrases.cart_user_company} <sup>*</sup></div>
        <div class="v"><input type="text" name="company" value="{cart_user.company}" placeholder="{phrases.cart_user_company}" required></div>
    </fieldset>

    <fieldset class="cart_user_row usertype_company">
        <div class="t">{phrases.cart_user_company_code} <sup>*</sup></div>
        <div class="v"><input type="text" name="company_code" value="{cart_user.company_code}" placeholder="{phrases.cart_user_company_code}" required></div>
    </fieldset>

    <fieldset class="cart_user_row usertype_company">
        <div class="t">{phrases.cart_user_company_vat} </div>
        <div class="v"><input type="text" name="company_vat" value="{cart_user.company_vat}" placeholder="{phrases.cart_user_company_vat}" ></div>
    </fieldset>

    <fieldset class="cart_user_row usertype_company">
        <div class="t">{phrases.cart_user_city} <em>*</em></div>
        <div class="v"><input type="text" name="city_company" value="{cart_user.city}" placeholder="{phrases.cart_user_city}" required></div>
    </fieldset>

    <fieldset class="cart_user_row usertype_company">
        <div class="t">{phrases.cart_user_address} <em>*</em></div>
        <div class="v"><input type="text" name="address_company" value="{cart_user.address}" placeholder="{phrases.cart_user_address}" required></div>
    </fieldset>


    <fieldset class="cart_user_row">
        <div class="t">{phrases.cart_user_name} <sup>*</sup></div>
        <div class="v"><input type="text" name="title" value="{cart_user.title}" placeholder="{phrases.cart_user_name}" required></div>
    </fieldset>

    <fieldset class="cart_user_row">
        <div class="t">{phrases.cart_user_email} <sup>*</sup></div>
        <div class="v"><input type="email" name="email" value="{cart_user.email}" placeholder="{phrases.cart_user_email}" required></div>
    </fieldset>

    <fieldset class="cart_user_row">
        <div class="t">{phrases.cart_user_phone} <sup>*</sup></div>
        <div class="v"><input type="tel" name="phone" value="{cart_user.phone}" placeholder="{phrases.cart_user_phone}" required></div>
    </fieldset>

    <fieldset class="cart_user_row usertype_private">
        <div class="t">{phrases.cart_user_city} <em>*</em></div>
        <div class="v"><input type="text" name="city" value="{cart_user.city}" placeholder="{phrases.cart_user_city}" required></div>
    </fieldset>

    <fieldset class="cart_user_row usertype_private">
        <div class="t">{phrases.cart_user_address} <em></em></div>
        <div class="v"><input type="text" name="address" value="{cart_user.address}" placeholder="{phrases.cart_user_address}"></div>
    </fieldset>
    
    <fieldset>
        <div class="t">{phrases.reg_user_pswd} <em></em></div>
        <div class="v">
            <input type="password" name="pswd_1" placeholder="{phrases.reg_dialog_pswd1}" required>
            <input type="password" name="pswd_2" placeholder="{phrases.reg_dialog_pswd2}" data-valid-repeat="pswd_1" required>
        </div>
    </fieldset>

    <div class="submit">
        
        <input type="submit" value="{phrases.register_dialog_submit}" class="add2cart">
        
    </div>
        
    <div class="login">
        
        <a href="javascript: void(login());">{phrases.login}</a>
        
    </div>        
    
</form>