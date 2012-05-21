/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Scripts related to the Image dialog window (see fck_image.html).
 */

var dialog		= window.parent ;
var oEditor		= dialog.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;
var FCKDebug	= oEditor.FCKDebug ;
var FCKTools	= oEditor.FCKTools ;

var Gallery_mode = 1;

var bImageButton = ( document.location.search.length > 0 && document.location.search.substr(1) == 'ImageButton' ) ;

//#### Dialog Tabs

// Set the dialog tabs.
dialog.AddTab( 'Info', FCKLang.TabGalleryFoto ) ;
dialog.AddTab( 'Params', FCKLang.TabGallerySettings ) ;


// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;
	ShowE('divParams'		, ( tabCode == 'Params' ) ) ;
}

var oHtml = FCK.Selection.GetSelectedElement();//.MoveToAncestorNode('DIV');

var Edit_mode = false;
if(oHtml){
	if(oHtml.className=='easy_gallery' || oHtml.className=='easy_slideshow') Edit_mode = true;
}



var oImageOriginal ;

function UpdateOriginal( resetSize )
{
}

window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	LoadSelection() ;

	dialog.SetOkButton( true ) ;

}

function LoadSelection()
{

	if(!Edit_mode) return;

	var aItems = oHtml.getElementsByTagName('a');
	params_fix = 0;
	for(var i=0; i<aItems.length; i++)
	{
		egimg = aItems[i].getElementsByTagName('img');
		egimg = egimg[0];
		
		if(!egimg) continue;
			
		str = egimg.src;
		urlas = str.substring(0, str.indexOf('thumb.php')).replace("\"", "");

		$('#url').val(urlas);
		
		get = str.substring(str.indexOf('?')+1);
		
		gallery_obj = new Object;
		
		arr = get.split('&');
		for(j=0; j<arr.length; j++){
			arr2 = arr[j].split('=');
			if(arr2[0]=='image') gallery_obj.image = arr2[1];
			if(arr2[0]=='t') gallery_obj.t = arr2[1];
			if(arr2[0]=='w') gallery_obj.w = arr2[1];
			if(arr2[0]=='h') gallery_obj.h = arr2[1];
		}
		
		if(params_fix==0){

			if(aItems[i].href){
				href = aItems[i].href.substring(aItems[i].href.indexOf('?')+1);
				arr = href.split('&');
				for(j=0; j<arr.length; j++){
					arr2 = arr[j].split('=');
					if(arr2[0]=='t') gallery_obj.b_t = arr2[1];
					if(arr2[0]=='w') gallery_obj.b_w = arr2[1];
					if(arr2[0]=='h') gallery_obj.b_h = arr2[1];
				}
				param_width_img = gallery_obj.b_w;
				param_height_img = gallery_obj.b_h;
				param_big_img = true;
			}

			param_width = gallery_obj.w;
			param_height = gallery_obj.h;
			
			if(oHtml.className=='easy_gallery'){
				param_resize_type = gallery_obj.t;
				param_margin = parseInt(egimg.style.margin);
				param_padding = (egimg.style.padding?parseInt(egimg.style.padding):0);
				param_border_width = parseInt(egimg.style.borderWidth);
				param_border_color = egimg.style.borderColor;
			}else{
				param_margin = parseInt(oHtml.style.margin);
				param_border_width = parseInt(oHtml.style.borderWidth);
				param_border_color = oHtml.style.borderColor;
				
				param_speed = parseInt(oHtml.getAttribute('speed'));
				param_big_img = (aItems[i].href!=''?true:false);
			}
			params_fix = 1;
		}
		
		insertImageUrl(gallery_obj.image);
		
	}

	if(oHtml.className=='easy_gallery'){
		
		GetE('lightbox_chk').checked  = true;
		GetE('slideshow_chk').checked  = false;
		
		$('#lightbox_param').show();
		$('#slideshow_param').hide();

		GetE('margin').value  = param_margin;
		GetE('padding').value  = param_padding;
		GetE('border').value  = param_border_width;
		GetE('bordercolor').value  = param_border_color;
		GetE('width').value  = param_width;
		GetE('height').value  = param_height;
		GetE('resize_type_img_chk').checked  = (param_resize_type==1?true:false);
		GetE('width_img').value  = param_width_img;
		GetE('height_img').value  = param_height_img;
		
	}else{
		
		GetE('lightbox_chk').checked  = false;
		GetE('slideshow_chk').checked  = true;

		$('#lightbox_param').hide();
		$('#slideshow_param').show();

		GetE('margin_s').value  = param_margin;
		GetE('width_s').value  = param_width;
		GetE('height_s').value  = param_height;
		GetE('speed_s').value  = param_speed;
		GetE('big_img_chk').checked  = param_big_img;
		if(typeof(param_width_img)!='undefined') GetE('width_s_img').value  = param_width_img;
		if(typeof(param_height_img)!='undefined') GetE('height_s_img').value  = param_height_img;
		
	}
	
	$("#img_dir").sortable();
	
	
}

//#### The OK button was hit.
function Ok()
{
	//html = "";
	if(document.getElementById('slideshow_chk').checked){
		gallery_html = "";
		var index = 0;
		gallery_html += '<div class="easy_slideshow" speed="'+$('#speed_s').val()+'" style="width:'+$('#width_s').val()+'px;height:'+$('#height_s').val()+'px;margin:'+$('#margin_s').val()+'px;">';
		$("#img_dir div a").each(function(){ 
			if($(this).parent().css('display')!='none') gallery_html += '<a class="index_'+(index++)+'" '+(document.getElementById('big_img_chk').checked?'href="'+$('#url').val()+'thumb.php?image='+$(this).html()+'&w='+$('#width_s_img').val()+'&h='+$('#height_s_img').val()+'&t=0" rel="lightbox[rel]"':'')+' style="position:absolute;display:block;"><img src="'+$('#url').val()+'thumb.php?image='+$(this).html()+'&w='+$('#width_s').val()+'&h='+$('#height_s').val()+'&t=1" alt="" style="" /></a>'; });
		gallery_html += "</div>";

		FCK.InsertHtml(gallery_html);
	}
	
	if(document.getElementById('lightbox_chk').checked){
		gallery_html = "";
		gallery_html += "<div class='easy_gallery'>";
		$("#img_dir div a").each(function(){ 
			if($(this).parent().css('display')!='none') gallery_html += '<a href="'+$('#url').val()+'thumb.php?image='+$(this).html()+'&w='+$('#width_img').val()+'&h='+$('#height_img').val()+'&t=0" rel="lightbox[rel]"><img src="'+$('#url').val()+'thumb.php?image='+$(this).html()+'&w='+$('#width').val()+'&h='+$('#height').val()+'&t='+$('#resize_type_img_chk:checked').val()+'" alt="" style="border:'+$('#border').val()+'px solid '+$('#bordercolor').val()+';margin:'+$('#margin').val()+'px;padding:'+$('#padding').val()+'px;" class="vam" /></a>'; });
		gallery_html += "</div>";

		FCK.InsertHtml(gallery_html);
	}
	
	return true ;
}



function BrowseServer()
{
	OpenServerBrowser(
		'Image',
		FCKConfig.ImageBrowserURL,
		FCKConfig.ImageBrowserWindowWidth,
		FCKConfig.ImageBrowserWindowHeight ) ;
}

function LnkBrowseServer()
{
	OpenServerBrowser(
		'Link',
		FCKConfig.LinkBrowserURL,
		FCKConfig.LinkBrowserWindowWidth,
		FCKConfig.LinkBrowserWindowHeight ) ;
}

function OpenServerBrowser( type, url, width, height )
{
	sActualBrowser = type ;
	OpenFileBrowser( url+"&gallery=1", width, height ) ;
}

var sActualBrowser ;

function insertImageUrl(file){
	$('#img_dir').append('<div style="margin:1px;padding:2px;background:#CCC;clear:both;"> <p title="'+FCKLang.GalleryDelete+'" style="float:right;cursor:pointer;margin:0px;" onclick="javascript: void($(this).parent().hide());">[x]</p><a href="'+$('#url').val()+file+'" target="_blank">'+file+'</a></div>');
}

function SetUrl(file, url, project_dir, path)
{
	arr = file.split("::");
	//alert($('#img_dir'));
	for(i=0; i<arr.length; i++){
		if(arr[i]!='') insertImageUrl(path+arr[i]); 
	}
	if(arr.length>0){
		document.getElementById('url').value=url;
		//$('#img_dir').append('<input type="hidden" id="url" value="'+url+'" />');
		//$('#img_dir').append('<input type="hidden" id="project_dir" value="'+project_dir+'" />');
	}
	
	$("#img_dir").sortable();
	
	dialog.SetSelectedTab( 'Info' ) ;
	
}
