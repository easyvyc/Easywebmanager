<?php
/*
 * Created on 2007.4.18
 * path.php
 * Vytautas
 */


include_once(CLASSDIR."stat.class.php");
$stat_obj = & new stat();

$list = $stat_obj->getVisitorPath($_GET['id']);

$tpl->setLoop('list', $list);

?>
