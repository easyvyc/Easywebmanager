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
		params:{}
	},
	last_state: {
		module:"",
		method:"",
		params:{}
	},
	
	check_not_saved:function(){
		if(!this.post && this.is_not_saved){
			return true;
		}else{
			return false;
		}
	},
	
	select_module:function(module){
		
	},
	
	change_language:function(lng){
		
		rq = "";
		if(this.current_state.module) rq += "module="+this.current_state.module+"&";
		if(this.current_state.method) rq += "method="+this.current_state.method+"&";
		if(this.current_state.params) rq += "params="+$(this.current_state.params).serialize()+"&";
		
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
		this.set_state(module, '', {});
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
			success: function(json) {
				$obj.end_loading();
				if(json.loged==true){
					
					if($obj.request.history_push){
						history.pushState(null, null, $obj.main_url + $obj.request.url);
					}
					for(i=0; i<json.section.length; i++){
						if(!$("#"+json.section[i].id).length){
							$('body').append("<div id='"+json.section[i].id+"'></div>");
						}
						$("#"+json.section[i].id).html(json.section[i].content);
					}
					$obj.is_not_saved = false;
					$obj.request = $obj.default_request_state;
					
				}else{
					$obj.login(json);
				}

			}
		});
	},
	
	login:function(json){
		$obj.end_loading();
		eDIALOG.showDialog('');
		for(i=0; i<json.section.length; i++){
			$("#"+json.section[i].id).html(json.section[i].content);
		}
	},
	
	reload_tree:function(){
		if(this.last_state.module!=this.current_state.module){
			
		}
	},

	set_state:function(module, method, params){
		
		this.last_state = this.current_state;
		
		this.current_state.module = module;
		this.current_state.method = method;
		this.current_state.params = params;
		
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
				post_data:form.serialize(),
				dataType:"json",
				url:get,
				history_push:false
		};
		
		this.load();
	},
	
	start_loading:function(){
		loading_start();
	},
	end_loading:function(){
		loading_end();
	}
		
}