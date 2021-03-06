function initGridObject(){
	//alert(this.columns.allColumnWidth);
}

function resetColumnWidth(value){
	
	if(!$('#header_'+this.name)) return false;
	$('#header_'+this.name).width(value + '%');
	return value;
	
}

function fieldsColumnAdd(name, width, type){
	var i = this.cols.length;
	this.cols[i] = new Object;
	this.cols[i].name = name;
	this.cols[i].width = width;
	this.cols[i].cells = new Array;
        this.cols[i].optionArray = new Array;
	this.cols[i].reset = resetColumnWidth;
        var $obj = this;
	if(type=='select' || type == 'checkbox_group' || type == 'radio'){
		this.cols[i].elm_choice = 1;
		this.cols[i].createSelectObject = function(obj, value){
				arr = value.split('::');
                    $(obj).append($("<option></option>").attr("value","").text("---")); 
                    $.each($obj.cols[i].optionArray, function(key, val) { 
                         $(obj).append($("<option></option>").attr("value",val.id).text(val.title).attr('selected', ($.inArray(val.id, arr)==-1 ? false : true))); 
                    });
		};
	}else{
		this.cols[i].elm_choice = 0;
	}

	this.allColumnWidth += width;
}

function gridClass(module){
	
	this.module = module;
        this.cid = 0;

	this.columns = new Object;
	this.columns.cols = new Array;
	this.columns.add = fieldsColumnAdd;
	this.columns.allColumnWidth = 0;
	
	this.grid_sortable_arr = [];
	
	this.cellBlurEvent = function(cell){
		var arr = cell.id.split("___");
		$('#item___'+arr[1]+'___'+arr[2]).addClass('column');
		$('#value___'+arr[1]+'___'+arr[2]).show();
		$('#edit___'+arr[1]+'___'+arr[2]).hide();
	};
	
	this.getColumnIndex = function(column_name){
		for(var i=0; i<this.columns.cols.length; i++){
			if(this.columns.cols[i].name==column_name) return i;
		}
	};
	
	this.selectRow = function(checkbox){
		row = $('#item_row_'+checkbox.value);
		if(checkbox.checked){
			row.addClass('selected');
		}else{
			row.removeClass('selected');
		}
	};
	
	this.saveEditItem = function(id, field, value){
		$obj = this;
		$.ajax({
			url: "admin.php?module="+this.module+"&method=change_field&ajax=1",
			type: "POST",
			data: "id="+id+"&column="+field+"&value="+value,
			dataType: "json",
			success: function(json){
				if(json.error==0){
					if(json.elm_type!='checkbox'){
						$("#value___"+field+"___"+id).html(json.value);
						$obj.cellBlurEvent(document.getElementById('edititem___'+field+'___'+id));
					}else{
						$("#buttonImg_"+id+"_"+field).attr('src', 'admin/images/status_'+json.value+'.gif');
						$("#chk_"+id+"_"+field).val(json.value==1 ? 0 : 1);
					}
				}else{
					eDIALOG.my_alert(json.error_message);
				}
				$('#DEBUG_content').html(json.debug);
			}
		});
	};
	
	this.cellEditItem_text = this.cellEditItem_textarea = function(cell){

		var arr = cell.id.split("___");

		str = $('#value___'+arr[1]+'___'+arr[2]).html().replace("&lt;", "<").replace("&gt;", ">");
		$('#edititem___' + arr[1] + '___' + arr[2]).val(str);

		$('#item___'+arr[1]+'___'+arr[2]).addClass('column').addClass('edit');
		$('#value___'+arr[1]+'___'+arr[2]).hide();
		$('#edit___'+arr[1]+'___'+arr[2]).show();
		$('#edititem___'+arr[1]+'___'+arr[2]).focus();
		
	};
	
        this.cellEditItem_autocomplete = function(cell){
		return false;
	};
        
	this.cellEditItem_checkbox = function(cell){
		return false;
	};
	
	this.cellEditItem_image = function(cell){

		var arr = cell.id.split("___");

		$('#item___'+arr[1]+'___'+arr[2]).addClass('column').addClass('edit');
		if($('#edit___'+arr[1]+'___'+arr[2])) $('#edit___'+arr[1]+'___'+arr[2]).show();

		var old_value;
		
		var module = this.module;
		var language = this.language;
		
		var error_message_upload = "Error";
		
		var settings = {
			flash_url : "lib/swfupload/swfupload.swf",
			upload_url: "admin.php?module="+this.module+"&method=uploadFile",
			post_params: {"PHPSESSID" : getCookie('PHPSESSID'), "module" : this.module, "column" : arr[1], "id" : arr[2], "lng" : this.language, "old" : $('old_img_'+arr[1]+'_'+arr[2]).value },
			file_size_limit : "8 MB",
			file_types : "*.jpg;*.png;*.gif",
			file_types_description : "Images",
			file_upload_limit : 1,
			file_queue_limit : 1,
			button_window_mode : "transparent",
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "images/form_element_bgr.jpg",
			button_width: "100%",
			button_height: "23",
			button_placeholder_id: 'btn___'+arr[1]+'___'+arr[2],
			button_text: 'Upload',
			button_text_style: ".theFont { font-size: 12; text-align:center; }",
			button_text_left_padding: 6,
			button_text_top_padding: 2,
			
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : function(){ old_value = $('img___'+arr[1]+'___'+arr[2]).src; $('img___'+arr[1]+'___'+arr[2]).src="images/loading.gif"; },
			upload_progress_handler : uploadProgress,
			upload_error_handler : function(){ alert(error_message_upload); $('img___'+arr[1]+'___'+arr[2]).src=old_value; },
			upload_success_handler : function(){  },
			upload_complete_handler : function(){ $('img___'+arr[1]+'___'+arr[2]).src="file.php?module="+module+"&column="+arr[1]+"&id="+arr[2]+"&lng="+language+"&w=100&h=40&t=1&v="+escape(Math.random()); $('edit___'+arr[1]+'___'+arr[2]).style.display = 'none'; },
			queue_complete_handler : function(){}	// Queue plugin event
		};
		
		new SWFUpload(settings);
		
	};
	
	this.cellEditItem_file = function(cell){
		
		var arr = cell.id.split("___");

		$('item___'+arr[1]+'___'+arr[2]).className = 'column edit';
		if($('edit___'+arr[1]+'___'+arr[2])) $('edit___'+arr[1]+'___'+arr[2]).style.display = 'block';

		var old_value;
		
		var module = this.module;
		var language = this.language;
		
		var error_message_upload = "Error";
		
		var settings = {
			flash_url : "lib/swfupload/swfupload.swf",
			upload_url: "../xml.php?get=change_catalog_file_field",
			post_params: {"PHPSESSID" : getCookie('PHPSESSID'), "module" : this.module, "column" : arr[1], "id" : arr[2], "lng" : this.language, "old" : $('old_img_'+arr[1]+'_'+arr[2]).value },
			file_size_limit : "8 MB",
			file_types : "*.*",
			file_types_description : "All files",
			file_upload_limit : 1,
			file_queue_limit : 1,
			button_window_mode : "transparent",
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "images/form_element_bgr.jpg",
			button_width: "100%",
			button_height: "23",
			button_placeholder_id: 'btn___'+arr[1]+'___'+arr[2],
			button_text: 'Upload',
			button_text_style: ".theFont { font-size: 12; text-align:center; }",
			button_text_left_padding: 6,
			button_text_top_padding: 2,
			
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : function(){ old_value = $('img___'+arr[1]+'___'+arr[2]).src; $('img___'+arr[1]+'___'+arr[2]).src="images/loading.gif"; },
			upload_progress_handler : uploadProgress,
			upload_error_handler : function(){ alert(error_message_upload); $('img___'+arr[1]+'___'+arr[2]).src="images/0.gif"; },
			upload_success_handler : function(file, data, response){ $('file_link_'+arr[1]+'_'+arr[2]).innerHTML=data; },
			upload_complete_handler : function(){ $('img___'+arr[1]+'___'+arr[2]).src="images/0.gif"; $('edit___'+arr[1]+'___'+arr[2]).style.display = 'none'; },
			queue_complete_handler : function(){}	// Queue plugin event
		};
		
		new SWFUpload(settings);		
		
	};
	
	this.cellEditItem_submit = function(cell){
		return false;
	};
	this.cellEditItem_button = function(cell){
		return false;
	};
	
	this.cellEditItem_hidden = function(cell){
		//alert('asdfds');
		return false;
	};
	
	this.cellEditItem_date = function(cell, event){
		var arr = cell.id.split("___");
		$('#edititem___'+arr[1]+'___'+arr[2]).datepicker();
		return false;
	};
	
	this.cellEditItem_select = function(cell){

		var arr = cell.id.split("___");

		$('#item___'+arr[1]+'___'+arr[2]).addClass('column edit');
		$('#value___'+arr[1]+'___'+arr[2]).hide();
		$('#edit___'+arr[1]+'___'+arr[2]).show();
		
		index = this.getColumnIndex(arr[1]);
                this.columns.cols[index].createSelectObject(document.getElementById('edititem___'+arr[1]+'___'+arr[2]), $('#edititemvalue___'+arr[1]+'___'+arr[2]).val());
		
	};
		
	this.registerResizeColumn = function(e, column1, column2, column_index){
		this.column_for_resize_left = column1;
		this.column_for_resize_right = column2;
		this.column_index = column_index;
		var mousePos = mouseCoords(e);
		this.start_resize_x = mousePos.x;//(document.all?e.clientX + document.body.scrollLeft:e.pageX);
	};

	this.mouseRightClick = function(e){
		/*
		if (!e) var e = window.event;
		var targ;
		if (e.target) targ = e.target;
		else if (e.srcElement) targ = e.srcElement;
		if (targ.nodeType == 3) // defeat Safari bug
			targ = targ.parentNode;
		if(targ = getParentNodeByClassName(targ, 'item')){
			arr = targ.id.split('_');
			showItemContextMenu(arr[2], e);
			return false;
		}
		return true;
		*/	
	};

	this.hideItemContenxtMenu = function(event){
	
		if (!event) var event = window.event;
		if (!document.getElemtById('contextMenuArea').contains(event.relatedTarget || event.toElement)){ 
			$('#contextMenuArea').hide();
			return false;
		} 
	
	};
	
	this.init = function(module){
		
		this.module = module;
                
		WIDTH = 100;
		var CH = WIDTH/this.columns.allColumnWidth;
		for(var i=0, all_length=0; i<this.columns.cols.length; i++){
			col_length = parseInt(this.columns.cols[i].width * CH );
			//this.columns.cols[i].minGridCellWidth = this.minGridCellWidth;
			if((i+1)==this.columns.cols.length) col_length = WIDTH - all_length;
			col_length = this.columns.cols[i].reset(col_length);
			all_length += col_length;
		}		
	};
	
	this.get_target_row = function (ui_item_id){
		trs = $("#grid_area___"+this.module+" tbody").find('tr');
		for(i=0; i<trs.length; i++){
			if(trs[i].id == ui_item_id){
				return this.grid_sortable_arr[i];
			}
		}
	};
	
	this.make_sortable = function(){
		
		str = "#grid_area___"+this.module+" tbody tr";
		trs = $(str);
		for(i=0; i<trs.length; i++){
			this.grid_sortable_arr[this.grid_sortable_arr.length] = trs[i].id;
		}

		$grid_obj = this;
		$("#grid_area___"+this.module+" tbody").sortable({
			axis: "y",
			containment: "#grid_area___"+this.module+" tbody",
			cursor: "move",
			forceHelperSize: true,
			forcePlaceholderSize: true,
			helper: "clone",
			placeholder: "sortable_placeholder",
			update: function(event, ui){
				
				ui_item_id = ui.item.attr('id');

				target_row = $grid_obj.get_target_row(ui_item_id);

				if(ui_item_id==target_row) return false;
				p = ui_item_id.lastIndexOf("_")+1;
				firstid = ui_item_id.substring(p);
				p = target_row.lastIndexOf("_")+1;
				lastid = target_row.substring(p);
				$NAV.get('?' + $grid_obj.base_url + '&change_order=1&firstid='+firstid+'&lastid='+lastid);
				
			}
		}).disableSelection();
		
	};

	this.setFilter = function(column, value){
		$('#filteritem___' + column).val(value);
		$NAV.post('?' + this.base_url, $('#filter___' + this.module));
	};
                
	this.setFilters = function(filters){
                for (var column in filters) {
                    $('#filteritem___' + column).val(filters[column]);
                }
		$NAV.post('?' + this.base_url, $('#filter___' + this.module));
	};
	
	this.cleanFilter = function(column){
		$('#filter___' + column + ' input, #filter___' + column + ' select').val('');
		$NAV.post('?' + this.base_url, $('#filter___' + this.module));
	};
	
	this.cleanFilters = function(){
		$('.list_item_filter input, .list_item_filter select').val('');
		$NAV.post('?' + this.base_url, $('#filter___' + this.module));
	};
	
	this.selectAllItems = function(checked){
		$('.selectall input[type=checkbox]').attr('checked', checked);
	};
        
        
        this.tools_toggle = function($link){
            console.dir($($link));
            $($link).parents('td').find('.display_paging').toggle();
        }
        
	
}




var dragObject = null;
var mouseOffset = null;

function grid_mouseDownEvent(e, grid, column1, column2, column_index){

	dragObject  = true;
	
	grid.registerResizeColumn(e, column1, column2, column_index);
	//$('debug_info').innerHTML = column1 + ' ' + column2;
	return false;
}

function grid_mouseMoveEvent(e, grid){

	if (!e) var e = window.event;
	
	if(dragObject && typeof(gridObject)=='object'){
		
		var mousePos = mouseCoords(e);
		
		var mouseOffset = getMouseOffset(dragObject, e);
		
		column_width1 = parseInt($('#header_'+gridObject.column_for_resize_left).width());
		column_width2 = parseInt($('#header_'+gridObject.column_for_resize_right).width());
		
		diference = mousePos.x - gridObject.start_resize_x;
		
		if((column_width1 > 15 && diference < 0) || (column_width2 > 15 && diference > 0)){

			new_column_width = column_width1 + diference;// + mouseOffset.x;
			gridObject.start_resize_x = mousePos.x;
			
			index = gridObject.column_index-1;
			
			gridObject.columns.cols[index].reset(new_column_width);

			new_column_width2 = column_width2 - diference;// + mouseOffset.x;
			
			index = gridObject.column_index;
			//$('debug_info').innerHTML = new_column_width + ' ' + new_column_width2 + ' ' + diference + ' ' + column_width1 + ' ' + column_width2;
			gridObject.columns.cols[index].reset(new_column_width2);
		
		}

		return false;
	}
	
}

function grid_mouseOverEvent(e, grid, column){
	mouseOffset = getMouseOffset(targ, e);
	return false;
}

function grid_mouseOutEvent(e, grid){
	//grid_mouseUpEvent(e, grid);
}

function grid_mouseUpEvent(e, grid){
	
	if (!e) var e = window.event;
	
	if(dragObject && typeof(gridObject)=='object'){
		gridObject.registerResizeColumn(e, '');
		dragObject = null;
	}
	
	//grid.columns.cols[0].resetColumnWidth(new_column_width);
	
}

document.onmousemove = grid_mouseMoveEvent;
document.onmouseup = grid_mouseUpEvent;


function getMouseOffset(target, ev){
	ev = ev || window.event;

	var docPos    = getPosition(target);
	var mousePos  = mouseCoords(ev);
	return {x:mousePos.x - docPos.x, y:mousePos.y - docPos.y};
}

function getPosition(e){
	var left = 0;
	var top  = 0;

	while (e.offsetParent){
		left += e.offsetLeft;
		top  += e.offsetTop;
		e     = e.offsetParent;
	}

	left += e.offsetLeft;
	top  += e.offsetTop;

	return {x:left, y:top};
}

function mouseCoords(ev){
	if(ev.pageX || ev.pageY){
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
}