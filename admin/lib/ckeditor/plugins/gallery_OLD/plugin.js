/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/**
 * @fileOverview Gallery plugin
 */

CKEDITOR.plugins.add( 'gallery', {
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
                var pluginName = 'gallery';

                // Register the dialog.
                CKEDITOR.dialog.add( 'gallery', this.path + 'dialogs/gallery.js' );
                CKEDITOR.dialog.add( 'gallery_settings', this.path + 'dialogs/gallery_settings.js' );
                cmd1 = editor.addCommand("gallery", new CKEDITOR.dialogCommand("gallery"));
                cmd2 = editor.addCommand("gallery_settings", new CKEDITOR.dialogCommand("gallery_settings"));
                editor.ui.addButton("gallery", {label: editor.lang.gallery.btn_create_gallery, command: "gallery"});
                editor.ui.addButton("gallery_settings", {label: editor.lang.gallery.btn_gallery_settings, command: "gallery_settings"});
                if (editor.contextMenu) {
                    editor.addMenuGroup("gallery_group");
                    editor.addMenuItem("gallery_add", {label: editor.lang.gallery.btn_gallery_settings, command: "gallery_settings", icon: this.path + "icons/gallery_settings.png", group: "gallery_group"});
                    editor.addMenuItem("gallery_settings", {label: editor.lang.gallery.btn_add_gallery_images, command: "gallery", icon: this.path + "icons/gallery.png", group: "gallery_group"});
                    editor.contextMenu.addListener(function(i, q) {
                        if (i && i.is("div") && i.$.className == "easy_gallery") {
                            return{gallery_add: CKEDITOR.TRISTATE_OFF, gallery_settings: CKEDITOR.TRISTATE_OFF};
                        }
                    });
                }
                
                var items = {};
                items[ 'lightbox' ] = {
                        label: 'lightbox',
                        langId: 'lightbox',
                        group: 'gallery',
                        order: 0,
                        // Tells if this language is left-to-right oriented (default: true).
                        onClick: function() {
                                editor.execCommand( 'gallery', this.langId );
                        },
                        role: 'menuitemcheckbox'
                };

                
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