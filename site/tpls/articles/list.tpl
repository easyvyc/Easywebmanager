<div class="cont articles_page">
    
<aside class="articles_nav">

    <div class="articles_nav_item kryptys">
    <h3>{phrases.kryptys_title}</h3>
    <ul>
        {loop kryptys}
        <li {kryptys.selected}class="a"{-kryptys.selected}><a href="{lng}{page_data.page_url}?b={kryptys.id}" title="{kryptys.page_title}">{kryptys.title}</a></li>
        {-loop kryptys}
    </ul>
    </div>
    
    <div class="articles_nav_item temos">
    <h3>{phrases.temos_title}</h3>
    <ul>
        {loop temos}
        <li {temos.selected}class="a"{-temos.selected}><a href="{lng}{page_data.page_url}?a={temos.id}" title="{temos.page_title}">{temos.title}</a></li>
        {-loop temos}
    </ul>
    </div>
    
    <div class="left_banners">
        
        <div class="contenteditable" contenteditable="true" id="blocks-left_article_banners-0">{main_blocks.left_article_banners.description}</div>
        
    </div>
    
</aside>

<div class="articles_list_inner">
<div class="articles_list">

    <div class="content">
    
        <header class="article_list_header">
            
            <h1 class="title">{page_data.title}</h1>

            <div class="contenteditable" contenteditable="true" id="blocks-header-{page_data.id}">{current_page_blocks.header.description}</div>

        </header>

        {loop items}
        <article class="item" id="article-{items.id}">
            <a href="{lng}{page_data.page_url}{items.page_url}-{items.id}.html">
                <figure>
                    <img src="index.php?module=articles&method=show_image&column=image&id={items.id}&w=220&h=300&t=landscape" />
                </figure>
                <div class="text">
                    <h2>{items.title}</h2>
                    <p>{items.short_description}</p>
                </div>
                <div class="b"></div>
            </a>
        </article>
        <script> $('#article-{items.id} img').load(function(){ $('#article-{items.id} .text').css('top', $(this).height() + 'px'); }); </script>
        {-loop items}

        <div class="clear"></div>
        
        {block is_paging}
        <div class="paging">
            {loop paging}
            <a {block paging.active}class="a"{-block paging.active} href="{lng}{page_data.page_url}?offset={paging.value}">{paging.title}</a>
            {-loop paging}
        </div>
        {-block is_paging}
        
    </div>

</div>
</div>
</div>