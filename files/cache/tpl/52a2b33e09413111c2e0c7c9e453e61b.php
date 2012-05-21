<div id="_APP_CONTAINER" class="bo">

	<div id="_APP_TOP_BANNER" class="bo drag1" rel="banner">
		<div class="content"><?php echo TPL::getVar("banner_top"); ?></div>
	</div>
	
	<div id="_APP_LOGO" class="bo drag1" rel="banner">
		<div class="content"><?php echo TPL::getVar("logo"); ?></div>
	</div>
	
	<div id="_APP_MENU" class="bo drag1" rel="menu">
		<div class="content"><?php echo TPL::getVar("menu"); ?></div>
	</div>
	
	<div id="_APP_CONTENT" class="bo">
	
		<div id="_APP_LEFT_BLOCK" class="bo drag2" rel="banner">
			<div class="content"><?php echo TPL::getVar("left_block"); ?></div>
		</div>
		
		<div id="_APP_CENTER_BLOCK" class="bo">
			
			<div class="block drag3">block 1</div>
			
			<div class="block drag3">block 2</div>
			
			<div class="block drag3">block 3</div>
			
		</div>
		
		<div id="_APP_RIGHT_BLOCK" class="bo drag2" rel="banner">
			<div class="content"><?php echo TPL::getVar("right_block"); ?></div>
		</div>
	
	</div>
	
	<div id="_APP_BOT_BANNER" class="bo drag1" rel="banner">
		<div class="content"><?php echo TPL::getVar("banner_bottom"); ?></div>
	</div>

</div>