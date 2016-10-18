{loop list}
<label class="table" style="float:left;width:170px;">
    <div class="cell" style="width:10px;">
        <input type='checkbox' name='{elm.column_name}[]' value='{list.id}' class='FRM {style}_{elm.elm_type}' {block list.selected}checked{-block list.selected} {block list.readonly}disabled{-block list.readonly} {list.field_extra_params}>
    </div>
    <div class="cell">
        <span style="vertical-align:top;{block list.readonly}color:#AAA;{-block list.readonly}">{list.title}</span>
    </div>
</label>
{-loop list}
