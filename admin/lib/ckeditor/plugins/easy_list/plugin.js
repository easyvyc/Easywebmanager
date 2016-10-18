/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/**
 * @fileOverview Image plugin
 */

(function() {

//        var myCommand = {
//           label : "My Command label",
//           command : 'myCommand',
//           group : 'image'
//        };
//
//
//        CKEDITOR.contextMenu.addListener( function( element, selection ) {
//           return { 
//              myCommand : CKEDITOR.TRISTATE_OFF 
//           };
//        });
//
//        CKEDITOR.addMenuItems({
//           myCommand : {
//              label : "My Command label",
//              command : 'myCommand',
//              group : 'image',
//              order : 1
//        }});


	CKEDITOR.plugins.add( 'easy_list', {
		requires: 'widget',
		icons: 'easy_list', // %REMOVE_LINE_CORE%
		init: function( editor ) {
			var pluginName = 'easy_list';

			// Register the dialog.
			//CKEDITOR.dialog.add( 'easy_list', this.path + 'dialogs/easy_list.js' );

			
                        editor.widgets.add( 'easy_list', {

                            button: 'Add List Item',

                            template:'<div class="easy-list-item"><div class="easy-list-link">Link Here</div><div class="easy-list-content"><p>Content here...</p></div></div>',

                            editables: {
                                link: {
                                    selector: '.easy-list-link',
                                    allowedContent: 'strong em b u i span'
                                },
                                content: {
                                    selector: '.easy-list-content',
                                    allowedContent: 'br strong em b u i p'
                                }
                            },

                            upcast: function( element ) {
                            },

                            init: function() {
                            },

                            data: function() {
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
