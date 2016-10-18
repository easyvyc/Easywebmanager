<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="{main_page.page_url}" title="{main_page.page_title}">{main_page.title}</a>
        
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        {page_data.header_title} ({get.q})
        
    </nav>
    
    <div id="social">
        <div class="contenteditable" contenteditable="true" id="blocks-social-0">{main_blocks.social.description}</div>
    </div>
    
</div>



<div id="inner_content" class="overflow rel">
    
    <nav id="inner_menu">&nbsp;</nav>
    
    <article>
    
       
    <h3>{page_data.header_title} ({get.q})</h3>

    <div class="text-content">
    {block short_key}
    {phrases.to_short_key}
    {-block short_key}

    {block short_key no}

    {block no_results}
    {phrases.no_search_results}
    {-block no_results}

    {loop search_results}
    <div class="search_res">
    {block search_results.image}
    <a href="{search_results.page_url}"><img alt="{search_results._title_}" src="thumb.php?image={upload_url}{search_results.image}&w=150&h=150&t=0" /></a>
    {-block search_results.image}
    <a href="{search_results.page_url}">{search_results.title}</a>
    <p>...{search_results._description_}...</p>
    </div>
    {-loop search_results}

    <div class="paging">
    {loop paging}
    <a href="{lng}{page_data.page_url}?q={get.q}&offset={paging.value}" {block paging.active}class="a"{-block paging.active}>{paging.title}</a>
    {-loop paging}
    </div>            

    {-block short_key no}    
    </div>        
        
	
    </article>
            
</div>