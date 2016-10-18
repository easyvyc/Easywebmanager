<div id="shopping_cart_mini">
    <a style="display:block;" href="{block cart_data.kiekis}javascript: void($('#shopping_cart_content').toggle());{-block cart_data.kiekis}{block cart_data.kiekis no}javascript: ;{-block cart_data.kiekis no}" title="{phrases.cart_link_title}" rel="nofollow">
        <i class="icon-shopping-cart"></i>
        {block cart_data.kiekis}
        <span class="ajax_cart_quantity">{cart_data.kiekis} vnt. - {cart_data.allsum} {currency.title}</span>
        {-block cart_data.kiekis}
        {block cart_data.kiekis no}
        <span class="ajax_cart_no_product">{cart_data.allsum} {currency.title}</span>
        {-block cart_data.kiekis no}
    </a>
</div>

<section id="shopping_cart_content" style="display:none;">
    
    <div class="toggle_content">

        <div id="cart_block_list">
            
            {block cart_items}
            <dl class="products table">
                {loop cart_items}
                <dt class="row">
                    <a class="cell cart-images" href="{cart_items.page_url}{cart_items.item_url}-{cart_items.id}.html">
                        {block cart_items.image}
                        <img src="index.php?module=products&method=show_image&column=image&id={cart_items.id}&w=50&h=50&t=crop" alt="" title="{cart_items.title}"/>
                        {-block cart_items.image}
                        {block cart_items.image no}
                        <img src="site/images/autozed_default.png" width="50" alt="" />
                        {-block cart_items.image no}
                    </a>
                    <span class="cell quantity-formated"><span class="quantity">{cart_items.kiekis}</span>x</span>
                    <a class="cell cart_block_product_name product_link" href="{cart_items.page_url}{cart_items.item_url}-{cart_items.id}.html" title="{cart_items.title}">
                        {cart_items.title}<br />
                        {block cart_items.id_mod_arr}
                        (
                        {loop cart_items.id_mod_arr}
                        {cart_items.id_mod_arr.group_title}: {cart_items.id_mod_arr.title}
                        {-loop cart_items.id_mod_arr}
                        )
                        {-block cart_items.id_mod_arr}
                    </a>
                    <span class="cell price">{cart_items.price_sum}&nbsp;{currency.title}<br /><span class="euro">({cart_items.price_sum_eur}&nbsp;{currency.title_ltl})</span></span>
                    <span class="cell remove_link"><a rel="nofollow" class="ajax_cart_block_remove_link" href="javascript: void(remove_cart_item('{lng}', '{cart_items.id}', '{cart_items.modifs}'));" title="{phrases.remove_from_cart}"><span class="icon-trash">x</span></a></span>
                </dt>
                {-loop cart_items}
            </dl>            
            
            <div class="cart-prices">
                {block cart_data.shipping_price}
                <div class="cart-prices-block">
                    <span>{phrases.shipping_price}</span>
                    <span id="cart_block_shipping_cost" class="price ajax_cart_shipping_cost">{cart_data.shipping_price} {currency.title}</span>
                </div>
                {-block cart_data.shipping_price}
                <div class="cart-prices-block">
                    <span>{phrases.cart_total_price}</span>
                    <span id="cart_block_total" class="price ajax_block_cart_total">{cart_data.allsum} {currency.title} <span class="euro">({cart_data.allsum_eur} {currency.title_ltl})</span></span>
                </div>
            </div>
            <div class="clear"></div>
            <p id="cart-buttons" class="">
                <a href="{lng}/cart/index" class="button_mini" title="{phrases.view_cart}" rel="nofollow">{phrases.view_cart}</a> 
                <a href="{lng}/cart/index" id="button_order_cart" class="button_mini" title="{phrases.checkout}" rel="nofollow">{phrases.checkout}</a>
            </p>
            <div class="clear"></div>
            {-block cart_items}
            
        </div>
    </div>
</section>