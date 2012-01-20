<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

// TODO: Bankadan data geldiği için burada sorun çıkarıyor
//Permission::checkPermissionRedirect("b2c");


$productattribute = new Productattribute;
$aProductattribute = $productattribute->getProductattributesFromBasket();
if (!$aProductattribute) {
	$data["process"] = array(
		"success"=>false,
		"msg"=>"Sepetiniz boş olduğundan işleme devam edilemiyor"
	);
	break;
}

$user = new User();
$aUser = $user->getEntry($_SESSION["userId"]);
//print_r($aUser);exit;

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

$request = "xmldata=".
					"<posnetRequest>".
						"<mid>$mid</mid>".
						"<tid>$tid</tid>".
						"<oosResolveMerchantData>".
							"<bankData>$bankData</bankData>".
							"<merchantData>$merchantData</merchantData>".
							"<sign>$sign</sign>".
						"</oosResolveMerchantData>".
					"</posnetRequest>"
;


$ch = curl_init(); // initialize curl handle

curl_setopt($ch, CURLOPT_URL, $XML_SERVICE_URL); // set url to post to
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s

$result = curl_exec($ch); // run the whole process

if (curl_errno($ch)) {
	print curl_error($ch);
} else {
	curl_close($ch);
}

/*
// HTML Output
echo(HtmlEntities($result));exit;
*/


/*
// export xml file
header('Content-type: application/x-www-form-urlencoded');
header('Content-Disposition: attachment; filename="response.xml"');
echo $result;exit;
*/


// XML Parse
$oosResolveMerchantDataResponse = new SimpleXMLElement($result);

//header ('Content-type: text/html; charset=utf-8');
if ( $oosResolveMerchantDataResponse->approved == 1 ) {
	//echo "merchantPacket verisi çözümlendi";


	$request = "xmldata=".
						"<posnetRequest>".
							"<mid>$mid</mid>".
							"<tid>$tid</tid>".
							"<oosTranData>".
								"<bankData>$bankData</bankData>".
								"<wpAmount>0</wpAmount>".
							"</oosTranData>".
						"</posnetRequest>"
	;
	
	$ch = curl_init(); // initialize curl handle
	
	curl_setopt($ch, CURLOPT_URL, $XML_SERVICE_URL); // set url to post to
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
	curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s
	
	$result = curl_exec($ch); // run the whole process
	
	if (curl_errno($ch)) {
		print curl_error($ch);
	} else {
		curl_close($ch);
	}

	/*
	// HTML Output
	echo(HtmlEntities($result));exit;
	*/

	// XML Parse
	$Root = new SimpleXMLElement($result);
	
	header ('Content-type: text/html; charset=utf-8');
	if ( $Root->approved == 1 ) {
		echo "Ödeme tamamlandı";
		
		$XID = $oosResolveMerchantDataResponse->oosResolveMerchantDataResponse->xid;
		
		$productorder = new Productorder();
		$productorderId = $productorder->saveProductorder($XID, 2);
		
		//echo(json_encode(array("success"=>true, "productorderId"=>$productorderId)));
		header("Location: " . $project['url'] . "modules/b2c/productorder.php?action=showProductorder&productorderId=" . $productorderId);
		exit;
		
	}
	else {
		echo "Ödeme tamamlanamadı";
	}

}
else {
	header ('Content-type: text/html; charset=utf-8');
	echo "merchantPacket verisi çözümlenemedi";
	//echo $oosResolveMerchantDataResponse->respCode . PHP_EOL;
	//echo $oosResolveMerchantDataResponse->respText . PHP_EOL;
}
exit;