CKEDITOR.dialog.add( 'gallery', function( editor ) {
    return {
        title: editor.lang.gallery.menu,
        minWidth: 800,
        minHeight: 500,
        contents: [
            {
                id: 'kcfinder',
                elements: [
                    {
                        type:'html',
                        id:'gallery_content',
                        html: '<iframe id="kc_finder_gallery_browser" src="' + editor.config.filebrowserImageBrowseUrl + '" style="width: 100%; height: ' + 480 + 'px" hidefocus="true" frameborder="0" ' + '></iframe>'
                    }

                ]
            },
//            {
//                id: 'gallery_settings',
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
            
            var edit_mode = (sel_elm.hasClass('easy_gallery') ? true : false);
            
            var thumb = {};
            thumb.h = editor.config.easy_gallery_thumb_height;
            thumb.w = editor.config.easy_gallery_thumb_width;
            thumb.t = editor.config.easy_gallery_thumb_type;

            var img = {};
            img.h = editor.config.easy_gallery_img_height;
            img.w = editor.config.easy_gallery_img_width;
            img.t = editor.config.easy_gallery_img_type;
            
            kc_iframe = document.getElementById("kc_finder_gallery_browser").contentWindow;
            var files = kc_iframe.$('.file.selected').get();
            if(files.length){
                var gallery_html = "";
                if(!edit_mode){
                    var gallery = editor.document.createElement( 'figure' );
                    gallery.setAttribute( 'class', 'easy_gallery' );
                    gallery_id = 'eg_' + randomString(6);
                    gallery.setAttribute( 'id', gallery_id );
                    gallery.setAttribute( 'data-thumb-w', thumb.w );
                    gallery.setAttribute( 'data-thumb-h', thumb.h );
                    gallery.setAttribute( 'data-thumb-t', thumb.t );
                    gallery.setAttribute( 'data-img-w', img.w );
                    gallery.setAttribute( 'data-img-h', img.h );
                    gallery.setAttribute( 'data-img-t', img.t );
                }else{
                    gallery_id = sel_elm.getAttribute('id');
                    if(sel_elm.getAttribute( 'data-thumb-w')){
                        thumb.w = sel_elm.getAttribute( 'data-thumb-w');
                    }
                    if(sel_elm.getAttribute( 'data-thumb-h')){
                        thumb.h = sel_elm.getAttribute( 'data-thumb-h');
                    }
                    if(sel_elm.getAttribute( 'data-thumb-t')){
                        thumb.t = sel_elm.getAttribute( 'data-thumb-t');
                    }
                    if(sel_elm.getAttribute( 'data-img-w')){
                        img.w = sel_elm.getAttribute( 'data-img-w');
                    }
                    if(sel_elm.getAttribute( 'data-img-h')){
                        img.h = sel_elm.getAttribute( 'data-img-h');
                    }
                    if(sel_elm.getAttribute( 'data-img-t')){
                        img.t = sel_elm.getAttribute( 'data-img-t');
                    }
                }
                $.each(files, function(i, cfile) {
                    file_url = kc_iframe.browser.uploadURL + '/' + kc_iframe.browser.dir + '/' + kc_iframe.$(cfile).data('name')
                    gallery_html += "<a href='index.php?module=easy_gallery&method=show_image&w=" + img.w + "&h=" + img.h + "&t=" + img.t + "&f=" + file_url + "' rel='lightbox[" + gallery_id + "]' title=''><img src='index.php?module=easy_gallery&method=show_image&w=" + thumb.w + "&h=" + thumb.h + "&t=" + thumb.t + "&f=" + file_url + "' alt='' /></a>";
                });
                if(edit_mode){
                    var html = sel_elm.getHtml();
                    var regex = /<br[^>]*>$/g;
                    html = html.replace(regex, "");
                    var regex = /\&nbsp;$/g;
                    html = html.replace(regex, "");
                    sel_elm.setHtml(html + gallery_html + "&nbsp;");
                }else{
                    gallery.setHtml(gallery_html + "&nbsp;");
                    editor.insertElement(gallery);
                }
            }else{
                alert(editor.lang.gallery.not_selected_image);
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