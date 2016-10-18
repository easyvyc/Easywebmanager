<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <meta http-equiv="pragma" content="no-cache" >
    <title>{block page_data.id}{page_data.page_title}{-block page_data.id}{block page_data.id no}{page_settings.page_title}{-block page_data.id no}</title>
    <meta name="description" content="{page_data.description}" >
    <meta name="abstract" content="{page_data.description}" >
    <meta name="keywords" content="{page_data.keywords}" >
    <meta name="GOOGLEBOT" content="index,follow" >
    <meta name="ROBOTS" content="index,follow" >
    <meta name="revisit_after" content="3 Days" >
    <meta name="GENERATOR" content="easywebmanager" >
    
    <meta name=viewport content="width=device-width, initial-scale=1" />
    
    <meta property="og:title" content="{block page_data.id}{page_data.page_title}{-block page_data.id}{block page_data.id no}{page_settings.page_title}{-block page_data.id no}" />
    <meta property="og:description" content="{page_data.description}" />
    
    {block page_data.og_image}
    <meta property="og:image" content="{page_data.og_image}" />
    {-block page_data.og_image}
        
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <base href="{config.site_url}" >
    <script src="site/js/jquery.js"></script>
    <script src="site/js/jquery.prettyPhoto.js"></script>
    <script src="site/js/jquery.dd.js"></script>
    <script src="site/js/flux.js"></script>
    
    <script src="site/js/scripts.js"></script>
    
    <style type="text/css">
        {css}
    </style>
    

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--[if lt IE 9]>
      <script type="text/javascript" src="js/PIE2/PIE_IE678.js"></script>
    <![endif]-->
    <!--[if IE 9]>
      <script type="text/javascript" src="js/PIE2/PIE_IE9.js"></script>
    <![endif]-->

    <script type="text/javascript">
        {javascript}
            
        var SITE_URL = '{config.site_url}';
        var CURRENT_URL = '{current_url}';
            
    </script>
    
    {block load_site_js}
    <script src="site/js/site.js"></script>
    {-block load_site_js}
    

</head>
<body>

    
    <div id="top">
        
        <div class="cont rel">
            
            {block ESHOP_OPEN}
            <div id="cart">
            
                {cart_content}
            
            </div>
            {-block ESHOP_OPEN}
                
            {block ESHOP_PRICES}
            <div id="curr">

                <select class="dd" name="curr">
                <option selected value="EUR">{phrases.eur}</option>
                </select>

            </div>
            {-block ESHOP_PRICES}
            
            <div id="lang">
                
                <select class="dd" name="lang" onchange="javascript: location='{config.site_url}' + $(this).val(); ">
                {loop languages}
                <option {block languages.selected}selected{-block languages.selected} value="{languages.value}" data-image="site/images/{languages.value}.gif">{languages.title}</option>
                {-loop languages}
                </select>
                
            </div>
            
        </div>
        
    </div>    
    
    
    <nav class="cont" id="top_small_menu">
        <ul>
                {loop bmenu}
                {block bmenu._FIRST no}<li>|</li>{-block bmenu._FIRST no}
                <li {block bmenu.selected}class="a"{-block bmenu.selected}><a href="{lng}{bmenu.page_url}" title="{bmenu.page_title}">{bmenu.title}</a></li>
                {-loop bmenu}
        </ul>
    </nav>
                
    <header class="cont rel">
    
        <div id="logo">
        
            <div class="contenteditable" id="blocks-logo-0" data-cke="text_plain">{main_blocks.logo.description}</div>
            
        </div>
        
        <div id="search">
        
            <form name="search" action="{search_page.page_url}">
                <input type="search" name="q" placeholder="{phrases.search_placeholder}" />
                <input type="submit" value="" />
            </form>
        
        </div>
    
        <div id="phone" class="pm0">
        
            <div class="contenteditable" id="blocks-phone-0">{main_blocks.phone.description}</div>
            
        </div>
        
    </header>

    <nav class="cont" id="top_menu">
        <ul>
                {loop menu}
                <li class="mn_{menu.template} {block menu.selected}a{-block menu.selected}">
                    
                    <div class="rel">
                        
                    <a href="{lng}{menu.page_url}" title="{menu.page_title}">{menu.title}</a>
                    
                    {block menu.sub}
                    <ul>
                        {loop menu.sub}
                        <li class="mn_{menu.sub.template} {block menu.sub.selected}a{-block menu.sub.selected}">
                            <a href="{lng}{menu.sub.page_url}" title="{menu.sub.page_title}">{menu.sub.title}</a>
                        </li>
                        {-loop menu.sub}
                    </ul>
                    {-block menu.sub}
                    
                    </div>
                        
                </li>
                {-loop menu}
        </ul>
    </nav>
                
    <section class="cont" id="content">
    
        {page_content}
    
    </section>
        
    <footer class="cont rel">
        
        <div id="secure" class="pm0">
            <div class="contenteditable" id="blocks-secure-0">{main_blocks.secure.description}</div>
        </div>
        
        <div id="copyrighs" class="pm0">
            <div class="contenteditable" id="blocks-copy-0">{main_blocks.copy.description}</div>
        </div>
        
    </footer>
    
        
{page_settings.google}
        
</body>
</html>
