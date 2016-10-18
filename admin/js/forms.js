var eFORM = {
		
    load:function(name){
        this.name = name;
        $eform = this;
        $('#'+this.name+' .FRM').change(function(){
            nm = $(this).attr('name').replace("[]", '');
            $('#id_'+$eform.name+'_'+nm).addClass('edited');
            $('#ELM_state_'+$eform.name+'_'+nm).val(1);
            // set navigation status to warning form data is not saved
            $NAV.is_not_saved = true;
        });
        $('#'+this.name+' .ELM_state[value=1]').each(function(i, elm){
            $eform.set_edited($(this).attr('rel'));
        });
    },

    set_edited:function(name){
        $('#id_'+this.name+'_'+name).addClass('edited');
        // set navigation status to warning form data is not saved
        $NAV.is_not_saved = true;
    },

    add_field:function(field){
        this.fields[this.fields.length] = field;
    },
            
    remove_autocomplete_value:function(elm_name, value){
        $("#autocomplete_" + elm_name + "_" + value).remove();
        this.set_edited(elm_name);
    },
		
    clear_autocomplete_value:function(elm_name){
        $("#autocomplete_" + elm_name + " .autocomplete_values").remove();
        this.set_edited(elm_name);
    },

    add_autocomplete_value:function(elm_name, item_data){
        html = "<div id=\"autocomplete_" + elm_name + "_" + item_data.value + "\" class=\"autocomplete_values\">";
        html+= "<input type=\"hidden\" name=\"" + elm_name + ($("#autocomplete_" + elm_name).attr("data-multiple")==1 ? "[]" : "") + "\" value=\"" + item_data.value + "\">";
        html+= "<a href=\"javascript: void(eFORM.remove_autocomplete_value('" + elm_name + "', '" + item_data.value + "'));\" class=\"close\">x</a>";
        html+= "<a>" + item_data.label + "</a>";
        html+= "</div>";
        $("#autocomplete_" + elm_name).append(html);
        this.set_edited(elm_name);
    }
            
}