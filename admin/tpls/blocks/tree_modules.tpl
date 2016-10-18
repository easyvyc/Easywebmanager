<ul class="tree" id="_TREE_{module.table_name}_{tree_id}{prefix}" style="{block tree_id}display:none;{-block tree_id}">
	
	{loop tree_list}
	<li id="_BRANCH_{tree_list.id}{prefix}" rel="{tree_list.id}" class="tree_item {block tree_list._LAST}last{-block tree_list._LAST}{block tree_list._LAST no}not_last{-block tree_list._LAST no}">
	
		<div class="sep"></div>
	
		<table class="dropper {block tree_list.sub}isSub{-block tree_list.sub}" rel="{tree_list.id}" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td width="18">
					{block tree_list.sub}
					<a class="extract sub{block tree_list._LAST}_last{-block tree_list._LAST}" href="javascript: void(_TREE_{module.table_name}.extract('{tree_list.id}{prefix}'));">&nbsp;</a>
					{-block tree_list.sub}
					{block tree_list.sub no}
					<a class="extract no_sub{block tree_list._LAST}_last{-block tree_list._LAST}"></a>
					{-block tree_list.sub no}
				</td>
				<td width="18">
					<a class="leaf" href="javascript: void(_TREE_{module.table_name}.context('_TREE_CONTEXT_{module.table_name}_{tree_list.id}{prefix}'));" style="background:url('{config.admin_dir}images/tree/leaf.gif') center center no-repeat;"></a>
				</td>
				<td>
					<div><a href="javascript: void(_TREE_{module.table_name}.context('_TREE_CONTEXT_{module.table_name}_{tree_list.id}{prefix}'));" class="{block tree_list.active no}striketrough{-block tree_list.active no}">{tree_list.title}</a></div>
				</td>
			</tr>
		</table>
		
		<div id="_TREE_CONTEXT_{module.table_name}_{tree_list.id}{prefix}" class="hide">
			<div class="title">{tree_list.title_short}</div>
			<div class="text">
				{loop tree_list.context}
				<div><a {block tree_list.context.action}href="{tree_list.context.action}"{-block tree_list.context.action}><img src="{config.admin_dir}images/actions/{tree_list.context.img}.gif" alt="" class="vam" border="0" />&nbsp;{tree_list.context.title}</a></div>
				{-loop tree_list.context}
			</div>
		</div>
		
		<div class="child_branch {block tree_list._LAST}last{-block tree_list._LAST}{block tree_list._LAST no}not_last{-block tree_list._LAST no}"></div>
		
	</li>
	{-loop tree_list}
	
	{block paging}
	<li class="paging">
		{loop paging}
		<a href="javascript: void(_TREE_{module.table_name}.paging('{tree.id}{prefix}', {paging.value}));">{paging.title}</a>
		{-loop paging}
	</li>
	{-block paging}

</ul>

<script type="text/javascript">

{block tree_id no}
var _TREE_{module.table_name} = new _TREE_('{module.table_name}');
{-block tree_id no}

$( "#_TREE_{module.table_name}_{tree_id}{prefix} .tree_item" ).draggable({ 
	containment: "#left",
	handle: ".dropper",
	revert: "invalid",
	start:function(event, ui){
		//$(this).css('position', 'absolute');
		_TREE_{module.table_name}.stop_context = true;
	},
	stop:function(event, ui){
		//$(this).css('position', 'relative');
		_TREE_{module.table_name}.stop_context = false;
	}
});

$( "#_TREE_{module.table_name}_{tree_id}{prefix} li .dropper" ).droppable({
	hoverClass: "hovered",
	over: function(event, ui){
		if($(this).hasClass('isSub')){
			//_TREE_{module.table_name}.open_branch($(this).attr('rel'), true);
		}
	},
	drop: function( event, ui ) {
		$(this).addClass( "ui-state-highlight" );
		//_TREE_{module.table_name}.refresh_branch(ui.draggable.attr('rel'));
		_TREE_{module.table_name}.remove_branch(ui.draggable.attr('rel'));
		if(ui.draggable.attr('rel')!=$(this).attr('rel')){
			_TREE_{module.table_name}.refresh_branch($(this).attr('rel'));
		}
		_TREE_{module.table_name}.stop_context = false;
		hideItemContextMenu();
	}		
});

/*
$( "#_TREE_{module.table_name}_{tree_id} li .sep" ).droppable({
	hoverClass: "hovered_sep",
	over: function(event, ui){
		$(this).addClass("hovered_sep");
	},
	drop: function( event, ui ) {
		$(this).addClass( "ui-state-highlight" );
		_TREE_{module.table_name}.refresh_branch(ui.draggable.attr('rel'));
		if(ui.draggable.attr('rel')!=$(this).attr('rel')){
			_TREE_{module.table_name}.refresh_branch($(this).attr('rel'));
			_TREE_{module.table_name}.refresh_branch(ui.draggable.closest('.tree_item').attr('rel'));
			hideItemContextMenu();
		}
		ui.draggable.remove();
	}		
});
*/
</script>