<style>
    .car_modif_values {
        padding:7px !important;
        max-height:250px;
        overflow:auto;
    }
    .car_modif_values .value {
        margin:5px 0 !important;
        padding:3px !important;
        box-shadow:0 0 2px #999;
        position:relative;
    }
    .car_modif_values .value .remove {
        position:absolute;
        top:3px;
        right:5px;
        cursor:pointer;
    }
    .add_car_modif_area {
        padding:7px !important;
        background:#DDD;
    }
</style>
<script src="admin/js/jquery.chained.remote.min.js"></script>
<script>
    $(document).ready(function(){
    
        $('#id_{form_settings.id}_{elm.name} .car_modif_values .remove').live('click', function(){
            var car_modif_id = $(this).parents('.value').attr('data-modif-id');
            $(this).parents('.value').remove();
            return false;
        });

        $("#car_model").remoteChained({
            parents : "#car_mark",
            url : "admin.php?module=cars&method=list_model_by_mark"
        });

        $("#car_modif").remoteChained({
            parents : "#car_model",
            url : "admin.php?module=cars&method=list_modif_by_modif"
        });
        
        $('#add_car_modif').click(function(){
            var modifs = $('#car_modif').val();
            for(var i=0; i < modifs.length; i++){
                if($("#id_{form_settings.id}_{elm.name} .car_modif_values [data-modif-id=" + modifs[i] + "]").size() == 0){
                    $("#id_{form_settings.id}_{elm.name} .car_modif_values").append("<div class='value' data-modif-id='" + modifs[i] + "'>" + $('#car_modif option[value='+modifs[i]+']').html() + "<input type='hidden' name='{elm.name}[]' value='" + modifs[i] + "'><a class='remove' title='Išimti'>x</a></div>");
                }
                
            }
            $('#car_model').val('');
            $('#car_modif').empty().append('<option selected="selected" value="">---</option>');
            ;            
        });
    
    });
</script>
<div id="id_{form_settings.id}_{elm.name}" class="formElementsField {elm.style}">
    <div class="t">
        <span class="">{elm.title}:{block elm.required}*{-block elm.required}</span>
        {block elm.show_error}<span class="error_message">{elm.error_message}</span>{-block elm.show_error}
    </div>
    <div class="e">

        <div class="car_modif_values">
            
            {loop car_modifs}
            <div class="value" data-modif-id="{car_modifs.id}">
                {car_modifs.title}
                <input type="hidden" name="{elm.name}[]" value="{car_modifs.id}">
                <a href="javascript: void(return false);" class="remove" title="Išimti">x</a>
            </div>
            {-loop car_modifs}
            
        </div>
        
        <div class="add_car_modif_area">
            <table>
                <tr>
                    <td valign="top">
            <select id="car_mark" name="car_mark" size="15">
              <option value="">--</option>

              {loop cars}
              <option value="{cars.id}">{cars.title}</option>
              {-loop cars}

            </select>
                    </td>
                    <td valign="top">
            <select id="car_model" name="car_model" size="15">
              <option value="">--</option>
            </select>
                     </td>
                     <td valign="top">
            <select id="car_modif" name="car_modif" multiple size="15">
              <option value="">--</option>
            </select>        
                     </td>
                     <td valign="top">
            <input type="button" value=" Add " class="fo_button" id="add_car_modif">
            <br />
            Pasirinkite markę, modelį ir modifikacijas (laikant nuspadus "Ctrl" mygtuką galite, pažymėti keletą modifikacijų iškart)
                     </td>
                </tr>
            </table>

        </div>

    </div>	
</div>
