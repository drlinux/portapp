<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

Permission::checkPermissionRedirect("b2b");

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
		$model->displayTemplate("b2b", "wishlist");
		break;
}