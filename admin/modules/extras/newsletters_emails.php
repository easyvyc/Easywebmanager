<?php

//$this->tpl[$v['column_name']]->setVar('get', $_GET);


$phras['lt']['emails_simple'] = "Įrašyti el. laiškus";
$phras['lt']['emails_from_db'] = "Pasirinkti el. laiškus iš duomenų bazės";

$phras['en']['emails_simple'] = "E-mails";
$phras['en']['emails_from_db'] = "Choose emails from categories";


$this->tpl[$v['column_name']]->setVar('phras', $phras[$_SESSION['admin_interface_language']]);

global $main_object;
$subs_obj = $main_object->create("subscribers");
$subs_obj->sqlQueryGroup = " GROUP BY S.record_id ";
$subs_obj->sqlQueryJoins = " LEFT JOIN {$subs_obj->config->variable['pr_code']}_{$subs_obj->_table_fields['category']['list_values']['module']} S ON (S.record_id=T.category AND S.lng='{$_SESSION['site_lng']}') ";
$subs_obj->fields = " COUNT(R.id) AS emails_count, S.title AS category, S.record_id AS category_id, ";
$categories = $subs_obj->listSearchItems();

//$categories = $main_object->call($subs_obj->_table_fields['category']['list_values']['module'], "listItems", array($subs_obj->_table_fields['category']['list_values']['parent_id']));

$this->tpl[$v['column_name']]->setLoop('categories', $categories);



?>