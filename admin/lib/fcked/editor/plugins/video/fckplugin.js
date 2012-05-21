// Register the related commands.
FCKCommands.RegisterCommand(
   'video',
    new FCKDialogCommand(
        'Embed Video - BETA',
        'Embed Video - BETA',
        FCKConfig.PluginsPath + 'video/video.html', 375, 200));

// Create the "video" toolbar button.
var oVideoItem = new FCKToolbarButton('video', FCKLang['DlgVideoTitle']);
oVideoItem.IconPath = FCKConfig.PluginsPath + 'video/video.gif' ;

// 'video' is the name used in the Toolbar config.
FCKToolbarItems.RegisterItem( 'video', oVideoItem ) ;

