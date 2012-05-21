FCKCommands.RegisterCommand( 'Gallery', new FCKDialogCommand( "Gallery", FCKLang.DlgGalleryTitle, FCKConfig.PluginsPath + 'gallery/dialog.html', 450, 370));


// Create the "Find" toolbar button.
var oGalleryItem		= new FCKToolbarButton( 'Gallery', FCKLang.DlgGalleryTitle) ;
oGalleryItem.IconPath	= FCKConfig.PluginsPath + 'gallery/button.gif' ;

FCKToolbarItems.RegisterItem( 'Gallery', oGalleryItem ) ;			// 'My_Find' is the name used in the Toolbar config.


FCK.ContextMenu.RegisterListener( {
	AddItems : function( menu, tag, tagName )
	{
		// under what circumstances do we display this option
		if ( tagName == 'DIV' && (tag.className=='easy_gallery' || tag.className=='easy_slideshow') )
		{
			// No other options:
			menu.RemoveAllItems() ;
			// the command needs the registered command name, the title for the context menu, and the icon path
			menu.AddItem( 'Gallery', FCKLang.DlgGalleryTitle, oGalleryItem.IconPath ) ;
		}
	}}
);


// Double click
FCK.RegisterDoubleClickHandler( editGallery, 'DIV' ) ;

function editGallery( oNode )
{
	if (oNode.className=='easy_slideshow' || oNode.className=='easy_gallery')
		FCK.Commands.GetCommand( 'Gallery' ).Execute() ;
	else	
		return ;
}
