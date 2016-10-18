<div id="attention" class="pm0">
    
    <span class="a" style="display:inline-block;">{phrases.uzmanibu}</span>
    <div class="contenteditable" contenteditable="true" id="blocks-runline-0" style="display:inline-block;">{main_blocks.runline.description}</div>
    
    <div id="social">
        
        <div class="contenteditable" contenteditable="true" id="blocks-social-0">{main_blocks.social.description}</div>

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
        {loop flash}
            {block flash.hiperlink}<a href="{flash.hiperlink}" target="_blank">{-block flash.hiperlink}
            <img src="index.php?module=main_images&method=show_image&column=image&id={flash.id}&w=985&h=382&t=landscape" alt="{flash.short_description}" />
            {block flash.hiperlink}</a>{-block flash.hiperlink}
        {-loop flash}
    </div>
        
</div>
        

<div class="pm0" id="main_content">
    
    <div class="contenteditable" contenteditable="true" id="blocks-description-{page_data.id}">{page_data.page_area.description}</div>
    
</div>

    
<div id="main_links">

    <div class="block">
        
        
        <h2>{main_link2_page.title}</h2>
        
        {loop main_link2}
        <a href="{lng}{main_link2.page_url}" title="{main_link2.page_title}">{main_link2.title}</a>
        {-loop main_link2}
            
    </div>
    
    <div class="block">
        
        <h2>{main_link1_page.title}</h2>
        
        {loop main_link1}
        <a href="{lng}{main_link1.page_url}" title="{main_link1.page_title}">{main_link1.title}</a>
        {-loop main_link1}
            
    </div>

    <div class="block">
        
        <h2>{phrases.subscribers_title}</h2>
        
        <div class="contenteditable" contenteditable="true" id="blocks-subscribers-0">{main_blocks.subscribers.description}</div>
        
    </div>

    <div class="block">

        <h2>{main_link3_page.title}</h2>
        
        {loop main_link3}
        <a href="{lng}{main_link3.page_url}" title="{main_link3.page_title}">{main_link3.title}</a>
        {-loop main_link3}
            
    </div>
        
        
</div>