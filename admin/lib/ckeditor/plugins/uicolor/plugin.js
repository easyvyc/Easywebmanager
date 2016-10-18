/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.add( 'uicolor', {
	requires: 'dialog',
	lang: 'en,lt', // %REMOVE_LINE_CORE%
	icons: 'uicolor', // %REMOVE_LINE_CORE%
	init: function( editor ) {
		if ( CKEDITOR.env.ie6Compat )
			return;

		editor.addCommand( 'uicolor', new CKEDITOR.dialogCommand( 'uicolor' ) );
		editor.ui.addButton && editor.ui.addButton( 'UIColor', {
			label: editor.lang.uicolor.title,
			command: 'uicolor',
			toolbar: 'tools,1'
		});
		CKEDITOR.dialog.add( 'uicolor', this.path + 'dialogs/uicolor.js' );

		// Load YUI js files.
		CKEDITOR.scriptLoader.load( CKEDITOR.getUrl( 'plugins/uicolor/yui/yui.js' ) );

		// Load YUI css files.
		CKEDITOR.document.appendStyleSheet( CKEDITOR.getUrl( 'plugins/uicolor/yui/assets/yui.css' ) );
	}
});
