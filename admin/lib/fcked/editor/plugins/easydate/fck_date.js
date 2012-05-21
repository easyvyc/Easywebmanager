var dialog	= window.parent ;
var oEditor = dialog.InnerDialogLoaded() ;
var FCKLang		= oEditor.FCKLang ;

// Gets the document DOM
var oDOM = oEditor.FCK.EditorDocument ;

var oActiveEl = dialog.Selection.GetSelection().MoveToAncestorNode( 'FORM' ) ;

var FORMID = 0;


// Set the dialog tabs.
dialog.AddTab( 'Info', FCKLang.DlgFormTabInfo ) ;
dialog.AddTab( 'Params', FCKLang.DlgFormTabSettings ) ;
dialog.AddTab( 'Required', FCKLang.DlgFormTabRequired ) ;

// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;
	ShowE('divParams'		, ( tabCode == 'Params' ) ) ;
	ShowE('divRequired'		, ( tabCode == 'Required' ) ) ;
}

window.onload = function()
{
	// First of all, translate the dialog box texts
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	if ( oActiveEl )
	{
		GetE('txtName').value	= oActiveEl.name ;
		
		var form_data = getForm();
		
		FORMID = form_data.id;
		
		$('#selType').val(form_data.selType);
		$('#targetEmailEmails').val(form_data.targetEmailEmails);
		$('#targetEmailSubject').val(form_data.targetEmailSubject);
		$('#targetEmailFromemail').val(form_data.targetEmailFromemail);
		$('#targetEmailFromname').val(form_data.targetEmailFromname);
		$('#targetEmailTemplate').val(form_data.targetEmailTemplate);
		$('#targetDatabaseModule').val(form_data.targetDatabaseModule);
		$('#targetCustomModule').val(form_data.targetCustomModule);
		$('#targetCustomMethod').val(form_data.targetCustomMethod);
		
		$('.types').hide();
		$('#type_'+form_data.selType).show();
		
		$('#tmp').html(oActiveEl.innerHTML);
		
		required_fields_arr = new Array;
		$('#tmp input,#tmp select,#tmp textarea').each(function(){ 
			if(this.name && jQuery.inArray(this.name, required_fields_arr)==-1){ 
				required_fields_arr[required_fields_arr.length] = this.name;
				//alert(required_fields_arr[required_fields_arr.length-1]+'  '+jQuery.inArray(this.name, required_fields_arr));
				$('#divRequired').append('<div style="padding:5px;"><input type="checkbox" id="'+this.name+'" '+(is_checked(this.name, form_data.required_fields)?'checked':'')+' /><label>'+this.name+'</label></div>');
			}
		});
		
	}
	else
		oActiveEl = null ;

	dialog.SetOkButton( true ) ;
	dialog.SetAutoSize( true ) ;
	//SelectField( 'txtName' ) ;
}

function is_checked(name, required_fields){
	arr = required_fields.split("::");
	for(i=0; i<arr.length; i++){
		if(arr[i]==name) return true;
	}
	return false;
}

var return_data = new Object;

function getForm(){
	str = oActiveEl.action.substring(oActiveEl.action.indexOf('?')+1).replace("\"", "");

	str_obj = new Object;
	
	arr = str.split('&');
	for(j=0; j<arr.length; j++){
		arr2 = arr[j].split('=');
		if(arr2[0]=='formid') formid = arr2[1];
	}
	
	getFormData(formid);
	
	return return_data;
	
}

function getFormData(formid){
	$.ajax({
		url:"../../../../../../xml.php?get=json&module=forms&method=loadItem&params="+formid+"&lng=", 
		dataType:"json",
		async:false,
		success: function(data){
			for(var key in data){
				return_data[key] = data[key].replace(new RegExp("<br />","g"), "\n").replace(new RegExp("&quote;","g"), "\"");
			}
		}
	});
}

function createNewFormid(){
	return editFormid(0);
}

function editFormid(formid){
	
	var form_data = new Object;
	var form_data_str = '';
	
	form_data.parent_id = 0;
	if(formid==0){
		form_data.isNew = 1;
		form_data.id = 0;
	}else{
		form_data.isNew = 0;
		form_data.id = formid;
	}
	
	form_data.title = GetE('txtName').value;
	form_data.selType = $('#selType').val();
	form_data.targetEmailEmails = GetE('targetEmailEmails').value;
	form_data.targetEmailSubject = GetE('targetEmailSubject').value;
	form_data.targetEmailFromemail = GetE('targetEmailFromemail').value;
	form_data.targetEmailFromname = GetE('targetEmailFromname').value;
	form_data.targetEmailTemplate = GetE('targetEmailTemplate').value;
	form_data.targetDatabaseModule = GetE('targetDatabaseModule').value;
	form_data.targetCustomModule = GetE('targetCustomModule').value;
	form_data.targetCustomMethod = GetE('targetCustomMethod').value;
	
	var str = '';
	$('#divRequired input').each(function(){
		if(this.checked) str += this.id+'::';
	});
	form_data.required_fields = str;
	
	for(var key in form_data){
		form_data_str += key+'='+form_data[key]+'&';
	}
	
	var formid = $.ajax({
		type:"POST",
		url:"../../../../../../xml.php?get=editForm",
		data:form_data_str,
		async:false
	}).responseText;
	
	return formid;
	
}

function Ok()
{
	if ( !oActiveEl )
	{
		oActiveEl = oEditor.FCK.InsertElement( 'form' ) ;
		
		FORMID = createNewFormid();

		if ( oEditor.FCKBrowserInfo.IsGeckoLike )
			oEditor.FCKTools.AppendBogusBr( oActiveEl ) ;
	}else{
		editFormid(FORMID);
	}

	oActiveEl.name = GetE('txtName').value ;
	SetAttribute( oActiveEl, 'action', "post.php?formid="+FORMID ) ;
	oActiveEl.method = "post" ;
	SetAttribute( oActiveEl, 'target', "FORMS_IFRAME" ) ;
	

	return true ;
}