{block EDIT_MODE no}
<div class="popup_page_content">

	{page_data.page_area.description}
	
</div>
{-block EDIT_MODE no}
        
{block EDIT_MODE}
<div id="popup_dialog_content">
    {page_data.page_area.description}
</div>
<script>
    $(document).ready(function(){
        my_dialog('{page_data.header_title}', '<div class="contenteditable popup_page_content" style="min-height:150px" contenteditable="true" id="blocks-description-{page_data.id}">' + $('#popup_dialog_content').html() + '</div>', 600);
        CKEDITOR.inline( 'blocks-description-{page_data.id}' );
    });
</script>
{-block EDIT_MODE}