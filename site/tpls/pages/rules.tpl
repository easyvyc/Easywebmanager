<div id="data_text">

	<h1 cms="pages-title-{item_data.id}">{item_data.title}</h1>
	
	<div id="path">
	{loop id_path}
	{block id_path.first no}
	&nbsp;&nbsp;»&nbsp;&nbsp;
	{-block id_path.first no}
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	{-loop id_path}
	</div>										
	
	<div class="contenteditable" contenteditable="true" id="blocks-description-{block_data.id}">{block_data.description}&nbsp;</div>
	
</div>