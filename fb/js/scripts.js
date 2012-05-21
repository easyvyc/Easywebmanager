$(document).ready(function(){
	
	$('body').append("<div id='_OVERLAY'></div>");
	$('body').append("<div id='_LOADING'></div>");
	$('body').append("<div id='_WINDOW'><div id='_WINDOW_toolbar'><div id='_WINDOW_tabs'><div id='_WINDOW_tabs_inner'></div></div>" +
			"<div id='_WINDOW_ico'>&nbsp" +
			"<a href='javascript: void(eDIALOG.closeDialog());'><img src='fb/images/W_close.gif' alt='' class='vam' /></a></div></div>" +
			"<div id='_WINDOW_content'></div></div>");
	
	reset_content_pos();
	
	$("#_WINDOW").draggable({ cursor: 'move', handle: '#_WINDOW_toolbar', opacity: 0.8, 'containment': 'body' });
	$("#_WINDOW").resizable({ autoHide: true, minHeight: 200, minWidth: 300, alsoResize: '#_WINDOW_content' });
	
	$('#left .resizer_v').draggable({
			axis:"x", 
			drag:reset_left_resizer,
			stop:reset_left_resizer,
			containment: "#center", 
			scroll: false
	});
	
});

$(window).resize(function(){
	reset_content_pos();
});

function reset_left_resizer(){
	n=$(this).position().left; 
	$('#left').css('width', n+'px'); 
	$('#content').css('margin-left', n+'px'); 
}

function select_module_folder(mod){
	$('#module_folder').html($('#'+mod).html());
	reset_content_pos();
}

function reset_content_pos(){
	$('#center').css('margin-top', $('#top').height()+'px');
	h = $(document).height()-$('#top').height();
	$('#left').height(h);
	$('#center').height(h);
}

function loading_start(){
	$('#_OVERLAY').show();
	$('#_LOADING').show();
}

function loading_end(){
	$('#_OVERLAY').hide();
	$('#_LOADING').hide();
}

function f_clientWidth() {
	return f_filterResults (
		window.innerWidth ? window.innerWidth : 0,
		document.documentElement ? document.documentElement.clientWidth : 0,
		document.body ? document.body.clientWidth : 0
	);
}
function f_clientHeight() {
	return f_filterResults (
		window.innerHeight ? window.innerHeight : 0,
		document.documentElement ? document.documentElement.clientHeight : 0,
		document.body ? document.body.clientHeight : 0
	);
}
function f_scrollLeft() {
	return f_filterResults (
		window.pageXOffset ? window.pageXOffset : 0,
		document.documentElement ? document.documentElement.scrollLeft : 0,
		document.body ? document.body.scrollLeft : 0
	);
}
function f_scrollTop() {
	return f_filterResults (
		window.pageYOffset ? window.pageYOffset : 0,
		document.documentElement ? document.documentElement.scrollTop : 0,
		document.body ? document.body.scrollTop : 0
	);
}
function f_filterResults(n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}