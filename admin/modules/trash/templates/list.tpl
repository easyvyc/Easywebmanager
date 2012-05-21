<table border="0" cellpadding="5" cellspacing="0" width="100%">
	
	<tr>
		<td align="left" valign="top" height="20" style="width:100%;">

{menu}

		</td>
	</tr>	
	<tr>
		<td>
		
		
<div style="width:100%;">
		
	<div class="modulesMain" id="secondlist" style="width:100%;">



<ul style="width:100%;padding:0px;margin:0px;">	
<li class="dragLayer" id="secondlist_secondlist1" style="width:100%;">
<div id="elements_list" style="<block name="not_empty_elements" no>display:none;</block name="not_empty_elements" no>">
	
<div id="items_list_grid">
	
	{items_list_content}

</div>

</div>
</li>
</ul>



	</div>
	
</div>

		</td>
	</tr>
</table>


<div class="formElementsFieldWYSIWYG" id="show_trash_item_main" style="position:absolute;z-index:1000;width:850px;display:none;">

	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('show_trash_item',10,40);" id="show_trash_item_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{elm.title}</span>
			</td>
			<td align="right">
	<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('show_trash_item',10,40);" ><img id="img_show_trash_item_id" src="images/minus.gif" border="0" style="vertical-align:middle;" vspace="0" hspace="0" alt="" /></a>&nbsp;
	<a style="cursor:pointer;" onclick="javascript: $('show_trash_item_main').style.display='none';" ><img id="img_close_trash_item_id" src="images/close.gif" border="0" style="vertical-align:middle;" vspace="0" hspace="0" alt="" /></a>&nbsp;
			</td>
		</tr>
	</table>
	</div>
	
	
	<div id="show_trash_item" style="padding:3px;margin-top:-10px;">
	</div>
	
</div>

<script type="text/javascript">
popup_show('show_trash_item_main', 'show_trash_item_drag', '', 'screen-right', 10, 100);
</script>