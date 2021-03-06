<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productsalesmovement;

switch($_action)
{
	case 'jsonVoucherByVoucherCode':
		$voucherCode = $_GET["voucherCode"];
		$voucher = new Voucher();
		$data = $voucher->getVoucherByVoucherCode($voucherCode);
		echo(json_encode($data));
		break;
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
		$productattributeId = $_REQUEST["productattributeId"];
		$productattributebasketQuantity = $_REQUEST["productattributebasketQuantity"];
		
		if ($productattributebasketQuantity > 0) {
			$productattribute = new Productattribute;
			$pa = $productattribute->getEntry($productattributeId);
			if ($productattributebasketQuantity > $pa["productattributeQuantity"]) {
				$success = false;
				$msg = "Yeterli stok yok";
			}
			else {
				setcookie("productattributebasket[".$productattributeId."]", $productattributebasketQuantity, time()+24*60*60);
				$success = true;
				$msg = "Sepetiniz güncellendi";
			}
		}
		else {
			setcookie("productattributebasket[".$productattributeId."]", "", time()-60*60);
			$success = true;
			$msg = "Sepetinizden çıkarıldı";
		}

		echo json_encode(array("success"=>$success, "msg"=>$msg));
		break;
	case 'view':
	default:
		addJavascript("assets/extension/classes/Transportation.js");
		addJavascript("assets/extension/classes/User.js");
		addJavascript("assets/extension/classes/Postaladdress.js");
		
		$model->displayTemplate("b2c", "sales", $data);
		break;
}