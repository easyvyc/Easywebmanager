FCKCommands.RegisterCommand( '_Form', new FCKDialogCommand( "_Form", FCKLang.DlgFormTitle, FCKConfig.PluginsPath + 'easyform/fck_form.html', 450, 350));
var oFormItem		= new FCKToolbarButton( '_Form', FCKLang.DlgFormTitle) ;
oFormItem.IconPath	= FCKConfig.PluginsPath + 'easyform/img/form.gif' ;
FCKToolbarItems.RegisterItem( '_Form', oFormItem ) ;

// Context menu
FCK.ContextMenu.RegisterListener( {
	AddItems : function( menu, tag, tagName )
	{
		if ( tagName == 'FORM' )
		{
			menu.RemoveAllItems() ;
			menu.AddItem( '_Form', FCKLang.DlgFormTitle, oFormItem.IconPath ) ;
		}
	}}
);


// Double click
FCK.RegisterDoubleClickHandler( editForm, 'FORM' ) ;

function editForm( oNode )
{
	if (oNode)
		FCK.Commands.GetCommand( '_Form' ).Execute() ;
	else	
		return ;
}
