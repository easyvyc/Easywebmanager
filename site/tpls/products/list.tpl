<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a>
        
        {loop path}
        {block path._FIRST no}
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        <a href="{path.page_url}" title="{path.page_title}">{path.title}</a>
        {-block path._FIRST no}
        {-loop path}
        
    </nav>
    
    <div id="social">
        <div class="contenteditable" contenteditable="true" id="blocks-social-0">{main_blocks.social.description}</div>
    </div>
    
</div>    

<div id="inner_content" class="overflow rel">
    
    {inner_menu_content}
    
    <article>
    
        {block is_paging.is_paging}
        <div class="paging t_paging">
            
        {block is_paging.paging_start_arrow}
        <a href="{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}offset={is_paging.paging_start_arrow_value}" ><img src="site/images/p_backward.png" alt="" class="vam" /></a>
        {-block is_paging.paging_start_arrow}
            
        {loop paging}
        <a href="{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}offset={paging.value}" {block paging.active}class="a"{-block paging.active}>{paging.title_number}</a>
        {-loop paging}

        {block is_paging.paging_end_arrow}
        <a href="{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}offset={is_paging.paging_end_arrow_value}" ><img src="site/images/p_forward.png" alt="" class="vam" /></a>
        {-block is_paging.paging_end_arrow}

        </div>
        {-block is_paging.is_paging}
            
            
        <h1 class="title">
            {page_data.header_title}
            
            <select id="order_by_price" name="price" class="fo_select">
                <option value="">{phrases.product_sorting_by_price_none}</option>
                <option value="ASC" <?= ($_SESSION['products_sort']['dir']=='ASC' ? "selected" : "") ?>>{phrases.product_sorting_by_price_asc}</option>
                <option value="DESC" <?= ($_SESSION['products_sort']['dir']=='DESC' ? "selected" : "") ?>>{phrases.product_sorting_by_price_desc}</option>
            </select>
            
            <script>
                $('#order_by_price').live('change', function(){ location='{config.site_url}{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}sort_by=price&sort_dir=' + $(this).val(); })
            </script>
            
        </h1>
        
        <div>
        
            {loop products}
            <div class="product_thumb {block products.akcija}akcija{-block products.akcija}">
                
                <div class="akcijos">
                    {block products.popular}<span class="pop">{phrases.popular_item}</span>{-block products.popular}
                    {block products.akcija}<span class="dis">{phrases.discount_item} - {products.discount_percent}%</span>{-block products.akcija}
                    {block products.new_item}<span class="new">{phrases.new_item}</span>{-block products.new_item}
                    {block products.lizing}<span class="liz">{phrases.pirk_lizingu}</span>{-block products.lizing}
                </div>
                
                <a title="{products.title}" href="{lng}{page_data.page_url}{products.item_url}-{products.id}.html" class="img" style="{block products.image_id}background:url('index.php?module=products_images&method=show_image&column=image&id={products.image_id}&w=225&h=125&t=auto') center center no-repeat;{-block products.image_id}"></a>
                {block ESHOP_PRICES}
                <p class="price">
                    {block products.add2cart no}{phrases.from}&nbsp;{products.price} {currency.title} {block products.akcija}<br /><span class="old_price">{products.old_price} {currency.title}</span> {-block products.akcija}{-block products.add2cart no}
                    {block products.add2cart}{products.price} {currency.title} {block products.akcija}<br /><span class="old_price">{products.old_price} {currency.title}</span>{-block products.akcija}{-block products.add2cart}
                </p>
                {-block ESHOP_PRICES}
                <a title="{mainitems.title}" class="title" href="{lng}{page_data.page_url}{products.item_url}-{products.id}.html">{products.title}</a>
                <div class="desc">{products.short_description}</div>
                
                <div class="desc_b"></div>
                
                {block products.add2cart}
                {block ESHOP_OPEN}
                <a class="add2cart" href="javascript: void(add2cart('{lng}', '{products.id}'));">{phrases.add2cart}</a>
                {-block ESHOP_OPEN}
                {-block products.add2cart}
                
                <a title="{products.title}" class="more" href="{lng}{page_data.page_url}{products.item_url}-{products.id}.html">{phrases.more} <img src="site/images/p_forward.png" alt="" class="vam" /></a>
            </div>
            {-loop products}

            <div class="clear"></div>
        
        </div>

        {block is_paging.is_paging}
        <div class="paging" style="margin-top:10px;">
            
        {block is_paging.paging_start_arrow}
        <a href="{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}offset={is_paging.paging_start_arrow_value}" ><img src="site/images/p_backward.png" alt="" class="vam" /></a>
        {-block is_paging.paging_start_arrow}
            
        {loop paging}
        <a href="{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}offset={paging.value}" {block paging.active}class="a"{-block paging.active}>{paging.title_number}</a>
        {-loop paging}

        {block is_paging.paging_end_arrow}
        <a href="{lng}{page_data.page_url}?{block get_filter_str}{get_filter_str}&{-block get_filter_str}offset={is_paging.paging_end_arrow_value}" ><img src="site/images/p_forward.png" alt="" class="vam" /></a>
        {-block is_paging.paging_end_arrow}

        </div>
        {-block is_paging.is_paging}
            
    </article>
    
</div>
