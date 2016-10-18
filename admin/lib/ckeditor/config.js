/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
	config.plugins = 'widget,dialogui,contextmenu,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,div,resize,toolbar,elementspath,list,indent,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo,font,format,htmlwriter,horizontalrule,iframe,wysiwygarea,image,smiley,justify,link,liststyle,magicline,maximize,newpage,pagebreak,pastetext,pastefromword,preview,print,removeformat,save,selectall,showblocks,showborders,sourcearea,specialchar,stylescombo,tab,table,tabletools,undo,tableresize,onchange,uicolor,myforms';
	config.skin = 'moono';
	// %REMOVE_END%

	config.extraPlugins = 'menubutton,quicktable,easy_maps,gallery,slideshow,ajaxsave,preview,tableresize,magicline,oembed,sourcedialog,easy_list';
	
	config.removePlugins = 'newpage,find,replace,about';
	
	config.toolbar = [['AjaxSave','Sourcedialog'],
	                  ['Templates'],
	                  ['Cut','Copy','Paste','PasteText','PasteFromWord'],
	                  ['Undo','Redo','-','SelectAll','RemoveFormat','-','ShowBlocks'],
	                  ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','Captcha','HiddenField'],
	                  '/',
	                  ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	                  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	                  ['Link','Unlink','Anchor'],           
	                  ['Image','gallery','slideshow','oembed','Flash','Table','HorizontalRule','Iframe','easy_maps'],
	                  '/',
	                  ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	                  ['Styles','Format','Font','FontSize'],
	                  ['TextColor','BGColor']];
	
        config.toolbar_Full = [   
                                  ['Source','-','Templates','-','Maximize'],
                                  ['Cut','Copy','Paste','PasteText','PasteFromWord'],
                                  ['Undo','Redo','-','SelectAll','RemoveFormat','-','ShowBlocks'],
                                  ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','Captcha','HiddenField'],
                                  ['Image','gallery','slideshow','oembed','Flash','Table','HorizontalRule','Iframe','easy_maps'],
                                  '/',
                                  ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
                                  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                                  ['Link','Unlink','Anchor'],           
                                  ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                                  ['Styles','Format','Font','FontSize'],
                                  ['TextColor','BGColor']];
                      
	config.toolbar_Default = [
	                          ['Source','-','Templates'],
	                          ['Cut','Copy','Paste','PasteText','PasteFromWord'],
	                          ['Undo','Redo','-','SelectAll','RemoveFormat','-','ShowBlocks'],
	    	                  ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    	                  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    	                  ['Link','Unlink','Anchor'],           
	    	                  '/',
	    	                  ['Image','gallery','slideshow','oembed','Flash','Table','HorizontalRule','Iframe','Map'],
	    	                  ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    	                  ['Styles','Format','Font','FontSize'],
	    	                  ['TextColor','BGColor']
	                         ];
	
	config.toolbar_Basic = [
	                          ['Source','-','ShowBlocks'],
	                          ['Paste','PasteText','PasteFromWord'],
	    	                  ['NumberedList','BulletedList','-','CreateDiv'],
	    	                  ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    	                  ['Link','Unlink'],    
	    	                  ['Bold','Italic','Underline','Strike'],
	    	                  ['Format','FontSize']
	                         ];
	
	config.filebrowserBrowseUrl = 'admin/lib/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = 'admin/lib/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = 'admin/lib/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = 'admin/lib/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = 'admin/lib/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = 'admin/lib/kcfinder/upload.php?type=flash';
	   
	// Define changes to default configuration here. For example:
	config.language = top._CNF.lng;
	config.uiColor = '#edd99b';
	
	config.oembed_WrapperClass = 'embededContent';
        
        config.easy_maps_width = 400;
        config.easy_maps_height = 300;
        config.easy_maps_default_x = 55.2666
        config.easy_maps_default_y = 23.57666
        config.easy_maps_default_zoom = 6
        
        config.easy_gallery_thumb_width = 150;
        config.easy_gallery_thumb_height = 120;
        config.easy_gallery_thumb_type = 'crop';
        config.easy_gallery_img_width = 800;
        config.easy_gallery_img_height = 800;
        config.easy_gallery_img_type = 'auto';

        config.easy_slideshow_img_width = 500;
        config.easy_slideshow_img_height = 300;
        config.easy_slideshow_img_type = 'crop';
        config.easy_slideshow_opt = 'slide';
        config.easy_slideshow_delay = 15000;
        config.easy_slideshow_autoplay = true;
        config.easy_slideshow_paging = false;

        config.allowedContent = true;
        
        config.emailProtection = false;
        
        config.entities = false;
        
        config.disableAutoInline = true;
	
};