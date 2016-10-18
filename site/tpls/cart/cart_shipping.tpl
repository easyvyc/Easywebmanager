<div class="block">

    <div class="cont">

        <div id="path" class="path">


            <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a> > <a href="{lng}/cart/shipping_info" title="{phrases.cart_shipping_info_title}">{phrases.cart_shipping_info_title}</a>

        </div>

        <div id="data_text">

    
{block cart_data.kiekis no}
<p class="warning">{phrases.cart_empty}</p>
{-block cart_data.kiekis no}
  
{block cart_data.kiekis}
    <form action="{lng}/cart/shipping_info/" method="post" id="cart_data_form">
        
        <input type="hidden" name="action" value="shipping">

        <fieldset class="cart_user_row">
            <div class="t">{phrases.cart_shipping_type} <sup>*</sup></div>
            <div class="v">
                <label><input type="radio" name="shipping_type" value="by_self" required {block cart_shipping.shipping_type_by_self}checked{-block cart_shipping.shipping_type_by_self}> {phrases.shipping_type_by_self}</label>
                <label><input type="radio" name="shipping_type" value="by_address" required {block cart_shipping.shipping_type_by_address}checked{-block cart_shipping.shipping_type_by_address}> {phrases.shipping_type_by_address}</label>
            </div>
        </fieldset>
        
        <fieldset class="cart_user_row shipping_type_by_address">
            <div class="t">{phrases.cart_shipping_city} <sup>*</sup></div>
            <div class="v"><input type="text" name="city" value="{cart_shipping.city}" placeholder="{phrases.cart_shipping_city}" required></div>
        </fieldset>

        <fieldset class="cart_user_row shipping_type_by_address">
            <div class="t">{phrases.cart_shipping_address} <sup>*</sup></div>
            <div class="v"><input type="text" name="address" value="{cart_shipping.address}" placeholder="{phrases.cart_shipping_address}" required></div>
        </fieldset>

        <fieldset class="cart_user_row">
            <div class="t">{phrases.cart_shipping_info} <em></em></div>
            <div class="v">
                <textarea name="info" placeholder="{phrases.cart_shipping_info}">{cart_shipping.info}</textarea>
            </div>
        </fieldset>
            
        <fieldset class="cart_user_row">
            <div class="t">{phrases.cart_shipping_price}</div>
            <div class="v"><input type="text" name="price" value="{cart_shipping.price} {currency.title}" disabled readonly></div>
        </fieldset>
        
        
    </form>
                
    <p class="cart_navigation">
        <a href="javascript: void(cart_shipping_submit());" class="btn continue" title="{phrases.cart_next}">{phrases.cart_next} &raquo;</a>
        <a href="{lng}/cart/user_info"  class="btn prev_step" title="{phrases.prev_cart_step}">&laquo; {phrases.prev_cart_step}</a>
    </p>    
                
{-block cart_data.kiekis}    
    

<script>

$(document).ready(function(){
    
    if($('[name=shipping_type]:checked').size() == 0){
        $('[name=shipping_type][value=by_self]').prop('checked', true);
    }
    
    shipping_type_toggle($('[name=shipping_type]:checked').val());
    
    $('[name=shipping_type]').click(function(){
        shipping_type_toggle($(this).val());
    });

});

function shipping_type_toggle(val){
    if(val == 'by_self'){
        $('.shipping_type_by_address').hide();
        $('.shipping_type_by_self').show();
        $('[name=price]').val('{cart_shipping.shipping_price_by_self} {currency.title}');
    }else{
        $('.shipping_type_by_address').show();
        $('.shipping_type_by_self').hide();
        $('[name=price]').val('{cart_shipping.shipping_price_by_address} {currency.title}');
    }    
}

function cart_shipping_submit(){
    if(validate_form($('#cart_data_form'))){
        $('#cart_data_form').submit();
    }else{
    }
}
    
</script>
        </div>

    </div>

</div>