$(document).ready(function(){
	
	$('body').append("<div id='_OVERLAY'></div>");
	$('body').append("<div id='_LOADING'></div>");
	$('body').append("<div id='_SCRIPT_' class='hide'></div>");
	$('body').append("<div id='contextMenu'></div>");
	$('body').append("<div id='_LOGIN_' class='_WINDOW'></div>");
	$('body').append("<div id='_POPUP_' class='_WINDOW'><div class='rel'><div class='close' onclick=\"javascript: $('#_POPUP_').hide();\"></div><div class='content'></div></div></div>");
	
	reset_content_pos();
	
	$('#left .resizer_v').draggable({
			axis:"x", 
			drag:reset_left_resizer,
			stop:reset_left_resizer,
			containment: "#center", 
			scroll: false
	});
	
	$("#contextMenu").mouseleave(function(){ $(this).hide(); });
	
	$("#DEBUG").draggable({
		handle: ".handle"
	}).resizable();
	
});

var currentMousePos = { x: -1, y: -1 };
$(document).mousemove(function(event) {
    currentMousePos = {
        x: event.pageX,
        y: event.pageY
    };
});

$(window).resize(function(){
	reset_content_pos();
});

function ajaxItemContextMenu(url){
	//$('#contextMenu').hide();
        
        $('#contextMenu').css({'left':currentMousePos.x-5+'px', 'top':currentMousePos.y-5+'px'});
        $.ajax({
                async: false,
                url:url,
                dataType:"json",
                type: "GET",
                beforeSend:function(){
                        $('#contextMenu').html("<p><mig src='/admin/images/loading.gif' alt='' ></p>");
                        $('#contextMenu').show();
                },
                complete:function(){

                },
                success: function(_json_response_) {
                        if(_json_response_.loged==true){
                                $('#contextMenu').html(_json_response_.section[0].content);
                        }else{
                                hideItemContextMenu();
                                $NAV.login(_json_response_);
                        }
                }
        });
	
	return false;
}

function showItemContextMenu(obj_id){
	//$('#contextMenu').hide();
	$('#contextMenu').css({'left':currentMousePos.x-5+'px', 'top':currentMousePos.y-5+'px'});
	$('#contextMenu').html($('#'+obj_id).html());
	$('#contextMenu').show();
	return false;
}

function hideItemContextMenu(){
	$('#contextMenu').hide();
	return false;	
}

function reset_left_resizer(){
	n=$(this).position().left; 
	$('#left').css('width', n+'px'); 
	$('#content').css('margin-left', n+'px'); 
}

function select_module_folder(mod){
	$('#module_folder').html($('#'+mod).html());
        
        $('#easy_main_navigation a').removeClass('a');
        $('#'+mod).parents('li').find('a').addClass('a');
        
	reset_content_pos();
}

function reset_content_pos(){
	$('#center').css('margin-top', $('#top').height()+'px');
	h = $(document).height()-$('#top').height();
	$('#left').height(h);
	$('#center').height(h);
}

function loading_start(){
	//$('#_OVERLAY').show();
	$('#_LOADING').show();
}

function loading_end(){
	//$('#_OVERLAY').hide();
	$('#_LOADING').hide();
}

function get_url_vars(url){
    var vars = [], hash;
    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
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