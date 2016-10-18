<fieldset class="formElementsField table action_info">
    
    <legend>{phrases.main.common.note_title}</legend>
    
    <form id="create-note-form" action="javascript: void($NAV.post('?module={module_info.table_name}&method=note&id={item.id}&json=1&area=action_area_{item.id}', $('#create-note-form')));" method="post" style="padding:0 10px">
        <textarea name="note" placeholder="{phrases.main.common.note_placeholder}" required></textarea><br />
        <input type="submit" value="{phrases.main.common.note_submit}" class="fo_submit">
        <input type="hidden" name="action" value="note">
    </form>
    
</fieldset>
    
{loop notes}
<fieldset class="formElementsField table action_info">
    
    <legend>{notes.author}: {notes.comment_date}</legend>
    
    <div style="padding:10px">{notes.text}</div>

</fieldset>
{-loop notes}