function extractTreeItem(id){

	//alert($('main_'+id+'_'+this.nm));
	if($('main_'+id+'_'+this.nm).style.display=='none'){
		this.showTreeItem(id);
	}else{
		this.hideTreeItem(id);
	}

}

function redirect_field_click_function(url, id){ 
	this.setActiveItem(id); $('page_redirect').value=id; setEdited('page_redirect'); return false; 
}

function showTreeItem(id){

	if($('main_'+id+'_'+this.nm)) $('main_'+id+'_'+this.nm).style.display = 'block';
	if($('ico_'+id+'_'+this.nm)) if($('ico_'+id+'_'+this.nm).src.replace(this.baseurl, '')==(this.basedir+'images/tree/plus.gif')) $('ico_'+id+'_'+this.nm).src = 'images/tree/minus.gif';

}


function hideTreeItem(id){

	if($('main_'+id+'_'+this.nm)) $('main_'+id+'_'+this.nm).style.display = 'none';
	if($('ico_'+id+'_'+this.nm)) if($('ico_'+id+'_'+this.nm).src.replace(this.baseurl, '')==(this.basedir+'images/tree/minus.gif')) $('ico_'+id+'_'+this.nm).src = 'images/tree/plus.gif';

}


function mouseRightClick(e){

	if (!e) var e = window.event;
	var targ;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;

	if (targ.nodeType == 3) // defeat Safari bug
		targ = targ.parentNode;
	
	/*if (navigator.appName == 'Netscape' && e.which == 3) {
			if(targ = getParentNodeByClassName(targ, 'item')){
				arr = targ.id.split('_');
				showTreeItemContextMenu(arr[1], arr[2]);
				return true;
			}
	} else {*/
		//if (navigator.appName == 'Microsoft Internet Explorer' && event.button==2){

			if(targ = getParentNodeByClassName(targ, 'item')){
				arr = targ.id.split('_');
				showTreeItemContextMenu(arr[1], arr[2]);
				return true;
			}
		//}
	//	return false;
	//}
	return true;

}


function showTreeItemContextMenu(id, nm){
	
	//if(this.context!=1) return false;
	if(!$('contextmenu_'+id+'_'+nm)) return false;
	
	$('contextMenuArea').innerHTML = $('contextmenu_'+id+'_'+nm).innerHTML;
	var arr = findPos($('item_' + id + '_' + nm));
	$('contextMenuArea').style.left = arr[0] + 25 + 'px';
	$('contextMenuArea').style.top = arr[1] + 15 + 'px';
	$('contextMenuArea').style.display = 'block';
	return false;
	
}

if(typeof(HTMLElement)!='undefined'){
	HTMLElement.prototype.contains = function(node) {
		if (node == null)
			return false;
		if (node == this)
			return true;
		else
			return this.contains(node.parentNode);
	}
}

function hideTreeItemContenxtMenu(event){
	
	if (!event) var event = window.event;
	if (!$('contextMenuArea').contains(event.relatedTarget || event.toElement)){ 
		$('contextMenuArea').style.display = 'none';
		return false;
	} 
	
}

function treeItemImgClick(url, id){
	
	this.setActiveItem(id);
	eval(url);
	//top.content.location = url;
	
}

function treeSetActiveItem(id){
	for(i=0; i<this.items.length; i++){
		if($('link_'+this.items[i].id+'_'+this.nm)) $('link_'+this.items[i].id+'_'+this.nm).className = '';
	}
	if($('link_'+id+'_'+this.nm)) $('link_'+id+'_'+this.nm).className = 'active';
	this.currentItem = id;
}

function treeItemCheckboxClick(id){
	var sub_val = $('chk_'+id+'_'+this.nm).checked;
	var arr = $('main_'+id+'_'+this.nm).getElementsByTagName('input');
	for(var i=0; i<arr.length; i++){
		if(arr[i].type=='checkbox') arr[i].checked = sub_val;
	}
}

function createTree(id){
	
	this.opened = 1;
	//document.write(this.baseurl + this.basedir + "ajax.php?get=tree/"+this.script+"&module="+this.module+"&nm="+this.nm+"&lng="+this.lng+"&id="+id+this.getParamUrl());
	PageClass.getPageContent(this.baseurl + this.basedir + "ajax.php?get=tree/"+this.script+"&module="+this.module+"&nm="+this.nm+"&lng="+this.lng+"&id="+id+this.getParamUrl(), "module_tree_"+this.module+"_"+this.nm, 1);
	if(id) this.setActiveItem(id);
	
}

function treeItemChange(drag_to, drag_from){
	
	if(drag_to==drag_from.split('_')[1]) return false;
	if(confirm(this.phrases.move_confirm_text)) PageClass.getPageContent(this.baseurl+this.basedir+"ajax.php?get=tree/"+this.script+"&module="+this.module+"&nm="+this.nm+"&lng="+this.lng+"&action=drag&drag_to="+drag_to+"&drag_item="+drag_from+this.getParamUrl(), "module_tree_"+this.module+"_"+this.nm, 1);
	
}

function treeItemInsert(drag_to, drag_from){

	if(drag_to==drag_from.split('_')[1] || drag_to==document.getElementById(drag_from).getAttribute('rel').split('_')[1]) return false;
	if(confirm(this.phrases.move_confirm_text)) PageClass.getPageContent(this.baseurl+this.basedir+"ajax.php?get=tree/"+this.script+"&module="+this.module+"&nm="+this.nm+"&lng="+this.lng+"&action=parent&drag_to="+drag_to+"&drag_item="+drag_from+this.getParamUrl(), "module_tree_"+this.module+"_"+this.nm, 1);
	
}

function getParamUrl(){
	
	var str = "";
	for(var p in this.param){
		str += "&"+p+"="+this.param[p];
	}
	return str;
	
}

// for form control FRM_TEE
function show_hide_tree(elm, val){
	if(document.getElementById(elm+"_tree_id").style.display=="none"){
		//t_obj = 'TreeObj_'+mod+'_'+elm;
		//alert(typeof(eval(t_obj)));
		//if(typeof(eval(t_obj))!='object'){
			this.create(val);
			//eval("TreeObj_"+mod+"_"+elm+".create("+val+");");
		//}
		document.getElementById(elm+"_tree_id").style.display = "block";
		document.getElementById(elm+"_tree_show_button").style.display = "none";
		document.getElementById(elm+"_tree_hide_button").style.display = "block";
	}else{
		document.getElementById(elm+"_tree_id").style.display = "none";
		document.getElementById(elm+"_tree_show_button").style.display = "block";
		document.getElementById(elm+"_tree_hide_button").style.display = "none";
	}
}

function _TreeClass(url, basedir, script, mod, nm, lng, params, phrases, clickFunc){
	
	var obj = new TreeClass(url, basedir, script, mod, nm, lng);

	obj.param.dragndrop = params.dragndrop;
	obj.param.checkbox = params.checkbox;
	obj.param.context = params.context;

	obj.param.click = clickFunc;
	
	obj.phrases = phrases;
	
	if(clickFunc) obj.ImgClick = eval(clickFunc);
		
	return obj;
}

function TreeClass(url, basedir, script, mod, nm, lng){
	
	this.module = mod;
	this.lng = lng;
	this.script = script;
	this.nm = nm;
	this.opened = 0;
	this.baseurl = url;
	this.basedir = basedir;
	this.phrases = new Object();
	
	this.create = createTree;
	
	this.param = new Object();
	this.param.dragndrop = 0;
	this.param.checkbox = 0;
	this.param.context = 0;
	
	this.items = new Array;
	this.add = function(id, title){
		var index = this.items.length;
		this.items[index] = new Object();
		this.items[index].id = id;
		this.items[index].title = title;
	};
	
	this.extract = extractTreeItem;
	this.showTreeItem = showTreeItem;
	this.hideTreeItem = hideTreeItem;
	this.ImgClick = treeItemImgClick;
	this.CheckboxClick = treeItemCheckboxClick;
	this.setActiveItem = treeSetActiveItem;
	this.change = treeItemChange;
	this.insert = treeItemInsert;
	this.getParamUrl = getParamUrl;
	
	this.mouseRightClick = mouseRightClick;
	this.showTreeItemContextMenu = showTreeItemContextMenu;
	
	this.show_hide_tree = show_hide_tree;
	
}