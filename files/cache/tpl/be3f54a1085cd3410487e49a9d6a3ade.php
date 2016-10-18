<div id="shopping_cart_mini">
    <a style="display:block;" href="<?php if(TPL::getVar("cart_data.kiekis")){ ?>javascript: void($('#shopping_cart_content').toggle());<?php } ?><?php if(!TPL::getVar("cart_data.kiekis")){ ?>javascript: ;<?php } ?>" title="<?php echo TPL::getVar("phrases.cart_link_title"); ?>" rel="nofollow">
        <i class="icon-shopping-cart"></i>
        <?php if(TPL::getVar("cart_data.kiekis")){ ?>
        <span class="ajax_cart_quantity"><?php echo TPL::getVar("cart_data.kiekis"); ?> vnt. - <?php echo TPL::getVar("cart_data.allsum"); ?> <?php echo TPL::getVar("currency.title"); ?></span>
        <?php } ?>
        <?php if(!TPL::getVar("cart_data.kiekis")){ ?>
        <span class="ajax_cart_no_product"><?php echo TPL::getVar("cart_data.allsum"); ?> <?php echo TPL::getVar("currency.title"); ?></span>
        <?php } ?>
    </a>
</div>

<section id="shopping_cart_content" style="display:none;">
    
    <div class="toggle_content">

        <div id="cart_block_list">
            
            <?php if(TPL::getVar("cart_items")){ ?>
            <dl class="products table">
                <?php $cart_items_iterator=1; foreach(TPL::getLoop("cart_items") as $cart_items_key => $cart_items_val){ if(!is_array($cart_items_val)){ $tmp_val=$cart_items_val; $cart_items_val=array(); $cart_items_val['_VALUE']=$tmp_val; } $cart_items_val['_FIRST']=0; if($cart_items_iterator==1) $cart_items_val['_FIRST']=1; if($cart_items_iterator%2==1) $cart_items_val['_EVEN']=0; else $cart_items_val['_EVEN']=1; $cart_items_val['_INDEX']=$cart_items_iterator++; $cart_items_val['_KEY']=$cart_items_key; ?>
                <dt class="row">
                    <a class="cell cart-images" href="<?php if(isset($cart_items_val["page_url"])) echo $cart_items_val["page_url"]; ?><?php if(isset($cart_items_val["item_url"])) echo $cart_items_val["item_url"]; ?>-<?php if(isset($cart_items_val["id"])) echo $cart_items_val["id"]; ?>.html">
                        <?php if(isset($cart_items_val["image"]) && $cart_items_val["image"]){ ?>
                        <img src="index.php?module=products&method=show_image&column=image&id=<?php if(isset($cart_items_val["id"])) echo $cart_items_val["id"]; ?>&w=50&h=50&t=crop" alt="" title="<?php if(isset($cart_items_val["title"])) echo $cart_items_val["title"]; ?>"/>
                        <?php } ?>
                        <?php if(!isset($cart_items_val["image"]) || !$cart_items_val["image"]){ ?>
                        <img src="site/images/autozed_default.png" width="50" alt="" />
                        <?php } ?>
                    </a>
                    <span class="cell quantity-formated"><span class="quantity"><?php if(isset($cart_items_val["kiekis"])) echo $cart_items_val["kiekis"]; ?></span>x</span>
                    <a class="cell cart_block_product_name product_link" href="<?php if(isset($cart_items_val["page_url"])) echo $cart_items_val["page_url"]; ?><?php if(isset($cart_items_val["item_url"])) echo $cart_items_val["item_url"]; ?>-<?php if(isset($cart_items_val["id"])) echo $cart_items_val["id"]; ?>.html" title="<?php if(isset($cart_items_val["title"])) echo $cart_items_val["title"]; ?>">
                        <?php if(isset($cart_items_val["title"])) echo $cart_items_val["title"]; ?><br />
                        <?php if(isset($cart_items_val["id_mod_arr"]) && $cart_items_val["id_mod_arr"]){ ?>
                        (
                        <?php $cart_items_id_mod_arr_iterator=1; if(isset($cart_items_val["id_mod_arr"])){ foreach($cart_items_val["id_mod_arr"] as $cart_items_id_mod_arr_key => $cart_items_id_mod_arr_val){ if(!is_array($cart_items_id_mod_arr_val)){ $tmp_val=$cart_items_id_mod_arr_val; $cart_items_id_mod_arr_val=array(); $cart_items_id_mod_arr_val['_VALUE']=$tmp_val; } $cart_items_id_mod_arr_val['_FIRST']=0; if($cart_items_id_mod_arr_iterator==1) $cart_items_id_mod_arr_val['_FIRST']=1; if($cart_items_id_mod_arr_iterator%2==1) $cart_items_id_mod_arr_val['_EVEN']=0; else $cart_items_id_mod_arr_val['_EVEN']=1; $cart_items_id_mod_arr_val['_INDEX']=$cart_items_id_mod_arr_iterator++; $cart_items_id_mod_arr_val['_KEY']=$cart_items_id_mod_arr_key;  ?>
                        <?php if(isset($cart_items_id_mod_arr_val["group_title"])) echo $cart_items_id_mod_arr_val["group_title"]; ?>: <?php if(isset($cart_items_id_mod_arr_val["title"])) echo $cart_items_id_mod_arr_val["title"]; ?>
                        <?php }} ?>
                        )
                        <?php } ?>
                    </a>
                    <span class="cell price"><?php if(isset($cart_items_val["price_sum"])) echo $cart_items_val["price_sum"]; ?>&nbsp;<?php echo TPL::getVar("currency.title"); ?><br /><span class="euro">(<?php if(isset($cart_items_val["price_sum_eur"])) echo $cart_items_val["price_sum_eur"]; ?>&nbsp;<?php echo TPL::getVar("currency.title_ltl"); ?>)</span></span>
                    <span class="cell remove_link"><a rel="nofollow" class="ajax_cart_block_remove_link" href="javascript: void(remove_cart_item('<?php echo TPL::getVar("lng"); ?>', '<?php if(isset($cart_items_val["id"])) echo $cart_items_val["id"]; ?>', '<?php if(isset($cart_items_val["modifs"])) echo $cart_items_val["modifs"]; ?>'));" title="<?php echo TPL::getVar("phrases.remove_from_cart"); ?>"><span class="icon-trash">x</span></a></span>
                </dt>
                <?php } ?>
            </dl>            
            
            <div class="cart-prices">
                <?php if(TPL::getVar("cart_data.shipping_price")){ ?>
                <div class="cart-prices-block">
                    <span><?php echo TPL::getVar("phrases.shipping_price"); ?></span>
                    <span id="cart_block_shipping_cost" class="price ajax_cart_shipping_cost"><?php echo TPL::getVar("cart_data.shipping_price"); ?> <?php echo TPL::getVar("currency.title"); ?></span>
                </div>
                <?php } ?>
                <div class="cart-prices-block">
                    <span><?php echo TPL::getVar("phrases.cart_total_price"); ?></span>
                    <span id="cart_block_total" class="price ajax_block_cart_total"><?php echo TPL::getVar("cart_data.allsum"); ?> <?php echo TPL::getVar("currency.title"); ?> <span class="euro">(<?php echo TPL::getVar("cart_data.allsum_eur"); ?> <?php echo TPL::getVar("currency.title_ltl"); ?>)</span></span>
                </div>
            </div>
            <div class="clear"></div>
            <p id="cart-buttons" class="">
                <a href="<?php echo TPL::getVar("lng"); ?>/cart/index" class="button_mini" title="<?php echo TPL::getVar("phrases.view_cart"); ?>" rel="nofollow"><?php echo TPL::getVar("phrases.view_cart"); ?></a> 
                <a href="<?php echo TPL::getVar("lng"); ?>/cart/index" id="button_order_cart" class="button_mini" title="<?php echo TPL::getVar("phrases.checkout"); ?>" rel="nofollow"><?php echo TPL::getVar("phrases.checkout"); ?></a>
            </p>
            <div class="clear"></div>
            <?php } ?>
            
        </div>
    </div>
</section>