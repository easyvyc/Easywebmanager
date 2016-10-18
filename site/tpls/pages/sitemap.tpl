<div id="data_text">

	<h1 cms="pages-header_title-{page_data.id}">{page_data.header_title}</h1>
	
	<div class="contenteditable" contenteditable="true" id="blocks-description-{page_data.id}">{page_data.page_area.description}&nbsp;</div>
        
        <ul class="sitemap">
        {loop tree_list}
            <li style="padding-left:{tree_list.level}0px">
                <a href="{tree_list.page_url}" class="sitemap">{block tree_list.level no}<b>{-block tree_list.level no}{tree_list.title}{block tree_list.level no}</b>{-block tree_list.level no}</a>
            </li>
        {-loop tree_list}
        </ul>

	
</div>