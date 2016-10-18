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

<div id="inner_content" class="overflow">
    
    {inner_menu_content}
            
    <article {block inner_menu no}class="no_inner_menu"{-block inner_menu no}>
    
        <h1 class="title">{page_data.header_title}</h1>
        
        <div class="contenteditable" id="blocks-description-{page_data.id}">{page_data.page_area.description}</div>
        
    </article>
    
</div>    

