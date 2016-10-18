<fieldset class="formElementsField table action_info">
    
    <legend>{phrases.main.common.info_title}</legend>
    
    <div class="row">
        <span class="cell">ID#:</span> 
        <span class="cell">{info.id}</span>
    </div>
    
    <div class="row">
        <span class="cell">{phrases.main.common.info_module}:</span> 
        <span class="cell">{info.module_info.title} ({info.module_info.table_name} - #{info.module_info.id})</span>
    </div>

    {block no}
    {block info.parent_id}
    <div class="row">
        <span class="cell">{phrases.main.common.info_parent_id}:</span> 
        <span class="cell">
            <a href="javascript: void()">{info.parent_id}</a>
        </span>
    </div>
    {-block info.parent_id}
    {-block no}
        
    <div class="row">
        <span class="cell">{phrases.main.common.info_sort_number}:</span> 
        <span class="cell">{info.sort_order}</span>
    </div>

    {block info.module_info.multilng}
    <div class="row">
        <span class="cell">{phrases.main.common.info_languages_saved}:</span> 
        <span class="cell">
            {loop item_lng_status}
            <label><input type="checkbox" disabled {block item_lng_status.disabled}checked{-block item_lng_status.disabled}>{item_lng_status._KEY}</label>
            {-loop item_lng_status}
        </span>
    </div>
    {-block info.module_info.multilng}
    
    {loop info_extra}
    <div class="row">
        <span class="cell">{info_extra.title}:</span> 
        <span class="cell">{info_extra.value}</span>
    </div>
    {-loop info_extra}
        
</fieldset>
    
<fieldset class="formElementsField table action_info">
    
    <legend>{phrases.main.common.info_created}</legend>
    
    <div class="row">
        <span class="cell">{phrases.main.common.info_created_date}:</span> 
        <span class="cell">{info.create_date}</span>
    </div>

    {block info.create_by_admin.title}
    <div class="row">
        <span class="cell">{phrases.main.common.info_created_by}:</span> 
        <span class="cell">{info.create_by_admin.title}</span>
    </div>
    {-block info.create_by_admin.title}

    <div class="row">
        <span class="cell">{phrases.main.common.info_created_ip}:</span> 
        <span class="cell">{info.create_by_ip}</span>
    </div>

</fieldset>

<fieldset class="formElementsField table action_info">
    
    <legend>{phrases.main.common.info_updated}</legend>
    
    <div class="row">
        <span class="cell">{phrases.main.common.info_updated_date}:</span> 
        <span class="cell">{info.last_modif_date}</span>
    </div>

    {block info.last_modif_by_admin.title}
    <div class="row">
        <span class="cell">{phrases.main.common.info_updated_by}:</span> 
        <span class="cell">{info.last_modif_by_admin.title}</span>
    </div>
    {-block info.last_modif_by_admin.title}

    <div class="row">
        <span class="cell">{phrases.main.common.info_updated_ip}:</span> 
        <span class="cell">{info.last_modif_by_ip}</span>
    </div>
    
</fieldset>