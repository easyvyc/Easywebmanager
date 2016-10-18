/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/**
 * @fileOverview Image plugin
 */

(function() {

	CKEDITOR.plugins.add( 'omega_block', {
		requires: 'widget,dialog',
		lang: 'lt,en', // %REMOVE_LINE_CORE%
		icons: 'omega_block', // %REMOVE_LINE_CORE%
		init: function( editor ) {
			var pluginName = 'omega_block';

			// Register the dialog.
			CKEDITOR.dialog.add( 'omega_block', this.path + 'dialogs/omega_block.js' );

			
                        editor.widgets.add( 'omega_block', {

                            button: 'Create/Edit Block',

                            template:
                                '<div class="omega_block">' +
                                    '<div class="rel cont omega_block-content"><p>Content...</p><p>Content...</p></div>' +
                                '</div>',

                            editables: {
                                content: {
                                    selector: '.omega_block-content'
                                }
                            },

                            allowedContent:
                                'div(!omega_block,align-left,align-right,align-center){height};' +
                                'div(!omega_block-content);',

                            requiredContent: 'div(omega_block)',

                            dialog: 'omega_block',

                            upcast: function( element ) {
                                return element.name == 'div' && element.hasClass( 'omega_block' );
                            },

                            init: function() {
                                var height = this.element.getStyle( 'height' );
                                if ( height )
                                    this.setData( 'height', height );
                            },

                            data: function() {
                                if ( this.data.height == '' )
                                    this.element.removeStyle( 'height' );
                                else
                                    this.element.setStyle( 'height', this.data.height );                                
                            }
                    } );                        
                        
                        
		},
		afterInit: function( editor ) {
			// Customize the behavior of the alignment commands. (#7430)

		}
	});

})();

/**
 * Whether to remove links when emptying the link URL field in the image dialog.
 *
 *		config.image_removeLinkByEmptyURL = false;
 *
 * @cfg {Boolean} [image_removeLinkByEmptyURL=true]
 * @member CKEDITOR.config
 */

/**
 * Padding text to set off the image in preview area.
 *
 *		config.image_previewText = CKEDITOR.tools.repeat( '___ ', 100 );
 *
 * @cfg {String} [image_previewText='Lorem ipsum dolor...' (placeholder text)]
 * @member CKEDITOR.config
 */
