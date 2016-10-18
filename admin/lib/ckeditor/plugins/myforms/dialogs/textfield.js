/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.dialog.add( 'textfield', function( editor ) {
	var autoAttributes = { value:1,size:1,maxLength:1 };

	var acceptedTypes = { text:1,password:1,email:1,url:1,month:1,range:1,time:1,search:1,date:1,datetime:1,number:1 };

	function autoCommit( data ) {
		var element = data.element;
		var value = this.getValue();

		value ? element.setAttribute( this.id, value ) : element.removeAttribute( this.id );
	}

	function autoSetup( element ) {
		var value = element.hasAttribute( this.id ) && element.getAttribute( this.id );
		this.setValue( value || '' );
	}

	return {
		title: editor.lang.forms.textfield.title,
		minWidth: 350,
		minHeight: 230,
		onShow: function() {
			delete this.textField;

			var element = this.getParentEditor().getSelection().getSelectedElement();
			if ( element && element.getName() == "input" && ( acceptedTypes[ element.getAttribute( 'type' ) ] || !element.getAttribute( 'type' ) ) ) {
				this.textField = element;
				this.setupContent( element );
			}
		},
		onOk: function() {
			var editor = this.getParentEditor(),
				element = this.textField,
				isInsertMode = !element;

			if ( isInsertMode ) {
				element = editor.document.createElement( 'input' );
				element.setAttribute( 'type', 'text' );
			}

			var data = { element: element };

			if ( isInsertMode )
				editor.insertElement( data.element );

			this.commitContent( data );

			// Element might be replaced by commitment.
			if ( !isInsertMode )
				editor.getSelection().selectElement( data.element );
		},
		onLoad: function() {
			this.foreach( function( contentObj ) {
				if ( contentObj.getValue ) {
					if ( !contentObj.setup )
						contentObj.setup = autoSetup;
					if ( !contentObj.commit )
						contentObj.commit = autoCommit;
				}
			});
		},
		contents: [
			{
			id: 'info',
			label: editor.lang.forms.textfield.title,
			title: editor.lang.forms.textfield.title,
			elements: [
				{
				type: 'hbox',
				widths: [ '50%', '50%' ],
				children: [
					{
					id: '_cke_saved_name',
					type: 'text',
					label: editor.lang.forms.textfield.name,
					'default': '',
					accessKey: 'N',
					setup: function( element ) {
						this.setValue( element.data( 'cke-saved-name' ) || element.getAttribute( 'name' ) || '' );
					},
					commit: function( data ) {
						var element = data.element;

						if ( this.getValue() )
							element.data( 'cke-saved-name', this.getValue() );
						else {
							element.data( 'cke-saved-name', false );
							element.removeAttribute( 'name' );
						}
					}
				},
					{
					id: 'value',
					type: 'text',
					label: editor.lang.forms.textfield.value,
					'default': '',
					accessKey: 'V',
					commit: function( data ) {
						if ( CKEDITOR.env.ie && !this.getValue() ) {
							var element = data.element,
								fresh = new CKEDITOR.dom.element( 'input', editor.document );
							element.copyAttributes( fresh, { value:1 } );
							fresh.replace( element );
							data.element = fresh;
						} else
							autoCommit.call( this, data );
					}
				}
				]
			},
			{
				id: 'placeholder',
				type: 'text',
				label: editor.lang.myforms.form.placeholder,
				'default': '',
				style: 'width:100%'
			},			
				{
				type: 'hbox',
				widths: [ '50%', '50%' ],
				children: [
					{
					id: 'size',
					type: 'text',
					label: editor.lang.forms.textfield.charWidth,
					'default': '',
					accessKey: 'C',
					style: 'width:50px',
					validate: CKEDITOR.dialog.validate.integer( editor.lang.common.validateNumberFailed )
				},
					{
					id: 'maxLength',
					type: 'text',
					label: editor.lang.forms.textfield.maxChars,
					'default': '',
					accessKey: 'M',
					style: 'width:50px',
					validate: CKEDITOR.dialog.validate.integer( editor.lang.common.validateNumberFailed )
				}
				],
				onLoad: function() {
					// Repaint the style for IE7 (#6068)
					if ( CKEDITOR.env.ie7Compat )
						this.getElement().setStyle( 'zoom', '100%' );
				}
			},
			
			
			{
				type: 'hbox',
				widths: [ '50%', '50%' ],
				children: [
							{
								id: 'type',
								type: 'select',
								label: editor.lang.forms.textfield.type,
								'default': 'text',
								accessKey: 'M',
								items: [
									[ editor.lang.forms.textfield.typeText, 'text' ],
                                                                        [ editor.lang.myforms.textfield.typeEmail, 'email' ],
                                                                        [ editor.lang.myforms.textfield.typeNumber, 'number' ],
                                                                        [ editor.lang.myforms.textfield.typeSearch, 'search' ],
                                                                        [ editor.lang.myforms.textfield.typeUrl, 'url' ],
                                                                        //[ editor.lang.myforms.textfield.typePhone, 'tel' ],
                                                                        //[ editor.lang.myforms.textfield.typeRange, 'range' ],
                                                                        [ editor.lang.myforms.textfield.typeMonth, 'month' ],
                                                                        //[ editor.lang.forms.textfield.typePhone, 'week' ],
                                                                        [ editor.lang.myforms.textfield.typeTime, 'time' ],
                                                                        [ editor.lang.myforms.textfield.typeDatetime, 'datetime' ],
									[ editor.lang.forms.textfield.typePass, 'password' ]
									],
								setup: function( element ) {
                                                                    console.dir(element);
									this.setValue( element.getAttribute( 'type' ) );
								},
								commit: function( data ) {
									var element = data.element;

									if ( CKEDITOR.env.ie ) {
										var elementType = element.getAttribute( 'type' );
										var myType = this.getValue();

										if ( elementType != myType ) {
											var replace = CKEDITOR.dom.element.createFromHtml( '<input type="' + myType + '"></input>', editor.document );
											element.copyAttributes( replace, { type:1 } );
											replace.replace( element );
											data.element = replace;
										}
									} else
										element.setAttribute( 'type', this.getValue() );
								}
							},
							{
								id: 'class',
								type: 'text',
								label: editor.lang.myforms.form.css_class,
								style: 'width:100%'
							}
				]
			},			
			{
				id: 'style',
				type: 'text',
				label: editor.lang.myforms.form.style,
				'default': '',
				style: 'width:100%'
			}		
			
			]
		}
		]
	};
});
