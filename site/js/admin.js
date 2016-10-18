var ck_toolbars = { 
    //uiColor: '#FF69B4', 
    text_plain: {
        toolbar: [
            [ 'AjaxSave','Sourcedialog' ]
        ]
    },
    text_html: {
        toolbar: [
            [ 
                ['AjaxSave','Sourcedialog'], 
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                ['Link','Unlink','Anchor'],
                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                ['Styles','Format','Font','FontSize'],
                ['TextColor','BGColor']
            ]
        ]
    },
    image: {
        toolbar: [
            [ 'AjaxSave','Sourcedialog' ],
            ['Image']
        ]
    },
    gallery: {
        toolbar: [
            [ 'AjaxSave','Sourcedialog' ],
            ['gallery']
        ]
    },
    slideshow: {
        toolbar: [
            [ 'AjaxSave','Sourcedialog' ],
            ['slideshow']
        ]
    },
    map: {
        toolbar: [
            [ 'AjaxSave','Sourcedialog' ],
            ['easy_maps']
        ]
    },
    
    
};

$(document).ready(function () {

	$('a').click(function(){ 
		return false; 
	}); 

	$('[onclick]').click(function(){ 
		return false; 
	}); 

	$('form').submit(function(){ 
		return false; 
	});
        
//        $('.contenteditable').click(function(){
//            $(this).attr('contenteditable', true);
//        })
	
	//$('.cke').draggable();
        
        //destroyEditorInstances();
        //CKEDITOR.inlineAll();
        
        $('.contenteditable').each(function(){
            $(this).attr('contenteditable', true);
            var toolbar = $(this).attr('data-cke');
            if(toolbar){
                CKEDITOR.inline( $(this).attr('id'), ck_toolbars[toolbar] );
            }else{
                CKEDITOR.inline( $(this).attr('id') );
            }
        });
        
        $('.hide').hide(500);

});

function destroyEditorInstances() {
    for (var instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].destroy();
    }
}
