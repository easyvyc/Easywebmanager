/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.dialog.add( 'captcha', function( editor ) {
	return {
		title: editor.lang.myforms.captcha.title,
		minWidth: 350,
		minHeight: 110,
		onShow: function() {
			var editor = this.getParentEditor(),
				selection = editor.getSelection(),
				element = selection.getSelectedElement();
		},
		onOk: function() {
			var editor,
				element = this.textarea,
				isInsertMode = !element;
                        
                        if ( isInsertMode ) {
				editor = this.getParentEditor();
				element = editor.document.createElement( 'input' );
                                element.setAttribute( 'type', 'text' );
                                element.setAttribute( 'name', 'captcha' );
                                element.setAttribute( 'required', true );
                                element.setAttribute( 'style', 'width:100px' );
				img = editor.document.createElement( 'img' );
                                img.setAttribute( 'src', 'index.php?module=forms&method=captcha&w=' + this.getValueOf('info', 'width') + '&h=' + this.getValueOf('info', 'height') + '&t=' + (this.getValueOf('info', 'transparent') ? 1 : 0));
                                img.setAttribute( 'rel', 'captcha');
                                img.setAttribute( 'title', 'Click to Reset');
                                img.setAttribute( 'style', 'cursor:pointer;');
                                img.setAttribute( 'onclick', 'javascript: void(resetCaptcha());');
			}
			this.commitContent( element );

			if ( isInsertMode ){
                        	editor.insertElement( element );
                                editor.insertElement( img );
                        }
			
			return true;
		},
		contents: [
			{
			id: 'info',
			label: editor.lang.myforms.captcha.title,
			title: editor.lang.myforms.captcha.title,
			elements: [
				{
				id: 'placeholder',
				type: 'text',
				label: editor.lang.myforms.form.placeholder,
				'default': '',
				accessKey: 'V',
				setup: function( element ) {
					this.setValue( element.getAttribute( 'placeholder' ) || '' );
				},
				commit: function( element ) {
					if ( this.getValue() )
						element.setAttribute( 'placeholder', this.getValue() );
					else
						element.removeAttribute( 'placeholder' );
				}
                                },
                                {
					type: 'hbox',
					widths: [ '50%', '50%' ],
					children: [
                                                    {
                                                    id: 'width',
                                                    type: 'text',
                                                    label: editor.lang.myforms.captcha.width,
                                                    'default': '200',
                                                    },
                                                    {
                                                    id: 'height',
                                                    type: 'text',
                                                    label: editor.lang.myforms.captcha.height,
                                                    'default': '70',
                                                    }                                    
                                        ]                            
                                },
				{
				id: 'transparent',
				type: 'checkbox',
				label: editor.lang.myforms.captcha.transparent,
				'default': '1',
                                }                                
			]
		}
		]
	};
});
