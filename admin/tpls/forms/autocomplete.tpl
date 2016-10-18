<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
    <div class="t">
        <span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
        <span class="mini">{phrases.autocomplete_field_text}</span>
        {block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
    </div>
    <div class="e">

        <div id="autocomplete_{elm.name}" data-multiple="{elm.list_values.multiple}">
            
        {block elm.list_values.multiple no}
        {block elm.value}
        <div id="autocomplete_{elm.name}_{elm.value}" class="autocomplete_values">
                <input type="hidden" name="{elm.name}" value="{elm.value}">
                {block elm.editable}<a href="javascript: void(eFORM.remove_autocomplete_value('{elm.name}', {elm.value}));" class="close">x</a>{-block elm.editable}
                <a>{auto_complete_data.label}</a>
        </div>
        {-block elm.value}
        {-block elm.list_values.multiple no}
            
        {block elm.list_values.multiple}
        {loop list}
        <div id="autocomplete_{elm.name}_{list.id}" class="autocomplete_values">
                <input type="hidden" name="{elm.name}[]" value="{list.id}">
                {block elm.editable}<a href="javascript: void(eFORM.remove_autocomplete_value('{elm.name}', {list.id}));" class="close">x</a>{-block elm.editable}
                <a>{list.label}</a>
        </div>
        {-loop list}
        {-block elm.list_values.multiple}
        
        </div>

        <div>
            <input type='text' id="auto_text_{form_settings.id}_{elm.column_name}" value='' class='{style}_{elm.elm_type}' {block elm.editable no}readonly{-block elm.editable no} />
            {block elm.list_values.create_new}
            <a class="dotted" href="javascript: void($NAV.open_dialog('{elm.list_values.module}_{elm.column_name}_{form_data.id}', '?module={elm.list_values.module}&method=create_from_autocomplete&no_tree_reload=1&json=0&multiple={elm.list_values.multiple}&column={elm.column_name}', '{phrases.main.catalog.new_element}'));">[ NEW ]</a>
            {-block elm.list_values.create_new}
        </div>


        <script type="text/javascript">

            $( "#auto_text_{form_settings.id}_{elm.column_name}" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                  if ( event.keyCode === $.ui.keyCode.TAB &&
                      $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                  }
                })
                .autocomplete({
                  source: function( request, response ) {
                    $.getJSON( "?module={elm.list_values.module}&method={block elm.list_values.method}{elm.list_values.method}{-block elm.list_values.method}{block elm.list_values.method no}listAutocompleteItems{-block elm.list_values.method no}&columns={elm.list_values.columns}&left=1&right=1{block elm.list_values.list_title}&list_title={elm.list_values.list_title}{-block elm.list_values.list_title}", {
                      term: request.term
                    }, response );
                  },
                  search: function() {
                    // custom minLength
                    if ( this.value < 2 ) {
                      return false;
                    }
                  },
                  focus: function() {
                    // prevent value inserted on focus
                    return false;
                  },
                  select: function( event, ui ) {
                    var terms = this.value;
                    // remove the current input
                    
                    {block elm.list_values.multiple no}
                    eFORM.clear_autocomplete_value('{elm.name}');
                    {-block elm.list_values.multiple no}

                    eFORM.add_autocomplete_value('{elm.name}', ui.item);
                    
                    this.value = "";
                    return false;
                  }
                
            });

        </script>		

    </div>	
</div>
