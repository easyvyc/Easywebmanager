<div id="attention" class="pm0">

    <nav id="path">
        
        <a href="<?php echo TPL::getVar("main_page.page_url"); ?>" title="<?php echo TPL::getVar("main_page.page_title"); ?>"><?php echo TPL::getVar("main_page.title"); ?></a>
        
        <?php $path_iterator=1; foreach(TPL::getLoop("path") as $path_key => $path_val){ if(!is_array($path_val)){ $tmp_val=$path_val; $path_val=array(); $path_val['_VALUE']=$tmp_val; } $path_val['_FIRST']=0; if($path_iterator==1) $path_val['_FIRST']=1; if($path_iterator%2==1) $path_val['_EVEN']=0; else $path_val['_EVEN']=1; $path_val['_INDEX']=$path_iterator++; $path_val['_KEY']=$path_key; ?>
        <?php if(!isset($path_val["_FIRST"]) || !$path_val["_FIRST"]){ ?>
        &nbsp;&nbsp;<img src="site/images/p.png" alt="" class="vam" />&nbsp;&nbsp;
        <a href="<?php if(isset($path_val["page_url"])) echo $path_val["page_url"]; ?>" title="<?php if(isset($path_val["page_title"])) echo $path_val["page_title"]; ?>"><?php if(isset($path_val["title"])) echo $path_val["title"]; ?></a>
        <?php } ?>
        <?php } ?>
    </nav>
    
    <div id="social">
        
        <div class="contenteditable" contenteditable="true" id="blocks-social-0"><?php echo TPL::getVar("main_blocks.social.description"); ?></div>
        
    </div>
    
</div>    

<div id="inner_content" class="overflow">
    
    <?php echo TPL::getVar("inner_menu_content"); ?>
            
    <article <?php if(!TPL::getVar("inner_menu")){ ?>class="no_inner_menu"<?php } ?>>
    
        <h1 class="title"><?php echo TPL::getVar("page_data.header_title"); ?></h1>
        
        <div class="contenteditable" id="blocks-description-<?php echo TPL::getVar("page_data.id"); ?>"><?php echo TPL::getVar("page_data.page_area.description"); ?></div>
        
    </article>
    
</div>    

