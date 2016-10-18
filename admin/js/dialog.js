var e_multiDialog = {

	dialogs:[],
		
	load:function(id){
		if(typeof(this.dialogs[id])=='undefined'){
			this.dialogs[id] = new eDIALOG(id);
			this.dialogs[id].init();
		}
		return this.dialogs[id];
	},

	open:function(id, content){
		this.load(id).showDialog(content);
	},
	
	open_url:function(id, url, title){
                tab_id = 'tab_' + $.random(10);
		this.load(id).showAjaxDialog(url, title, tab_id);
	},
	
	close:function(id){
		this.load(id).closeDialog();
                
                // reikalingas nes sito nebeatsidaro popup 
		this.dialogs[id] = undefined;
	},
	
	print:function(id){
		this.load(id).printDialog();
	}

};

function eDIALOG(id){
		
		this.id = id;
		this.opened = false;
		this.overlay = '#_OVERLAY';
		this.tab_arr = [];
		this.current_tab = 0;

		this.init = function(){
			this.dialog = '#_WINDOW_'+this.id;
			this.content = '#_WINDOW_content_'+this.id;
			this.tabs = '#_WINDOW_tabs_'+this.id;
			this.tabs_i = '#_WINDOW_tabs_inner_'+this.id;
			this.ico = '#_WINDOW_ico_'+this.id;
			this.loading = '#_WINDOW_loading_'+this.id;
			
			$('body').append("<div id='_WINDOW_"+this.id+"' class='_WINDOW'><div id='_WINDOW_toolbar_"+this.id+"' class='_WINDOW_toolbar'><div id='_WINDOW_tabs_"+this.id+"' class='_WINDOW_tabs'><div id='_WINDOW_tabs_inner_"+this.id+"' class='_WINDOW_tabs_inner'></div></div>" +
					"<div id='_WINDOW_ico_"+this.id+"' class='_WINDOW_ico'>\n" +
                                        //"<a href='javascript: void(e_multiDialog.print(\""+this.id+"\"));'><img src='admin/images/W_print.gif' alt='' class='vam' /></a>&nbsp" +
					"<a href='javascript: void(e_multiDialog.close(\""+this.id+"\"));'><img src='admin/images/W_close.gif' alt='' class='vam' /></a></div></div>" +
					"<div id='_WINDOW_content_"+this.id+"' class='_WINDOW_content'></div></div>");

			$("#_WINDOW_"+this.id).draggable({ cursor: 'move', handle: '#_WINDOW_toolbar_'+this.id, opacity: 0.8, containment: 'body' });
			$("#_WINDOW_"+this.id).resizable({ autoHide: true, minHeight: 200, minWidth: 300, alsoResize: '#_WINDOW_content_'+this.id });
			
		},
                        
                this.my_alert = function(msg){
			this.showDialog(msg);
		},

		this.doAjaxRequest = function(url){

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
				    if(typeof(func)=='function') func(html);
				  },
				  //timeout: 20,
				  complete: function(html){
				    
				  }
				});
				
			return false;	
		},

		this.showAjaxDialog = function(url, title, tab_id){

                        $dlg_obj = this;
			
			$.ajax({
			  async: true,
			  url: url,
			  cache: false,
			  beforeSend: function(){
			  	$dlg_obj.openLoading();
			  },
			  success: function(html){
                                $dlg_obj.showDialog(html, title, tab_id);
                                $dlg_obj.closeLoading();
			  },
			  //timeout: 20,
			  complete: function(html){
			    
			  }
			});
			
			return false;
			
		},

		this.saveEditDialog = function(id){
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

		this.printDialog = function(){
			$(this.content).print($(this.content+' .item_title').html());
		},

		this.showDialog = function(msg){
                        if(typeof(arguments[1])!='undefined'){
                            // TODO: set dialog title = arguments[1]
                            //$(this.content).html(arguments[1]);
                        }
			$(this.content).html(msg);
			this.openDialog();
			
		},
		
		this.openDialog = function(){

                        client_h = f_clientHeight();
                        wnd_h = $(this.dialog).height();

                        if(client_h < wnd_h){
                            $(this.dialog).css('max-height', client_h + 'px');
                            $(this.content).css('max-height', client_h - 45 + 'px');
			}

                        wnd_top = parseInt(client_h/2) - parseInt($(this.dialog).height()/2);
                        if(wnd_top < 0) wnd_top = 0;

                        $(this.dialog).css('top', wnd_top + 'px');
                    
			if(!this.opened){
				client_w = f_clientWidth();
                                
				$(this.overlay).fadeIn(200, function(){ $(this.overlay).css('filter', 'alpha(opacity=55)'); });

				if($(this.dialog).width() > (client_w-30)){
					$(this.dialog).width(client_w - 30);
					$(this.content).width(client_w - 50);
				}
				$(this.dialog).css('left', parseInt(client_w/2) - parseInt($(this.dialog).width()/2) + 'px');
				
				$(this.dialog).fadeIn(200);
			}
			this.opened = true;
		},

		this.closeDialog = function(){
			$(this.overlay).fadeOut(500);
			$(this.dialog).fadeOut(500);
			$(this.dialog).stopTime();
			$(this.dialog).remove();
		},
		
		this.openLoading = function(){
			$(this.loading).show();
		},
		
		this.closeLoading = function(){
			$(this.loading).hide();
		}
		
};

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
