CKEDITOR.dialog.add( 'slideshow_settings', function( editor ) {
    
    var autoAttributes = ['data-img-w', 'data-img-h', 'data-img-t']
    
    return {
        title: editor.lang.slideshow.btn_slideshow_settings,
        minWidth: 400,
        minHeight: 200,
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
                                id: 'data-img-w',
                                label: editor.lang.slideshow.img_w_title
                            },
                            {
                                type: 'text',
                                id: 'data-img-h',
                                label: editor.lang.slideshow.img_h_title
                            },

                        ],
                        
                    },
                    {
                        type: 'hbox',
                        widths: [ '50%', '50%' ],
                        children: [
                            {
                                type: 'text',
                                id: 'data-delay',
                                label: editor.lang.slideshow.delay
                            },
                            {
                                type: 'select',
                                id: 'data-slide-opt',
                                label: editor.lang.slideshow.opt,
                                items: [
                                    [ editor.lang.slideshow.slide_opt.bars, 'bars' ],
                                    [ editor.lang.slideshow.slide_opt.zip, 'zip' ],
                                    [ editor.lang.slideshow.slide_opt.blinds, 'blinds' ],
                                    [ editor.lang.slideshow.slide_opt.blocks, 'blocks' ],
                                    [ editor.lang.slideshow.slide_opt.concentric, 'concentric' ],
                                    [ editor.lang.slideshow.slide_opt.warp, 'warp' ],
                                    [ editor.lang.slideshow.slide_opt.slide, 'slide' ],
                                    [ editor.lang.slideshow.slide_opt.swipe, 'swipe' ],
                                    [ editor.lang.slideshow.slide_opt.dissolve, 'dissolve' ],
                                    [ editor.lang.slideshow.slide_opt.blocks2, 'blocks2' ],
                                    [ editor.lang.slideshow.slide_opt.bars3d, 'bars3d' ],
                                    [ editor.lang.slideshow.slide_opt.cube, 'cube' ],
                                    [ editor.lang.slideshow.slide_opt.tiles3d, 'tiles3d' ],
                                    [ editor.lang.slideshow.slide_opt.blinds3d, 'blinds3d' ],
                                    [ editor.lang.slideshow.slide_opt.turn, 'turn' ],
                                ]
                            },

                        ],
                        
                    },                    
                    {
                        type: 'hbox',
                        widths: [ '50%', '50%' ],
                        children: [
                            {
                                type: 'checkbox',
                                id: 'data-autoplay',
                                label: editor.lang.slideshow.autoplay
                            },
                            {
                                type: 'checkbox',
                                id: 'data-links',
                                label: editor.lang.slideshow.links,
                            },

                        ],
                        
                    },
                    {
                        type: 'hbox',
                        widths: [ '50%', '50%' ],
                        children: [
                            {
                                type: 'checkbox',
                                id: 'data-controls',
                                label: editor.lang.slideshow.controls,
                            },
                            {
                                type: 'select',
                                id: 'data-pagination',
                                label: editor.lang.slideshow.paging_type.title,
                                items: [
                                    [ editor.lang.slideshow.paging_type.none, 'none' ],
                                    [ editor.lang.slideshow.paging_type.empty, 'empty' ],
                                    [ editor.lang.slideshow.paging_type.number, 'number' ],
                                    [ editor.lang.slideshow.paging_type.thumb, 'thumb' ],
                                    [ editor.lang.slideshow.paging_type.text, 'text' ]
                                ]
                            },

                        ],
                        
                    },
                    
                ]
            },
        ],
        onShow: function() {
            var selection = editor.getSelection();
            var sel_elm = selection.getStartElement();
            
            if(sel_elm.getName() != 'figure'){
                figure_elm = sel_elm.getAscendant('figure', true);
                if(figure_elm){
                    sel_elm = figure_elm;
                }else{
                    CKEDITOR.dialog.getCurrent().hide();
                }
            }
            
            this.foreach( function( contentObj ) {
                    if(contentObj.type == 'text' || contentObj.type == 'select'){
                        contentObj.setValue( sel_elm.getAttribute( contentObj.id ) );
                    }
                    if(contentObj.type == 'checkbox'){
                        contentObj.setValue( sel_elm.getAttribute( contentObj.id ) == 'true' ? "1" : "" );
                    }
            });
            
        },
        onOk: function() {
            var dialog = this;

            var selection = editor.getSelection();
            var sel_elm = selection.getStartElement();
            
            if(sel_elm.getName() != 'figure'){
                figure_elm = sel_elm.getAscendant('figure', true);
                if(figure_elm){
                    sel_elm = figure_elm;
                }
            }
            
            var edit_mode = (sel_elm.hasClass('easy_slideshow') ? true : false);

            this.foreach( function( contentObj ) {
                    if(contentObj.type == 'text' || contentObj.type == 'select' || contentObj.type == 'checkbox'){
                        sel_elm.setAttribute( contentObj.id, contentObj.getValue() );
                    }
            });
            
            sel_elm.setAttribute('style', 'width:'+dialog.getValueOf('settings', 'data-img-w')+'px;height:'+dialog.getValueOf('settings', 'data-img-h')+'px');
            
            if(edit_mode){
                
                var object = $('<div/>').html(sel_elm.getHtml());
                
                $('img', object).each(function(){
                    var src = $(this).attr('src');
                    params = get_url_query(src);

                    params['w'] = dialog.getValueOf('settings', 'data-img-w');
                    params['h'] = dialog.getValueOf('settings', 'data-img-h');
                    
                    var src = "index.php?module=easy_gallery&method=show_image&w="+params['w']+"&h="+params['h']+"&t=crop&f="+params['f'];
                    var link = "index.php?module=easy_gallery&method=show_image&w=1000&h=1000&t=auto&f="+params['f'];

                    $(this).attr('data-link', link);
                    $(this).attr('src', src);
                    $(this).attr('data-cke-saved-src', src);
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