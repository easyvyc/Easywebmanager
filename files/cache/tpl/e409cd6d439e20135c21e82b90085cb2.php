<ul class="tree" id="_TREE_<?php echo TPL::getVar("module.table_name"); ?>_<?php echo TPL::getVar("tree_id"); ?><?php echo TPL::getVar("prefix"); ?>" style="<?php if(TPL::getVar("tree_id")){ ?>display:none;<?php } ?>">
	
	<?php $tree_list_iterator=1; foreach(TPL::getLoop("tree_list") as $tree_list_key => $tree_list_val){ if(!is_array($tree_list_val)){ $tmp_val=$tree_list_val; $tree_list_val=array(); $tree_list_val['_VALUE']=$tmp_val; } $tree_list_val['_FIRST']=0; if($tree_list_iterator==1) $tree_list_val['_FIRST']=1; if($tree_list_iterator%2==1) $tree_list_val['_EVEN']=0; else $tree_list_val['_EVEN']=1; $tree_list_val['_INDEX']=$tree_list_iterator++; $tree_list_val['_KEY']=$tree_list_key; ?>
	<li id="_BRANCH_<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?><?php echo TPL::getVar("prefix"); ?>" rel="<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?>" class="tree_item <?php if(isset($tree_list_val["_LAST"]) && $tree_list_val["_LAST"]){ ?>last<?php } ?><?php if(!isset($tree_list_val["_LAST"]) || !$tree_list_val["_LAST"]){ ?>not_last<?php } ?>">
	
		<div class="sep"></div>
	
		<table class="dropper <?php if(isset($tree_list_val["sub"]) && $tree_list_val["sub"]){ ?>isSub<?php } ?>" rel="<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?>" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td width="18">
					<?php if(isset($tree_list_val["sub"]) && $tree_list_val["sub"]){ ?>
					<a class="extract sub<?php if(isset($tree_list_val["_LAST"]) && $tree_list_val["_LAST"]){ ?>_last<?php } ?>" href="javascript: void(_TREE_<?php echo TPL::getVar("module.table_name"); ?>.extract('<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?><?php echo TPL::getVar("prefix"); ?>'));">&nbsp;</a>
					<?php } ?>
					<?php if(!isset($tree_list_val["sub"]) || !$tree_list_val["sub"]){ ?>
					<a class="extract no_sub<?php if(isset($tree_list_val["_LAST"]) && $tree_list_val["_LAST"]){ ?>_last<?php } ?>"></a>
					<?php } ?>
				</td>
				<td width="18">
					<a class="leaf" href="javascript: void(_TREE_<?php echo TPL::getVar("module.table_name"); ?>.context('_TREE_CONTEXT_<?php echo TPL::getVar("module.table_name"); ?>_<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?><?php echo TPL::getVar("prefix"); ?>'));" style="background:url('<?php echo TPL::getVar("config.admin_dir"); ?>images/tree/leaf.gif') center center no-repeat;"></a>
				</td>
				<td>
					<div><a href="javascript: void(_TREE_<?php echo TPL::getVar("module.table_name"); ?>.context('_TREE_CONTEXT_<?php echo TPL::getVar("module.table_name"); ?>_<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?><?php echo TPL::getVar("prefix"); ?>'));" class="<?php if(!isset($tree_list_val["active"]) || !$tree_list_val["active"]){ ?>striketrough<?php } ?>"><?php if(isset($tree_list_val["title"])) echo $tree_list_val["title"]; ?></a></div>
				</td>
			</tr>
		</table>
		
		<div id="_TREE_CONTEXT_<?php echo TPL::getVar("module.table_name"); ?>_<?php if(isset($tree_list_val["id"])) echo $tree_list_val["id"]; ?><?php echo TPL::getVar("prefix"); ?>" class="hide">
			<div class="title"><?php if(isset($tree_list_val["title_short"])) echo $tree_list_val["title_short"]; ?></div>
			<div class="text">
				<?php $tree_list_context_iterator=1; if(isset($tree_list_val["context"])){ foreach($tree_list_val["context"] as $tree_list_context_key => $tree_list_context_val){ if(!is_array($tree_list_context_val)){ $tmp_val=$tree_list_context_val; $tree_list_context_val=array(); $tree_list_context_val['_VALUE']=$tmp_val; } $tree_list_context_val['_FIRST']=0; if($tree_list_context_iterator==1) $tree_list_context_val['_FIRST']=1; if($tree_list_context_iterator%2==1) $tree_list_context_val['_EVEN']=0; else $tree_list_context_val['_EVEN']=1; $tree_list_context_val['_INDEX']=$tree_list_context_iterator++; $tree_list_context_val['_KEY']=$tree_list_context_key;  ?>
				<div><a <?php if(isset($tree_list_context_val["action"]) && $tree_list_context_val["action"]){ ?>href="<?php if(isset($tree_list_context_val["action"])) echo $tree_list_context_val["action"]; ?>"<?php } ?>><img src="<?php echo TPL::getVar("config.admin_dir"); ?>images/actions/<?php if(isset($tree_list_context_val["img"])) echo $tree_list_context_val["img"]; ?>.gif" alt="" class="vam" border="0" />&nbsp;<?php if(isset($tree_list_context_val["title"])) echo $tree_list_context_val["title"]; ?></a></div>
				<?php }} ?>
			</div>
		</div>
		
		<div class="child_branch <?php if(isset($tree_list_val["_LAST"]) && $tree_list_val["_LAST"]){ ?>last<?php } ?><?php if(!isset($tree_list_val["_LAST"]) || !$tree_list_val["_LAST"]){ ?>not_last<?php } ?>"></div>
		
	</li>
	<?php } ?>
	
	<?php if(TPL::getVar("paging")){ ?>
	<li class="paging">
		<?php $paging_iterator=1; foreach(TPL::getLoop("paging") as $paging_key => $paging_val){ if(!is_array($paging_val)){ $tmp_val=$paging_val; $paging_val=array(); $paging_val['_VALUE']=$tmp_val; } $paging_val['_FIRST']=0; if($paging_iterator==1) $paging_val['_FIRST']=1; if($paging_iterator%2==1) $paging_val['_EVEN']=0; else $paging_val['_EVEN']=1; $paging_val['_INDEX']=$paging_iterator++; $paging_val['_KEY']=$paging_key; ?>
		<a href="javascript: void(_TREE_<?php echo TPL::getVar("module.table_name"); ?>.paging('<?php echo TPL::getVar("tree.id"); ?><?php echo TPL::getVar("prefix"); ?>', <?php if(isset($paging_val["value"])) echo $paging_val["value"]; ?>));"><?php if(isset($paging_val["title"])) echo $paging_val["title"]; ?></a>
		<?php } ?>
	</li>
	<?php } ?>

</ul>

<script type="text/javascript">

<?php if(!TPL::getVar("tree_id")){ ?>
var _TREE_<?php echo TPL::getVar("module.table_name"); ?> = new _TREE_('<?php echo TPL::getVar("module.table_name"); ?>');
<?php } ?>

$( "#_TREE_<?php echo TPL::getVar("module.table_name"); ?>_<?php echo TPL::getVar("tree_id"); ?><?php echo TPL::getVar("prefix"); ?> .tree_item" ).draggable({ 
	containment: "#left",
	handle: ".dropper",
	revert: "invalid",
	start:function(event, ui){
		//$(this).css('position', 'absolute');
		_TREE_<?php echo TPL::getVar("module.table_name"); ?>.stop_context = true;
	},
	stop:function(event, ui){
		//$(this).css('position', 'relative');
		_TREE_<?php echo TPL::getVar("module.table_name"); ?>.stop_context = false;
	}
});

$( "#_TREE_<?php echo TPL::getVar("module.table_name"); ?>_<?php echo TPL::getVar("tree_id"); ?><?php echo TPL::getVar("prefix"); ?> li .dropper" ).droppable({
	hoverClass: "hovered",
	over: function(event, ui){
		if($(this).hasClass('isSub')){
			//_TREE_<?php echo TPL::getVar("module.table_name"); ?>.open_branch($(this).attr('rel'), true);
		}
	},
	drop: function( event, ui ) {
		$(this).addClass( "ui-state-highlight" );
		//_TREE_<?php echo TPL::getVar("module.table_name"); ?>.refresh_branch(ui.draggable.attr('rel'));
		_TREE_<?php echo TPL::getVar("module.table_name"); ?>.remove_branch(ui.draggable.attr('rel'));
		if(ui.draggable.attr('rel')!=$(this).attr('rel')){
			_TREE_<?php echo TPL::getVar("module.table_name"); ?>.refresh_branch($(this).attr('rel'));
		}
		_TREE_<?php echo TPL::getVar("module.table_name"); ?>.stop_context = false;
		hideItemContextMenu();
	}		
});

/*
$( "#_TREE_<?php echo TPL::getVar("module.table_name"); ?>_<?php echo TPL::getVar("tree_id"); ?> li .sep" ).droppable({
	hoverClass: "hovered_sep",
	over: function(event, ui){
		$(this).addClass("hovered_sep");
	},
	drop: function( event, ui ) {
		$(this).addClass( "ui-state-highlight" );
		_TREE_<?php echo TPL::getVar("module.table_name"); ?>.refresh_branch(ui.draggable.attr('rel'));
		if(ui.draggable.attr('rel')!=$(this).attr('rel')){
			_TREE_<?php echo TPL::getVar("module.table_name"); ?>.refresh_branch($(this).attr('rel'));
			_TREE_<?php echo TPL::getVar("module.table_name"); ?>.refresh_branch(ui.draggable.closest('.tree_item').attr('rel'));
			hideItemContextMenu();
		}
		ui.draggable.remove();
	}		
});
*/
</script>