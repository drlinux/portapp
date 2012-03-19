<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

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
		
		$model->displayTemplate("b2c", "productcompare", $data);
		break;
}