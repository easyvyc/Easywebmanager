  <?php
/*
 * Created on 2005.9.21
 *
 * VB
 * editor_tpl_edit.php
 */

$xmlFile = FCKDIR.'fckstyles.xml';

include_once(CLASSDIR."xmlini.class.php");
$arr2xml = new xmlIni($xmlFile);

include_once(CLASSDIR."forms.class.php");
$form = new forms();

$form->imgDir = FCKDIR."editor/dialog/fck_template/images/";
$form->imgUrl = $configFile->variable['site_url'].$configFile->variable['admin_dir']."fck/editor/dialog/fck_template/images/";
$form->img->path = FCKDIR."editor/dialog/fck_template/images/";

$xmlNodeEdit = $arr2xml->xmlTree->children[($_GET['id']-1)];

if(isset($_GET['id']) && $_GET['id']!=0){
    $data['isNew'] = 0;
}else{
    $data['isNew'] = 1;
}
$data['id'] = $_GET['id'];

$form->addField('action', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>"save"));
$form->addField('id', 			array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$data['id']));
$form->addField('isNew', 		array('title'=>'', 'require'=>0, 'type'=>'hidden', 'value'=>$data['isNew']));

$form->addField('title', 		array('title'=>$cms_phrases['main']['settings']['style_name'], 'require'=>1, 'type'=>'text', 'value'=>trim($xmlNodeEdit->attributes['name']), 'editorship'=>1));
$form->addField('element', 		array('title'=>$cms_phrases['main']['settings']['html_element'], 'require'=>0, 'type'=>'text', 'value'=>$xmlNodeEdit->attributes['element'], 'editorship'=>1));
$form->addField('style', 		array('title'=>$cms_phrases['main']['settings']['style'], 'require'=>0, 'type'=>'textarea', 'value'=>trim($xmlNodeEdit->children[0]->attributes['value']), 'editorship'=>1));
$form->addField('align', 		array('title'=>$cms_phrases['main']['settings']['alignment'], 'require'=>0, 'type'=>'text', 'value'=>trim($xmlNodeEdit->children[1]->attributes['value']), 'editorship'=>1));
$form->addField('border', 		array('title'=>$cms_phrases['main']['settings']['border'], 'require'=>0, 'type'=>'text', 'value'=>trim($xmlNodeEdit->children[2]->attributes['value']), 'editorship'=>1));
$form->addField('size', 		array('title'=>$cms_phrases['main']['settings']['size'], 'require'=>0, 'type'=>'text', 'value'=>trim($xmlNodeEdit->children[3]->attributes['value']), 'editorship'=>1));
$form->addField('color', 		array('title'=>$cms_phrases['main']['settings']['color_code'], 'require'=>0, 'type'=>'text', 'value'=>trim($xmlNodeEdit->children[4]->attributes['value']), 'editorship'=>1));
$form->addField('class', 		array('title'=>$cms_phrases['main']['settings']['css_class'], 'require'=>0, 'type'=>'text', 'value'=>trim($xmlNodeEdit->children[5]->attributes['value']), 'editorship'=>1));

$form->addField("submit", array('type'=>'submit', 'value'=>"", 'title'=>'', 'require'=>0));

if(isset($_POST['action'])&&$_POST['action']=='save'){
	
	$form->validate($_POST);
	if($form->error!=1){
		$xmlNodeEdit->attributes['name'] = $_POST['title'];
		$xmlNodeEdit->attributes['element'] = $_POST['element'];
		$xmlNodeEdit->children[0]->attributes['name'] = "style";
		$xmlNodeEdit->children[0]->attributes['value'] = $_POST['style'];
		$xmlNodeEdit->children[1]->attributes['name'] = "align";
		$xmlNodeEdit->children[1]->attributes['value'] = $_POST['align'];
		$xmlNodeEdit->children[2]->attributes['name'] = "border";
		$xmlNodeEdit->children[2]->attributes['value'] = $_POST['border'];
		$xmlNodeEdit->children[3]->attributes['name'] = "size";
		$xmlNodeEdit->children[3]->attributes['value'] = $_POST['size'];
		$xmlNodeEdit->children[4]->attributes['name'] = "color";
		$xmlNodeEdit->children[4]->attributes['value'] = $_POST['color'];
		$xmlNodeEdit->children[5]->attributes['name'] = "class";
		$xmlNodeEdit->children[5]->attributes['value'] = $_POST['class'];
		//pae($xmlNodeEdit); 
		if($_POST['isNew']==1){
			$xmlNodeEdit->name = "Style";
			$xmlNodeEdit->children[0]->name = "Attribute";
			$xmlNodeEdit->children[1]->name = "Attribute";
			$xmlNodeEdit->children[2]->name = "Attribute";
			$xmlNodeEdit->children[3]->name = "Attribute";
			$xmlNodeEdit->children[4]->name = "Attribute";
			$xmlNodeEdit->children[5]->name = "Attribute";
			$arr2xml->xmlTree->children[] = $xmlNodeEdit;
		}else{
			$arr2xml->xmlTree->children[($_POST['id']-1)] = $xmlNodeEdit;
		}
		
		//pae($arr2xml->xmlTree);
		$xml = $arr2xml->objToXml($arr2xml->xmlTree);
		$file = fopen($xmlFile, "w");
		fwrite($file, $xml);
		fclose($file);	
		redirect("main.php?content=settings&page=editor_css_list");
	}
}

$tpl->setVar('form', $form->construct_form('save'));

include_once(dirname(__FILE__)."/menu.php");
 
?>
