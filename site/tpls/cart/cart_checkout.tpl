<div class="block">

    <div class="cont">

        <div id="path" class="path">


            <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a> > <a href="{lng}/cart/index" title="{phrases.cart_title}">{phrases.cart_title}</a>

        </div>

        <div id="data_text">


    
{block cart_data.kiekis no}
<p class="warning">{phrases.cart_empty}</p>
{-block cart_data.kiekis no}
  
{block cart_data.kiekis}
<div>
    <table class="cart-checkout" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <td width="150"></td>
                <td>{phrases.product_title}</td>
                <td>{phrases.product_price}</td>
                <td>{phrases.cart_kiekis}</td>
                <td>{phrases.item_price_sum}</td>
                <td>{phrases.product_remove}</td>
            </tr>
        </thead>
        <tbody>
				
            {loop cart_items}
            <tr>
                <td class="cart_product">
                    <a href="{cart_items.page_url}{cart_items.item_url}-{cart_items.id}.html">
                        {block cart_items.image}
                        <img src="index.php?module=products&method=show_image&column=image&id={cart_items.id}&w=100&h=100&t=auto" alt="{cart_items.title}" />
                        {-block cart_items.image}
                        {block cart_items.image no}
                        <img src="site/images/0.gif" height="100" alt="{cart_items.title}" />
                        {-block cart_items.image no}
                    </a>
                </td>
                <td class="cart">
                    <a class="product_link" href="{cart_items.page_url}{cart_items.item_url}-{cart_items.id}.html">{cart_items.title}{block cart_items.code} ({cart_items.code}){-block cart_items.code}</a>
                    {block cart_items.id_mod_arr}
                    <br />(
                    {loop cart_items.id_mod_arr}
                    {cart_items.id_mod_arr.group_title}: {cart_items.id_mod_arr.title}
                    {-loop cart_items.id_mod_arr}
                    )
                    {-block cart_items.id_mod_arr}
                    
                </td>
                <td>
                        <span class="price">
                            {cart_items.price}&nbsp;{currency.title}<br />
                            <span class="euro">({cart_items.price_eur}&nbsp;{currency.title_ltl})</span>
                        </span>
                        
                 </td>
                 <td>
                        <div class="cart_quantity">
                            <div class="cart_quantity_button" style="float:left;">
                                <input type="hidden" value="{cart_items.kiekis}" />
                                <input size="2" type="text" autocomplete="off" class="cart_quantity_input" value="{cart_items.kiekis}" readonly="true" id="cart_item_qty_{cart_items.id_mod_x}" />
                                <a rel="nofollow" class="cart_quantity_up" href="javascript: void(plus_add2cart('{lng}', '{cart_items.id}', '{cart_items.modifs}', '{cart_items.id_mod_x}'));" title="Add">
                                    <img src="site/images/plus.gif" alt="Add" />
                                </a>
                                <br />
                                <a rel="nofollow" class="cart_quantity_down" href="javascript: void(minus_add2cart('{lng}', '{cart_items.id}', '{cart_items.modifs}', '{cart_items.id_mod_x}'));" title="Subtract">
                                    <img src="site/images/minus.gif" alt="Subtract" />
                                </a>
                            </div>
                        </div>
                </td>
                <td>
                    <span class="price total-pr">{cart_items.price_sum}&nbsp;{currency.title}<br /><span class="euro">({cart_items.price_sum_eur}&nbsp;{currency.title_ltl})</span></span>
                </td>
                <td>
                    <a rel="nofollow" class="cart_quantity_delete" href="javascript: void(remove_add2cart('{lng}', '{cart_items.id}', '{cart_items.modifs}'));"><img src="site/images/action_delete.gif" alt="" title="{phrases.item_remove_title}" /></a>                    
                </td>
            </tr>
            {-loop cart_items}
		
        </tbody>
        
        <tfoot>
            <tr class="cart_total_delivery" style="display:none">
                <td >{phrases.shipping_price}</td>
                <td  class="price" id="total_shipping">{cart_data.shipping_price} {currency.title}</td>
            </tr>
            <tr class="cart_total_price">
                <td colspan="4" align="right">{phrases.cart_total_no_shipping}</td>	
                <td colspan="2">{cart_data.allsum_no_shipping}&nbsp;{currency.title}<br /><span class="euro">({cart_data.allsum_no_shipping_eur}&nbsp;{currency.title_ltl})</span></td>
            </tr>
        </tfoot>
        
    </table>
</div>  
            
            
<p class="cart_navigation">
    <a href="{lng}/cart/user_info" class="btn continue" title="{phrases.cart_next}">{phrases.cart_next} &raquo;</a>
</p>

{-block cart_data.kiekis}    

        </div>

    </div>

</div>