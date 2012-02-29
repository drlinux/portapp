<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	case 'view':
	default:
		$data = $model->getProductattributes($_GET);
		$data = json_decode($data, true);
		//print_r($data);exit;
		$model->displayTemplate('mb2c', 'index', $data);
		break;
}