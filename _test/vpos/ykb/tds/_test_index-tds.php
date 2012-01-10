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
			//echo "3D Secure için bankaya yönlendirileceksiniz.";
			
			//$bo = "https://localhost/portapp/_test/vpos/ykb/tds/";
			$bo = "https://www.bedenozgurlugu.com/tds/";
			
			//$bodir = "D:/sdk/xampp/htdocs/portapp/_test/vpos/ykb/tds";
			$bodir = "/home/zenbi/public_html/tds";
			
			$data	= array(
			'mid' => $mid,
			'posnetID' => $posnetid,
			'posnetData' => $Root->oosRequestDataResponse->data1,
			'posnetData2' => $Root->oosRequestDataResponse->data2,
			'digest' => $Root->oosRequestDataResponse->sign,
			'vftCode' => '',
			//'useJokerVadaa' => '',
			//'merchantReturnURL' => $bo . 'provision-tds.php',
			'lang' => 'tr',
			'url' => $bo . 'index-tds.php',
			'openANewWindow' => '0'
			);
			
			$ch = curl_init(); // initialize curl handle
			
			curl_setopt($ch, CURLOPT_URL, $OOS_TDS_SERVICE_URL);
			//curl_setopt($ch, CURLOPT_URL, "https://www.bedenozgurlugu.com/tds/curl_result.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			//curl_setopt($ch, CURLOPT_CAINFO, "D:/sdk/xampp/apache/conf/ssl.crt/server.crt");
			//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/bedenozgurlugu_com.cer");
			//curl_setopt($ch, CURLOPT_CAINFO, $bodir . "/bedenozgurlugu_com.cer");
			//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/cert/ykb.cer");
			curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/cert/cacert.pem");
			//curl_setopt($ch, CURLOPT_SSLCERT, getcwd() . "/bedenozgurlugu_com.cer");
			//curl_setopt($ch, CURLOPT_SSLCERTPASSWD, '');
			
			$result = curl_exec($ch); // run the whole process
			
			if (curl_errno($ch)) {
				print curl_error($ch);
			} else {
				curl_close($ch);
			}
			exit;
			
			/*
			// HTML Output
			echo(HtmlEntities($result));exit;
			*/
			
			
			
		}
		else {
			echo "Hata oluştu.";
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