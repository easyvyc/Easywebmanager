<section class="inner-page">

    <h1 class="title">{page_data.header_title}</h1>

    <div class="news-list">
    {loop events}
    <article>
        <figure><a href="{lng}{page_data.page_url}{events.item_url}-{events.id}.html"><img src="index.php?module=events&method=show_image&id={events.id}&column=image&w=245&h=160&t=auto" alt="{events.title}" ></a></figure>
        <h2><a href="{lng}{page_data.page_url}{events.item_url}-{events.id}.html">{events.title}</a></h2>
        <time itemprop="dateCreated" datetime="{events.news_date}">{events.news_date_text}<time>
        <p>{events.short_description}</p>
        <a href="{lng}{page_data.page_url}{events.item_url}-{events.id}.html" class="more">{phrases.more}</a>
    </article>
    {-loop events}
    </div>

    
    {block is_paging}
    <div class="paging">
        {loop paging}
        <a {block paging.active}class="a"{-block paging.active} href="{lng}{page_data.page_url}?offset={paging.value}">{paging.title_number}</a>
        {-loop paging}
    </div>
    {-block is_paging}
        
</section>