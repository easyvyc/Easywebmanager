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
<body class="grey_page">
        <div class="cont">
        
            <div class="contenteditable" id="blocks-description-{page_data.id}">{page_data.page_area.description}</div>
        
        </div>
    
</body>
</html>
