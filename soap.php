<?php
/*
 * Created on 2007.2.5
 * service.php
 * Vytautas
 */

error_reporting(0);

require_once('inc/config.inc.php');
require_once(NUSOAPDIR.'nusoap.php'); // include the NuSOAP classes 

$cache_obj = cache::getInstance();

$ns=Config::$val['site_url']."soap.php";

$server = new soap_server();
$server->configureWSDL('easywebmanager web service', $ns);
$server->wsdl->schemaTargetNamespace = $ns;
$server->soap_defencoding = "UTF-8";
$server->decode_utf8 = false;

$server->register('saveItem', 
					array(
							'loginname' => 'xsd:string',							
							'userpass' => 'xsd:string',
							'module' => 'xsd:string',
							'data' => 'xsd:array'
					), 
					array('return' => 'xsd:array'), 
					$ns);


$server->wsdl->addComplexType(
	'myArray',
	'complexType',
	'array',
	' ',
	'SOAP-ENC:Array',
	array(),
	array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'xsd:array[]')
);


$server->register('getItem', 
					array(
							'loginname' => 'xsd:string',							
							'userpass' => 'xsd:string',
							'module' => 'xsd:string',
							'lng' => 'xsd:string', 
							'id' => 'xsd:int'
					), 
					array('return' => 'tns:myArray'), 
					$ns);

$server->register('getItemsList', 
					array(	
							'loginname' => 'xsd:string',							
							'userpass' => 'xsd:string',
							'module' => 'xsd:string',
							'lng' => 'xsd:string', 
							'parent_id' => 'xsd:int',
							'is_category' => 'xsd:int'
					),
					array('return' => 'tns:myArray'), 
					$ns);

$server->register('getSearchItemsList', 
					array(	
							'loginname' => 'xsd:string',							
							'userpass' => 'xsd:string',
							'module' => 'xsd:string',
							'lng' => 'xsd:string', 
							'search' => 'xsd:array',
							'order' => 'xsd:array',
							'group' => 'xsd:array',
							'limit' => 'xsd:array'
					),
					array('return' => 'tns:myArray'), 
					$ns);



//$server->register('getFields', 
//					array(
//							'loginname' => 'xsd:string',							
//							'userpass' => 'xsd:string',
//							'module' => 'xsd:string'
//					), 
//					array('return' => 'xsd:array'), 
//					$ns);
//
//$server->register('getModules', 
//					array(
//							'loginname' => 'xsd:string',							
//							'userpass' => 'xsd:string',
//							'module' => 'xsd:string'
//					), 
//					array('return' => 'xsd:array'), 
//					$ns);

include_once(INCDIR."services.php");

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA); 


?>
