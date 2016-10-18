$(document).ready(function () { 
	
	$('[contenteditable]').each(function () {
		$(this).removeAttr('contenteditable');
	});
        
});