<div id="attention" class="pm0">
    
    <span class="a" style="display:inline-block;"><?php echo TPL::getVar("phrases.uzmanibu"); ?></span>
    <div class="contenteditable" contenteditable="true" id="blocks-runline-0" style="display:inline-block;"><?php echo TPL::getVar("main_blocks.runline.description"); ?></div>
    
    <div id="social">
        
        <div class="contenteditable" contenteditable="true" id="blocks-social-0"><?php echo TPL::getVar("main_blocks.social.description"); ?></div>

    </div>
    
</div>

<link href="site/js/slider/js-image-slider.css" rel="stylesheet" type="text/css" />
<script src="site/js/slider/js-image-slider.js" type="text/javascript"></script>

<script>
var sliderOptions=
{
	sliderId: "slider",
	startSlide: 0,
	effect: "1,2",
	effectRandom: false,
	pauseTime: 7600,
	transitionTime: 500,
	slices: 12,
	boxes: 8,
	hoverPause: 1,
	autoAdvance: true,
	captionOpacity: 0.3,
	captionEffect: "fade",
	thumbnailsWrapperId: "thumbs",
	m: false,
	license: "b6t80"
};
var imageSlider=new mcImgSlider(sliderOptions);

</script>
    

<div id="flash">
    
    <div id="slider">
        <?php $flash_iterator=1; foreach(TPL::getLoop("flash") as $flash_key => $flash_val){ if(!is_array($flash_val)){ $tmp_val=$flash_val; $flash_val=array(); $flash_val['_VALUE']=$tmp_val; } $flash_val['_FIRST']=0; if($flash_iterator==1) $flash_val['_FIRST']=1; if($flash_iterator%2==1) $flash_val['_EVEN']=0; else $flash_val['_EVEN']=1; $flash_val['_INDEX']=$flash_iterator++; $flash_val['_KEY']=$flash_key; ?>
            <?php if(isset($flash_val["hiperlink"]) && $flash_val["hiperlink"]){ ?><a href="<?php if(isset($flash_val["hiperlink"])) echo $flash_val["hiperlink"]; ?>" target="_blank"><?php } ?>
            <img src="index.php?module=main_images&method=show_image&column=image&id=<?php if(isset($flash_val["id"])) echo $flash_val["id"]; ?>&w=985&h=382&t=landscape" alt="<?php if(isset($flash_val["short_description"])) echo $flash_val["short_description"]; ?>" />
            <?php if(isset($flash_val["hiperlink"]) && $flash_val["hiperlink"]){ ?></a><?php } ?>
        <?php } ?>
    </div>
        
</div>
        

<div class="pm0" id="main_content">
    
    <div class="contenteditable" contenteditable="true" id="blocks-description-<?php echo TPL::getVar("page_data.id"); ?>"><?php echo TPL::getVar("page_data.page_area.description"); ?></div>
    
</div>

    
<div id="main_links">

    <div class="block">
        
        
        <h2><?php echo TPL::getVar("main_link2_page.title"); ?></h2>
        
        <?php $main_link2_iterator=1; foreach(TPL::getLoop("main_link2") as $main_link2_key => $main_link2_val){ if(!is_array($main_link2_val)){ $tmp_val=$main_link2_val; $main_link2_val=array(); $main_link2_val['_VALUE']=$tmp_val; } $main_link2_val['_FIRST']=0; if($main_link2_iterator==1) $main_link2_val['_FIRST']=1; if($main_link2_iterator%2==1) $main_link2_val['_EVEN']=0; else $main_link2_val['_EVEN']=1; $main_link2_val['_INDEX']=$main_link2_iterator++; $main_link2_val['_KEY']=$main_link2_key; ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($main_link2_val["page_url"])) echo $main_link2_val["page_url"]; ?>" title="<?php if(isset($main_link2_val["page_title"])) echo $main_link2_val["page_title"]; ?>"><?php if(isset($main_link2_val["title"])) echo $main_link2_val["title"]; ?></a>
        <?php } ?>
            
    </div>
    
    <div class="block">
        
        <h2><?php echo TPL::getVar("main_link1_page.title"); ?></h2>
        
        <?php $main_link1_iterator=1; foreach(TPL::getLoop("main_link1") as $main_link1_key => $main_link1_val){ if(!is_array($main_link1_val)){ $tmp_val=$main_link1_val; $main_link1_val=array(); $main_link1_val['_VALUE']=$tmp_val; } $main_link1_val['_FIRST']=0; if($main_link1_iterator==1) $main_link1_val['_FIRST']=1; if($main_link1_iterator%2==1) $main_link1_val['_EVEN']=0; else $main_link1_val['_EVEN']=1; $main_link1_val['_INDEX']=$main_link1_iterator++; $main_link1_val['_KEY']=$main_link1_key; ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($main_link1_val["page_url"])) echo $main_link1_val["page_url"]; ?>" title="<?php if(isset($main_link1_val["page_title"])) echo $main_link1_val["page_title"]; ?>"><?php if(isset($main_link1_val["title"])) echo $main_link1_val["title"]; ?></a>
        <?php } ?>
            
    </div>

    <div class="block">
        
        <h2><?php echo TPL::getVar("phrases.subscribers_title"); ?></h2>
        
        <div class="contenteditable" contenteditable="true" id="blocks-subscribers-0"><?php echo TPL::getVar("main_blocks.subscribers.description"); ?></div>
        
    </div>

    <div class="block">

        <h2><?php echo TPL::getVar("main_link3_page.title"); ?></h2>
        
        <?php $main_link3_iterator=1; foreach(TPL::getLoop("main_link3") as $main_link3_key => $main_link3_val){ if(!is_array($main_link3_val)){ $tmp_val=$main_link3_val; $main_link3_val=array(); $main_link3_val['_VALUE']=$tmp_val; } $main_link3_val['_FIRST']=0; if($main_link3_iterator==1) $main_link3_val['_FIRST']=1; if($main_link3_iterator%2==1) $main_link3_val['_EVEN']=0; else $main_link3_val['_EVEN']=1; $main_link3_val['_INDEX']=$main_link3_iterator++; $main_link3_val['_KEY']=$main_link3_key; ?>
        <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($main_link3_val["page_url"])) echo $main_link3_val["page_url"]; ?>" title="<?php if(isset($main_link3_val["page_title"])) echo $main_link3_val["page_title"]; ?>"><?php if(isset($main_link3_val["title"])) echo $main_link3_val["title"]; ?></a>
        <?php } ?>
            
    </div>
        
        
</div>