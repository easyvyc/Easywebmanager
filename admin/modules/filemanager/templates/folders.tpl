<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
	<head>
		<title>Folders</title>
		<link href="browser.css" type="text/css" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/filemanager.css" />
                
    <link rel="stylesheet" type="text/css" href="css/tree.css" />

	<script language="JavaScript" type="text/javascript" src="js/admin.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/nav.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/listChangeFields.js"></script>
    <script language="JavaScript" type="text/javascript" src="js/tree.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="js/sorting/prototype.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/sorting/scriptaculous.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/sorting/dragdrop.js"></script>
        
        
	</head>
	<body class="FileArea" style="margin:0px;" oncontextmenu="javascript: return false;">

<div id="folders_top">
<img src="images/logo.png" class="png" alt="" />
</div>
<br />
<div id="files_tree_id">
<div id="module_tree_files_c"  class="module_tree_box" style=""></div>
</div>


<div id="contextMenuArea" onmouseout="javascript: hideTreeItemContenxtMenu(event);"></div>
        
<script type="text/javascript">
	
	var TreeObj_files_c = new TreeClass('{config.site_url}', '{config.admin_dir}', 'files', 'files', 'c', 'lt');
	
	TreeObj_files_c.param.dragndrop = 0;
	TreeObj_files_c.param.checkbox = 0;
	TreeObj_files_c.param.context = 1;
    
    TreeObj_files_c.create(0);

	if(document.body.addEventListener){
		document.body.addEventListener('contextmenu', TreeObj_files_c.mouseRightClick, true);
	}else{
		$('files_tree_id').oncontextmenu = TreeObj_files_c.mouseRightClick;
	}
    
    function deleteTreeItem(folder){
	    TreeObj_files_c.param.deletefolder = folder;
	    TreeObj_files_c.param.action = 'delete';
    	TreeObj_files_c.create(0);
    }
    
    function editTreeItem(folder, id){
		$('link_'+id+'_c').style.display='none';
	    $('edit_'+id+'_c').style.display='inline';
	    $('edit_'+id+'_c').focus();
    	$('contextMenuArea').style.display='none';
    }
    
    function changeTreeItem(folder, id, obj, evt){
    	keyCode = getKeyCode(evt);
    	if(keyCode==13){
		    if(is_valid_folder_name(obj.value)){
	    		TreeObj_files_c.param.editfolder = folder;
			    TreeObj_files_c.param.newname = obj.value;
			    TreeObj_files_c.param.action = 'edit';
			    TreeObj_files_c.param.fid = id;
	    		TreeObj_files_c.create(0);
    		}else{
    			alert('Wrong folder name!');
    		}
    	}
	    if(keyCode == 27){
			$('link_'+id+'_c').style.display='inline';
		    $('edit_'+id+'_c').style.display='none';
    	}
    }
    
    function createTreeItem(folder, id){
    	if($('item_new'+id+'_c')) return;
    	if(!$('main_'+id+'_c')){
    		$('item_'+id+'_c').innerHTML += '<ul class="tree" id=\'main_'+id+'_c\'></ul>';
    	}
        $('main_'+id+'_c').style.display = 'block';
    	$('main_'+id+'_c').innerHTML += '<li class="sep" id="sep_new_c"><img src="images/0.gif" height="1" width="1" vspace="0" hspace="0" alt="" border="0" /></li>';
        $('main_'+id+'_c').innerHTML += '<li class="item mod_mod_c" id="item_new'+id+'_c" rel="parent_'+id+'"><img src="images/tree/blank.gif" alt="" class="vam" /> <img src="images/tree/folder.gif" class="vam" /> <input type="text" id="edit_new'+id+'_c" value="" class="edittreeitem" onkeypress="javascript: changeTreeItem(\''+folder+'\', \'0\', this, event);" /></li>';
        $('edit_new'+id+'_c').focus();
        $('contextMenuArea').style.display='none';
    }
    
    function is_valid_folder_name(folder){
    	if(folder.match(/^[a-zA-Z0-9_-]+$/)) return true;
        else return false;
    }
    
    	
</script>        

        
	</body>
</html>
