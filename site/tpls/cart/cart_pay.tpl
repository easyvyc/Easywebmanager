<div id="columns" class="container">
<div class="row">  
<div class="loader_page"> 
                 			                                             			                                                          
<div id="center_column" class="center_column span12 clearfix">
 
<!-- Breadcrumb -->
<div class="ps_breadcrumb">
<div class="ps_breadcrumb_inset">
    
	<a class="breadcrumb-home" href="{lng}/" title=""><i class="icon-home"></i></a>
        <span class="navigation-pipe" >&gt;</span>
	<span class="navigation_page">{phrases.cart_pay_info_title}</span>
        
</div>
</div>
<!-- /Breadcrumb -->

<!-- Steps -->
<ul id="order_steps" class="step1" style="display:none">
    <li class="step_todo">
        <span><span>01</span> Summary</span>
    </li>
    <li class="step_todo">
        <span><span>02</span> Login</span>
    </li>
    <li id="step_end" class="step_todo">
        <span><span>03</span> Payment</span>
    </li>
</ul>
<!-- /Steps -->


<h1>{phrases.cart_pay_info_title}</h1>


<div id="data_text" class="cont">

{block cart_data.kiekis}
    
    <form action="{lng}/cart/pay_info/" method="post" style="width:50%;" id="cart_data_form">
        
        <input type="hidden" name="action" value="pay">
        
        <fieldset class="cart_user_row">
            <div class="t">{phrases.cart_pay_select} <sup>*</sup></div>
            <div class="v">
                
                {loop payments}
                <div style="margin:5px;">
                    <input type="radio" name="pay" id="pay_{payments.id}" value="{payments.id}" style="vertical-align:top" required > <label for="pay_{payments.id}">{payments.title}</label>
                    <p class="small">{payments.code}</p>
                </div>
                {-loop payments}
                
                {block cart_pay.pay}
                <script> $(document).ready(function(){ $('input:radio[name="pay"]').filter('[value={cart_pay.pay}]').prop('checked', true); }); </script>
                {-block cart_pay.pay}
                
            </div>
        </fieldset>

        <fieldset class="cart_user_row">
            <div class="t">{phrases.cart_pay_info} <em></em></div>
            <div class="v">
                <textarea name="info" placeholder="{phrases.cart_pay_info}">{cart_pay.info}</textarea>
            </div>
        </fieldset>
        
    </form>
    
    <p class="cart_navigation  clearfix inner-top">
        <a href="javascript: void(cart_user_info_submit());" class="exclusive standard-checkout" title="{phrases.cart_next}">{phrases.cart_next} &raquo;</a>
        <a href="{lng}/cart/pay_user" class="button_large" title="{phrases.prev_cart_step}">&laquo; {phrases.prev_cart_step}</a>
    </p>    
    
{-block cart_data.kiekis}
	
</div>
        
</div>
</div>
</div>
</div>
<script>

function cart_user_info_submit(){
    if(validate_form($('#cart_data_form'))){
        $('#cart_data_form').submit();
    }else{
    }
}
    
</script>