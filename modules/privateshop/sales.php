<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("privateshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productsalesmovement;

switch($_action)
{
	case 'jsonPaymentgroup':
		$paymentgroup = new Paymentgroup;
		echo(json_encode($paymentgroup->getPaymentgroup($_GET[$paymentgroup->sIndexColumn])));
		break;
	case 'jsonPaymentgroups':
		$paymentgroup = new Paymentgroup;
		echo(json_encode($paymentgroup->getPaymentgroups()));
		break;
	case 'jsonProductattributebasket':
		$productattribute = new Productattribute;
		echo(json_encode($productattribute->getProductattributesFromBasket()));
		break;
	case 'removeProductattributebasket':
		setcookie("productattributebasket[".$_REQUEST["productattributeId"]."]", "", time()-60*60);
		echo json_encode(array("success"=>true));
		break;
	case 'emptyProductattributebasket':
		if (isset($_COOKIE["productattributebasket"])) {
			foreach ($_COOKIE["productattributebasket"] as $productattributeId=>$v) {
				setcookie("productattributebasket[".$productattributeId."]", "", time()-60*60);
			}
		}
		echo json_encode(array("success"=>true));
		break;
	case 'updateProductattributebasket':
		//echo json_encode($_REQUEST);exit;
		$pb = $_REQUEST["productattributebasket"];
		$pbd = $_REQUEST["productattributebasketdelete"];

		foreach ($pb as $productattributeId=>$productattributebasketQuantity) {
			if ($productattributebasketQuantity > 0) {
				if ($pbd[$productattributeId]=="on") {
					setcookie("productattributebasket[".$productattributeId."]", "", time()-60*60);
					$success = true;
				}
				else {
					$productattribute = new Productattribute;
					$pa = $productattribute->getEntry($productattributeId);
					if ($productattributebasketQuantity > $pa["productattributeQuantity"]) {
						$success = false;
					}
					else {
						setcookie("productattributebasket[".$productattributeId."]", $productattributebasketQuantity, time()+24*60*60);
						$success = true;
					}
				}
			}
			else {
				setcookie("productattributebasket[".$productattributeId."]", "", time()-60*60);
				$success = true;
			}
		}

		echo json_encode(array("success"=>$success));
		break;
	case 'view':
	default:
		$model->displayTemplate("privateshop", "sales");
		break;
}