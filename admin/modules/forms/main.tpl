<script type="text/javascript" src="js/tree.js"></script>

<form target="formSumbitFrame_{form.name}" method="post" name="{form.name}" {block form.action}action="{form.action}"{-block form.action} enctype="multipart/form-data" onbeforesubmit="javascript: top.frames['content'].edited_element=false;" onsubmit="javascript: top.frames['content'].edited_element=false; openLoading();">
<div style="padding:0px;vertical-align:top;text-align:left;" id="formContent_{form.name}" class="formContent">

{form_content}

</div>
</form>