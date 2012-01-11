<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("promoshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	case 'jsonPayment':
		$paymentgroup = new Paymentgroup;
		echo(json_encode($paymentgroup->getPaymentgroups()));
		break;
	case 'jsonProduct':
		$productId = $_REQUEST["productId"];
		$attributeIds = $_REQUEST["attributeIds"];
		$data = $model->getProductattributeByProductId($productId, $attributeIds);
		//print_r($data);exit;

		echo json_encode($data);
		break;
	case 'show':
		$productId = $_GET["productId"];
		if ($productId == null) header("Location: " . PROJECT_URL . "modules/promoshop/");
		$data = $model->getProductattributeByProductId($productId);
		//print_r($data);exit;
		
		$model->displayTemplate("promoshop", "product", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("promoshop", "product");
		break;
}