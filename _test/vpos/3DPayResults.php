<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2c");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productorder;

switch ($_action)
{
	case "access":
		$ProcReturnCode_KEY = "ProcReturnCode";
		$ProcReturnCode_VAL = "00";
		$XID = "oid";
		break;
	case "bonus":
		$ProcReturnCode_KEY = "procreturncode";
		$ProcReturnCode_VAL = "00";
		$XID = "orderid";
		break;
	case "world":
		$ProcReturnCode_KEY = "ApprovedCode";
		$ProcReturnCode_VAL = "1";
		$XID = "XID";
		break;
}


if ($_POST[$ProcReturnCode_KEY] == $ProcReturnCode_VAL)
{
	$XID = $_REQUEST[$XID];

	$productattribute = new Productattribute;
	$pb = $productattribute->getProductattributesFromBasket();
	if (!$pb) header("Location: " . _MODULE_DIR_ . "b2c/");
	//print_r($pb);exit;

	$model->insert(
		$model->sTable,
		array(
			"productorderstatusId"=>1,
			"userId"=>$_SESSION["userId"],
			"XID"=>$XID,
			"productorderDatetime"=>date("Y-m-d H:i:s"),
			"paymentId"=>$_SESSION["paymentId"],
			"transportationId"=>$_SESSION["transportationId"],
			"deliveryaddressId"=>$_SESSION["deliveryaddressId"],
			"invoiceaddressId"=>$_SESSION["invoiceaddressId"]
		)
	);
	unset($_SESSION["paymentId"]);
	unset($_SESSION["transportationId"]);
	unset($_SESSION["deliveryaddressId"]);
	unset($_SESSION["invoiceaddressId"]);

	$rows = $model->select($model->sTable, "XID = :XID", array("XID"=>$XID));
	$productorderId = $rows[0]["productorderId"];

	$psm = new Productsalesmovement;
	foreach ($pb["aaData"] as $product) {
		$psm->insert(
			$psm->sTable,
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

	$mailer = new CasMailer();
	$mailer->Subject = "Sipariş";
	$mailer->MsgHTML(sprintf("Sipariş Kodu: %s", $XID));
	$mailer->Send();

	$model->displayTemplate("b2c", "3DPayResults", array("isApproved"=>true));
}
else {
	$model->displayTemplate("b2c", "3DPayResults", array("isApproved"=>false));
}
//$model->displayTemplate("b2c", "3DPayResults", $_POST);
