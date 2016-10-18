<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <meta http-equiv="pragma" content="no-cache" >
    <title><?php if(TPL::getVar("page_data.id")){ ?><?php echo TPL::getVar("page_data.page_title"); ?><?php } ?><?php if(!TPL::getVar("page_data.id")){ ?><?php echo TPL::getVar("page_settings.page_title"); ?><?php } ?></title>
    <meta name="description" content="<?php echo TPL::getVar("page_data.description"); ?>" >
    <meta name="abstract" content="<?php echo TPL::getVar("page_data.description"); ?>" >
    <meta name="keywords" content="<?php echo TPL::getVar("page_data.keywords"); ?>" >
    <meta name="GOOGLEBOT" content="index,follow" >
    <meta name="ROBOTS" content="index,follow" >
    <meta name="revisit_after" content="3 Days" >
    <meta name="GENERATOR" content="easywebmanager" >
    
    <meta name=viewport content="width=device-width, initial-scale=1" />
    
    <meta property="og:title" content="<?php if(TPL::getVar("page_data.id")){ ?><?php echo TPL::getVar("page_data.page_title"); ?><?php } ?><?php if(!TPL::getVar("page_data.id")){ ?><?php echo TPL::getVar("page_settings.page_title"); ?><?php } ?>" />
    <meta property="og:description" content="<?php echo TPL::getVar("page_data.description"); ?>" />
    
    <?php if(TPL::getVar("page_data.og_image")){ ?>
    <meta property="og:image" content="<?php echo TPL::getVar("page_data.og_image"); ?>" />
    <?php } ?>
        
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <base href="<?php echo TPL::getVar("config.site_url"); ?>" >
    <script src="site/js/jquery.js"></script>
    <script src="site/js/jquery.prettyPhoto.js"></script>
    <script src="site/js/jquery.dd.js"></script>
    <script src="site/js/flux.js"></script>
    
    <script src="site/js/scripts.js"></script>
    
    <style type="text/css">
        <?php echo TPL::getVar("css"); ?>
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
        <?php echo TPL::getVar("javascript"); ?>
            
        var SITE_URL = '<?php echo TPL::getVar("config.site_url"); ?>';
        var CURRENT_URL = '<?php echo TPL::getVar("current_url"); ?>';
            
    </script>
    
    <?php if(TPL::getVar("load_site_js")){ ?>
    <script src="site/js/site.js"></script>
    <?php } ?>
    

</head>
<body>

    
    <div id="top">
        
        <div class="cont rel">
            
            <?php if(TPL::getVar("ESHOP_OPEN")){ ?>
            <div id="cart">
            
                <?php echo TPL::getVar("cart_content"); ?>
            
            </div>
            <?php } ?>
                
            <?php if(TPL::getVar("ESHOP_PRICES")){ ?>
            <div id="curr">

                <select class="dd" name="curr">
                <option selected value="EUR"><?php echo TPL::getVar("phrases.eur"); ?></option>
                </select>

            </div>
            <?php } ?>
            
            <div id="lang">
                
                <select class="dd" name="lang" onchange="javascript: location='<?php echo TPL::getVar("config.site_url"); ?>' + $(this).val(); ">
                <?php $languages_iterator=1; foreach(TPL::getLoop("languages") as $languages_key => $languages_val){ if(!is_array($languages_val)){ $tmp_val=$languages_val; $languages_val=array(); $languages_val['_VALUE']=$tmp_val; } $languages_val['_FIRST']=0; if($languages_iterator==1) $languages_val['_FIRST']=1; if($languages_iterator%2==1) $languages_val['_EVEN']=0; else $languages_val['_EVEN']=1; $languages_val['_INDEX']=$languages_iterator++; $languages_val['_KEY']=$languages_key; ?>
                <option <?php if(isset($languages_val["selected"]) && $languages_val["selected"]){ ?>selected<?php } ?> value="<?php if(isset($languages_val["value"])) echo $languages_val["value"]; ?>" data-image="site/images/<?php if(isset($languages_val["value"])) echo $languages_val["value"]; ?>.gif"><?php if(isset($languages_val["title"])) echo $languages_val["title"]; ?></option>
                <?php } ?>
                </select>
                
            </div>
            
        </div>
        
    </div>    
    
    
    <nav class="cont" id="top_small_menu">
        <ul>
                <?php $bmenu_iterator=1; foreach(TPL::getLoop("bmenu") as $bmenu_key => $bmenu_val){ if(!is_array($bmenu_val)){ $tmp_val=$bmenu_val; $bmenu_val=array(); $bmenu_val['_VALUE']=$tmp_val; } $bmenu_val['_FIRST']=0; if($bmenu_iterator==1) $bmenu_val['_FIRST']=1; if($bmenu_iterator%2==1) $bmenu_val['_EVEN']=0; else $bmenu_val['_EVEN']=1; $bmenu_val['_INDEX']=$bmenu_iterator++; $bmenu_val['_KEY']=$bmenu_key; ?>
                <?php if(!isset($bmenu_val["_FIRST"]) || !$bmenu_val["_FIRST"]){ ?><li>|</li><?php } ?>
                <li <?php if(isset($bmenu_val["selected"]) && $bmenu_val["selected"]){ ?>class="a"<?php } ?>><a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($bmenu_val["page_url"])) echo $bmenu_val["page_url"]; ?>" title="<?php if(isset($bmenu_val["page_title"])) echo $bmenu_val["page_title"]; ?>"><?php if(isset($bmenu_val["title"])) echo $bmenu_val["title"]; ?></a></li>
                <?php } ?>
        </ul>
    </nav>
                
    <header class="cont rel">
    
        <div id="logo">
        
            <div class="contenteditable" id="blocks-logo-0" data-cke="text_plain"><?php echo TPL::getVar("main_blocks.logo.description"); ?></div>
            
        </div>
        
        <div id="search">
        
            <form name="search" action="<?php echo TPL::getVar("search_page.page_url"); ?>">
                <input type="search" name="q" placeholder="<?php echo TPL::getVar("phrases.search_placeholder"); ?>" />
                <input type="submit" value="" />
            </form>
        
        </div>
    
        <div id="phone" class="pm0">
        
            <div class="contenteditable" id="blocks-phone-0"><?php echo TPL::getVar("main_blocks.phone.description"); ?></div>
            
        </div>
        
    </header>

    <nav class="cont" id="top_menu">
        <ul>
                <?php $menu_iterator=1; foreach(TPL::getLoop("menu") as $menu_key => $menu_val){ if(!is_array($menu_val)){ $tmp_val=$menu_val; $menu_val=array(); $menu_val['_VALUE']=$tmp_val; } $menu_val['_FIRST']=0; if($menu_iterator==1) $menu_val['_FIRST']=1; if($menu_iterator%2==1) $menu_val['_EVEN']=0; else $menu_val['_EVEN']=1; $menu_val['_INDEX']=$menu_iterator++; $menu_val['_KEY']=$menu_key; ?>
                <li class="mn_<?php if(isset($menu_val["template"])) echo $menu_val["template"]; ?> <?php if(isset($menu_val["selected"]) && $menu_val["selected"]){ ?>a<?php } ?>">
                    
                    <div class="rel">
                        
                    <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($menu_val["page_url"])) echo $menu_val["page_url"]; ?>" title="<?php if(isset($menu_val["page_title"])) echo $menu_val["page_title"]; ?>"><?php if(isset($menu_val["title"])) echo $menu_val["title"]; ?></a>
                    
                    <?php if(isset($menu_val["sub"]) && $menu_val["sub"]){ ?>
                    <ul>
                        <?php $menu_sub_iterator=1; if(isset($menu_val["sub"])){ foreach($menu_val["sub"] as $menu_sub_key => $menu_sub_val){ if(!is_array($menu_sub_val)){ $tmp_val=$menu_sub_val; $menu_sub_val=array(); $menu_sub_val['_VALUE']=$tmp_val; } $menu_sub_val['_FIRST']=0; if($menu_sub_iterator==1) $menu_sub_val['_FIRST']=1; if($menu_sub_iterator%2==1) $menu_sub_val['_EVEN']=0; else $menu_sub_val['_EVEN']=1; $menu_sub_val['_INDEX']=$menu_sub_iterator++; $menu_sub_val['_KEY']=$menu_sub_key;  ?>
                        <li class="mn_<?php if(isset($menu_sub_val["template"])) echo $menu_sub_val["template"]; ?> <?php if(isset($menu_sub_val["selected"]) && $menu_sub_val["selected"]){ ?>a<?php } ?>">
                            <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($menu_sub_val["page_url"])) echo $menu_sub_val["page_url"]; ?>" title="<?php if(isset($menu_sub_val["page_title"])) echo $menu_sub_val["page_title"]; ?>"><?php if(isset($menu_sub_val["title"])) echo $menu_sub_val["title"]; ?></a>
                        </li>
                        <?php }} ?>
                    </ul>
                    <?php } ?>
                    
                    </div>
                        
                </li>
                <?php } ?>
        </ul>
    </nav>
                
    <section class="cont" id="content">
    
        <?php echo TPL::getVar("page_content"); ?>
    
    </section>
        
    <footer class="cont rel">
        
        <div id="secure" class="pm0">
            <div class="contenteditable" id="blocks-secure-0"><?php echo TPL::getVar("main_blocks.secure.description"); ?></div>
        </div>
        
        <div id="copyrighs" class="pm0">
            <div class="contenteditable" id="blocks-copy-0"><?php echo TPL::getVar("main_blocks.copy.description"); ?></div>
        </div>
        
    </footer>
    
        
<?php echo TPL::getVar("page_settings.google"); ?>
        
</body>
</html>
