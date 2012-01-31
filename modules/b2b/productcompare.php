<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute();

switch($_action)
{
	case 'view':
	default:
		if (empty($_COOKIE["productcompare"]) == false) {
			$productIds = explode(",", $_COOKIE["productcompare"]);
			foreach ($productIds as $productId) {
				$data[] = $model->getProductattributeByProductId($productId);
			}
			//print_r($data);exit;
		}
		
		$model->displayTemplate("b2b", "productcompare", $data);
		break;
}