// Register the related commands.
FCKCommands.RegisterCommand(
   'paypal',
    new FCKDialogCommand(
        'PayPal Buy Now Button',
        'PayPal Buy Now Button',
        FCKConfig.PluginsPath + 'paypal/paypal.html', 375, 280));

// Create the "PayPal" toolbar button.
var oPayPalItem = new FCKToolbarButton('paypal', FCKLang['DlgPayPalTitle']);
oPayPalItem.IconPath = FCKConfig.PluginsPath + 'paypal/paypal.gif' ;

// 'paypal' is the name used in the Toolbar config.
FCKToolbarItems.RegisterItem( 'paypal', oPayPalItem ) ;

