<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <meta http-equiv="pragma" content="no-cache" >
    <title>{block page_data.id}{page_data.page_title}{-block page_data.id}{block page_data.id no}{site.title}{-block page_data.id no}</title>
    <meta name="description" content="{page_data.description}" >
    <meta name="abstract" content="{page_data.description}" >
    <meta name="keywords" content="{page_data.keywords}" >
    <meta name="GOOGLEBOT" content="index,follow" >
    <meta name="ROBOTS" content="index,follow" >
    <meta name="revisit_after" content="3 Days" >
    <meta name="GENERATOR" content="easywebmanager" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <base href="{config.site_url}" >
    <script src="site/js/jquery.js"></script>
    <script src="site/js/jquery.prettyPhoto.js"></script>
    <script src="site/js/scripts.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,latin-ext,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <style type="text/css">
        {css}
    </style>
    {loop rss}
    <link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php?module={rss.table_name}&amp;lng={lng}" >
    {-loop rss}

    {xml_config.google}
</head>
<body>
    <div id="main">
        <div class="navbar">
          <header id="top">
            <div class="cont">
              <div class="logo">
                <div class="contenteditable" contenteditable="true" id="blocks-logo-0">{main_blocks.logo.description}</div>
            </div>
            <nav class="menu">
                <ul>
                  {loop menu}
                  <li class="{block menu.selected} a{-block menu.selected}"> <a href="{lng}{menu.page_url}" title="{menu.page_title}">{menu.title} {block menu.sub}<span class="fa fa-caret-down"></span>{-block menu.sub}</a> {block menu.sub}
                    <ul>
                      {loop menu.sub}
                      <li> <a href="{lng}{menu.sub.page_url}" title="{menu.sub.page_title}">{menu.sub.title}</a> </li>
                      {-loop menu.sub}
                  </ul>
                  {-block menu.sub} </li>
                  {-loop menu}
              </ul>
          </nav>
          <div class="login"> <a href="#"><span class="fa fa-key"></span>&nbsp;{phrases.login}</a> <a href="#"><span class="fa fa-user"></span>&nbsp;{phrases.register}</a> </div>
          <div class="clear"></div>
      </div>
  </header>
  <header id="header_product">
    <div class="cont">
      <div class="logo">
        <div><a href="."><img alt="" src="files/Main/images/omega-3-logo.png" style="width: 193px; height: 43px;"></a></div>
    </div>
    <nav class="menu">
        <ul>
          {loop productmenu}
          <li class="{block productmenu.selected}active{-block productmenu.selected}"> <a href="{lng}{productmenu.page_url}" title="{productmenu.page_title}">{productmenu.title} {block productmenu.sub}<span class="fa fa-caret-down"></span>{-block productmenu.sub}</a>  {block productmenu.sub}
            <ul>
              {loop productmenu.sub}
              <li> <a href="{lng}{productmenu.sub.page_url}" title="{productmenu.sub.page_title}">{productmenu.sub.title}</a> </li>
              {-loop productmenu.sub}
          </ul>
          {-block productmenu.sub} </li>
          {-loop productmenu}
      </ul>
  </nav>
  <a href="#" class="buy-btn">{phrases.buy}</a>
  <div class="clear"></div>
</div>
</header>
</div>
<div id="content"> {page_content} </div>
<div id="abejones">
    <div class="cont">
      <div class="contenteditable" contenteditable="true" id="blocks-abejones-0">{main_blocks.abejones.description}</div>
  </div>
</div>
<div id="kaps" class="block">
    <div class="cont">
      <div class="contenteditable" contenteditable="true" id="blocks-buy_bottom-0">{main_blocks.buy_bottom.description}</div>
  </div>
</div>
<footer id="bottom">
    <div class="cont">{phrases.copyrights}</div>
</footer>
</div>
</body>
</html>
