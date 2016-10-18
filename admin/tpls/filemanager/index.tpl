<style type="text/css">
{css}
</style>

<div class="current_folder">
	<a href="javascript: void($FILEMANAGER.load(''))">Home</a>
	{loop path}
	: <a href="javascript: void($FILEMANAGER.load('{path.path}'))">{path.name}</a>
	{-loop path}
</div>



<div >

{loop list}

	{block list.is_folder}
	<a class="fmng_folder" href="javascript: void($FILEMANAGER.load('{list.folder}'));" title="{list.title}">
	<em>{list.name}</em>
	</a>
	{-block list.is_folder}

{-loop list}

{loop list}

	{block list.is_folder no}
	<a class="fmng_file" href="javascript: void($FILEMANAGER.select('{list.file}'));" title="{list.title}" style="background-image:url('admin.php?module=filemanager&method=thumb_img&file={list.folder}');">
	<em>{list.name}</em>
	</a>
	{-block list.is_folder no}

{-loop list}

</div>