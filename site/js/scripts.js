var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
$(document).ready(function () { 
	
        $('a[rel^=prettyPhoto]').prettyPhoto({social_tools:''}); 
        $('a[rel^=lightbox]').prettyPhoto({social_tools:''}); 
	
        $('a[rel=prettyDialog]').click(function(){
            my_ajax_dialog($(this).attr('href'));
            return false;
        })
        
	$('body').append('<iframe name="FORMS_IFRAME" style="display:none;"></iframe>');
	$('body').append('<div style="display:none;" id="OVERLAY" onclick="javascript: close_my_dialog();"></div>');
	
        $('.easy-list .easy-list-content').hide();
        $('.easy-list .easy-list-link').removeClass('a');
        
        $('.easy-list-link').live('click', function(){
            $ul = $(this).parents('.easy-list-item');
            $c = $(this).parents('.easy-list');
            if($ul.find('.easy-list-content').is(':hidden')){
                $c.find('.easy-list-link').removeClass('a');
                $c.find('.easy-list-content').hide();
                $(this).addClass('a');
                $ul.find('.easy-list-content').show();
                
                $('html, body').animate({
                        scrollTop: $ul.offset().top
                }, 2000);                
            }else{
                $c.find('.easy-list-link').removeClass('a');
                $c.find('.easy-list-content').hide();
            }
        });
        
        $('.input input').live('focus', function(){
            $(this).addClass('focus');
        });
        $('.input input').live('blur', function(){
            $(this).removeClass('focus');
        });
        
	$('input,select,textarea').live('change', function(){
            $(this).removeClass('err');
            $(this).closest('label').removeClass('err');
	});
        
        $(".dd").msDropdown({roundedBorder:false});
        
        if(typeof(top._CNF) == 'undefined'){
            if($('figure.easy_slideshow').size() > 0){
                $('figure.easy_slideshow').each(function(){
                    $obj = $(this);
                    wdth = $obj.attr('data-img-w');
                    hght = $obj.attr('data-img-h');
                    parent_wdth = $obj.parent().width();
                    if(wdth > parent_wdth){
                        prprc = parent_wdth / wdth;
                        wdth = parent_wdth;
                        hght = parseInt(hght * prprc);
                        $obj.width(wdth);
                        $obj.height(hght + ($obj.attr('data-pagination') == 'thumb' ? 30 : 0));
                    }
                    window.myFlux = new flux.slider('#' + $obj.attr('id'), {
                        autoplay: ($obj.attr('data-autoplay')=='true' || $obj.attr('data-autoplay')=='yes' || $obj.attr('data-autoplay')=='1'),
                        pagination: ($obj.attr('data-pagination')!='none' && $obj.attr('data-pagination') ? true : false),
                        // pagination type: thumb, number, empty, text
                        pagination_type: ($obj.attr('data-pagination') ? $obj.attr('data-pagination') : 'thumb'),
                        stop_slide_onmouseover: ($obj.attr('data-stop_slide_onmouseover')=='true' || $obj.attr('data-stop_slide_onmouseover')=='yes' || $obj.attr('data-stop_slide_onmouseover')=='1' ? true : false),
                        controls: ($obj.attr('data-controls') && ($obj.attr('data-controls')=='1' || $obj.attr('data-controls')=='true' || $obj.attr('data-controls')=='yes') ? true : false),
                        captions: true,
                        width: wdth,
                        height: hght,
                        lightbox: $obj.attr('data-links'),
                        delay: parseInt($obj.attr('data-delay')),
                        transitions: [$obj.attr('data-slide-opt')]
                    });
                });
            }
            
        }
        
        $('body').click(function(e){
            if ($(e.target).parents('#cart').size() > 0) {
                
            }else{
                $('#shopping_cart_content').hide();
            }
        });
        
        if(isMobile.any() || $(window).width() < 801){
            $('img,iframe').each(function(){
                $obj = $(this);
                //alert($obj.attr('src') + ": " + $obj.width() + " - " + $obj.height());
                if($obj.width() > ($(window).width()-30)){
                   old_w = $obj.width();
                   old_h = $obj.height();
                   $obj.width($(window).width() - 30);
                   $obj.height(parseInt($(window).width() / old_w * $obj.height()));
                }
            });
        }        
        
        if($('figure.easy_maps').size() > 0){
//            $.getScript('http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places,weather', function() {});
//            $.getScript('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel_packed.js', function() {});
            function initialize_easy_maps(){
                $('figure.easy_maps').each(function(){
                    $map = $(this);
                    var json_data = JSON.parse(decodeURIComponent($map.find('img.easy_maps_img').attr('data-map')));
                    //load_easy_map($map.attr('id'), json_data);
                    load_easy_map($map, json_data)
                });
            }
            
            $(window).bind('gMapsLoaded', initialize_easy_maps);
            window.loadGoogleMaps();            
            //google.maps.event.addDomListener(window, 'load', function(){ initialize_easy_maps() });
        }
	
});

var gMapsLoaded = false;
window.gMapsCallback = function(){
    gMapsLoaded = true;
    $(window).trigger('gMapsLoaded');
}
window.loadGoogleMaps = function(){
    if(gMapsLoaded) return window.gMapsCallback();
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src","http://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback");
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src","http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel_packed.js");
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
}


load_easy_map = function(canva,json){
    canva.css('width', json.width+"px");
    canva.css('height', json.height+"px");
    var map = new google.maps.Map(canva[0], { 
                                          zoom: parseInt(json.zoom), 
                                          center: new google.maps.LatLng(parseFloat(json.lat), parseFloat(json.lng)), 
                                          mapTypeId:json.type 
                                      });
    if( json.settings ){ 
        for( var id in json.settings ) 
            map.set(id,json.settings[id]?true:false);
    };
    if( json.objects ) 
        for( var type in json.objects ){ 
            for( var i in json.objects[type] ){ 
                var object = 0;
                switch( type ){ 
                    case 'Marker': 
                        object = new google.maps.Marker({ 
                                                        position: new google.maps.LatLng( json.objects[type][i][0], json.objects[type][i][1]),
                                                        map: map,
                                                        title: json.objects[type][i][2]
                                                    });
                        (function(txt){
                            google.maps.event.addListener(object, 'click', function() { 
                                                                                (new google.maps.InfoWindow({content: txt})).open( map,object );
                                                                            });
                        })
                        (json.objects[type][i][2]);
                    break;
                    case 'Rectangle': 
                        object = new google.maps.Rectangle({ 
                                                        bounds: new google.maps.LatLngBounds( 
                                                                                new google.maps.LatLng( json.objects[type][i][0][0], json.objects[type][i][0][1]), 
                                                                                new google.maps.LatLng( json.objects[type][i][1][0], json.objects[type][i][1][1]) ),
                                                        map: map,
                                                    });
                    break;
                    case 'Polygon':case 'Polyline': 
                        var path = json.objects[type][i],array_path = []; 
                        for( var j in path )
                            array_path.push( new google.maps.LatLng( path[j][0], path[j][1]) );
                        
                        object = new google.maps[type]({ path: array_path, map: map, });
                    break;
                    case 'Text':
                        object = new MarkerWithLabel({ 
                                                position: new google.maps.LatLng( json.objects[type][i][0], json.objects[type][i][1]), 
                                                map: map, 
                                                labelContent: json.objects[type][i][2], 
                                                labelAnchor: new google.maps.Point(22, 0),
                                                labelClass: "labels",
                                                labelStyle: {
                                                        opacity: 1.0, 
                                                        minWidth:'200px',
                                                        textAlign:'left'
                                                },
                                                icon: {}
                                    });
                    break;
                    case 'Circle':
                        object = new google.maps.Circle({
                                                    radius: json.objects[type][i][2],
                                                    center:new google.maps.LatLng( json.objects[type][i][0], json.objects[type][i][1]),map: map,});
                    break;
                    
                }
            }
        }
};
    
//loadmap = function( id,json ){ google.maps.event.addDomListener(window, 'load', function(){_loadmap(id,json)}); };


function create_slider(slider_obj){
  $(slider_obj + ' .slider_container').attr('data-stop-scroll', 0);
  $(slider_obj).find('.slider_bck').click(function(){
      myslider_(slider_obj + ' .slider_container', slider_obj + ' .slider_content', -1);
  });
  $(slider_obj).find('.slider_fwd').click(function(){
      myslider_(slider_obj + ' .slider_container', slider_obj + ' .slider_content', 1);
  });
}

function myslider_(content, container, direction){ 
        stop_scroll = $(content).attr('data-stop-scroll') * 1;
  	if(!stop_scroll){
		leftPos_int = parseInt($(container).position().left)*1-(direction)*parseInt($(content).width());
		if(direction == -1){
			if(leftPos_int>0){ 
				$(content).attr('data-stop-scroll', 0);
				return;
			}
		}else{
			if(leftPos_int*(-1)>$(container+' .product_thumb').length*parseInt($(container+' .product_thumb').width())){ 
				$(content).attr('data-stop-scroll', 0);
				return;
			}
		}
		leftPos = leftPos_int+'px';
                
		if($(container).width()<=((parseInt(leftPos))*(-1))){
			$(container).animate( { left:'0px' }, 1000, '', function(){ $(content).attr('data-stop-scroll', 0); } );
		}else{
			$(container).animate( { left:leftPos }, 1000, '', function(){ $(content).attr('data-stop-scroll', 0); } );
		}
	}
}
 
function select_modif(cont, modif_id, modif_option_id){
    $('#'+cont+' .modif_value_'+modif_id).val(modif_option_id);
    $('#'+cont+' .modif_arr_'+modif_id+' .selected_modif').removeClass('selected_modif');    
    $('#'+cont+' .content_modif_' + modif_option_id + ' img').addClass('selected_modif');
}


                                    
                                    
function prettyDialog(obj_id){
    $.prettyPhoto.open('#' + obj_id, '', '');
}

function my_ajax_dialog(url){
    $.ajax({
      url: url,
      cache: false,
      dataType:"json",
      beforeSend:function(){
      },
      success: function(json){
            width = 700;
            if(typeof(json.width)!='undefined') width = json.width;
            my_dialog(json.title, json.content, width);
      }
    });
}

function post_ajax_dialog(url, data){
    $.ajax({
      url: url,
      type:'POST',
      data: data,
      cache: false,
      dataType:"json",
      beforeSend:function(){
      },
      success: function(json){
            width = 600;
            if(typeof(json.width)!='undefined') width = json.width;
            my_dialog(json.title, json.content, width);
      }
    });
}

function my_dialog(title, content, width){
    close_my_dialog();
    $('#OVERLAY').show(0);

//    $obj = $('<div />');
//    $obj.html(content);
//
//    $obj.find("script").each(function(){
//        src = $(this).attr('src');
//        if(src){
//            $.getScript( src, function( data, textStatus, jqxhr ) {
//              console.log( data ); // Data returned
//              console.log( textStatus ); // Success
//              console.log( jqxhr.status ); // 200
//              console.log( "Load was performed." );
//            });            
//        }else{
//            eval($(this).text());
//        }
//    })
    //eval($('.popup_content').find("script").text());
    $('body').append('<div class="popup"><div class="rel"><a href="javascript: void(close_my_dialog());"><img src="site/images/close.png" class="close" alt="Close" /></a>' + (title ? '<div class="popup_title">' + title + '</div>' : '') + '<div class="popup_content">' + content + '</div></div></div>');

    $('.popup_content').width(width);
    $('.popup').css('left', parseInt(f_clientWidth()/2) - parseInt($('.popup').width()/2) + 'px');
    $('.popup').css('top', parseInt($(document).scrollTop()) + 100 + 'px');
    
    $('.popup').fadeIn(500);
}

function open_request(lng, pid){
    my_ajax_dialog('index.php?module=products&method=product_request&pid='+pid+'&lng='+lng+'&ajax=1');
}

function add2cart(lng, pid){
    
    var quantity = 1;
    if(arguments[2]){
        quantity = arguments[2];
    }
    var modif = '';
    if(arguments[3]){
        modif = arguments[3];
    }
    
    $.ajax({
      url: 'index.php?module=cart&method=add&id=' + pid + '&lng=' + lng + '&q=' + quantity + '&modif=' + modif + '&ajax=1',
      cache: false,
      dataType:"json",
      beforeSend:function(){
      },
      success: function(json){
            $('#cart').html(json.cart_content);
            //$('#shopping_cart_content').show();
      }
    });    
}

function remove_cart_item(lng, pid){
  
    var modif = '';
    if(arguments[2]){
        modif = arguments[2];
    }
  
    $.ajax({
      url: 'index.php?module=cart&method=remove&id=' + pid + '&lng=' + lng + '&modif=' + modif + '&ajax=1',
      cache: false,
      dataType:"json",
      beforeSend:function(){
      },
      success: function(json){
            $('#cart').html(json.cart_content);
            $('#shopping_cart_content').show();
      }
    });    
}

function minus_add2cart(lng, pid){
    var modif = '';
    if(arguments[2]){
        modif = arguments[2];
    }
    var modif_id = pid;
    if(arguments[3]){
        modif_id = arguments[3];
    }
    
    var q = $('#cart_item_qty_' + modif_id).val();
    q--;
    if(q < 0) return false;
    $('#cart_item_qty_' + modif_id).val(q)
    set_quantity_add2cart(lng, pid, q, modif);
      }
function plus_add2cart(lng, pid){
    var modif = '';
    if(arguments[2]){
        modif = arguments[2];
}
    var modif_id = pid;
    if(arguments[3]){
        modif_id = arguments[3];
    }
    
    var q = $('#cart_item_qty_' + modif_id).val();
    q++;
    $('#cart_item_qty_' + modif_id).val(q)
    
    set_quantity_add2cart(lng, pid, q, modif);
}
function remove_add2cart(lng, pid){
    var modif = '';
    if(arguments[2]){
        modif = arguments[2];
    }
    
    $.ajax({
      url: 'index.php?module=cart&method=cart_checkout&id=' + pid + '&lng=' + lng + '&a=remove&q=' + 0 + '&modif=' + modif + '&ajax=1',
      cache: false,
      dataType:"json",
      beforeSend:function(){
      },
      success: function(json){
            $('#cart').html(json.cart_content);
            $('#content').html(json.checkout_cart_content);
      }
    }); 
    return false;
}
function set_quantity_add2cart(lng, pid, q){
    var modif = '';
    if(arguments[3]){
        modif = arguments[3];
    }
  
    $.ajax({
      url: 'index.php?module=cart&method=cart_checkout&id=' + pid + '&lng=' + lng + '&a=plus&q=' + q + '&modif=' + modif + '&ajax=1',
      cache: false,
      dataType:"json",
      beforeSend:function(){
      },
      success: function(json){
            $('#cart').html(json.cart_content);
            $('#content').html(json.checkout_cart_content);
      }
    });  
}

function select_pay(pay_id){
    $('#payment_type_value').val(pay_id);
    $('.pay_type').removeClass('a');
    $('#payment_type_value').parents('.confirm_part').removeClass('wrong');
    $('#pay_' + pay_id).addClass('a');
}

function close(){
    close_my_dialog();
}

function profile(){
    my_ajax_dialog('index.php?module=users&method=profile&ajax=1');
}

function logout(){
    my_ajax_dialog('index.php?module=users&method=logout&ajax=1');
}

function login(){
    my_ajax_dialog('index.php?module=users&method=login&ajax=1');
}

function register(){
    my_ajax_dialog('index.php?module=users&method=register&ajax=1');
}

function reset(code){
    my_ajax_dialog('index.php?module=users&method=reset&code='+code+'&ajax=1');
}

function forget(){
    my_ajax_dialog('index.php?module=users&method=forget&ajax=1');
}

function buy(item){
    my_ajax_dialog('index.php?module=products&method=load&ajax=1&item_id=' + item);
}

function checkout(){
    my_ajax_dialog('index.php?module=products&method=checkout&ajax=1');
}

function valid_field(field){
    return (field.val() ? true : false);
}
function valid_email(field){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return (re.test(field.val()) ? true : false);
}
function valid_number(field){
    var re = /^-{0,1}\d*\.{0,1}\d+$/;
    return (re.test(field.val()) ? true : false);
}
function valid_url(field){
    var re = /^(https?:\/\/)?((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|((\d{1,3}\.){3}\d{1,3}))(\:\d+)?(\/[-a-z\d%_.~+]*)*(\?[;&a-z\d%_.~+=-]*)?(\#[-a-z\d_]*)?$/i;
    return (re.test(field.val()) ? true : false);
}
function valid_tel(field){
    var re = /^\+?([0-9\s-\(\)]){5,}$/;
    return (re.test(field.val()) ? true : false);
}
function valid_password(field){
    var re = /^\w+$/;
    var attr = field.attr("data-valid-repeat");
    if(typeof attr !== 'undefined' && attr !== false){
        return (field.val() == $('input[name='+attr+']').val() && re.test(field.val()) && field.val().length > 4 ? true : false);
    }
    return (re.test(field.val()) && field.val().length > 4 ? true : false);
}
function valid_checkbox(field){
    if(field.is(':checked')){
        return true;
    }else{
        return false;
    }
}
function validate_form(form){
    var valid = true;

    $(':input[required]:visible', form).each(function(){
        fn = valid_field;
        if($(this).attr('type')=='email') fn = valid_email;
        if($(this).attr('type')=='tel') fn = valid_tel;
        if($(this).attr('type')=='number') fn = valid_number;
        if($(this).attr('type')=='password') fn = valid_password;
        if($(this).attr('type')=='checkbox') fn = valid_checkbox;
        if(!fn($(this))){
            $(this).addClass('err');
            $(this).closest('label').addClass('err');
            valid = false;
        }
    });

    return valid;
}

function close_my_dialog(){
	$('#OVERLAY').hide(0);
	$('.popup').remove();	
}

function formSuccess(form_name, text){
	$('form[name='+form_name+']').html(text);
}

function enableForm(form_name){
	$('form[name='+form_name+'] input[type=submit]').removeAttr('disabled');
}

function resetCaptcha(){
        $img = $('img[rel=captcha]');
        if($img.size() > 0){
            src = $img.attr('src');
            if(src.indexOf('&r=') != -1){
                src = src.substring(0, src.indexOf('&r='));
            }
            $img.attr('src', src + '&r=' + Math.random());
        }
}

function forms_prepare(){
	$('.err input, .err select, .err textarea').change(function(){
		//alert($(this).parent().parent().attr('class'));
		$(this).parent().parent().removeClass('err');
		$(this).parent().removeClass('err');
	});
}

function getMouseXY(e) {
  if (document.all) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft;
    tempY = event.clientY + document.body.scrollTop;
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX;
    tempY = e.pageY;
  }  
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}  
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  return { x:tempX, y:tempY }
}

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return { x:curleft, y:curtop };
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
