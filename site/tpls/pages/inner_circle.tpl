<div id="data_text">

	<div class="contenteditable" id="blocks-description-{page_data.id}">{page_data.page_area.description}</div>
	
</div>

<div id="pagalba" class="block">

    <div class="cont">

        <div class="contenteditable" id="blocks-pagalba-0">{main_blocks.pagalba.description}</div>
        
        <div id="circle-area" class="rel">
            
            <div class="c-link c-link1" rel="c1"><em></em>{phrases.circle_link1}</div>
            <div class="c-link c-link2" rel="c2"><em></em>{phrases.circle_link2}</div>
            <div class="c-link c-link3" rel="c3"><em></em>{phrases.circle_link3}</div>
            <div class="c-link c-link4" rel="c4"><em></em>{phrases.circle_link4}</div>
            <div class="c-link c-link5" rel="c5"><em></em>{phrases.circle_link5}</div>
            <div class="c-link c-link6" rel="c6"><em></em>{phrases.circle_link6}</div>
            <div class="c-link c-link7" rel="c7"><em></em>{phrases.circle_link7}</div>
            <div class="c-link c-link8" rel="c8"><em></em>{phrases.circle_link8}</div>
            
            <div id="circle">
                
                <div id="c1" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle1-0" >{main_blocks.circle1.description}</div>                
                </div>
                <div id="c2" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle2-0" >{main_blocks.circle2.description}</div>                
                </div>
                <div id="c3" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle3-0" >{main_blocks.circle3.description}</div>                
                </div>
                <div id="c4" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle4-0" >{main_blocks.circle4.description}</div>                
                </div>
                <div id="c5" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle5-0" >{main_blocks.circle5.description}</div>                
                </div>
                <div id="c6" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle6-0" >{main_blocks.circle6.description}</div>                
                </div>
                <div id="c7" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle7-0" >{main_blocks.circle7.description}</div>                
                </div>
                <div id="c8" class="c-text hide">
                    <div class="contenteditable" id="blocks-circle8-0" >{main_blocks.circle8.description}</div>                
                </div>
                
            </div>
        
        </div>

<script>
$(document).ready(function(){

    //$('#circle .c-text').attr('contenteditable', true);

    $('.c-link').click(function(){
    
        $('#circle').css('background-image', 'none');
    
        txt_obj = $(this).attr('rel');
        $('.c-text').hide();
        $('#' + txt_obj).show();
        $('.c-link').removeClass('a');
        $(this).addClass('a');
    
    });

});
</script>
                
    </div>

</div>

