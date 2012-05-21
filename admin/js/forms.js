var eFORM = {
		
		load:function(name){
			this.name = name;
			$('#'+this.name+' .FRM').change(function(){
				nm = $(this).attr('name').replace("[]", '');
				$('#id_'+nm).addClass('edited');
			});
			this.save_button();
		},
		
		add_field:function(field){
			this.fields[this.fields.length] = field;
		},
		
		save_button:function(){
			//$('#content').append("<div class='form_submit'><input type='button' class='fo_submit radius3' value='Save' /></div>");
		}
		
}