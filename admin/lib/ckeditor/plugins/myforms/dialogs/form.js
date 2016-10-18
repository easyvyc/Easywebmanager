$.fn.getType = function(){ return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase(); }

function createNewFormid(obj){
	return editFormid(0, obj);
}

function editFormid(formid, obj){
	
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
	
	form_data.title = obj.getValueOf('info', 'txtName');
	form_data.selType = obj.getValueOf('info', 'selType');
	form_data.targetEmailEmails = obj.getValueOf('settings_mail', 'targetEmailEmails');
	form_data.targetEmailSubject = obj.getValueOf('settings_mail', 'targetEmailSubject');
	form_data.targetEmailFromemail = obj.getValueOf('settings_mail', 'targetEmailFromemail');
	form_data.targetEmailFromname = obj.getValueOf('settings_mail', 'targetEmailFromname');
	form_data.targetEmailTemplate = obj.getValueOf('settings_mail', 'targetEmailTemplate');
	form_data.targetDatabaseModule = obj.getValueOf('settings_database', 'targetDatabaseModule');
	form_data.targetCustomModule = obj.getValueOf('settings_custom', 'targetCustomModule');
	form_data.targetCustomMethod = obj.getValueOf('settings_custom', 'targetCustomMethod');

	var str = '';
	$('#required_fields_items_area input').each(function(){
		if(this.checked) str += this.id+'::';
	});
	form_data.required_fields = str;
	
	for(var key in form_data){
		form_data_str += key+'='+form_data[key]+'&';
	}
	
	var formid = $.ajax({
		type:"POST",
		url:"admin.php?module=forms&method=edit_form",
		data:form_data_str,
		async:false
	}).responseText;
	
	return formid;
	
}

/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.dialog.add( 'form', function( editor ) {
    
	var autoAttributes = { selType:1,action:1,id:1,method:1,enctype:1,target:1 };

	return {
		title: editor.lang.myforms.form.title,
		minWidth: 350,
		minHeight: 250,
		onShow: function() {
			delete this.form;

			var path = this.getParentEditor().elementPath(),
				form = path.contains( 'form', 1 );

			if ( form ) {
				this.form = form;
				this.setupContent( form );
				
				action = this.form.getAttribute('action');

				str = action.substring(action.indexOf('?')+1).replace("\"", "");

				str_obj = new Object;
				
				arr = str.split('&');
				for(j=0; j<arr.length; j++){
					arr2 = arr[j].split('=');
					if(arr2[0]=='formid') formid = arr2[1];
				}
				
				if(formid){
					
					this.formid = formid;
					$obj = this;
					
					$.ajax({
						url:"admin.php?module=forms&method=outputItem&params[id]="+formid+"&params[type]=json", 
						dataType:"json",
						async:false,
						success: function(form_data){
							if(form_data.required_fields)
								form_data.required_fields = form_data.required_fields.split("::");
							if(form_data.targetEmailTemplate)
								form_data.targetEmailTemplate = form_data.targetEmailTemplate.replace(new RegExp("<br />","g"), "\n").replace(new RegExp("&quote;","g"), "\"");

							$obj.setValueOf('info', 'selType', form_data.selType);
							$obj.setValueOf('info', 'action', "index.php?module=forms&method=process&formid="+formid);
							//$obj.setValueOf('info', 'id', form_data.formid);
							
							$obj.setValueOf('settings_mail', 'targetEmailEmails', form_data.targetEmailEmails);
							$obj.setValueOf('settings_mail', 'targetEmailSubject', form_data.targetEmailSubject);
							$obj.setValueOf('settings_mail', 'targetEmailFromemail', form_data.targetEmailFromemail);
							$obj.setValueOf('settings_mail', 'targetEmailFromname', form_data.targetEmailFromname);
							$obj.setValueOf('settings_mail', 'targetEmailTemplate', form_data.targetEmailTemplate);
							
							$obj.setValueOf('settings_database', 'targetDatabaseModule', form_data.targetDatabaseModule);
							
							$obj.setValueOf('settings_custom', 'targetCustomModule', form_data.targetCustomModule);
							$obj.setValueOf('settings_custom', 'targetCustomMethod', form_data.targetCustomMethod);
							
							$('#required_fields_items_temp').html($obj.form.getHtml());
							
							required_fields_arr = new Array;
							//form_data = { required_fields: [] };
							$('#required_fields_items_area').html('');
                                                        var targetEmailTemplate = '';
							$('#required_fields_items_temp :input').each(function(){ 
								elm_name = $(this).attr('name');
								if(!elm_name) elm_name = $(this).attr('data-cke-saved-name');
								if(elm_name && jQuery.inArray(elm_name, required_fields_arr)==-1){ 
									required_fields_arr[required_fields_arr.length] = elm_name;
									$('#required_fields_items_area').append('<div style="padding:5px;"><input type="checkbox" style="vertical-align:middle;" id="'+elm_name+'" '+(jQuery.inArray(elm_name, form_data.required_fields)!==-1 || elm_name=='captcha'?'checked':'')+' />&nbsp;<label for="'+elm_name+'">'+elm_name+' ('+$(this).getType()+')</label></div>');
                                                                        title = $(this).attr('placeholder');
                                                                        targetEmailTemplate += (title ? title + ': ' : '') + '{' + elm_name + '}\n';
                                                                        if($(this).getType()=='email'){
                                                                            finded_email = '{' + elm_name + '}';
                                                                        }
								}
							});
                                                        
                                                        if($obj.getValueOf('settings_mail', 'targetEmailTemplate') == ''){
                                                            $obj.setValueOf('settings_mail', 'targetEmailTemplate', targetEmailTemplate);
                                                        }
                                                        if($obj.getValueOf('settings_mail', 'targetEmailFromemail')){
                                                            $obj.setValueOf('settings_mail', 'targetEmailFromemail', finded_email);
                                                        }
							
						}
					});
	
				}
			}
		},
		onOk: function() {
			var editor,
				element = this.form,
				isInsertMode = !element;

                        editor = this.getParentEditor();

                        if(this.getValueOf('info', 'txtName') == ''){
                            alert(editor.lang.myforms.form.required_form_name);
                            return false;
                        }

			if ( isInsertMode ) {
				element = editor.document.createElement( 'form' );
				!CKEDITOR.env.ie && element.append( editor.document.createElement( 'br' ) );
				
				if(this.getValueOf('info', 'selType') != 'simple'){
					FORMID = createNewFormid(this);
					this.setValueOf('info', 'action', "index.php?module=forms&method=process&formid="+FORMID ) ;
				}
				
			}else{
				if(this.getValueOf('info', 'selType') != 'simple'){
					editFormid(this.formid, this);
				}
			}

			if ( isInsertMode )
				editor.insertElement( element );
			this.commitContent( element );
		},
		onLoad: function() {
			function autoSetup( element ) {
				this.setValue( element.getAttribute( this.id ) || '' );
			}

			function autoCommit( element ) {
				if ( this.getValue() )
					element.setAttribute( this.id, this.getValue() );
				else
					element.removeAttribute( this.id );
			}

			this.hidePage('settings_mail');
			this.hidePage('settings_database');
			this.hidePage('settings_custom');
			if(this.getValueOf('info', 'selType') == 'simple'){
				this.hidePage('required_fields');
			}else{
				this.setValueOf('info', 'target', 'FORMS_IFRAME');
				this.showPage('settings_' + this.getValueOf('info', 'selType'));
				this.showPage('required_fields');
                                this.getContentElement('info', 'action').disable();
                                //this.getContentElement('info', 'id').disable();
                                this.getContentElement('info', 'target').disable();
                                this.getContentElement('info', 'method').disable();
			}
			
			this.foreach( function( contentObj ) {
				if ( autoAttributes[ contentObj.id ] ) {
					contentObj.setup = autoSetup;
					contentObj.commit = autoCommit;
				}
			});
		},
		contents: [
			{
			id: 'info',
			label: editor.lang.myforms.form.title,
			title: editor.lang.myforms.form.title,
			elements: [
				{
					type: 'hbox',
					widths: [ '45%', '55%' ],
					children: [
						{
							id: 'selType',
							type: 'select',
							label: editor.lang.myforms.form.sel_type,
							style: 'width:100%',
							'default': 'email',
							onChange: function( api ){
								this.getDialog().hidePage('settings_mail');
								this.getDialog().hidePage('settings_database');
								this.getDialog().hidePage('settings_custom');
								if(this.getValue() == 'simple'){
									this.getDialog().hidePage('required_fields');
									this.getDialog().showPage('info');
                                                                        this.getDialog().getContentElement('info', 'action').enable();
                                                                        //this.getDialog().getContentElement('info', 'id').enable();
                                                                        this.getDialog().getContentElement('info', 'target').enable();
                                                                        this.getDialog().getContentElement('info', 'method').enable();
								}else{
									this.getDialog().getContentElement('info', 'target').setValue('FORMS_IFRAME');
									this.getDialog().showPage('settings_' + this.getValue());
									this.getDialog().showPage('required_fields');
                                                                        this.getDialog().getContentElement('info', 'action').disable();
                                                                        //this.getDialog().getContentElement('info', 'id').disable();
                                                                        this.getDialog().getContentElement('info', 'target').disable();
                                                                        this.getDialog().getContentElement('info', 'method').disable();
                                                                        
								}
							},
							items: [
									[ editor.lang.myforms.form_sel_type.mail, 'mail' ],
									[ editor.lang.myforms.form_sel_type.database, 'database' ],
									[ editor.lang.myforms.form_sel_type.custom, 'custom' ],
									[ editor.lang.myforms.form_sel_type.simple, 'simple' ]
									]
						},
						{
							id: 'txtName',
							type: 'text',
                                                        required:true,
							label: editor.lang.common.name,
							'default': '',
							accessKey: 'N',
							setup: function( element ) {
								this.setValue( element.data( 'cke-saved-name' ) || element.getAttribute( 'name' ) || '' );
							},
							commit: function( element ) {
								if ( this.getValue() )
									element.data( 'cke-saved-name', this.getValue() );
								else {
									element.data( 'cke-saved-name', false );
									element.removeAttribute( 'name' );
								}
							}
						}
					]
				},
				{
				id: 'action',
				type: 'text',
				label: editor.lang.myforms.form.action,
				'default': '',
                                readonly: true,
				accessKey: 'T'
			},
				{
				type: 'hbox',
				widths: [ '45%', '55%' ],
				children: [
					{
					id: 'id',
					type: 'text',
					label: editor.lang.common.id,
					'default': '',
					accessKey: 'I'
				},
					{
					id: 'enctype',
					type: 'select',
					label: editor.lang.myforms.form.encoding,
					style: 'width:100%',
					accessKey: 'E',
					'default': '',
					items: [
						[ '' ],
						[ 'text/plain' ],
						[ 'multipart/form-data' ],
						[ 'application/x-www-form-urlencoded' ]
						]
				}
				]
			},
				{
				type: 'hbox',
				widths: [ '45%', '55%' ],
				children: [
					{
					id: 'target',
					type: 'text',
					label: editor.lang.common.target,
					style: 'width:100%',
					accessKey: 'M',
					'default': ''
				},
					{
					id: 'method',
					type: 'select',
					label: editor.lang.myforms.form.method,
					accessKey: 'M',
					'default': 'post',
					items: [
						[ 'GET', 'get' ],
						[ 'POST', 'post' ]
						]
				}
				]
			}
			]
		},
		{
		id: 'settings_mail',
		label: editor.lang.myforms.form.settings_title,
		title: editor.lang.myforms.form.settings_title,
		elements: [	
					{
						type: 'hbox',
						widths: [ '50%', '50%' ],
						children: [
							{
							id: 'targetEmailEmails',
							type: 'text',
							label: editor.lang.myforms.settings.target_emails
						},
							{
							id: 'targetEmailSubject',
							type: 'text',
							label: editor.lang.myforms.settings.target_subject
						}
						]
					},
					{
						type: 'hbox',
						widths: [ '50%', '50%' ],
						children: [
							{
							id: 'targetEmailFromemail',
							type: 'text',
							label: editor.lang.myforms.settings.target_from_email
						},
							{
							id: 'targetEmailFromname',
							type: 'text',
							label: editor.lang.myforms.settings.target_from_name
						}
						]
					},
					{
						id: 'targetEmailTemplate',
						type: 'textarea',
						label: editor.lang.myforms.settings.target_email_template
					}					
		           ]
		},
		{
		id: 'settings_database',
		label: editor.lang.myforms.form.settings_title,
		title: editor.lang.myforms.form.settings_title,
		elements: [	
					{
						id: 'targetDatabaseModule',
						type: 'text',
						label: editor.lang.myforms.settings.target_database_module
					}
		           ]
		},
		{
		id: 'settings_custom',
		label: editor.lang.myforms.form.settings_title,
		title: editor.lang.myforms.form.settings_title,
		elements: [	
					{
						id: 'targetCustomModule',
						type: 'text',
						label: editor.lang.myforms.settings.target_custom_module
					},
					{
						id: 'targetCustomMethod',
						type: 'text',
						label: editor.lang.myforms.settings.target_custom_metod
					}		           
		           ]
		},		
		{
			id: 'required_fields',
			label: editor.lang.myforms.form.required_fields,
			title: editor.lang.myforms.form.required_fields,
			elements: [	
						{
							id: 'required_fields_items',
							type: 'html',
							html: '<div>&nbsp;</div><div id=required_fields_items_temp style="display:none"></div><div id=required_fields_items_area></div>'
						}	
			           ]
		}
		]
	};
});
