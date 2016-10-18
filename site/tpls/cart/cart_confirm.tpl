<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a>
        
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        {phrases.order_step_confirm}
        
    </nav>
    
    
</div>    

<div id="inner_content" class="overflow rel">

    {steps_html}
    
        
{block cart_data.kiekis no}
<p class="warning">{phrases.cart_empty}</p>
{-block cart_data.kiekis no}
  
{block cart_data.kiekis}
    
    <div class="confirm_header">{phrases.cart_title} <span class="confirm_change">[<a href="{lng}/cart/index">{phrases.change}</a>]</span></div>

    <div class="confirm_content">

    <table width="100%" class="order_cart_items">
        
        <tr>
            <th>{phrases.cart_preke_title}</th>
            <th></th>
            <th>{phrases.cart_preke_kaina}</th>
            <th>{phrases.cart_preke_kiekis}</th>
            <th>{phrases.cart_preke_viso}</th>
        </tr>
        
        {loop cart_items}
        <tr>
                <td width="220">
                        <div class="img" style="background:url('{config.site_url}index.php?module=products_images&method=show_image&column=image&id={cart_items.image_id}&w=200&h=140&t=auto') center center no-repeat;"></div>
                </td>
                <td class="desc">

                    <b>{cart_items.title}</b>

                    <p>{cart_items.short_description}</p>
                    
                    {block cart_items.id_mod_arr} 
                    <p>{loop cart_items.id_mod_arr}{cart_items.id_mod_arr.group_title}: {cart_items.id_mod_arr.title}<br />{-loop cart_items.id_mod_arr}</p>
                    {-block cart_items.id_mod_arr}
                    
                    
                </td>
                <td width="70" class="price">
                    {cart_items.price} {currency.title}
                </td>
                <td width="70">
                    {cart_items.kiekis}
                </td>
                <td width="70" class="price">
                    {cart_items.price_sum} {currency.title}
                </td>
        </tr>
        {-loop cart_items}
    
    </table>

    <table class="order_cart_sum" align="right">

        {block cart.sum_shipping}
        <tr>
            <td class="t">{phrases.all_sum_pristatymas}</td>
            <td class="v">{cart_data.sum_shipping} {currency.title}</td>
        </tr>
        {-block cart.sum_shipping}

        <tr>
            <td class="t">{phrases.all_sum_no_pvm}</td>
            <td class="v">{cart_data.allsum_no_pvm} {currency.title}</td>
        </tr>
        <tr>
            <td class="t">{phrases.all_sum_pvm}</td>
            <td class="v">{cart_data.pvm} {currency.title}</td>
        </tr>
        
        {block cart_data.discount_is}
        <tr>
            <td class="t">{phrases.discount_sum}</td>
            <td class="v">{cart_data.discount_sum} {currency.title}</td>
        </tr>
        {-block cart_data.discount_is}
        
        <tr class="allsum">
            <td class="t">{phrases.all_sum}</td>
            <td class="v">{cart_data.allsum} {currency.title}</td>
        </tr>
    </table>

    <div class="clear"></div>
        
    <div class="confirm_header">{phrases.order_step_shipping_info} <span class="confirm_change">[<a href="{lng}/cart/shipping_info">{phrases.change}</a>]</span></div>

    <div class="confirm_content">
        <table width="100%" class="tbl">
            
            {block cart_shipping.shipping_type_by_self}
            <tr>
                <td width="150">{phrases.shipping_type}</td>
                <td>{phrases.shipping_type_by_self}</td>
            </tr>
            <tr>
                <td>{phrases.cart_shipping_place}</td>
                <td>{cart_shipping.place_data.title}</td>
            </tr>
            <tr>
                <td>{phrases.cart_shipping_info}</td>
                <td>{cart_shipping.info}</td>
            </tr>
            {-block cart_shipping.shipping_type_by_self}
            

            {block cart_shipping.shipping_type_by_address}
            <tr>
                <td width="150">{phrases.shipping_type}</td>
                <td>{phrases.shipping_type_by_address}</td>
            </tr>
            <tr>
                <td>{phrases.cart_shipping_city}</td>
                <td>{cart_shipping.city}</td>
            </tr>
            <tr>
                <td>{phrases.cart_shipping_address}</td>
                <td>{cart_shipping.address}</td>
            </tr>
            <tr>
                <td>{phrases.cart_shipping_info}</td>
                <td>{cart_shipping.info}</td>
            </tr>
            {-block cart_shipping.shipping_type_by_address}

            
        </table>
    </div>

<form name="confirm" action="{config.site_url}{lng}/cart/confirm" method="post">
        
<div class="confirm_header">{phrases.pay_confirm_title}</div>

<div class="confirm_content" >

        
        <div class="paysera_block">
        <div class="payment_title">{phrases.select_paysera_bank}</div>
        <p>{phrases.select_paysera_bank_desc}</p>
        
        {loop paysera}
        <div class="paysera">
            <label><input type="radio" name="payment" value="14413::{paysera.code}" class="fo_radio vam" id="paysera{paysera.id}" required /> <img class="vam" src="index.php?module=paysera&method=show_image&column=image&id={paysera.id}&w=200&h=100&t=auto" alt="{paysera.title}" title="{paysera.title}"></label>
        </div>
        {-loop paysera}
        
        </div>

        <div class="paysera_block">
        <div class="payment_title">{phrases.select_other_payments}</div>
        <p>{phrases.select_other_payments_text}</p>
        </div>
        
        <table align="center" cellpadding="10" width="100%">
            <tr>
	{loop payments}
	<td class="pay">
	<input type="radio" name="payment" value="{payments.id}" id="id_{payments.id}" class="fo_radio vam" required />
	<label for="id_{payments.id}">{payments.title}</label>
	<p>
            {block payments.image}<img src="index.php?module=payments&method=show_image&column=image&id={payments.id}&w=220&h=150&t=auto">{-block payments.image}
            {payments.description}
        </p>
	</td>
	{-loop payments}
        </tr>
        </table>
    
        
</div>
                
<div class="confirm_header">{phrases.notes_confirm_title} </div>

<div class="confirm_content" style="text-align:right">
	
    <textarea name="notes" clas="fo_textarea" placeholder="{phrases.notes_confirm_title}" style="color:#9F9F9F"></textarea>
    
</div>
<div class="confirm_content" style="margin-top:15px;text-align:right" >
    
    <label>{phrases.agree_text} <input type="checkbox" name="agree" value="1" id="agree_id" style="width:auto;margin-left:10px;" required /></label>
    
</div>
    

<br /><br />

    <div class="checkout_text">
        {phrases.checkout_text}
    </div>





<input type="hidden" name="action" value="confirm" />
<table class="order_next">
	<tr>
		<td>

<input type="button" onclick="javascript: location='{config.site_url}{lng}/cart/shipping_info'" value="{phrases.order_prev_step}" class="btn" />

		</td>
		<td align="right">
	
<input type="submit" value="{phrases.order_last_step}" class="btn" />
		
		</td>
	</tr>
</table>
</form>
    
{-block cart_data.kiekis}

</div>



<script>

function cart_confirm_submit(){
    if($('#payment_type_value').val()){
        $('#cart_data_form').submit();
    }else{
        alert('{phrases.wrong_payment_type}');
        $('#payment_type_value').parents('.confirm_part').addClass('wrong');
    }
}
    
</script>