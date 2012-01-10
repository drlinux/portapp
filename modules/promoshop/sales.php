<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("promoshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productsalesmovement;

switch($_action)
{
	case 'saveOrder':
		$productattribute = new Productattribute;
		$pb = $productattribute->getProductattributesFromBasket();
		if (!$pb) header("Location: " . PROJECT_URL . "modules/promoshop/");
		//print_r($pb);exit;
		
		$XID = 'MOR_0000'.date("ymdHis");
		
		$creditcard = new Creditcard;
		$creditcard->insert($creditcard->sTable, 
			array(
				"ccname"=>$_REQUEST["ccname"],
				"ccno"=>$_REQUEST["ccno"],
				"cvv"=>$_REQUEST["cvv"],
				"expdatem"=>$_REQUEST["expdatem"],
				"expdatey"=>$_REQUEST["expdatey"]
			)
		);
		$rows = $creditcard->run("select LAST_INSERT_ID() as last_insert_id;");
		$creditcardId = $rows[0]["last_insert_id"];
		
		$productorder = new Productorder;
		$productorder->insert(
			$productorder->sTable,
			array(
				"productorderstatusId"=>1,
				"userId"=>$_SESSION["userId"],
				"XID"=>$XID,
				"productorderDatetime"=>date("Y-m-d H:i:s"),
				"paymentId"=>$_REQUEST["paymentId"],
				"transportationId"=>$_REQUEST["transportationId"],
				"deliveryaddressId"=>$_REQUEST["deliveryaddressId"],
				"invoiceaddressId"=>$_REQUEST["invoiceaddressId"],
				"creditcardId"=>$creditcardId
			)
		);
		
		$rows = $productorder->select($productorder->sTable, "XID = :XID", array("XID"=>$XID));
		$productorderId = $rows[0]["productorderId"];
		
		foreach ($pb["aaData"] as $product) {
			$model->insert(
				$model->sTable,
				array(
					"productorderId"=>$productorderId,
					"productattributeId"=>$product["productattribute"]["productattributeId"],
					"productsalesmovementQuantity"=>$product["productattributebasketQuantity"],
					"productsalesmovementPrice"=>$product["product"]["productattributepriceMDV"],
					"currencyId"=>1
				)
			);
			setcookie("productattributebasket[".$product["productattribute"]["productattributeId"]."]", "", time()-60*60);
		}
		
		/*
		$mailer = new CasMailer();
		$mailer->Subject = "Sipariş Bilgileriniz";
		$mailer->MsgHTML(sprintf("Sipariş Kodu: %s", $XID));
		$mailer->Send();
		*/
		
		echo json_encode(array("success"=>true));
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
		$model->displayTemplate("promoshop", "sales");
		break;
}