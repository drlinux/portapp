<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	case 'view':
	default:
		$data = $model->getProductattributeByProductId($_GET["productId"]);
		//print_r($data);exit;
		
		$model->displayTemplate('mb2c', 'product', $data);
		break;
}