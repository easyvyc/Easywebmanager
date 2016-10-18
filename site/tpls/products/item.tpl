<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a>
        
        {loop path}
        {block path._FIRST no}
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        <a href="{path.page_url}" title="{path.page_title}">{path.title}</a>
        {-block path._FIRST no}
        {-loop path}
        
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        {product_data.title}
        
    </nav>
    
    <div id="social">
        <div class="contenteditable" contenteditable="true" id="blocks-social-0">{main_blocks.social.description}</div>
    </div>
    
</div>    

<div id="inner_content" class="overflow rel">
    
    {inner_menu_content}
    
    <article>


<div id="product" class="overflow">

    <div id="product_left">


        <figure id="product_slideshow" class="easy_slideshow" data-autoplay="false" data-links="true" data-pagination="thumb" data-img-w="280" data-img-h="400" data-slide-opt="dissolve" data-delay="5000" style="width:280px;height:450px;">

            {loop product_images}
            <img src="index.php?module=products_images&amp;method=show_image&amp;column=image&amp;id={product_images.id}&amp;w=280&amp;h=400&amp;t=auto" data-link="index.php?module=products_images&amp;method=show_image&amp;column=image&amp;id={product_images.id}&amp;w=1000&amp;h=1000&amp;t=landscape" alt="" />
            {-loop product_images}

        </figure>
        
       <div id="product_request">

           {product_request_site_block}
           
       </div>

    </div>

                
    <div id="product_right">

        <h1 class="title">{product_data.title}</h1>

        <div class="product_field">{product_data.description}</div>

        {loop modif_values}
        <div class="item_modif material modif_arr_{modif_values.id}">
            <span style="padding-right:0px;display:block;margin-bottom:5px;margin-top:15px;margin-left:15px;font-weight:bold;display:block">{modif_values.title}</span>
            {loop modif_values.modif_arr}
            <div class="modif" style="margin:0 1px;text-align:center;margin-bottom:3px;float:left;height:80px;width:78px;">
                <label title="{modif_values.modif_arr.title}" class="modif content_modif_{modif_values.modif_arr.id}" onclick="javascript: select_modif('product_right', '{modif_values.id}', '{modif_values.modif_arr.id}');">
                    <img src="index.php?module=products_modifications_options&method=show_image&column=image&id={modif_values.modif_arr.id}&w=60&h=60&t=crop" class="vam" />
                </label>
                {block modif_values.modif_arr.description}
                <br />
                <a href="javascript: void(my_dialog('{modif_values.modif_arr.title}', $('#modif_desc_{modif_values.modif_arr.id}').html(), 700, 450, 80));">{phrases.more}</a>
                {-block modif_values.modif_arr.description}
            </div>
            <div id="modif_desc_{modif_values.modif_arr.id}" style="display:none;">{modif_values.modif_arr.description}</div>
            {-loop modif_values.modif_arr}
            <div class="clear"></div>
            <input type="hidden" class="modif_value_{modif_values.id}" name="modif[{modif_values.id}]" value="" >
        </div>
        {-loop modif_values}
        
        
        {block ESHOP_PRICES}
        <div class="product_price rel">
            {block product_data.add2cart no}
                <b>{phrases.from}&nbsp;{product_data.price} {currency.title}{block product_data.akcija}&nbsp;<span class="old_price">{product_data.old_price} {currency.title}</span>{-block product_data.akcija}</b>
            {-block product_data.add2cart no}
            {block product_data.add2cart}
                <b>{product_data.price} {currency.title}{block product_data.akcija}&nbsp;<span class="old_price">{product_data.old_price} {currency.title}</span>{-block product_data.akcija}</b>
            {-block product_data.add2cart}
            {block product_data.add2cart}
            {block ESHOP_OPEN}
            <a class="add2cart abs" href="javascript: void(add2cart('{lng}', '{product_data.id}', 1, escape($('#product_right [name^=modif]').serialize())));">{phrases.add2cart}</a>
            {-block ESHOP_OPEN}
            {-block product_data.add2cart}
        </div>
        {-block ESHOP_PRICES}

        

        {loop filters_values}
        <div class="product_field"><b>{filters_values.title}</b> - {filters_values.value}</div>
        {-loop filters_values}


        {loop product_materials}
        <div class="product_field">
            <a href="javascript: void(my_dialog('{product_materials.title}', $('#material_{product_materials.record_id}').html(), 600));">{product_materials.title}</a>
            <div class="hide" id="material_{product_materials.record_id}">{product_materials.desc}</div>
        </div>
        {-loop product_materials}


    </div>  

    <div class="clear"></div>


    {block is_viewed_items}
    <div id="viewed_items">

        <h3 class="title">{phrases.viewed_items}</h3>

        <div class="slider_bck"></div>

        <div class="slider_container">
        <div class="slider_content">
        {loop viewed_items}
        <div class="product_thumb">
            <a href="{lng}{viewed_items.page_url}{viewed_items.item_url}-{viewed_items.id}.html" class="img" style="{block viewed_items.image_id}background:url('index.php?module=products_images&method=show_miage&column=image&id={viewed_items.image_id}&w=225&h=125&t=0') center center no-repeat;{-block viewed_items.image_id}"></a>
            {block ESHOP_PRICES}
            <p class="price">{block viewed_items.add2cart no}{phrases.from}&nbsp;{-block viewed_items.add2cart no}{viewed_items.price} {currency.title} / <span class="eur">{viewed_items.price_eur} {currency.title_eur}</span></p>
            {-block ESHOP_PRICES}
            <a class="title" href="{lng}{viewed_items.page_url}{viewed_items.item_url}-{viewed_items.id}.html">{viewed_items.title}</a>
        </div>
        {-loop viewed_items}
        </div>
        </div>

        <div class="slider_fwd"></div>

    </div>
    <script>
    $(document).ready(function(){
        create_slider('#viewed_items');
    });
    </script>
    {-block is_viewed_items}

</div>

        
    </article>
    
</div>        