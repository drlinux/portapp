<?php
/*
Array (
[MerchantPacket] => 127D1CFD216ADB714A10D5F42F24B1992407F6E53854C0722386EE27C1D947C6C4451A032E7CF43969B4D27FD793F45A3F6664C4B84EFB38D767A4F310514D654A6F1414637A7FD8208F7C742B40E9AF0965B8566DA2DFCD412555C697A265BADF342C675F308307617679163A17AAFA91877D5F80A853607961AFA0766C65417C115815EF098AFF2F406D23C30C08828688522FA51DA40D55719D3DF5CE8211A678731490E85B3005C94F9D3254D9AAA94011A0CF31ECB5471B8478 
[BankPacket] => 5C1799273A72552012D18A483FF9B35AB09B6BDE3DC3D1E8116A9DE66A0EAF3C917131A4FE642B7EDDD98748EFA0D33ED5FDA2A32BB7D35E0995B2AA25D2A846FFF10C18E0936A97AC8904FFB3F453A4A7760A3DAC3E38A961BC765FD1F59584EF0AE4D228979A3E0C0C2B719B7391AE231BAC3717C97551F9C96D55 
[Sign] => 2382EC8EA4FDF75F19473310FCA7A844 
[CCPrefix] => 450634 
[TranType] => Sale 
[Amount] => 100 
[Xid] => YKB_0000120108191152 
[MerchantId] => 6783406546
)
*/

//$XML_SERVICE_URL = "http://setmpos.ykb.com/PosnetWebService/XML"; // XML Web Servisi (XML_SERVICE_URL) TEST
//$OOS_TDS_SERVICE_URL = "http://setmpos.ykb.com/3DSWebService/YKBPaymentService"; // OOS/TDS Web Servisi (OOS_TDS_SERVICE_URL) TEST
$XML_SERVICE_URL = "https://www.posnet.ykb.com/PosnetWebService/XML"; // XML Web Servisi (XML_SERVICE_URL) PROD
$OOS_TDS_SERVICE_URL = "https://www.posnet.ykb.com/3DSWebService/YKBPaymentService"; // OOS/TDS Web Servisi (OOS_TDS_SERVICE_URL) PROD

$mid			= "6783406546";
$tid			= "67599225";
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
$Root = new SimpleXMLElement($result);

//header ('Content-type: text/html; charset=utf-8');
if ( $Root->approved == 1 ) {
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
	if ( $Root->approved == 1 ) {
		echo "Ödeme tamamlandı";
	}
	else {
		echo "Ödeme tamamlanamadı";
	}

}
else {
	echo "merchantPacket verisi çözümlenemedi";
	//echo $Root->respCode . PHP_EOL;
	//echo $Root->respText . PHP_EOL;
	//echo $Root->yourIP . PHP_EOL;
}
exit;