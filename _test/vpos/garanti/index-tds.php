<?php
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

switch($_action)
{
	case 'submit':
		
		$XML_SERVICE_URL = "https://ccpos.garanti.com.tr/servlet/cc5ApiServer"; //PROD
		//$XML_SERVICE_URL = "http://setmpos.ykb.com/PosnetWebService/XML"; //TEST
 
		$mid			= "6783406546";
		$tid			= "67599225";
		$amount			= $_POST["amount"] * 100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
		$ccno			= $_POST["ccno"];
		$cvc			= $_POST["cvc"];
		$expDate		= $_POST["expDate"];
		$installment	= ($_POST["installment"]==1)?"00":$_POST["installment"];//Taksit sayisi (taksitsiz işlemlerde taksit sayısı "00" gönderilmelidir)
		$orderID		= 'YKB_00000000'.date("ymdHis");//1s3456z8901234567890QWER
		
		$request = "xmldata=".
					"<posnetRequest>".
						"<mid>$mid</mid>".
						"<tid>$tid</tid>".
						"<tranDateRequired>1</tranDateRequired>".
						"<sale>".
							"<amount>$amount</amount>".
							"<ccno>$ccno</ccno>".
							"<currencyCode>YT</currencyCode>".
							"<cvc>$cvc</cvc>".
							"<expDate>$expDate</expDate>".
							"<installment>$installment</installment>".
							"<orderID>$orderID</orderID>".
						"</sale>".
					"</posnetRequest>"
		;
		
		$Name		= "7VHTRYM0";//İş yeri kullanıcı adı
		$Password	= "";//İş yeri şifresi
		$ClientId	= "9258469";//İş yeri no
		
		$IPAddress	= GetHostByName($REMOTE_ADDR);//Son kullanıcı IP adresi
		$Email		= "";//Son kullanıcı e-posta adresi
		$Mode		= "P";//P olursa gerçek islem, T olursa test islemi yapar
		$OrderId	= "";//Sipariş numarası. Boş gönderilirse sistem bir sipariş numarası üretir.
		$Type		= "Auth";//Auth: Satış, PreAuth: Ön Otorizasyon
		
		
		$request= "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>".
					"<CC5Request>".
						"<Name>$Name</Name>".
						"<Password>$Password</Password>".
						"<ClientId>$ClientId</ClientId>".
						"<IPAddress>$IPAddress</IPAddress>".
						"<Email>$Email</Email>".
						"<Mode>$Mode</Mode>".
						"<OrderId>$OrderId</OrderId>".
						"<GroupId></GroupId>".
						"<TransId></TransId>".
						"<UserId></UserId>".
						"<Type>$Type</Type>".
						"<Number>{MD}</Number>".
						"<Expires></Expires>".
						"<Cvv2Val></Cvv2Val>".
						"<Total>{TUTAR}</Total>".
						"<Currency>949</Currency>".
						"<Taksit>{TAKSIT}</Taksit>".
						"<PayerTxnId>{XID}</PayerTxnId>".
						"<PayerSecurityLevel>{ECI}</PayerSecurityLevel>".
						"<PayerAuthenticationCode>{CAVV}</PayerAuthenticationCode>".
						"<CardholderPresentCode>13</CardholderPresentCode>".
						"<BillTo>".
							"<Name></Name>".
							"<Street1></Street1>".
							"<Street2></Street2>".
							"<Street3></Street3>".
							"<City></City>".
							"<StateProv></StateProv>".
							"<PostalCode></PostalCode>".
							"<Country></Country>".
							"<Company></Company>".
							"<TelVoice></TelVoice>".
						"</BillTo>".
						"<ShipTo>".
							"<Name></Name>".
							"<Street1></Street1>".
							"<Street2></Street2>".
							"<Street3></Street3>".
							"<City></City>".
							"<StateProv></StateProv>".
							"<PostalCode></PostalCode>".
							"<Country></Country>".
						"</ShipTo>".
						"<Extra></Extra>".
					"</CC5Request>";
		
		
		$ch = curl_init(); // initialize curl handle
		
		curl_setopt($ch, CURLOPT_URL, $XML_SERVICE_URL); // set url to post to
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($request)); // add POST fields

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
		
		header ('Content-type: text/html; charset=utf-8');
		if ( $Root->approved == 1 ) {
			echo "Ödeme alındı";
		}
		else {
			echo "Ödeme alınamadı";
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
		<label>ccno</label>
		<input type="text" name="ccno" value="" required="required" />
	</li>
	<li>
		<label>cvc</label>
		<input type="text" name="cvc" value="" required="required" />
	</li>
	<li>
		<label>expDate YYAA</label>
		<input type="text" name="expDate" value="" required="required" />
	</li>
	<li>
		<label>amount</label>
		<input type="text" name="amount" value="1" required="required" />
	</li>
	<li>
		<label>installment</label>
		<input type="text" name="installment" value="1" required="required" />
	</li>
	<li>
		<button type="submit" name="action" value="submit">Gönder</button>
	</li>
</ul>
</form>

</body>
</html>