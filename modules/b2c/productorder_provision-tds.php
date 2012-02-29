<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

// TODO: Bankadan data geldiği için burada sorun çıkarıyor
//Permission::checkPermissionRedirect("b2c");

$productattribute = new Productattribute;
$aProductattribute = $productattribute->getProductattributesFromBasket();
if (!$aProductattribute) {
	$data["process"] = array(
		"success"=>false,
		"msg"=>"Sepetiniz boş olduğundan işleme devam edilemiyor"
	);
	echo "Sepetiniz boş olduğundan işleme devam edilemiyor." . "<br/>";
	break;
}

$payment = new Payment();
$aPayment = $payment->getPayment($_SESSION["paymentId"]);
//print_r($aPayment);exit;


$XML_SERVICE_URL		= $aPayment["paymentgroup"]["paymentgroupGate1"];
$OOS_TDS_SERVICE_URL	= $aPayment["paymentgroup"]["paymentgroupGate2"];

$mid			= $aPayment["paymentgroup"]["paymentgroupMid"];
$tid			= $aPayment["paymentgroup"]["paymentgroupTid"];

$merchantData	= $_POST["MerchantPacket"];
$bankData		= $_POST["BankPacket"];
$sign			= $_POST["Sign"];

$ykb = new YKB();
$ykb->XML_SERVICE_URL = $XML_SERVICE_URL;
$ykb->mid = $mid;
$ykb->tid = $tid;
$ykb->bankData = $bankData;
$ykb->merchantData = $merchantData;
$ykb->sign = $sign;

$result = $ykb->init_curl($ykb->tds_xmldata2());

/*
// HTML Output
echo(HtmlEntities($result));exit;
*/

// XML Parse
$oosResolveMerchantDataResponse = new SimpleXMLElement($result);

//header ('Content-type: text/html; charset=utf-8');
if ( $oosResolveMerchantDataResponse->approved == 1 )
{
	$result = $ykb->init_curl($ykb->tds_xmldata3());

	/*
	// HTML Output
	echo(HtmlEntities($result));exit;
	*/

	// XML Parse
	$Root = new SimpleXMLElement($result);
	
	if ( $Root->approved == 1 )
	{
		//echo "Ödeme tamamlandı";exit;
		
		$XID = $oosResolveMerchantDataResponse->oosResolveMerchantDataResponse->xid;
		
		$productorder = new Productorder();
		$productorderId = $productorder->saveProductorder($XID, $smarty->getVariable("_PRODUCTORDER_INITIALSTATUS_CC"));
		
		//echo(json_encode(array("success"=>true, "productorderId"=>$productorderId)));
		header("Location: " . $project['url'] . "modules/b2c/productorder.php?action=showProductorder&productorderId=" . $productorderId);
		exit;
		
	}
	else
	{
		header ('Content-type: text/html; charset=utf-8');
		echo "Ödeme tamamlanamadı" . "<br/>";
		echo "Hata Kodu: " . $Root->respCode . "<br/>";
		echo "Hata: " . $Root->respText . "<br/>";
		exit;
	}

}
else
{
	header ('Content-type: text/html; charset=utf-8');
	echo "merchantPacket verisi çözümlenemedi." . "<br/>";
	echo "Hata Kodu: " . $oosResolveMerchantDataResponse->respCode . "<br/>";
	echo "Hata: " . $oosResolveMerchantDataResponse->respText . "<br/>";
	exit;
}