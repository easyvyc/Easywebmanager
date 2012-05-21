$(document).ready(function () { 
	$('a[rel]').lightBox(); 
	$('.easy_slideshow').each(function(){
		speed = parseInt($(this).attr('speed'))*1000;
		$(this).find('a').fadeOut(0);
		$(this).find('.index_0').fadeIn(1000);
		$(this).everyTime(parseInt($(this).attr('speed'))*1000, function(i){ index=i%$(this).find('a').length; $(this).find('a').fadeOut(1000); $(this).find('.index_'+index).fadeIn(1000); });
	}); 
	
	$('.flash').each(function(){
		
	});
	
	showFlash(1);
	$('body').everyTime(10000, function(i){
		n = i%6+1;
		$('.flash').fadeOut(3000);
		showFlash(n);
		console.log('#img'+n);
	});
	
	$('body').append('<iframe name="FORMS_IFRAME" style="display:none;"></iframe>');
	$('body').append('<div style="display:none;" id="PRELOADER"></div>');
	$('body').append('<div style="display:none;" id="OVERLAY" onclick="javascript: closeUzklausa();"></div>');
	$('body').append('<div style="display:none;" id="WINDOW"></div>');

	DD_roundies.addRule('.radius10', '10px');
	DD_roundies.addRule('.radius5', '5px');
	DD_roundies.addRule('.radius3', '3px');
	
	$('input,select,textarea').change(function(){
		$(this).removeClass('err');
	});
	
});


function forms_prepare(){
	$('.err input, .err select, .err textarea').change(function(){
		//alert($(this).parent().parent().attr('class'));
		$(this).parent().parent().removeClass('err');
		$(this).parent().removeClass('err');
	});
}

function my_alert(msg){

	$('#OVERLAY').show(0);
	$('#WINDOW').width(370);
	$('#WINDOW').css('top','150px');
	$('#WINDOW').css('left', parseInt(f_clientWidth()/2) - parseInt($('#WINDOW').width()/2) + 'px');
	$('#WINDOW').html(msg);
	$('#WINDOW').fadeIn(200);
	
}

function modif_not_selected(msg){
	my_alert(msg);
	$(this).oneTime(3000, closeUzklausa);
}

function closeUzklausa(){
	$('#OVERLAY').hide(0);
	$('#WINDOW').fadeOut(500);	
}

function addSuccess(){
	
	$.ajax({
	  url: "ajax.php?content=add2cartsuccess&ajax=1",
	  cache: false,
	  beforeSend:function(){
	  },
	  success: function(html){
	    my_alert(html);
		$('.conf_options select').each( function(){ $(this).val(''); } );
		$('#data_text .grey').attr('class', 'orange');
		$(this).oneTime(3000, closeUzklausa);
	  }
	});
	
}

function addSuccess_order(){
	//$("#order_cart_sum b").animate( { backgroundColor:"#FF6666" }, 500, 0, function(){ $("#order_cart_sum b").animate( { backgroundColor:"#FFFFFF" }, { queue:false, duration:2000 } ) } );
}

function before_func(){
	$('#data_text .orange').attr('class', 'grey');
}

function add2cart(aurl, content, before_func, func){
$.ajax({
  url: aurl,
  cache: false,
  beforeSend:function(){
  	before_func();
  },
  success: function(html){
    $("#"+content).html(html);
    if(typeof(func)=='function') func();
  }
});
}

var wrong_modif = new Array;
function modifSelected(){
	ok = true;
	wrong_modif = new Array;
	$('.item_modif select').each( function(){ if($(this).val()==''){ ok=false; $(this).parent().find('span').attr('class', 'modif_err'); wrong_modif[wrong_modif.length] = $(this).parent().find('span').html(); }else{ $(this).parent().find('span').attr('class', ''); } } );
	return ok;
}

function getAllModif(){
	str = "";
	$('.conf_options select').each( function(){ if($(this).val()!='') str+="::"+$(this).attr('id')+"x"+$(this).val(); } );
	return str;
}


stop_scroll = false;

function slider(container, content, direction){ 
	if(!stop_scroll){
		leftPos_int = parseInt($('#'+container).css('left'))-(direction)*parseInt($('#'+content).width());
		if(direction==-1){
			if(leftPos_int>0){ 
				stop_scroll=false;
				return;
			}
		}else{
			if(leftPos_int*(-1)>$('#'+container+' .product_thumb').length*136){ 
				stop_scroll=false;
				return;
			}
		}
		leftPos = leftPos_int+'px';
		if($('#'+container).width()<=((parseInt(leftPos))*(-1))){
			$('#'+container).animate( { left:'0px' }, 1000, '', function(){ stop_scroll=false; } );
		}else{
			$('#'+container).animate( { left:leftPos }, 1000, '', function(){ stop_scroll=false; } );
		}
	}
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

function ajax(a_url, a_obj, top_pos){
			$.ajax({
			  async: true,
			  url: a_url,
			  cache: false,
			  beforeSend: function(){
			  	//$("#"+a_obj).slideUp(1000, function(){  });
			  },
			  success: function(html){
			    $("#"+a_obj).html(html);
			    if(top_pos) $("#"+a_obj).animate({height:"150px", top:top_pos}, 1000);
			  },
			  //timeout: 20,
			  complete: function(html){
			    
			  }
			});
}

function post(a_url, a_obj, form){
			$.ajax({
			  type: "POST",
			  async: true,
			  url: a_url,
			  cache: false,
			  data: formData2QueryString(form),
			  beforeSend: function(){
				$("#"+a_obj).html('<img src=images/loading.gif />');
			  },
			  success: function(html){
			    $("#"+a_obj).html(html);
			  },
			  //timeout: 20,
			  complete: function(html){
			    
			  }
			});
}

function setSelected(obj, val){
	for(i=0; i<obj.options.length; i++){
		if(obj.options[i].value==parseInt(val)) index=i;
	}
	if(index) obj.options[index].selected=true;
}

function formData2QueryString(docForm) {

        var strSubmit       = '';
        var formElem;
        var strLastElemName = '';
        
        for (i = 0; i < docForm.elements.length; i++) {
                formElem = docForm.elements[i];
                switch (formElem.type) {
                        // Text, select, hidden, password, textarea elements
                        case 'text':
                        case 'hidden':
                        case 'password':
                        case 'textarea':
				formElem.value = formElem.value.replace(/&/g, '%26');
				formElem.value = formElem.value.replace(/\+/g, '%2B');
				strSubmit += formElem.name + '=' + formElem.value + '&';
                        break;
                        case 'select-one':
                        	strSubmit += formElem.name + '=' + escape(formElem.options[formElem.selectedIndex].value) + '&';
                        break;
                        case 'checkbox':
                        	if(formElem.checked == true) strSubmit += formElem.name + '=' + escape(formElem.value) + '&';
                        break;
                        case 'radio':
	                        if(formElem.checked == true) strSubmit += formElem.name + '=' + escape(formElem.value) + '&';
                }
        }
        return strSubmit;
}

function _FRM_LIST_ADD(elm_name){
	$('#id_'+elm_name+' .frm_list .lst .item .btn').hide();
	$('#id_'+elm_name+' .frm_list .lst .item .h').val(1);
	$('#id_'+elm_name+' .frm_list .lst').append($('#'+elm_name+'_LIST_H').html());
	$('#id_'+elm_name+' .frm_list .item input.fo_date').datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1990:2020'
	});
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


function format_float(number){
	var str = new String();
	str = number + "";
	arr = str.split(/\./);
	if(arr.length>1){
		if((arr[1]).length<2)
			str = str + "0";
		if((arr[1]).length>2)
			str = Math.round(str*100)/100;
	}else{
		str = str + ".00";
	}
	return str;
}

function checkInt(x){
	var filter  = /^[0-9]*$/;
	if (filter.test(x)) return true;
	else return false;
}

function valid_email(){
	if(checkMail(document.forms['news'].elements['email'].value)) 
		document.forms['news'].submit();
	else
		alert('Neteisingai įvestas el. paštas.');
}

function checkMail(x)
{
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (filter.test(x)) return true;
	else return false;
}

function valid_number(x)
{
	var filter  = /^([0-9])*$/;
	if (filter.test(x)) return true;
	else return false;
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
