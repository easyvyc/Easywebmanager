function _TREE_(module){
	
	this.module = module;
	this.extracted = [];
	this.opened = [];
	this.stop_context = false;
	
	this.load = function(){
		this.list(0);
	};
	
	this.extract = function(id){
                //alert($('#_BRANCH_' + id + ' .extract:first-child').attr('class'));
                if($('#_BRANCH_' + id + ' .extract[rel='+id+']').hasClass('no_sub')) return false;
		if(typeof(this.extracted[id])!='undefined' && this.extracted[id]!=false){
			if(typeof(this.opened[id])!='undefined' && this.opened[id]!=false){
				this.open(id);
			}else{
				this.close(id);
			}
		}else{
			this.open(id);
			this.list(id);
		}
		
	};
	
	this.open_branch = function(id){
		if(typeof(this.extracted[id])!='undefined' && this.extracted[id]!=false){
			if(typeof(this.opened[id])!='undefined' && this.opened[id]!=false){
				this.open(id);
			}
		}else{
			this.list(id);
			this.open(id);
		}
	};
	
	this.open = function(id){
		$('#_BRANCH_'+id).addClass('opened');
		$('#_BRANCH_'+id+' ul.tree:first').slideDown(500);
		$('#_BRANCH_'+id+' a.extract:first').removeClass('loading').addClass('opened');//('style', "background:url('admin/images/tree/minus"+($('#_BRANCH_'+id).hasClass('last')?'_last':'')+".gif') center center no-repeat;");
		this.opened[id] = false;
	};
	
	this.close = function(id){
		$('#_BRANCH_'+id).removeClass('opened');
		$('#_BRANCH_'+id+' ul.tree:first').slideUp(500);
		$('#_BRANCH_'+id+' a.extract:first').removeClass('loading').removeClass('opened');//attr('style', "background:url('admin/images/tree/plus"+($('#_BRANCH_'+id).hasClass('last')?'_last':'')+".gif') center center no-repeat;");
		this.opened[id] = true;
	};
	
	this.remove_branch = function(id){
		main_ul = $("#_BRANCH_"+id).closest('ul');
		is_last = $("#_BRANCH_"+id).hasClass('last');
		$('[rel='+id+']').remove();
		if(is_last){
			main_ul.find('li:last-child').removeClass('not_last').addClass('last');
		}
		if($('li', main_ul).size() == 0){
			main_ul.closest('li').find('a.extract').removeClass('sub').removeClass('opened').addClass('no_sub');
		}
	};
	
	this.replace_branch = function(branch_id, parent_branch_id, sort_to_item_id){
		$obj = this;
		$.ajax({
			async: false,
			url:"admin.php?module="+$obj.module+"&method=tree_replace_item&branch_id="+branch_id+"&parent_branch_id="+parent_branch_id+"&sort_to_item_id="+sort_to_item_id+"&ajax=1",
			dataType:"json",
			type: "GET",
			beforeSend:function(){
				$obj.start_loading(parent_branch_id);
			},
			complete:function(){
				
			},
			success: function(_json_response_) {
				$obj.end_loading();
				if(_json_response_.loged==true){
					$obj.remove_branch(branch_id);
					$('#_BRANCH_' + parent_branch_id + ' .extract:first').removeClass('no_sub').addClass('sub');
					$obj.refresh_branch(parent_branch_id);
				}else{
					$obj.close(parent_id);
					$NAV.login(_json_response_);
				}
			}
		});		
	}
	
	this.refresh_branch = function(parent_id){
		this.list(parent_id);
	};
	
	this.list = function(parent_id){
		this.paging(parent_id, 0);
	};
	
	this.paging = function(parent_id, offset){
		$obj = this;
		$.ajax({
			async: false,
			url:"admin.php?module="+$obj.module+"&method=tree&parent_id="+parent_id+"&offset="+offset+"&ajax=1",
			dataType:"json",
			type: "GET",
			beforeSend:function(){
				$obj.start_loading(parent_id);
			},
			complete:function(){
				
			},
			success: function(_json_response_) {
				$obj.end_loading();
				if(_json_response_.loged==true){
					$('#_BRANCH_'+parent_id+' div.child_branch').html(_json_response_.section[0].content);
					$obj.extracted[parent_id] = true;
					$obj.open(parent_id);
				}else{
					$obj.close(parent_id);
					$NAV.login(_json_response_);
				}

			}
		});		
	};
	
	this.context = function(obj_id){
		if(!this.stop_context) showItemContextMenu(obj_id);
	};
	
	this.open_item = function(id){
		
	};
	
	this.start_loading = function(parent_id){
		$('#_BRANCH_'+parent_id+' a.extract:first').addClass('loading');//attr('style', "background:url('admin/images/tree/loading.gif') center center no-repeat;");
	};
	
	this.end_loading = function(){
		
	};
	
}