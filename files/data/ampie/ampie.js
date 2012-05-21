var ampie_src = ampie_path+'ampie.swf?ampie_settingsFile='+ampie_settingsFile+'&ampie_path='+ampie_path;

if(typeof ampie_settingsFile2!='undefined'){
  ampie_src +="&ampie_settingsFile2="+ampie_settingsFile2;
}

document.write ('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ampie_flashWidth+'" height="'+ampie_flashHeight+'" id="am_pie" align="middle">');
document.write ('<param name="allowScriptAccess" value="sameDomain" />');
document.write ('<param name="movie" value="'+ampie_src+'"/>');
document.write ('<param name="play" value="false" />');
document.write ('<param name="loop" value="false" />');
document.write ('<param name="menu" value="false" />');
document.write ('<param name="quality" value="high" />');
document.write ('<param name="scale" value="noscale" />');
document.write ('<param name="salign" value="lt" />');
document.write ('<param name="wmode" value="transparent" />');
document.write ('<param name="bgcolor" value="'+ampie_backgroundColor+'" />');
document.write ('<embed src="'+ampie_src+'" play="false" loop="false" menu="false" scale="noscale" quality="high" salign="lt" bgcolor="'+ampie_backgroundColor+'" width="'+ampie_flashWidth+'" height="'+ampie_flashHeight+'" name="am_pie" align="middle" wmode="transparent" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
document.write ('</object>');

