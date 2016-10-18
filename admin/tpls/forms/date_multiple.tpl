<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
	<div class="t">
            <span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>&nbsp;
            {block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
	</div>
	<div class="e">

                <table>
                    <tr>
                        <td>
                <div id="ELMID_multiple_{form_settings.id}_{elm.name}" class="date_multiple"></div>
                        </td>
                        <td>
                <textarea id="ELMID_{form_settings.id}_{elm.name}" name='{elm.name}_date' class='FRM vam {style}_{elm.elm_type} {style}_date_multiple' readonly>{elm.value}</textarea>
                        </td>
                    </tr>
                </table>
            

<script type="text/javascript" src="admin/js/jquery.multidatespicker.js"></script>
<script type="text/javascript">
$(function() {

    {block elm.value}
    var date_values_{elm.name} = [{loop date_values}{block date_values._FIRST no},{-block date_values._FIRST no}'{date_values._VALUE}'{-loop date_values}];
    {-block elm.value}

    $('#ELMID_multiple_{form_settings.id}_{elm.name}').multiDatesPicker({ 
            firstDay:1, 
            altFormat:'yy-mm-dd', 
            altField: "#ELMID_{form_settings.id}_{elm.name}", 
            {block elm.value}
            addDates: date_values_{elm.name},
            {-block elm.value}
            changeMonth:true, 
            changeYear:true, 
            showOtherMonths: true, 
            selectOtherMonths: true , 
            dateFormat:'yy-mm-dd'
            {block elm.extra_params}, {elm.extra_params}{-block elm.extra_params} 
    });
});

{block elm.editable}
{-block elm.editable}
    
</script>


	</div>
</div>
