/**
 * 
 */

var $FB_APP = {
	
	uploadurl:'',
	
	obj_index:1,
	
	set_upload_url:function(url){
		this.uploadurl = url;
	},
	
	load:function(){
		
		this.load_info();
		
		$('.tlb').each(function(){
			$(this).append("<div class='cmd'>" +
								"<div class='handle'></div>" +
								(typeof($(this).attr('rel'))!='undefined'?"<div class='edit' onclick='javascript: $FB_APP.edit_click($(this));'></div>":"") +
								"<div class='remove' onclick='javascript: $FB_APP.remove_click($(this));'></div>" +
								"</div>").css({position:'relative',minHeight:'30px'});
		});
		
		$fb_obj = this;
		
		$( "#_FB_APP_TOOLBAR div.tlb" ).draggable({
			connectToSortable: "#_FB_APP_EDIT",
			helper: "clone",
			revert: "invalid"
		});
		
		$( "#_FB_APP_EDIT" ).sortable({
			revert: true,
			placeholder:'sort_placeholder_highlight',
			opacity:0.8,
			containment: '#_FB_APP_EDIT',
			axis:'y',
			items:'.tlb',
			start:function(event, ui){
				$('.sort_placeholder_highlight').height($(ui.item).height()).width($(ui.item).width());
			},
			stop:function(event, ui){

			},
			update:function(event, ui){
				if(typeof(ui.item.attr('id'))=='undefined'){
					$fb_obj.add_block(ui.item);
				}
				//$fb_obj.change($(ui.item).attr('id'));
				$fb_obj.sort_reset();
				$fb_obj.save();
			}
		});		
		
		/*
		$('#_FB_APP_EDIT').sortable({
			opacity:0.8,
			axis:'y',
			handle:'.handle',
			items:'.drag',
			cancel:'',
			tolerance: 'pointer',
			placeholder:'sort_placeholder_highlight',
			start:function(event, ui){
				$('.sort_placeholder_highlight').height($(ui.item).height()).width($(ui.item).width());
			},
			update:function(event, ui){
				$fb_obj.change($(ui.item).attr('id'), 'position', 2);
				$fb_obj.save();
			}
		}).css({position:'relative'});
		*/

	},
	
	add_block:function(block){
		index = this.obj_index++;
		while($("#fb_index_"+index).length!=0){
			index = this.obj_index++;
		}
		block.attr('id', 'fb_index_'+index);
		if(!block.hasClass('social_useapp') && !block.hasClass('social_readapp')){
			this.openEditDialog(block.attr('rel'), block.attr('id'));
		}
		this.info.data[block.attr('id')] = {"type":block.attr('rel')};
	},
	
	edit_click:function(obj){
		mainobj = obj.parent().parent();
		type = mainobj.attr('rel');
		id = mainobj.attr('id');
		this.openEditDialog(type, id);
	},
	
	openEditDialog:function(type, id){
		eDIALOG.showAjaxDialog("admin.php?module=fb_app&method=editBlock&params[id]="+id+"&params[type]="+type, "Edit: '"+type+"'", '');		
	},
	
	remove_click:function(obj){
		mainobj = obj.parent().parent();
		mainobj.remove();
		this.sort_reset();
		delete this.info.data[mainobj.attr('id')];
		this.save();
	},
	
	change:function(id, key, val){
		//console.log(this.info[id][key]);
		this.info.data[id][key] = val;
	},
	
	reset:function(){
		sort_length = this.info.sort.length;
		if(sort_length==0) return false;
		for(i=0; i<sort_length; i++){
			block_data = this.info.data[this.info.sort[i]];
			block = $("#_FB_APP_TOOLBAR_"+block_data.type);
			block.find('.tlb').attr('id', this.info.sort[i]);
			$("#_FB_APP_EDIT").append(block.html());
			this.load_block_info(block_data.type, this.info.sort[i]);
		}
	},
	
	sort_reset:function(){
		new_sort = [];
		$("#_FB_APP_EDIT .tlb").each(function(){
			new_sort[new_sort.length] = $(this).attr('id');
		});
		this.info.sort = new_sort;
	},
	
	load_info:function(){
		$fb_obj = this;
		
		$.ajax({
			  url: "files/data/fb_app.js",
			  dataType:"json",
			  async: false,
			  cache:false,
			  success: function(json){
				  $fb_obj.info = json;
				  $fb_obj.reset();
			  }
		});
				
	},
	
	save:function(){
		$fb_obj = this;
		
		$.ajax({
			  url: "admin.php?module=fb_app&method=save_app",
			  dataType:"json",
			  data:"data="+escape($.toJSON($fb_obj.info)),
			  type:"POST",
			  async: false,
			  cache:false,
			  success: function(json){
				  $fb_obj.info = json;
				  $fb_obj.msg("Išsaugota.");
			  }
		});
					
	},
	
	load_block_info:function(type, id){
		if(type=='image'){
			if(this.info.data[id].url){
				$("#"+id+" .content").html("<a href=\""+this.info.data[id].link+"\" target=\"_blank\"><img src=\""+this.uploadurl+id+"/"+this.info.data[id].url+"\" width=\"520\"></a>");
			}
		}
		if(type=='news'){
			if(this.info.data[id].link){
				$fb_obj = this;
				$.ajax({
					  url: "admin.php?module=fb_app&method=load_rss&rssurl="+escape($fb_obj.info.data[id].link)+"&limit=10",
					  dataType:"json",
					  type:"GET",
					  async: true,
					  success: function(json){
						  $("#"+id+" .content").empty();
						  for(i=0; i<json.length; i++){
							  $("#"+id+" .content").append("<div ><b>"+json[i].title+"</b><p>"+json[i].description+"</p></div>");
						  }
					  }
				});
			}
		}
		if(type=='news1'){
			if(this.info.data[id].link){
				$fb_obj = this;
				$.ajax({
					  url: "admin.php?module=fb_app&method=load_rss&rssurl="+escape($fb_obj.info.data[id].link)+"&limit=1",
					  dataType:"json",
					  type:"GET",
					  async: true,
					  cache:true,
					  success: function(json){
						  $("#"+id+" .content .title1 b").html(json[0].title);
						  $("#"+id+" .content .title1 p").html(json[0].description);
					  }
				});
			}
		}
		if(type=='news2'){
			if(this.info.data[id].link){
				$fb_obj = this;
				$.ajax({
					  url: "admin.php?module=fb_app&method=load_rss&rssurl="+escape($fb_obj.info.data[id].link)+"&limit=2",
					  dataType:"json",
					  type:"GET",
					  async: true,
					  cache:true,
					  success: function(json){
						  $("#"+id+" .content .item1_title b").html(json[0].title);
						  $("#"+id+" .content .item2_title b").html(json[1].title);
						  $("#"+id+" .content .item1_title p").html(json[0].description);
						  $("#"+id+" .content .item2_title p").html(json[1].description);
					  }
				});
			}
		}
	},
	
	msg:function(str){
		$('#_SYSTEM_MSG').html(str);
		$('#_SYSTEM_MSG').fadeIn(500);
		$('#_SYSTEM_MSG').oneTime(3000, this.clearMsg);
	},
	
	clearMsg:function(){
		$('#_SYSTEM_MSG').fadeOut(500, function(){$('#_SYSTEM_MSG').html('');});
	}
	
}