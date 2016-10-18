CKEDITOR.dialog.add( 'easy_list', function( editor ) {
    return {
        title: 'Create/Edit List',
        minWidth: 300,
        minHeight: 100,
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
                        label: 'Nuorodų skaičius',
                        setup: function( widget ) {
                            //console.dir();
                            alert($('.easy-list-link', $(widget.element)).size());
                            //this.setValue( widget.element.getStyle('background-color') );
                        },
                        commit: function( widget ) {
                            //console.dir(widget);
                            if(this.getValue())
                                widget.element.setStyle( 'background-color', this.getValue() );
                        }                        
                      
                    }
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