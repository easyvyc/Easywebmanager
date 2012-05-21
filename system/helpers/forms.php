<?php
$FORM_ELM_TYPES[] = array('value'=>'text', 'id'=>'text', 'superadmin'=>0, 'title'=>'TEXT(Trumpas tekstinis laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'textarea', 'id'=>'textarea', 'superadmin'=>0, 'title'=>'TEXTAREA(Išsamus tekstinis laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'html', 'id'=>'html', 'superadmin'=>0, 'title'=>'HTML(WYSIWYG redaktorius)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'date', 'id'=>'date', 'superadmin'=>0, 'title'=>'DATE(Datos laukelis)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'image', 'id'=>'image', 'superadmin'=>0, 'title'=>'IMAGE(Paveikslėlis)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'file', 'id'=>'file', 'superadmin'=>0, 'title'=>'FILE(Failas)', 'w'=>3);
$FORM_ELM_TYPES[] = array('value'=>'radio', 'id'=>'radio', 'superadmin'=>0, 'title'=>'RADIO(Perjungiklių pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'checkbox', 'id'=>'checkbox', 'superadmin'=>0, 'title'=>'CHECKBOX(Pasirinkimas)', 'w'=>1);
$FORM_ELM_TYPES[] = array('value'=>'checkbox_group', 'id'=>'checkbox_group', 'superadmin'=>0, 'title'=>'CHECKBOX_GROUP(Daugybinis pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'select', 'id'=>'select', 'superadmin'=>0, 'title'=>'SELECT(Pasirinkimas iš sąrašo)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'autocomplete', 'id'=>'autocomplete', 'superadmin'=>0, 'title'=>'AUTOCOMPLETE(Pasirinkimas)', 'w'=>5);
$FORM_ELM_TYPES[] = array('value'=>'hidden', 'id'=>'hidden', 'superadmin'=>1, 'title'=>'HIDDEN(Paslėptas laukelis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'password', 'id'=>'password', 'superadmin'=>1, 'title'=>'PASSWORD(Slaptažodis)', 'w'=>10);
$FORM_ELM_TYPES[] = array('value'=>'submit', 'id'=>'submit', 'superadmin'=>0, 'title'=>'SUBMIT(Formos patvirtinimo mygtukas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'button', 'id'=>'button', 'superadmin'=>1, 'title'=>'BUTTON(Mygtukas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'list', 'id'=>'list', 'superadmin'=>1, 'title'=>'LIST(Sąrašas)', 'w'=>2);
$FORM_ELM_TYPES[] = array('value'=>'tree', 'id'=>'tree', 'superadmin'=>1, 'title'=>'TREE(Medis)', 'w'=>2);

$n = count($FORM_ELM_TYPES);
for($i=0; $i<$n; $i++){
	define('FRM_'.strtoupper($FORM_ELM_TYPES[$i]['value']), $FORM_ELM_TYPES[$i]['value']);	
}

// cvs export
$FORM_TYPES_NON_EXPORT = array(FRM_SUBMIT, FRM_BUTTON, FRM_LIST, FRM_HIDDEN, FRM_PASSWORD, FRM_TREE);

// file extensions for upload
$valid_images = array('gif', 'png', 'jpg', 'jpeg');
$valid_archives = array('zip');
$denied_upload_files = array('php', 'pl', 'exe', 'phtml', 'php3', 'inc');

?>