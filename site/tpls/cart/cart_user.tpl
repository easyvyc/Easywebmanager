<div class="block">

    <div class="cont">

        <div id="path" class="path">

            <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a> > <a href="{lng}/cart/user_info" title="{phrases.cart_user_info_title}">{phrases.cart_user_info_title}</a>

        </div>

        <div id="data_text">

{block cart_data.kiekis no}
<p class="warning">{phrases.cart_empty}</p>
{-block cart_data.kiekis no}
  
{block cart_data.kiekis}
    <form action="{lng}/cart/user_info/" method="post" id="cart_data_form">
        
        <input type="hidden" name="action" value="user">

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

        <fieldset class="cart_user_row">
            <div class="t">{phrases.cart_user_info} <em></em></div>
            <div class="v">
                <textarea name="info" placeholder="{phrases.cart_user_info}">{cart_user.info}</textarea>
            </div>
        </fieldset>
        
    </form>
                
    <p class="cart_navigation">
        <a href="javascript: void(cart_user_info_submit());" class="btn continue" title="{phrases.cart_next}">{phrases.cart_next} &raquo;</a>
        <a href="{lng}/cart/index"  class="btn prev_step" title="{phrases.prev_cart_step}">&laquo; {phrases.prev_cart_step}</a>
    </p>    
                
{-block cart_data.kiekis}    
    
	

<script>

$(document).ready(function(){
    
    if($('[name=usertype]:checked').size() == 0){
        $('[name=usertype][value=private]').prop('checked', true);
    }
    
    private_company_toggle($('[name=usertype]:checked').val());
    
    $('[name=usertype]').click(function(){
        private_company_toggle($(this).val());
    });

});

function private_company_toggle(val){
    if(val == 'private'){
        $('.usertype_company').hide();
        $('.usertype_private').show();
    }else{
        $('.usertype_company').show();
        $('.usertype_private').hide();
    }    
}

function cart_user_info_submit(){
    if(validate_form($('#cart_data_form'))){
        $('#cart_data_form').submit();
    }else{
    }
}
    
</script>

        </div>

    </div>

</div>