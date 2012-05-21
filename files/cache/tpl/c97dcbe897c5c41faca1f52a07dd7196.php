<div id="_FB_APP_TOOLBAR">
	
	<fieldset>
	
	<legend>News</legend>
	
	<div id="_FB_APP_TOOLBAR_news1">
	<div class="tlb breaknews1" rel="news1">
		<span class="title">1 breaking news block</span>
		<div class="content">
			<div class="img1"></div>
			<div class="title1"><b>1 breaking news block</b><p>1 breaking news block 1 breaking news block 1 breaking news block</p></div>
		</div>
	</div>
	</div>
	
	<div id="_FB_APP_TOOLBAR_news2">
	<div class="tlb breaknews2" rel="news2">
		<span class="title">2 breaking news block</span>
		<div class="content">
			<div class="img2 item1_img"></div>
			<div class="img2 item2_img"></div>
			<div class="title2 item1_title"><b>2 breaking news block</b><p>2 breaking news block 2 breaking news block 2 breaking news block</p></div>
			<div class="title2 item2_title"><b>2 breaking news block</b><p>2 breaking news block 2 breaking news block 2 breaking news block</p></div>
		</div>
	</div>
	</div>
	
	<div id="_FB_APP_TOOLBAR_news">
	<div class="tlb newsblock" rel="news">
		<span class="title">News block</span>
		<div class="content">
		</div>
	</div>
	</div>
	
	</fieldset>

	<fieldset>
	
	<legend>Social</legend>
	
	<div id="_FB_APP_TOOLBAR_social1">
	<div class="tlb social_useapp" rel="social1">
		<span class="title">Friends using this App</span>
		<div class="content">
			<b>Friends using this App</b>
		</div>
	</div>
	</div>
	
	<div id="_FB_APP_TOOLBAR_social2">
	<div class="tlb social_readapp" rel="social2">
		<span class="title">Friends readed articles</span>
		<div class="content">
			<b>Friends readed articles</b>
		</div>
	</div>
	</div>
	
	</fieldset>
	
	<fieldset>
	
	<legend>Others</legend>
	
	<div id="_FB_APP_TOOLBAR_image">
	<div class="tlb imgblock" rel="image">
		<span class="title">Image block</span>
		<div class="content">
			Image block
		</div>
	</div>
	</div>

	<div id="_FB_APP_TOOLBAR_menu">
	<div class="tlb menublock" rel="menu">
		<span class="title">Menu block</span>
		<div class="content">
			Menu block
		</div>
	</div>
	</div>
	
	</fieldset>
	
</div>

<script type="text/javascript" src="fb/js/app.js"></script>
<script type="text/javascript">
$FB_APP.set_upload_url('<?php echo TPL::getVar("upload_url"); ?>');
$FB_APP.load();
</script>