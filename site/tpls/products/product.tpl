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


<link href="site/js/slider/my-slider.css" rel="stylesheet" type="text/css" />
<script src="site/js/slider/my-slider.js" type="text/javascript"></script>


<div id="product" class="overflow">

    <div id="product_left">

        <div id="sliderFrame">

         <div id="slider">

             <block name="product_data.Image">
             <a class="slide" href="thumb.php?image={goods_url}{product_data.Image}&w=1000&h=1000&t=0" rel="prettyFoto[product]" style="background-image:url('thumb.php?image={goods_url}{product_data.Image}&w=450&h=270&t=0');" data-index="image"></a>
             </block name="product_data.Image">

             <?php if(is_array($product_data['more_img'])): ?>
             <?php foreach($product_data['more_img'] as $index=>$img): ?>
             <a class="slide" href="thumb.php?image={goods_url}<?php echo $img; ?>&w=1000&h=1000&t=0" rel="prettyFoto[product]" style="background-image:url('thumb.php?image={goods_url}<?php echo $img; ?>&w=450&h=270&t=0');" data-index="index<?= $index ?>"></a>
             <?php endforeach; ?>
             <?php endif; ?>

             <?php if($product_data['BigImage']): ?>
             <a class="slide" href="thumb.php?image={goods_url}<?php echo $product_data['BigImage']; ?>&w=1000&h=1000&t=0" rel="prettyFoto[product]" style="background-image:url('thumb.php?image={goods_url}<?php echo $product_data['BigImage']; ?>&w=450&h=270&t=0');" data-index="big_image"></a>
             <?php endif; ?>

         </div>

        <div id="product_gallery_thumbs">

            <div class="slider_bck"></div>

            <div class="slider_container">
            <div class="slider_content">

                <block name="product_data.Image">
                <a class="product_thumb thumb" style="background-image:url('thumb.php?image={goods_url}{product_data.Image}&w=90&h=68&t=0');"></a>
                </block name="product_data.Image">

                <?php if(is_array($product_data['more_img'])): ?>
                <?php foreach($product_data['more_img'] as $img): ?>
                <a class="product_thumb thumb" style="background-image:url('thumb.php?image={goods_url}<?php echo $img; ?>&w=90&h=68&t=0');"></a>
                <?php endforeach; ?>
                <?php endif; ?>

                <?php if($product_data['BigImage']): ?>
                <a class="product_thumb thumb" style="background-image:url('thumb.php?image={goods_url}<?php echo $product_data['BigImage']; ?>&w=90&h=68&t=0');"></a>
                <?php endif; ?>

            </div>
            </div>

            <div class="slider_fwd"></div>

        </div>
        <script>
        $(document).ready(function(){
            create_slider('#product_gallery_thumbs');
        });
        </script>                     


       </div>

       <div id="product_request">
            <call code="name=request_data::set=var::module=blocks::method=loadItem_byPageId::params=0,'request'">
            {request_data}
       </div>

    </div>

    <div id="product_right">

        <h1 class="title">{product_data.Name}</h1>

        <div class="product_field">{product_data.Description}</div>

        <?php if(!empty($product_data['char'][45]->select)): ?>

<script>
function select_modif__(val){
$('input[name=kampo_puse]').val(val);
$('.selected_modif').removeClass('selected_modif');    
$('#content_modif_' + val + ' img').addClass('selected_modif');
}
</script>

        <div class="item_modif kampo_puse">
            <span style="padding-right:0px"><?php echo $product_data['char'][45]->Name; ?></span>
            <?php foreach($product_data['char'][45]->select as $key => $select): ?>
            <label for="kampo_puse_<?php echo $key; ?>" title="<?= $select['name'] ?>" id="content_modif_<?= $key ?>" class="modif" onclick="javascript: select_modif__('<?= $key ?>');"><block name="product_data.add2cart"><input type="radio" name="kampo_puse__" value="<?= $key ?>" class="vam" id="kampo_puse_<?php echo $key; ?>" /></block name="product_data.add2cart">&nbsp;<img src="thumb.php?image={goods_url}<?php echo $select['img']; ?>&w=75&h=55&t=0" class="vam" /></label>
            <?php endforeach; ?>
            <input type="hidden" name="kampo_puse" value="" >
        </div>

        <block name="ESHOP_PRICES">
        <div class="product_price rel">
            <block name="product_data.add2cart" no>
                <b>{phrases.from}&nbsp;{product_data.item_price} {currency.title_short}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price} {currency.title_short}</span></block name="product_data.akcija"></b>
                <br />
                <b class="eur">{phrases.from}&nbsp;{product_data.item_price_eur} {currency.title_short_eur}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price_eur} {currency.title_short_eur}</span></block name="product_data.akcija"></b>
            </block name="product_data.add2cart" no>
            <block name="product_data.add2cart">
                <b>{product_data.item_price} {currency.title_short}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price} {currency.title_short}</span></block name="product_data.akcija"></b>
                <br />
                <b class="eur">{product_data.item_price_eur} {currency.title_short_eur}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price_eur} {currency.title_short_eur}</span></block name="product_data.akcija"></b>
            </block name="product_data.add2cart">
            <block name="product_data.add2cart">
            <block name="ESHOP_OPEN">
            <a class="add2cart abs" href="javascript: void(add2cart('{config.site_url}ajax.php?content=cart&add={product_data.id}&ajax=1&type[kampo_puse]='+$('#product_right input[name=kampo_puse]').val(), 'cart', before_func));">{phrases.add2cart}</a>
            </block name="ESHOP_OPEN">
            </block name="product_data.add2cart">
        </div>
        </block name="ESHOP_PRICES">

        <?php else: ?>

        <block name="ESHOP_PRICES">
        <div class="product_price rel">
            <block name="product_data.add2cart" no>
                <b>{phrases.from}&nbsp;{product_data.item_price} {currency.title_short}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price} {currency.title_short}</span></block name="product_data.akcija"></b>
                <br />
                <b class="eur">{phrases.from}&nbsp;{product_data.item_price_eur} {currency.title_short_eur}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price_eur} {currency.title_short_eur}</span></block name="product_data.akcija"></b>
            </block name="product_data.add2cart" no>
            <block name="product_data.add2cart">
                <b>{product_data.item_price} {currency.title_short}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price} {currency.title_short}</span></block name="product_data.akcija"></b>
                <br />
                <b class="eur">{product_data.item_price_eur} {currency.title_short_eur}<block name="product_data.akcija">&nbsp;<span class="old_price">{product_data.old_price_eur} {currency.title_short_eur}</span></block name="product_data.akcija"></b>
            </block name="product_data.add2cart">
            <block name="product_data.add2cart">
            <block name="ESHOP_OPEN">
            <a class="add2cart abs" href="javascript: void(add2cart('{config.site_url}ajax.php?content=cart&add={product_data.id}&ajax=1', 'cart', before_func));">{phrases.add2cart}</a>
            </block name="ESHOP_OPEN">
            </block name="product_data.add2cart">
        </div>
        </block name="ESHOP_PRICES">

        <?php endif; ?>

        <? foreach($product_data['char'] as $val): ?>
        <? if($val->pazymetas['apras']):  ?>
        <div class="product_field"><b><?php echo $val->Name; ?></b> - <?php echo $val->pazymetas['apras']; ?></div>
        <? endif; ?>
        <? endforeach; ?>


        <?php foreach($product_data['funcions'] as $function): ?>
        <div class="product_field"><!--<img src="thumb.php?image={goods_url}<?php echo $function['image']; ?>&w=50&h=50&t=0" class="vam" alt="<?php echo $function['Name']; ?>" /> - --><a target="_blank" href="{config.site_url}lt/naudinga-informacija_/baldu-kokybe/naudojamos-medziagos/#<?php echo $function['Hash']; ?>"><?php echo $function['Name']; ?></a></div>
        <?php endforeach; ?>

        <br /><br />

        <block name="ESHOP_PRICES">
    <? if($product_data['akcija'] && in_array($product_data['id'], array(95595, 90849, 94542, 41296))): ?>
    <iframe src="https://www.ubl.lt/skaiciuokle/calculator.php?layout=layout4white&amp;clientid=gintb&amp;profid=2420&amp;term=10&amp;price={product_data.item_price}" scrolling="no" frameborder="0" style="border:0; overflow:hidden; width:200px; height:141px;" ALLOWTRANSPARENCY="true"></iframe>
    <? else: ?>
    <iframe src="https://www.ubl.lt/skaiciuokle/calculator.php?layout=layout4white&amp;clientid=gintb&amp;profid=1507&amp;term=12&amp;price={product_data.item_price}" scrolling="no" frameborder="0" style="border:0; overflow:hidden; width:200px; height:141px;" ALLOWTRANSPARENCY="true"></iframe>
    <? endif; ?>                
    <!--iframe title="InCredit Group calculator" width="180" height="315" src="http://incredit.lv/calculator/ick_lat.html" frameborder="0"></iframe-->
        </block name="ESHOP_PRICES">

    </div>  

    <div class="clear"></div>

    <call code="name=viewed_items::set=loop::module=products::method=list_viewed_items::params={{product_data.id}}">
    <call code="name=is_viewed_items::set=var::module=products::method=is_viewd_items::params=">

    <block name="is_viewed_items">
    <div id="viewed_items">

        <h3 class="title">{phrases.viewed_items}</h3>

        <div class="slider_bck"></div>

        <div class="slider_container">
        <div class="slider_content">
        <loop name="viewed_items">
        <div class="product_thumb">
            <a href="{lng}{viewed_items.page_url}{viewed_items.product_url}-{viewed_items.id}.html" class="img" style="<block name="viewed_items.Image">background:url('thumb.php?image={goods_url}{viewed_items.Image}&w=225&h=125&t=0') center center no-repeat;</block name="viewed_items.Image">"></a>
            <block name="ESHOP_PRICES">
            <p class="price"><block name="viewed_items.add2cart" no>{phrases.from}&nbsp;</block name="viewed_items.add2cart" no>{viewed_items.item_price} {currency.title_short} / <span class="eur">{viewed_items.item_price_eur} {currency.title_short_eur}</span></p>
            </block name="ESHOP_PRICES">
            <a class="title" href="{lng}{viewed_items.page_url}{viewed_items.product_url}-{viewed_items.id}.html">{viewed_items.Name}</a>
        </div>
        </loop name="viewed_items">
        </div>
        </div>

        <div class="slider_fwd"></div>

    </div>
    <script>
    $(document).ready(function(){
        create_slider('#viewed_items');
    });
    </script>
    </block name="is_viewed_items">

</div>

        
    </article>
    
</div>        