<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" class="tabMenu">
	<tr>
		
		<?php foreach($templateVariables->loops["menu"] as $menu_key => $menu_val){ ?>
		<td width="20" class="<?php if($menu_val["active"]){ ?>a<?php } ?><?php if(!$menu_val["active"]){ ?>p<?php } ?>" align="center">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" height="20">
			<tr>
				<td class="l" width="3"><img src="images/0.gif" width="3" height="1"><td>
				<td class="m"><a href="<?php echo $menu_val["page_url"]; ?>" class="path"><?php echo $menu_val["title"]; ?></a></td>
				<td class="r" width="3"><img src="images/0.gif" width="3" height="1"><td>
			<tr>
		</table>
		</td>
		<td width="2" class="p"><img src="images/0.gif" width="1" height="1"></td>
		<?php } ?>


		<td class="p">
		&nbsp;
		</td>
		
	</tr>
</table>
