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
    
<div class="articles_one">

        <article class="item content">
            
            <header class="article_header">
                <h1 class="title">{article.title}</h1>
                <!--time itemprop="dateCreated" datetime="{article.news_date}">{article.news_date_text}</time-->
            </header>
            
            <!--figure>
                <img src="index.php?module=articles&method=show_image&column=image&id={article.id}&w=800&h=400&t=landscape" />
            </figure-->
            
            <div class="text">
                
                <div class="contenteditable" contenteditable="true" id="articles-description-{article.id}">{article.description}</div>
                
            </div>
                
            {block item_tags}
            <div class="item-tags">
                
                <b>{phrases.temos_title}:</b> {loop item_tags}{block item_tags._FIRST no},{-block item_tags._FIRST no} <a href="{path.1.page_url}?tag={item_tags.item_url}">{item_tags.title}</a>{-loop item_tags}
                
            </div>
            {-block item_tags}
                
            <footer class="article_footer">
                
                <div class="social">
                    <span>{phrases.share_article}:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={article.url_to_share}" target="_blank" class="fb"></a>
                    <a href="https://twitter.com/intent/tweet?text={article.url_to_share}" target="_blank" class="tw"></a>
                    <a href="https://plus.google.com/share?url={article.url_to_share}" target="_blank" class="gp"></a>
                </div>

                <div class="social2">
                    <a href="" class="print"></a>
                    <a href="mailto:?subject={article.title}&body={article.url_to_share}" class="email"></a>
                </div>
                
                <script>
                    $(document).ready(function(){
                        $('.print').click(function(){
                            window.print();
                            return false;
                        });
                    });
                </script>
                
            </footer>

          
            <div class="comments">
                <h5>{phrases.comments}</h5>
                <div class="list">
                    
                    {block comments no}
                    <p style="margin:10px;text-align:center;">{phrases.no_comments}</p>
                    {-block comments no}
                    
                    {loop comments}
                    <div class="comment-item">
                        <span class="author">{comments.author}</span>
                        <span class="date">{comments.c_date}</span>
                        <p>{comments.title}</p>
                    </div>
                    {-loop comments}
                </div>
                
                <h5>{phrases.comment_form}</h5>
                <form action="index.php?module=forms&amp;method=process&amp;formid=18472" method="post" name="comments" seltype="custom" target="FORMS_IFRAME" style="margin-top:10px;">
                <p><input name="author" type="text" placeholder="{phrases.comment_form_author}" /></p>

                <p><input name="email" type="email" placeholder="{phrases.comment_form_email}" /></p>

                <p><textarea name="title" placeholder="{phrases.comment_form_text}"></textarea></p>

                <p><input name="captcha" placeholder="{phrases.comment_form_captcha}" required="true" style="width:200px" type="text" /><img onclick="javascript: void(resetCaptcha());" rel="captcha" src="index.php?module=forms&amp;method=captcha&amp;w=200&amp;h=70&amp;t=1" style="cursor:pointer;vertical-align:middle;" title="Click to Reset" /></p>
                <input name="category_id" type="hidden" value="{article.id}" />
                <p><input type="submit" value="{phrases.comment_submit}" /></p>
                </form>

            </div>
                
        </article>

</div>
                
                
</div>