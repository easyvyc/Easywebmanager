<script language="javascript">

function startUpdate(btn){
	btn.disabled = true;
	top.desktop.location = 'update.php?step=2';
	window.frames['parent'].frames['toper'].document.getElementById('upd_img').src='images/top/update_start.gif';
}

</script>



<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
	<tr>
		<td align="left" valign="top" style="padding:10px;padding-top:0px;">

<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" align="left" class="update">
    
    <block name="error">
    <span class="error">{error}</span>
    </block name="error">
    
    <!--block name="step1">
    <block name="update_exist">
    {phrases.updates_exist_title}
    <input type="button" name="update_button_ok" class="button" value=" {phrases.get_updates_list_button} " onclick="javascript: location='update.php?step=2';">
    </block name="update_exist">
    
    <block name="update_exist" no>
    {phrases.no_updates_exist_title}
    </block name="update_exist" no>
    </block name="step1"-->
    
    
    <block name="step1">
    
    <block name="empty" no>
    
    
<div style="padding-top:10px;">
{items_list_content}
</div>


    <input type="submit" value=" {phrases.update.update_button} " class="fo_submit" onclick="javascript: startUpdate(this);">


    </block name="empty" no>

    
	<block name="empty">
	{phrases.update.no_updates_exist_title}
	</block name="empty">
    
    </block name="step1">
    
    <block name="update_complete">
    {phrases.update.update_complete}

	<script language="javascript">
		window.frames['parent'].frames['toper'].document.getElementById('upd_img').src='images/update.gif';
	</script>

    </block name="update_complete">
    
    </td>
  </tr>
</table>



		</td>
	</tr>
</table>

