<script type="text/javascript">
if(typeof(TreeObj_{mod.table_name}_{get.nm})!='object'){
	TreeObj_{mod.table_name}_{get.nm} = new TreeClass('{config.site_url}', '{config.admin_dir}', '{get.script}', '{mod.table_name}', '{get.nm}', '{lng}');
	{block get.click}
	TreeObj_{mod.table_name}_{get.nm}.ImgClick = {get.click};
	{-block get.click}
}
</script>

<ul class="tree" style="display:{block data.display no}none{-block data.display no}{block data.display}block{-block data.display};" id="main_{data.id}_{get.nm}">
	{loop items}
	<li class="sep" id="sep_{items.id}_{get.nm}"><img src="images/0.gif" height="1" width="1" vspace="0" hspace="0" alt="" border="0" /></li>
	<li class="item mod_{mod.id}_{get.nm}" id="item_{items.id}_{get.nm}" rel="parent_{items.parent_id}">
		
		{block get.context}
		{block items.context_menu}
		<div id="contextmenu_{items.id}_{get.nm}" class="contextMenu">
			<div class="title">{items.title}</div>
			<div class="text">
			{loop items.context}
				<div><a onclick="javascript: TreeObj_{mod.table_name}_{get.nm}.ImgClick('{items.context.action}', {items.id});"><img src="images/{items.context.img}.gif" alt="" class="vam" border="0" /> {items.context.title}</a></div>
			{-loop items.context}
			</div>
		</div>
		{-block items.context_menu}
		{-block get.context}
		
		<img src="images/tree/{items.ico}.gif" id="ico_{items.id}_{get.nm}" alt="" class="vam" {block items.sub}onclick="javascript: TreeObj_{mod.table_name}_{get.nm}.extract({items.id});"{-block items.sub} />
		{block get.checkbox no}
		<a onclick="javascript: TreeObj_{mod.table_name}_{get.nm}.ImgClick('{items.action}', {items.id});"><img src="images/tree/{items.img}.gif" class="vam" alt="{items.title}" /></a> 
		{-block get.checkbox no}
		{block get.checkbox}
		<input onclick="javascript: TreeObj_{mod.table_name}_{get.nm}.CheckboxClick({items.id});" type="checkbox" name="chk_{items.id}_{get.nm}" id="chk_{items.id}_{get.nm}" class="vam" style="padding:0px;margin:0px;" />
		{-block get.checkbox}
		<a onclick="javascript: TreeObj_{mod.table_name}_{get.nm}.ImgClick('{items.action}', {items.id});" id="link_{items.id}_{get.nm}" {block items.a}class="active"{-block items.a}>{items.title} {block items.sub_count}[{items.sub_count}]{-block items.sub_count}</a>
		
		{items.submenu}
		

	{block items.items_paging}
		<div style="padding:5px;padding-left:40px;"><a onclick="javascript: TreeObj_{mod.table_name}_{get.nm}.ImgClick('{items.action}', {items.id});">... all »»»</a></div>
	{-block items.items_paging}

	</li>

	
	<script type="text/javascript">
		TreeObj_{mod.table_name}_{get.nm}.add({items.id}, '{items.title}');
		{block items.a}
		TreeObj_{mod.table_name}_{get.nm}.currentItem = {items.id};
		{-block items.a}
		{block get.dragndrop}
		new Draggable('item_{items.id}_{get.nm}', {revert:true});
		{-block get.dragndrop}
	</script>
	
	{block get.dragndrop}
	<script type="text/javascript">
		
		Droppables.add('sep_{items.id}_{get.nm}', 
							{ 
								accept:'mod_{mod.id}_{get.nm}', 
								onDrop:function(element){ 
									TreeObj_{mod.table_name}_{get.nm}.change({items.id}, element.id);
								}, 
								hoverclass:'sep-active'
							}
						);

		{block items.drop_inner}
		Droppables.add('item_{items.id}_{get.nm}', 
							{ 
								accept:'mod_{mod.id}_{get.nm}', 
								onDrop:function(element){ 
									TreeObj_{mod.table_name}_{get.nm}.insert({items.id}, element.id);
								}, 
								hoverclass:'item-active',
								hoverfunc: function(){ TreeObj_{mod.table_name}_{get.nm}.showTreeItem({items.id}); }
							}
						);
		{-block items.drop_inner}

	</script>	
	{-block get.dragndrop}
	
	{-loop items}
	
	
</ul>