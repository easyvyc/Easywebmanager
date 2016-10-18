CKEDITOR.dialog.add( 'slideshow', function( editor ) {
    return {
        title: editor.lang.slideshow.menu,
        minWidth: 800,
        minHeight: 500,
        contents: [
            {
                id: 'kcfinder',
                elements: [
                    {
                        type:'html',
                        id:'slideshow_content',
                        html: '<iframe id="kc_finder_slideshow_browser" src="' + editor.config.filebrowserImageBrowseUrl + '" style="width: 100%; height: ' + 480 + 'px" hidefocus="true" frameborder="0" ' + '></iframe>'
                    }

                ]
            },
//            {
//                id: 'slideshow_settings',
//                elements: [
//                    {
//                        
//                    }
//                ]
//            }            
        ],
        onOk: function() {
            var dialog = this;
            
            var selection = editor.getSelection();
            var sel_elm = selection.getStartElement();
            
            var edit_mode = (sel_elm.hasClass('easy_slideshow') ? true : false);
            
            var img = {};
            img.h = editor.config.easy_slideshow_img_height;
            img.w = editor.config.easy_slideshow_img_width;
            img.t = editor.config.easy_slideshow_img_type;
            img.opt = editor.config.easy_slideshow_opt;
            img.delay = editor.config.easy_slideshow_delay;
            img.autoplay = editor.config.easy_slideshow_autoplay;
            img.paging = editor.config.easy_slideshow_paging;
            
            kc_iframe = document.getElementById("kc_finder_slideshow_browser").contentWindow;
            var files = kc_iframe.$('.file.selected').get();
            if(files.length){
                var slideshow_html = "";
                if(!edit_mode){
                    var slideshow = editor.document.createElement( 'figure' );
                    slideshow.setAttribute( 'class', 'easy_slideshow' );
                    slideshow_id = 'eg_' + randomString(6);
                    slideshow.setAttribute( 'id', slideshow_id );
                    slideshow.setAttribute( 'data-img-w', img.w );
                    slideshow.setAttribute( 'data-img-h', img.h );
                    slideshow.setAttribute( 'data-img-t', img.t );
                    slideshow.setAttribute( 'data-slide-opt', img.opt );
                    slideshow.setAttribute( 'data-delay', img.delay );
                    slideshow.setAttribute( 'data-autoplay', img.autoplay );
                    slideshow.setAttribute( 'data-pagination', img.paging );
                    slideshow.setAttribute( 'style', 'width:'+img.w+'px;height:'+img.h+'px' );
                }else{
                    slideshow_id = sel_elm.getAttribute('id');
                    if(sel_elm.getAttribute( 'data-img-w')){
                        img.w = sel_elm.getAttribute( 'data-img-w');
                    }
                    if(sel_elm.getAttribute( 'data-img-h')){
                        img.h = sel_elm.getAttribute( 'data-img-h');
                    }
                }
                $.each(files, function(i, cfile) {
                    file_url = kc_iframe.browser.uploadURL + '/' + kc_iframe.browser.dir + '/' + kc_iframe.$(cfile).data('name')
                    slideshow_html += "<img contenteditable=\"false\" src='index.php?module=easy_gallery&method=show_image&w=" + img.w + "&h=" + img.h + "&t=" + img.t + "&f=" + file_url + "' alt='' /></a>";
                });
                if(edit_mode){
                    var html = sel_elm.getHtml();
                    var regex = /<br[^>]*>$/g;
                    html = html.replace(regex, "");
                    var regex = /\&nbsp;$/g;
                    html = html.replace(regex, "");
                    sel_elm.setHtml(html + slideshow_html + "&nbsp;");
                }else{
                    slideshow.setHtml(slideshow_html + "&nbsp;");
                    editor.insertElement(slideshow);
                }
            }else{
                alert(editor.lang.slideshow.not_selected_image);
                return false;
            }
            
        }        
    };
} );


function randomString(len) {
    charSet = 'abcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
    	var randomPoz = Math.floor(Math.random() * charSet.length);
    	randomString += charSet.substring(randomPoz,randomPoz+1);
    }
    return randomString;
}