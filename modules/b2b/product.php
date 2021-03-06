<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	case 'removeWishlist':
		$productId = $_REQUEST["productId"];
		$model->delete("product_user", "productId = :productId AND userId = :userId", array("productId"=>$productId, "userId"=>$_SESSION["userId"]));
		echo(json_encode(array("success"=>true)));
		break;
	case 'saveWishlist':
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
		if ($productId == null) header("Location: " . $project['url'] . "modules/b2b/");
		$data = array_merge($data, $model->getProductattributeByProductId($productId));
		//print_r($data);exit;
		
		$product = new Product();
		$product->setProductHit($productId);
		
		$usertrack = new Usertrack();
		$usertrack->addTrack(3, "productId=" . $productId);
		// List similar products
		
		
		
		if(Permission::checkPermission("b2b"))
		{
			
			$salescampaign = new Salescampaign;
			$useCampaign = $smarty->getVariable("_USE_CAMPAIGN_MODULE");
			
			if($useCampaign == "true")
			{
				$temp = $salescampaign->getSimilarProductsFromCampaign($_REQUEST["productId"]);
			}
			
			if(($useCampaign != "true") || ($temp["iTotalRecords"] <= 0))
			{
				$temp = $productattribute->getProductattributes(array("iDisplayStart"=>0,"iDisplayLength"=>3,"sType"=>"similar", "categoryId"=>$data["category"]["defaultx"]["categoryId"]), false);
			}
			
			parseProductsList($temp["aaData"], $data["product_list"]);
		}
		
		addJavascript("assets/extension/classes/User.js");
		
		$model->displayTemplate("b2b", "product", $data);
		break;
	case 'view':
	default:
		$temp = $productattribute->getProductattributes(array("iDisplayStart"=>0,"iDisplayLength"=>100,"sSearch"=>""), false);
		
		if(Permission::checkPermission("b2b"))
		{
			parseProductsList($temp["aaData"], $data["product_list"]);
		}
		
		addJavascript("assets/extension/classes/User.js");
			
		$model->displayTemplate("b2b", "product_list", $data);
		break;
}