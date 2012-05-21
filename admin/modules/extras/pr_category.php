<?php
/*
 * Created on 2009.09.06
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */


$list = $this->main_object->call($v['list_values']['module'], "getPagesTree", array($v['list_values']['parent_id'], $v['value']));
$this->tpl[$v['column_name']]->setLoop('options_list', $list);


?>