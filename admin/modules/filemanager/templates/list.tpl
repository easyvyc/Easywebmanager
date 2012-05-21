<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<!--
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This page compose the File Browser dialog frameset.
-->
<html>
	<head>
		<title>easywebmanager - Resources Browser</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	</head>
	<frameset cols="250,*" class="Frame" framespacing="3" bordercolor="#f1f1e3" frameborder="1">
			<frame name="frmFolders" src="main.php?content=filemanager&page=folders" scrolling="auto" frameborder="1">
			<frame name="frmResourcesList" src="main.php?content=filemanager&page=files<block name="get.gallery">&mode=gallery</block name="get.gallery">" scrolling="auto" frameborder="1">
	</frameset>

</html>
