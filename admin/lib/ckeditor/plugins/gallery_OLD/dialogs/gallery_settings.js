CKEDITOR.dialog.add( 'gallery_settings', function( editor ) {
    
    var autoAttributes = ['data-thumb-w', 'data-thumb-h', 'data-thumb-t', 'data-img-w', 'data-img-h', 'data-img-t']
    
    return {
        title: editor.lang.gallery.btn_gallery_settings,
        minWidth: 400,
        minHeight: 250,
        contents: [
            {
                id: 'settings',
                elements: [
                    {
                        type: 'hbox',
                        widths: [ '50%', '50%' ],
                        children: [
                            {
                                type: 'text',
                                id: 'data-thumb-w',
                                label: editor.lang.gallery.thumb_w_title,
                            },
                            {
                                type: 'text',
                                id: 'data-thumb-h',
                                label: editor.lang.gallery.thumb_h_title,
                            },

                        ],
                        
                    },
                    {
                        type: 'hbox',
                        widths: [ '100%'],
                        children: [
                            {
                                type: 'select',
                                id: 'data-thumb-t',
                                label: editor.lang.gallery.thumb_t_title,
                                default:'landscape',
                                items: [
                                    [ editor.lang.gallery.thumb_t.auto, 'auto' ],
                                    [ editor.lang.gallery.thumb_t.crop, 'crop' ],
                                    [ editor.lang.gallery.thumb_t.landscape, 'landscape' ],
                                    [ editor.lang.gallery.thumb_t.portrait, 'portrait' ],
                                    [ editor.lang.gallery.thumb_t.exact, 'exact' ],
                                ],
                            },
                            
                        ]
                        
                    },
                    {
                        type: 'hbox',
                        widths: [ '50%', '50%' ],
                        children: [
                            {
                                type: 'text',
                                id: 'data-img-w',
                                label: editor.lang.gallery.img_w_title
                            },
                            {
                                type: 'text',
                                id: 'data-img-h',
                                label: editor.lang.gallery.img_h_title
                            },

                        ],
                        
                    },
                    {
                        type: 'hbox',
                        widths: [ '100%'],
                        children: [
                            {
                                type: 'select',
                                id: 'data-img-t',
                                label: editor.lang.gallery.img_t_title,
                                items: [
                                    [ editor.lang.gallery.thumb_t.auto, 'auto' ],
                                    [ editor.lang.gallery.thumb_t.crop, 'crop' ],
                                    [ editor.lang.gallery.thumb_t.landscape, 'landscape' ],
                                    [ editor.lang.gallery.thumb_t.portrait, 'portrait' ],
                                    [ editor.lang.gallery.thumb_t.exact, 'exact' ],
                                ]
                            },
                            
                        ]
                        
                    },
                ]
            },
        ],
        onShow: function() {
            var selection = editor.getSelection();
            var sel_elm = selection.getStartElement();
            this.foreach( function( contentObj ) {
                    if(contentObj.type == 'text' || contentObj.type == 'select'){
                        contentObj.setValue( sel_elm.getAttribute( contentObj.id ) );
                    }
            });
            
        },
        onOk: function() {
            var dialog = this;

            var selection = editor.getSelection();
            var sel_elm = selection.getStartElement();
            var edit_mode = (sel_elm.hasClass('easy_gallery') ? true : false);

            this.foreach( function( contentObj ) {
                    if(contentObj.type == 'text' || contentObj.type == 'select'){
                        sel_elm.setAttribute( contentObj.id, contentObj.getValue() );
                    }
            });
            
            if(edit_mode){
                
                var object = $('<div/>').html(sel_elm.getHtml());
                
                $('a[rel^=lightbox]', object).each(function(){
                    href = $(this).attr('href');
                    params = get_url_query(href);
                    
                    params['w'] = dialog.getValueOf('settings', 'data-img-w');
                    params['h'] = dialog.getValueOf('settings', 'data-img-h');
                    params['t'] = dialog.getValueOf('settings', 'data-img-t');
                    
                    var new_url = "index.php?module=easy_gallery&method=show_image&w="+params['w']+"&h="+params['h']+"&t="+params['t']+"&f="+params['f'];
                    
                    $(this).attr('href', new_url);
                    $(this).attr('data-cke-saved-href', new_url);
                    
                    var img = $('img', $(this));
                    
                    if(img){
                        var src = img.attr('src');
                        params = get_url_query(src);

                        params['w'] = dialog.getValueOf('settings', 'data-thumb-w');
                        params['h'] = dialog.getValueOf('settings', 'data-thumb-h');
                        params['t'] = dialog.getValueOf('settings', 'data-thumb-t');

                        var src = "index.php?module=easy_gallery&method=show_image&w="+params['w']+"&h="+params['h']+"&t="+params['t']+"&f="+params['f'];

                        img.attr('src', src);
                        img.attr('data-cke-saved-src', src);
                        
                    }
                    
                    //$(this).attr('href', href);
                });
                
                sel_elm.setHtml(object.html());
                
            }
            
        }        
    };
} );

function get_url_query(url){
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}