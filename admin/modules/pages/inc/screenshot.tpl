{block elm.isNew no}
<div class="formElementsFieldWYSIWYG" id="page_screenshot">

	<div class="tbltop" ondblclick="javascript: togglePannelAnimatedStatus('page_screenshot_id',10,40);" id="page_screenshot_drag">
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="10"></td>
			<td class="round"><img src="images/flag.png" class="png" style="vertical-align:middle;" alt="" /></td>
			<td>
	&nbsp;<span style="cursor:default;" >{elm.title}</span>
			</td>
			<td align="right">
	<a style="cursor:pointer;" onclick="javascript: togglePannelAnimatedStatus('page_screenshot_id',10,40);" ><img id="img_page_screenshot_id" src="images/minus.gif" border="0" style="vertical-align:middle;" vspace="0" hspace="0" alt="" /></a>&nbsp;
			</td>
		</tr>
	</table>
	</div>
	
	
	<div class="editZone" id="page_screenshot_id">
		<img src="{elm.icourl}{elm.template.file1}" border="1" >
		{elm.template.map}
	</div>
	
</div>

<script type="text/javascript">
top.frames['content'].popup_show('page_screenshot', 'page_screenshot_drag', '', 'screen-bottom', 10, 250);
</script>
{-block elm.isNew no}