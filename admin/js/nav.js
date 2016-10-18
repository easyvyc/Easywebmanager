var $NAV = {
		
	main_url:'admin.php',
	is_not_saved:false,
	request:{},
	default_request_state: {
		url:"",
		dataType:"json",
		post:false,
		history_push:true
	},
	current_state: {
		module:"",
		method:"",
		id:0,
		params:{}
	},
	last_state: {
		module:"",
		method:"",
		id:0,
		params:{}
	},
	
	check_not_saved:function(){
		if(!this.post && this.is_not_saved){
			return true;
		}else{
			return false;
		}
	},
	
	confirm_not_saved:function(){
		confirm("Do you?");
	},
	
	change_language:function(lng){

		rq = "";
		if(this.current_state.module) rq += "module="+this.current_state.module+"&";
		if(this.current_state.method) rq += "method="+this.current_state.method+"&";
		if(this.current_state.id) rq += "id="+this.current_state.id+"&";
		if(this.current_state.params) rq += ""+$(this.current_state.params).serialize()+"&";
		
		this.request = {
				post:false,
				dataType:"json",
				url:"?"+rq+"lng="+lng,
				history_push:true
		};
		$('#lang a').removeClass('a');
		$('#lang .'+lng).addClass('a');
		
		this.current_state.lng = lng;
		this.load();		
	},
	
	select_module:function(module){
		this.request = {
				post:false,
				dataType:"json",
				url:"?module="+module,
				history_push:true
		};
		this.set_state(module, '', 0, {});
                
                $('#module_folder a').removeClass('a');
                $('#module_folder li[rel=' + module + '] a').addClass('a');
                
		this.load();
	},
                
	select_context_action:function(module, method, id){
		this.request = {
				post:false,
				dataType:"json",
				url:"?module="+module+"&method="+method+"&id="+id,
				history_push:true
		};
		this.set_state(module, method, id, {});
		this.load();
	},
	
	load:function(){
		if(this.check_not_saved()){
			if(!this.confirm_not_saved()){
				return false;
			}
		}
		$obj = this;
		
		$.ajax({
			async: false,
			url: $obj.main_url + $obj.request.url + "&ajax=1",
			dataType:$obj.request.dataType,
			data:$obj.request.post_data,
			type: ($obj.request.post?"POST":"GET"),
			beforeSend:function(){
				$obj.start_loading();
			},
			complete:function(){
				
			},
			success: function(_json_response_) {
				$obj.end_loading();
				if(_json_response_.loged==true){
					
					if($obj.request.history_push){
						//history.pushState(null, null, $obj.main_url + $obj.request.url);
					}
					$obj.response(_json_response_);
					$obj.is_not_saved = false;
					$obj.request = $obj.default_request_state;
					
				}else{
					$obj.login(_json_response_);
				}

			}
		});
	},
	
	response:function(_json_response_){
		ln = _json_response_.section.length;
		for(var _I_=0; _I_<ln; _I_++){
			if(!$("#"+_json_response_.section[_I_].id).length){
				$('body').append("<div id='"+_json_response_.section[_I_].id+"'></div>");
				if(_json_response_.section[_I_].attr){
					for(var _KEY_ in _json_response_.section[_I_].attr){
						$("#"+_json_response_.section[_I_].id).attr(_KEY_.name, _KEY_.value);		
					}
				} 
			}
			$("#"+_json_response_.section[_I_].id).html(_json_response_.section[_I_].content);
		}
	},
	
	login:function(json){
		$obj.end_loading();
		login_obj = new eDIALOG('login');
		login_obj.showDialog('');
		for(i=0; i<json.section.length; i++){
			$("#"+json.section[i].id).html(json.section[i].content);
		}
	},
                
        open_dialog:function(dialog_area_id, url, title){
                e_multiDialog.open_url(dialog_area_id, url, title);
        },
                
	close_dialog:function(dialog_area_id){
                e_multiDialog.close(dialog_area_id);
        },
                
	reload_tree:function(){
		if(this.last_state.module!=this.current_state.module){
			
		}
	},

	set_state:function(module, method, id, params){
		
		this.last_state = this.current_state;
		
		this.current_state.module = module;
		this.current_state.method = method;
		this.current_state.id = id;
		this.current_state.params = params;
		//console.dir(this.current_state);
	},
	
	get:function(get){
		this.request = {
				post:false,
				dataType:"json",
				url:get,
				history_push:false
		};
		this.load();
	},
	
	post:function(get, form){
                this.request = {
				post:true,
				post_data:(typeof(form.serialize)=='function'?form.serialize():form),
				dataType:"json",
				url:get,
				history_push:false
		};
		this.load();
	},
	
	
	post_enctype:function(get, form){
                //console.dir(new FormData(document.getElementById(form.attr('id'))));
		$obj = this;

		$.upload( get + "&ajax=1", new FormData(document.getElementById(form.attr('id'))), null, 'json')
		.progress( function( progressEvent, upload) {
			$obj.start_loading();
			if( progressEvent.lengthComputable) {
		        var percent = Math.round( progressEvent.loaded * 100 / progressEvent.total) + '%';
		        if( upload) {
		            //console.log( percent + ' uploaded');
		        } else {
		            //console.log( percent + ' downloaded');
		        }
		    }
		})
		.done( function( _json_response_) {
		    //console.log( 'Finished upload');
		    $obj.end_loading();
		    $obj.response(_json_response_);
		    // add your code for rendering the server response
		    // into html here
		});
		
	},
	
	start_loading:function(){
		loading_start();
	},
	end_loading:function(){
		loading_end();
	}
		
}