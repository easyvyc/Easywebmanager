var eDIALOG = {
		
		opened:false,
		overlay:'#_OVERLAY',
		dialog:'#_WINDOW',
		content:'#_WINDOW_content',
		tabs:'#_WINDOW_tabs',
		tabs_i:'#_WINDOW_tabs_inner',
		ico:'#_WINDOW_ico',
		loading:'#_WINDOW_loading',
		tab_arr:[],
		current_tab:0,

		my_alert:function(msg){
			this.showDialog(msg);
			$(this.dialog).oneTime(3000, this.closeDialog);
		},

		doAjaxRequest:function(url){

		    if(arguments[1]){
		    	func = arguments[1];
		    }
		    
		    $obj = this;
			
			$.ajax({
				  async: true,
				  url: url,
				  cache: false,
				  beforeSend: function(){
					  $obj.showDialog('Loading...', 'Loading...', 'loading');
					  $obj.openLoading();
				  },
				  success: function(html){
					$obj.closeLoading();
				    $obj.closeTab('loading');
				    if(typeof(func)=='function') func(html);
				  },
				  //timeout: 20,
				  complete: function(html){
				    
				  }
				});
				
			return false;	
		},

		showAjaxDialog:function(url, title, tab_id){

			$('#contextMenuArea').hide();
			
			$obj = this;
			
			$.ajax({
			  async: true,
			  url: url,
			  cache: false,
			  dataType:"html",
			  beforeSend: function(){
			  	$obj.openLoading();
			  },
			  success: function(html){
				  $obj.showDialog(html, title, tab_id);
				  $obj.closeLoading();
			  },
			  //timeout: 20,
			  complete: function(html){
			    
			  }
			});
			
			return false;
			
		},

		saveEditDialog:function(id){
			if($('#obj_text').val()==''){
				$('#'+id+'_btn').removeClass('isinfo');
			}else{
				$('#'+id+'_btn').addClass('isinfo');
			}
			$('#'+id).val($('#obj_text').val()); 

			arr = id.split("_");
			rid = arr[2];
			
			$obj = this;
			
			if(arguments[1] && rid!=0){
				module = arguments[1];
				field = arguments[2];
				$obj = this;
				$.ajax({
					  type: "POST",
					  async: true,
					  url: "ajax.php?content=call&module="+module+"&method=setValue",
					  cache: false,
					  data: "params[field]="+field+"&params[value]="+$('#obj_text').val()+"&params[record_id]="+rid,
					  beforeSend: function(){
						$($obj.content).html("<img src='images/loading.gif' alt='' />");
					  },
					  success: function(html){
						$obj.closeDialog();
					  },
					  //timeout: 20,
					  complete: function(html){
					    
					  }
					});		
			}else{
				this.closeDialog();
			}	
		},

		printDialog:function(){
			$(this.content).print($(this.content+' .item_title').html());
		},

		showDialog:function(msg, title, tab_id){
			
			if(!this.opened){
				$(this.overlay).fadeIn(200, function(){ $(this.overlay).css('filter', 'alpha(opacity=55)'); });
				//$('#OVERLAY').fadeTo(200, 0.55);
				//console.log($(document).scrollTop());
				$(this.dialog).css('top', 150 + 'px');
			}
			
			this.createTab(msg, title, tab_id);
			
			if(!this.opened){
				client_h = f_clientHeight();
				client_w = f_clientWidth();
				if($(this.dialog).width() > (client_w-30)){
					$(this.dialog).width(client_w - 30);
					$(this.content).width(client_w - 50);
				}
				$(this.dialog).css('left', parseInt(client_w/2) - parseInt($(this.dialog).width()/2) + 'px');
				
				$(this.dialog).fadeIn(200);
			}
			
			this.opened = true;
			
		},

		createTab:function(msg, title, tab_id){
			if(typeof(title)=='undefined' || title=='') title = '[...]';
			if(typeof(tab_id)=='undefined' || tab_id=='') tab_id = this.generateTabid();
			this.addTab(tab_id, title);
			$(this.content).append("<div id=\"c_"+tab_id+"\" class=\"tab_c\">"+msg+"</div>");
			this.openTab(tab_id);
			this.tab_arr[this.tab_arr.length] = {id:tab_id};
		},
		
		validateTitle:function(title){
			if(title.length > 13){
				title = title.substring(0, 10)+'...';
			}
			return title;
		},		
		
		addTab:function(tab_id, title, ico){
			short_title = this.validateTitle(title);
			if(this.checkTab(tab_id)) return false;
			$(this.tabs_i).append("<div id=\"t_"+tab_id+"\" class=\"tab_t\">" +
					((typeof(ico)!='undefined' && ico!='')?"<img src=\"thumb.php?image=images/modules/"+ico+".gif&w=15&h=15&t=1\" class=\"vam\" />&nbsp;":"") +
					"<a href=\"javascript: void(eDIALOG.openTab('"+tab_id+"'));\" title=\""+title+"\">"+short_title+"</a>&nbsp;" +
					"<a href=\"javascript: void(eDIALOG.closeTab('"+tab_id+"'))\"><img src=\"images/T_close.gif\" alt=\"\" class=\"vam\" />" +
					"</a></div>");
		},
		
		checkTab:function(tab_id){
			for(var i=0; i<this.tab_arr.length; i++){
				if(this.tab_arr[i].id==tab_id){
					return true;
				}
			}
			return false;
		},
		
		generateTabid:function(){
			return $.random(6);
		},
		
		openTab:function(tab_id){
			$(this.content).find('.tab_c').hide();
			$("#c_"+tab_id).show();
			$(this.tabs_i).find('.tab_t').removeClass('a');
			$("#t_"+tab_id).addClass('a');
			this.current_tab = tab_id;
		},
		
		getCurrentTab:function(){
			return this.current_tab;
		},

		closeTab:function(tab_id){
			if(!this.is_openedTabs()){
				this.closeDialog();
			}else{
				for(i=0; i<this.tab_arr.length; i++){
					if(this.tab_arr[i].id==tab_id){
						index = i;
						break;
					}
				}
				for(i=index; i<(this.tab_arr.length-1); i++){
					this.tab_arr[i] = this.tab_arr[(i+1)];
				}
				//console.log(this.tab_arr);
				this.tab_arr.pop();
				//console.log(this.tab_arr);
				//console.log(index);
				if($('#t_'+tab_id).hasClass('a')){
					if(index>1){
						this.openTab(this.tab_arr[index-1].id);
					}else{
						this.openTab(this.tab_arr[index].id);
					}
				}
			}
			$('#c_'+tab_id).remove();
			$('#t_'+tab_id).remove();
		},
		
		is_openedTabs:function(){
			return ($(this.tabs_i).find('.tab_t').length>1?true:false);
		},

		closeDialog:function(){
			$(this.overlay).fadeOut(500);
			$(this.dialog).fadeOut(500);
			$(this.dialog).stopTime();
			this.clear();
			this.opened = false;
		},
		
		openLoading:function(){
			//$(this.content).addClass("loading");
			$(this.loading).show();
		},
		
		closeLoading:function(){
			//$(this.content).removeClass("loading");
			$(this.loading).hide();
		},
		
		clear:function(){
			$(this.content).html('');
			$(this.tabs_i).html('');
		}
		
}

$.extend({ 
	  random: function (length, special) {
	    var iteration = 0;
	    var password = "";
	    var randomNumber;
	    if(special == undefined){
	        var special = false;
	    }
	    while(iteration < length){
	        randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
	        if(!special){
	            if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
	            if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
	            if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
	            if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
	        }
	        iteration++;
	        password += String.fromCharCode(randomNumber);
	    }
	    return password;
	  }
});
