<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
		<span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
		{block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">
		<select {block elm.editable no}readonly disabled{-block elm.editable no} name='{elm.name}{block elm.list_values.multiple}[]{-block elm.list_values.multiple}' id="ELMID_{elm.column_name}" class='FRM {style}_{elm.elm_type}' {block elm.list_values.multiple}multiple size="10"{-block elm.list_values.multiple} {elm.extra_params}>
		<option value="">-------------</option>
		{loop tpl_data}
                    <optgroup label="{tpl_data.title}">
                    {loop tpl_data.sub}
                        <option value="{tpl_data.sub.id}" >{tpl_data.sub.title}</option>
                        
                        {loop tpl_data.sub.sub}
                            <option value="{tpl_data.sub.sub.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{tpl_data.sub.sub.title}</option>
                            
                            {loop tpl_data.sub.sub.sub}
                                <option value="{tpl_data.sub.sub.sub.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{tpl_data.sub.sub.sub.title}</option>
                            {-loop tpl_data.sub.sub.sub}
                            
                        {-loop tpl_data.sub.sub}
                        
                    {-loop tpl_data.sub}
                    </optgroup>
                {-loop tpl_data}
		</select>
		
		{elm.extra_data}
		
	</div>	
</div>

<script>
$(document).ready(function(){

{block elm.list_values.multiple no}
{block elm.value}
$('#ELMID_{elm.column_name}').val('{elm.value}');
{-block elm.value}
{-block elm.list_values.multiple no}

{block elm.list_values.multiple}
{loop elm_values}
$("#ELMID_{elm.column_name} option[value='" + {elm_values._VALUE} + "']").prop('selected', true);
{-loop elm_values}
{-block elm.list_values.multiple}


});
    
</script>