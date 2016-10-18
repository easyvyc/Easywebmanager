<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="<?php echo TPL::getVar("main_page.page_url"); ?>" title="<?php echo TPL::getVar("main_page.page_title"); ?>"><?php echo TPL::getVar("main_page.title"); ?></a>
        
        <?php $path_iterator=1; foreach(TPL::getLoop("path") as $path_key => $path_val){ if(!is_array($path_val)){ $tmp_val=$path_val; $path_val=array(); $path_val['_VALUE']=$tmp_val; } $path_val['_FIRST']=0; if($path_iterator==1) $path_val['_FIRST']=1; if($path_iterator%2==1) $path_val['_EVEN']=0; else $path_val['_EVEN']=1; $path_val['_INDEX']=$path_iterator++; $path_val['_KEY']=$path_key; ?>
        <?php if(!isset($path_val["_FIRST"]) || !$path_val["_FIRST"]){ ?>
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        <a href="<?php if(isset($path_val["page_url"])) echo $path_val["page_url"]; ?>" title="<?php if(isset($path_val["page_title"])) echo $path_val["page_title"]; ?>"><?php if(isset($path_val["title"])) echo $path_val["title"]; ?></a>
        <?php } ?>
        <?php } ?>
        
    </nav>
    
    <div id="social">
        <div class="contenteditable" contenteditable="true" id="blocks-social-0"><?php echo TPL::getVar("main_blocks.social.description"); ?></div>
    </div>
    
</div>    

<div id="inner_content" class="overflow rel">
    
    <?php echo TPL::getVar("inner_menu_content"); ?>
    
    <article>
    
        <?php if(TPL::getVar("is_paging.is_paging")){ ?>
        <div class="paging t_paging">
            
        <?php if(TPL::getVar("is_paging.paging_start_arrow")){ ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>offset=<?php echo TPL::getVar("is_paging.paging_start_arrow_value"); ?>" ><img src="site/images/p_backward.png" alt="" class="vam" /></a>
        <?php } ?>
            
        <?php $paging_iterator=1; foreach(TPL::getLoop("paging") as $paging_key => $paging_val){ if(!is_array($paging_val)){ $tmp_val=$paging_val; $paging_val=array(); $paging_val['_VALUE']=$tmp_val; } $paging_val['_FIRST']=0; if($paging_iterator==1) $paging_val['_FIRST']=1; if($paging_iterator%2==1) $paging_val['_EVEN']=0; else $paging_val['_EVEN']=1; $paging_val['_INDEX']=$paging_iterator++; $paging_val['_KEY']=$paging_key; ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>offset=<?php if(isset($paging_val["value"])) echo $paging_val["value"]; ?>" <?php if(isset($paging_val["active"]) && $paging_val["active"]){ ?>class="a"<?php } ?>><?php if(isset($paging_val["title_number"])) echo $paging_val["title_number"]; ?></a>
        <?php } ?>

        <?php if(TPL::getVar("is_paging.paging_end_arrow")){ ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>offset=<?php echo TPL::getVar("is_paging.paging_end_arrow_value"); ?>" ><img src="site/images/p_forward.png" alt="" class="vam" /></a>
        <?php } ?>

        </div>
        <?php } ?>
            
            
        <h1 class="title">
            <?php echo TPL::getVar("page_data.header_title"); ?>
            
            <select id="order_by_price" name="price" class="fo_select">
                <option value=""><?php echo TPL::getVar("phrases.product_sorting_by_price_none"); ?></option>
                <option value="ASC" <?= ($_SESSION['products_sort']['dir']=='ASC' ? "selected" : "") ?>><?php echo TPL::getVar("phrases.product_sorting_by_price_asc"); ?></option>
                <option value="DESC" <?= ($_SESSION['products_sort']['dir']=='DESC' ? "selected" : "") ?>><?php echo TPL::getVar("phrases.product_sorting_by_price_desc"); ?></option>
            </select>
            
            <script>
                $('#order_by_price').live('change', function(){ location='<?php echo TPL::getVar("config.site_url"); ?><?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>sort_by=price&sort_dir=' + $(this).val(); })
            </script>
            
        </h1>
        
        <div>
        
            <?php $products_iterator=1; foreach(TPL::getLoop("products") as $products_key => $products_val){ if(!is_array($products_val)){ $tmp_val=$products_val; $products_val=array(); $products_val['_VALUE']=$tmp_val; } $products_val['_FIRST']=0; if($products_iterator==1) $products_val['_FIRST']=1; if($products_iterator%2==1) $products_val['_EVEN']=0; else $products_val['_EVEN']=1; $products_val['_INDEX']=$products_iterator++; $products_val['_KEY']=$products_key; ?>
            <div class="product_thumb <?php if(isset($products_val["akcija"]) && $products_val["akcija"]){ ?>akcija<?php } ?>">
                
                <div class="akcijos">
                    <?php if(isset($products_val["popular"]) && $products_val["popular"]){ ?><span class="pop"><?php echo TPL::getVar("phrases.popular_item"); ?></span><?php } ?>
                    <?php if(isset($products_val["akcija"]) && $products_val["akcija"]){ ?><span class="dis"><?php echo TPL::getVar("phrases.discount_item"); ?> - <?php if(isset($products_val["discount_percent"])) echo $products_val["discount_percent"]; ?>%</span><?php } ?>
                    <?php if(isset($products_val["new_item"]) && $products_val["new_item"]){ ?><span class="new"><?php echo TPL::getVar("phrases.new_item"); ?></span><?php } ?>
                    <?php if(isset($products_val["lizing"]) && $products_val["lizing"]){ ?><span class="liz"><?php echo TPL::getVar("phrases.pirk_lizingu"); ?></span><?php } ?>
                </div>
                
                <a title="<?php if(isset($products_val["title"])) echo $products_val["title"]; ?>" href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?><?php if(isset($products_val["item_url"])) echo $products_val["item_url"]; ?>-<?php if(isset($products_val["id"])) echo $products_val["id"]; ?>.html" class="img" style="<?php if(isset($products_val["image_id"]) && $products_val["image_id"]){ ?>background:url('index.php?module=products_images&method=show_image&column=image&id=<?php if(isset($products_val["image_id"])) echo $products_val["image_id"]; ?>&w=225&h=125&t=auto') center center no-repeat;<?php } ?>"></a>
                <?php if(TPL::getVar("ESHOP_PRICES")){ ?>
                <p class="price">
                    <?php if(!isset($products_val["add2cart"]) || !$products_val["add2cart"]){ ?><?php echo TPL::getVar("phrases.from"); ?>&nbsp;<?php if(isset($products_val["price"])) echo $products_val["price"]; ?> <?php echo TPL::getVar("currency.title"); ?> <?php if(isset($products_val["akcija"]) && $products_val["akcija"]){ ?><br /><span class="old_price"><?php if(isset($products_val["old_price"])) echo $products_val["old_price"]; ?> <?php echo TPL::getVar("currency.title"); ?></span> <?php } ?><?php } ?>
                    <?php if(isset($products_val["add2cart"]) && $products_val["add2cart"]){ ?><?php if(isset($products_val["price"])) echo $products_val["price"]; ?> <?php echo TPL::getVar("currency.title"); ?> <?php if(isset($products_val["akcija"]) && $products_val["akcija"]){ ?><br /><span class="old_price"><?php if(isset($products_val["old_price"])) echo $products_val["old_price"]; ?> <?php echo TPL::getVar("currency.title"); ?></span><?php } ?><?php } ?>
                </p>
                <?php } ?>
                <a title="<?php echo TPL::getVar("mainitems.title"); ?>" class="title" href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?><?php if(isset($products_val["item_url"])) echo $products_val["item_url"]; ?>-<?php if(isset($products_val["id"])) echo $products_val["id"]; ?>.html"><?php if(isset($products_val["title"])) echo $products_val["title"]; ?></a>
                <div class="desc"><?php if(isset($products_val["short_description"])) echo $products_val["short_description"]; ?></div>
                
                <div class="desc_b"></div>
                
                <?php if(isset($products_val["add2cart"]) && $products_val["add2cart"]){ ?>
                <?php if(TPL::getVar("ESHOP_OPEN")){ ?>
                <a class="add2cart" href="javascript: void(add2cart('<?php echo TPL::getVar("lng"); ?>', '<?php if(isset($products_val["id"])) echo $products_val["id"]; ?>'));"><?php echo TPL::getVar("phrases.add2cart"); ?></a>
                <?php } ?>
                <?php } ?>
                
                <a title="<?php if(isset($products_val["title"])) echo $products_val["title"]; ?>" class="more" href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?><?php if(isset($products_val["item_url"])) echo $products_val["item_url"]; ?>-<?php if(isset($products_val["id"])) echo $products_val["id"]; ?>.html"><?php echo TPL::getVar("phrases.more"); ?> <img src="site/images/p_forward.png" alt="" class="vam" /></a>
            </div>
            <?php } ?>

            <div class="clear"></div>
        
        </div>

        <?php if(TPL::getVar("is_paging.is_paging")){ ?>
        <div class="paging" style="margin-top:10px;">
            
        <?php if(TPL::getVar("is_paging.paging_start_arrow")){ ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>offset=<?php echo TPL::getVar("is_paging.paging_start_arrow_value"); ?>" ><img src="site/images/p_backward.png" alt="" class="vam" /></a>
        <?php } ?>
            
        <?php $paging_iterator=1; foreach(TPL::getLoop("paging") as $paging_key => $paging_val){ if(!is_array($paging_val)){ $tmp_val=$paging_val; $paging_val=array(); $paging_val['_VALUE']=$tmp_val; } $paging_val['_FIRST']=0; if($paging_iterator==1) $paging_val['_FIRST']=1; if($paging_iterator%2==1) $paging_val['_EVEN']=0; else $paging_val['_EVEN']=1; $paging_val['_INDEX']=$paging_iterator++; $paging_val['_KEY']=$paging_key; ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>offset=<?php if(isset($paging_val["value"])) echo $paging_val["value"]; ?>" <?php if(isset($paging_val["active"]) && $paging_val["active"]){ ?>class="a"<?php } ?>><?php if(isset($paging_val["title_number"])) echo $paging_val["title_number"]; ?></a>
        <?php } ?>

        <?php if(TPL::getVar("is_paging.paging_end_arrow")){ ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>?<?php if(TPL::getVar("get_filter_str")){ ?><?php echo TPL::getVar("get_filter_str"); ?>&<?php } ?>offset=<?php echo TPL::getVar("is_paging.paging_end_arrow_value"); ?>" ><img src="site/images/p_forward.png" alt="" class="vam" /></a>
        <?php } ?>

        </div>
        <?php } ?>
            
    </article>
    
</div>
