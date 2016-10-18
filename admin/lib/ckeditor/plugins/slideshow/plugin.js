/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/**
 * @fileOverview Gallery plugin
 */

CKEDITOR.plugins.add( 'slideshow', {
        requires: 'dialog,fakeobjects',
        lang: 'lt,en', // %REMOVE_LINE_CORE%
        icons: 'slideshow', // %REMOVE_LINE_CORE%
        onLoad: function() {
                CKEDITOR.addCss( '.easy_slideshow:hover' +
                        '{' +
                                'box-shadow: 0 0 5px #C1A243 outset;' +
                        '}\n' );

        },

        init: function( editor ) {
                var pluginName = 'slideshow';

                // Register the dialog.
                CKEDITOR.dialog.add( 'slideshow', this.path + 'dialogs/slideshow.js' );
                CKEDITOR.dialog.add( 'slideshow_settings', this.path + 'dialogs/slideshow_settings.js' );
                cmd1 = editor.addCommand("slideshow", new CKEDITOR.dialogCommand("slideshow"));
                cmd2 = editor.addCommand("slideshow_settings", new CKEDITOR.dialogCommand("slideshow_settings"));
                editor.ui.addButton("slideshow", {label: editor.lang.slideshow.btn_create_slideshow, command: "slideshow"});
                editor.ui.addButton("slideshow_settings", {label: editor.lang.slideshow.btn_slideshow_settings, command: "slideshow_settings", icon: this.path + "icons/slideshow_settings.png"});
                if (editor.contextMenu) {
                    editor.addMenuGroup("slideshow_group");
                    editor.addMenuItem("slideshow_add", {label: editor.lang.slideshow.btn_slideshow_settings, command: "slideshow_settings", icon: this.path + "icons/slideshow_settings.png", group: "slideshow_group"});
                    editor.addMenuItem("slideshow_settings", {label: editor.lang.slideshow.btn_add_slideshow_images, command: "slideshow", icon: this.path + "icons/slideshow.png", group: "slideshow_group"});
                    editor.contextMenu.addListener(function(i, q) {
                        if (i && i.is("figure") && i.$.className == "easy_slideshow") {
                            return{slideshow_add: CKEDITOR.TRISTATE_OFF, slideshow_settings: CKEDITOR.TRISTATE_OFF};
                        }
                    });
                }





        },
        afterInit: function( editor ) {
                // Customize the behavior of the alignment commands. (#7430)

        }
});