<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2c");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Product();

switch($_action)
{
	case 'jsonProductsInWishlist':
		$data = $model->getProductsInWishlist();
		//print_r($data);exit;
		echo(json_encode($data));
		break;
	case 'view':
	default:
		$temp = $model->getProductsInWishlist();
		parseProductsList($temp["aaData"], $data["wish_list"]);
		
		$model->displayTemplate("b2c", "wishlist", $data);
		break;
}