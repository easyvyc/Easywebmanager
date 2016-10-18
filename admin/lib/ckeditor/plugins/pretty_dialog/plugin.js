/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/**
 * @fileOverview Gallery plugin
 */

CKEDITOR.plugins.add( 'pretty_dialog', {
        requires: 'dialog,fakeobjects',
        lang: 'lt,en', // %REMOVE_LINE_CORE%
        icons: 'gallery', // %REMOVE_LINE_CORE%
        onLoad: function() {
                CKEDITOR.addCss( '.cke_editable .easy_gallery:hover' +
                        '{' +
                                'box-shadow: 0 0 5px #FF0000 inset;' +
                        '}\n' );

        },

        init: function( editor ) {
                var pluginName = 'pretty_dialog';

                // Register the dialog.
                CKEDITOR.dialog.add( 'pretty_dialog', this.path + 'dialogs/gallery.js' );

                cmd = editor.addCommand("pretty_dialog", new CKEDITOR.dialogCommand("pretty_dialog"));
                
                editor.ui.addButton("pretty_dialog", {label: "Atidaryti popup", command: "pretty_dialog"});
                
                if (editor.contextMenu) {
                    editor.addMenuItem("pretty_dialog", {label: "Atidaryti popup", command: "pretty_dialog", icon: this.path + "icons/gallery_settings.png"});
                    editor.contextMenu.addListener(function(i, q) {
                        if (i && i.is("a") && i.$.className == "prettyDialog") {
                            return{pretty_dialog: CKEDITOR.TRISTATE_OFF};
                        }
                    });
                }
                

                
                // Init style property.
                items[ 'lightbox' ].style = new CKEDITOR.style( {
                        element: 'span',
                        attributes: {
                                lang: 'lightbox',
                                dir: 'ltr'
                        }
                } );
                
                items[ 'slideshow' ] = {
                        label: 'slideshow',
                        langId: 'slideshow',
                        group: 'gallery',
                        order: 1,
                        // Tells if this language is left-to-right oriented (default: true).
                        onClick: function() {
                                editor.execCommand( 'gallery', this.langId );
                        },
                        role: 'menuitemcheckbox'
                };

                // Init style property.
                items[ 'slideshow' ].style = new CKEDITOR.style( {
                        element: 'span',
                        attributes: {
                                lang: 'slideshow',
                                dir: 'ltr'
                        }
                } );                


                editor.addMenuGroup( 'gallery', 1 );
                editor.addMenuItems( items );                

        },
        afterInit: function( editor ) {
                // Customize the behavior of the alignment commands. (#7430)

        }
});