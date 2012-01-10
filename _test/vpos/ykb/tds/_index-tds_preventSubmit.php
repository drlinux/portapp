<?php
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

switch($_action)
{
	case 'submit':
		
		//$XML_SERVICE_URL		= "http://setmpos.ykb.com/PosnetWebService/XML"; // XML Web Servisi (XML_SERVICE_URL) TEST
		//$OOS_TDS_SERVICE_URL	= "http://setmpos.ykb.com/3DSWebService/YKBPaymentService"; // OOS/TDS Web Servisi (OOS_TDS_SERVICE_URL) TEST
		$XML_SERVICE_URL		= "https://www.posnet.ykb.com/PosnetWebService/XML"; // XML Web Servisi (XML_SERVICE_URL) PROD
		$OOS_TDS_SERVICE_URL	= "https://www.posnet.ykb.com/3DSWebService/YKBPaymentService"; // OOS/TDS Web Servisi (OOS_TDS_SERVICE_URL) PROD
 
		$mid			= "6783406546";
		$tid			= "67599225";
		$amount			= $_POST["amount"] * 100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
		$ccno			= $_POST["ccno"];
		$cvc			= $_POST["cvc"];
		$expDate		= $_POST["expDate"];
		$orderID		= 'YKB_00000000'.date("ymdHis");//1s3456z8901234567890QWER
		$installment	= ($_POST["installment"]==1)?"00":$_POST["installment"];//Taksit sayisi (taksitsiz işlemlerde taksit sayısı "00" gönderilmelidir)
		
		$posnetid		= "16916";
		$XID			= 'YKB_0000'.date("ymdHis");//YKB_0000080603143050
		$cardHolderName	= $_POST["cardHolderName"];
		
		$request = "xmldata=".
					"<posnetRequest>".
						"<mid>$mid</mid>".
						"<tid>$tid</tid>".
						"<oosRequestData>".
							"<posnetid>$posnetid</posnetid>".
							"<ccno>$ccno</ccno>".
							"<expDate>$expDate</expDate>".
							"<cvc>$cvc</cvc>".
							"<amount>$amount</amount>".
							"<currencyCode>YT</currencyCode>".
							"<installment>$installment</installment>".
							"<XID>$XID</XID>".
							"<cardHolderName>$cardHolderName</cardHolderName>".
							"<tranType>Sale</tranType>".
						"</oosRequestData>".
					"</posnetRequest>"
		;
		
		
		$ch = curl_init(); // initialize curl handle
		curl_setopt($ch, CURLOPT_URL, $XML_SERVICE_URL); // set url to post to
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
		curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields
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
			//echo "3D Secure için bankaya yönlendirileceksiniz.";
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>YKB</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
	$('form[name=formName]').submit(function() {
		console.log($(this).serializeArray());
		return false;
	});
});
</script>
</head>
<body>

<form name="formName" method="post" action="<?=$OOS_TDS_SERVICE_URL ?>" target="YKBWindow">
<input type="submit" name="Submit" value="Ödeme Yap" />

<input name="mid" type="hidden" id="mid" value="<?=$mid ?>">
<input name="posnetID" type="hidden" id="PosnetID" value="<?=$posnetid ?>">
<input name="posnetData" type="hidden" id="posnetData" value="<?=$Root->oosRequestDataResponse->data1 ?>">
<input name="posnetData2" type="hidden" id="posnetData2" value="<?=$Root->oosRequestDataResponse->data2 ?>">
<input name="digest" type="hidden" id="sign" value="<?=$Root->oosRequestDataResponse->sign ?>">
<input name="vftCode" type="hidden" id="vftCode" value="">

<!-- <input name="useJokerVadaa" type="hidden" id="useJokerVadaa" value="1"> --> <!-- Opsiyonel -->
<!-- <input name="merchantReturnURL" type="hidden" id=" merchantReturnURL" value="http://www.uyeisyeri.com/kk_provizyon.php"> --> <!-- Opsiyonel -->
<input name="merchantReturnURL" type="hidden" id=" merchantReturnURL" value="https://localhost/portapp/_test/vpos/ykb/tds/provision-tds.php">

<!-- Static Parameter -->
<input name="lang" type="hidden" id="lang" value="tr" />
<input name="url" type="hidden" id="url" value="https://localhost/portapp/_test/vpos/ykb/tds/index-tds.php" />
<input name="openANewWindow" type="hidden" id="openANewWindow" value="0" />
</form>

</body>
</html>
<?php
		}
		else {
			echo "Kart bilgileri hatalı";
			//echo $Root->respCode . PHP_EOL;
			//echo $Root->respText . PHP_EOL;
			//echo $Root->yourIP . PHP_EOL;
		}
		exit;
		
		
		
		break;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>YKB</title>
</head>
<body>

<form method="post" action="">
<ul>
	<li>
		<label>cardHolderName</label>
		<input type="text" name="cardHolderName" value="" />
	</li>
	<li>
		<label>ccno</label>
		<input type="text" name="ccno" value="" />
	</li>
	<li>
		<label>cvc</label>
		<input type="text" name="cvc" value="" />
	</li>
	<li>
		<label>expDate YYAA</label>
		<input type="text" name="expDate" value="" />
	</li>
	<li>
		<label>amount</label>
		<input type="text" name="amount" value="" />
	</li>
	<li>
		<label>installment</label>
		<input type="text" name="installment" value="" />
	</li>
	<li>
		<button type="submit" name="action" value="submit">Gönder</button>
	</li>
</ul>
</form>

</body>
</html>