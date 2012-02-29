<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	case 'removeWishlist':
		Permission::checkPermission("b2c");
		$productId = $_REQUEST["productId"];
		$model->delete("product_user", "productId = :productId AND userId = :userId", array("productId"=>$productId, "userId"=>$_SESSION["userId"]));
		echo(json_encode(array("success"=>true)));
		break;
	case 'saveWishlist':
		Permission::checkPermission("b2c");
		$productId = $_REQUEST["productId"];
		$model->insert("product_user", array("productId"=>$productId, "userId"=>$_SESSION["userId"]));
		echo(json_encode(array("success"=>true)));
		break;
	case 'jsonProductcommentsByProductId':
		$productId = $_REQUEST["productId"];
		$productcomment = new Productcomment();
		$data = $productcomment->getProductcommentsByProductId($productId);
		//print_r($data);exit;

		echo(json_encode($data));
		break;
	case 'jsonPayment':
		$paymentgroup = new Paymentgroup;
		echo(json_encode($paymentgroup->getPaymentgroups()));
		break;
	case 'jsonProduct':
		$productId = $_REQUEST["productId"];
		$attributeIds = $_REQUEST["attributeIds"];
		$data = $model->getProductattributeByProductId($productId, $attributeIds);
		//print_r($data);exit;

		echo(json_encode($data));
		break;
	case 'show':
		$productId = $_GET["productId"];
		if ($productId == null) header("Location: " . _MODULE_DIR_ . "b2c/");
		$data = $model->getProductattributeByProductId($productId);
		//print_r($data);exit;
		
		$product = new Product();
		$product->setProductHit($productId);
		
		$usertrack = new Usertrack();
		$usertrack->addTrack(3, "productId=" . $productId);
		
		$model->displayTemplate("b2c", "product", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2c", "product");
		break;
}