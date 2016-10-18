CKEDITOR.dialog.add( 'omega_block', function( editor ) {
    return {
        title: 'Create/Edit Block',
        minWidth: 500,
        minHeight: 300,
        contents: [
            {
                id: 'info',
                elements: [
                    {
                        type: 'text',
                        id: 'color',
                        // v-align with the 'txtUrl' field.
                        // TODO: We need something better than a fixed size here.
                        style: 'display:inline-block;margin-top:10px;',
                        align: 'center',
                        label: 'Fono spalva',
                        setup: function( widget ) {
                            this.setValue(  widget.element.getStyle('background-color') );
                        },
                        commit: function( widget ) {
                            //console.dir(widget);
                            if(this.getValue())
                                widget.element.setStyle( 'background-color', this.getValue() );
                        }                        
                      
                    },
                    {
                        type: 'button',
                        id: 'browse',
                        // v-align with the 'txtUrl' field.
                        // TODO: We need something better than a fixed size here.
                        style: 'display:inline-block;margin-top:10px;',
                        align: 'center',
                        label: editor.lang.common.browseServer,
                        hidden: !0,
                        filebrowser: {action: "Browse", target: "info:link", url: editor.config.filebrowserImageBrowseUrl },
                        
                    },
                    {
                        type: 'text',
                        id: 'link',
                        // v-align with the 'txtUrl' field.
                        // TODO: We need something better than a fixed size here.
                        style: 'display:inline-block;margin-top:10px;',
                        align: 'center',
                        label: 'Fono iliustracijos url',
                        setup: function( widget ) {
                            bgr = widget.element.getStyle('background-image');
                            bgr = bgr.substring(5, bgr.length - 2);
                            this.setValue( bgr );
                        },
                        commit: function( widget ) {
                            //console.dir(widget);
                            //alert(this.getValue());
                            if(this.getValue())
                                widget.element.setStyle( 'background-image', "url(" + this.getValue() + ")" );
                        }                        
                    },
                    {
                        type: 'text',
                        id: 'height',
                        // v-align with the 'txtUrl' field.
                        // TODO: We need something better than a fixed size here.
                        style: 'display:inline-block;margin-top:10px;',
                        align: 'center',
                        label: 'Aukštis',
                        setup: function( widget ) {
                            this.setValue(  parseInt(widget.element.getStyle('height')) );
                        },
                        commit: function( widget ) {
                            //console.dir(widget);
                            if(this.getValue())
                                widget.element.setStyle( 'height', this.getValue() + 'px' );
                        }                        
                    },
                    

                ]
            }            
        ],
        onOk: function() {
            var dialog = this;
            
            
//
//            var gallery = editor.document.createElement( 'div' );
//            gallery.setAttribute( 'title', dialog.getValueOf( 'tab-basic', 'title' ) );
//            gallery.setText( dialog.getValueOf( 'tab-basic', 'abbr' ) );
//
//            var id = dialog.getValueOf( 'tab-adv', 'id' );
//            if ( id )
//                abbr.setAttribute( 'id', id );
//
//            editor.insertElement( gallery );
        }        
    };
} );