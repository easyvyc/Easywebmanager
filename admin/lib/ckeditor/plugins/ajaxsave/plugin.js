function htmlspecialchars(string){ 
	str = encodeURIComponent(string);
	return str;
}

(function()
{
  var saveCmd =
  {
    modes : { wysiwyg:true, source:true },
    exec : function( editor )
    {
      try
      {
        //editor.updateElement();
        
        var arr = editor.name.split("-");
        var module = arr[0];
        var page_id = arr[2];
        var area = arr[1];
        
        var value = editor.getData();
        
        $.ajax({
	    	  url: 'admin.php?module='+module+'&method=save_post&ajax=1',
	    	  type: 'POST',
	    	  dataType: 'json',
	    	  data: "area="+area+"&value="+htmlspecialchars(value)+"&id="+page_id,
	    	  beforeSend: function(){
	    		  window.parent.$NAV.start_loading();
	    	  },
	    	  success: function(data) {
	    		  window.parent.$NAV.end_loading();
	    	  }        	
        });
      } catch ( e ) {
        alert(e);
      }
    }
  }
  var pluginName = 'ajaxsave';
  CKEDITOR.plugins.add( pluginName,
  {
     init : function( editor )
     {
        var command = editor.addCommand( pluginName, saveCmd );
        editor.ui.addButton( 'AjaxSave',
         {
            label : editor.lang.save.toolbar,
            command : pluginName,
            icon: "skins/moono/images/save.png"
         });
     }
   });
})();