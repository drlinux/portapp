<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2c");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productorder;

switch($_action)
{
	
	case 'provision':
		
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
		
		
		if ($aPayment["paymentgroup"]["paymentgroupType"] == "mt")
		{
			
		}
		elseif ($aPayment["paymentgroup"]["paymentgroupType"] == "pd")
		{
			
		}
		elseif ($aPayment["paymentgroup"]["paymentgroupType"] == "cc")
		{
			$XML_SERVICE_URL		= $aPayment["paymentgroup"]["paymentgroupGate1"]; // XML Web Servisi (XML_SERVICE_URL) PROD
			$OOS_TDS_SERVICE_URL	= $aPayment["paymentgroup"]["paymentgroupGate2"]; // OOS/TDS Web Servisi (OOS_TDS_SERVICE_URL) PROD
			
			$mid			= $aPayment["paymentgroup"]["paymentgroupMid"];//"6783406546";
			$tid			= $aPayment["paymentgroup"]["paymentgroupTid"];//"67599225";
			$amount			= $_POST["amount"] * 100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
			$ccno			= $_POST["ccno"];
			$cvc			= $_POST["cvc"];
			$expDate		= $_POST["expDate"];
			$orderID		= 'CC_'.$aPayment["paymentgroup"]["bankCode"].'_0000'.date("ymdHis");//'CC_0067_0000'.date("ymdHis");//1s3456z8901234567890QWER
			$installment	= ($_POST["installment"]==1)?"00":$_POST["installment"];//Taksit sayisi (taksitsiz işlemlerde taksit sayısı "00" gönderilmelidir)
		
			$posnetid		= $aPayment["paymentgroup"]["paymentgroupPosnetid"];
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
		
			// XML Parse
			$Root = new SimpleXMLElement($result);
			if ( $Root->approved == 1 ) {
				
				/*
				$data["response"] = array(
				"approved"=>$Root->approved,
				"msg"=>"3D Secure için bankaya yönlendirileceksiniz."
				);
				*/
				
				$data["OOS_TDS_SERVICE_URL"] = $OOS_TDS_SERVICE_URL;
				$data["mid"] = $mid;
				$data["posnetid"] = $posnetid;
				$data["posnetData"] = $Root->oosRequestDataResponse->data1;
				$data["posnetData2"] = $Root->oosRequestDataResponse->data2;
				$data["digest"] = $Root->oosRequestDataResponse->sign;
				$data["vftCode"] = "";
				$data["merchantReturnURL"] = PROJECT_URL . "modules/b2c/productorder_provision-tds.php";
				
				$model->displayTemplate("b2c", $model->sTable."_cc_provision", $data);
				break;
			}
			else {
				$data["response"] = array(
				"approved"=>$Root->approved,
				"respCode"=>$Root->respCode,
				"respText"=>$Root->respText,
				"yourIP"=>$Root->yourIP,
				"msg"=>"Kart bilgileri hatalı"
				);
				echo "Kart bilgileri hatalı";exit;
			}
		}
		
		
		// TODO: işlem onaylanırsa sipariş veritabanına girilecek
		if (false) {
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
			
			$productsalesmovement = new Productsalesmovement();
			foreach ($pb["aaData"] as $productattribute) {
				$productsalesmovement->insert(
					$productsalesmovement->sTable,
					array(
						"productorderId"=>$productorderId,
						"productattributeId"=>$productattribute["productattribute"]["productattributeId"],
						"productsalesmovementQuantity"=>$productattribute["productattributebasketQuantity"],
						"productsalesmovementPrice"=>$productattribute["productattribute"]["productattributepriceMDV"]
					)
				);
				setcookie("productattributebasket[".$productattribute["productattribute"]["productattributeId"]."]", "", time()-60*60);
			}
			
			$mailer = new CasMailer();
			$mailer->Subject = "Sipariş";
			$mailer->MsgHTML(sprintf("Sayın %s;<br/>Siparişiniz işleme alınmıştır.<br/>Sipariş Kodunuz: %s<br/>Toplam Miktar: %s<br/>Ödeme Tipi: %s", $u["userLastname"], $XID, $pb["productattributebasketTotalCur"], $p["paymentgroup"]["paymentgroupTitle"]));
			$mailer->AddAddress($u["userEmail"]);
			$mailer->AddCC(_EMAIL_USERNAME_);
			if(!$mailer->Send()) {
				//$this->msg = $smarty->getConfigVariable("ALERT_MailerSendError");//$mailer->ErrorInfo
				//return false;
			}
			else {
				//$this->msg = $smarty->getConfigVariable("ALERT_MailerSendSuccessfully");
				//return true;
			}
			
			echo(json_encode(array("success"=>true, "productorderId"=>$productorderId)));
		}
		
		
		
		$model->displayTemplate("b2c", $model->sTable."_provision", $data);
		break;
	
	
	


		
		
	
	case 'listProductorder':
		$data = $model->getProductordersOwned();
		//print_r($data);exit;

		$model->displayTemplate("b2c", $model->sTable."_list", $data);
		break;
		
	case 'showProductorder':
		$data = $model->getProductorder($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
	
		$model->displayTemplate("b2c", $model->sTable."_show", $data);
		break;
		
	case 'jsonBincodes':
		$bankbin = new Bankbin;
		echo(json_encode($bankbin->getBankbincodesByBankcode($_REQUEST["bankCode"])));
		break;
		
	case 'setParameters':
		$paymentId = $_REQUEST["paymentId"];
		$transportationId = $_REQUEST["transportationId"];
		$deliveryaddressId = $_REQUEST["deliveryaddressId"];
		$invoiceaddressId = $_REQUEST["invoiceaddressId"];
		$_SESSION["paymentId"] = $paymentId;
		$_SESSION["transportationId"] = $transportationId;
		$_SESSION["deliveryaddressId"] = $deliveryaddressId;
		$_SESSION["invoiceaddressId"] = $invoiceaddressId;
		header("Location: " . _MODULE_DIR_ . "b2c/" . "productorder.php");
		break;
		
	case 'view':
	default:
		$paymentId = $_SESSION["paymentId"];
		$transportationId = $_SESSION["transportationId"];
		$deliveryaddressId = $_SESSION["deliveryaddressId"];
		$invoiceaddressId = $_SESSION["invoiceaddressId"];
		
		$payment = new Payment;
		$data["payment"] = $payment->getPayment($paymentId);
		//print_r($data);exit;
		
		$transportation = new Transportation;
		$data["transportation"] = $transportation->getTransportation($transportationId);

		$productattribute = new Productattribute;
		$data["productattributebasket"] = $productattribute->getProductattributesFromBasket();
		if (!$data["productattributebasket"]) header("Location: " . _MODULE_DIR_ . "b2c/");
		//print_r($data);exit;

		$productattributebasketTotal = $data["productattributebasket"]["productattributebasketTotal"];
		$paymentimpactWeight = $data["payment"]["paymentimpactWeight"];
		$paymentimpactPrice = $data["payment"]["paymentimpactPrice"];

		$paymentPeriod = intval($data["payment"]["paymentPeriod"]);
		$total = $productattributebasketTotal * (1 + $paymentimpactWeight) + $paymentimpactPrice;
		$installment = ($total/$paymentPeriod);

		//$transportationimpactWeight = $data["transportation"]["transportationimpactWeight"];
		//$transportationimpactPrice = $data["transportation"]["transportationimpactPrice"];
		//$amount = number_format($total * (1 + $transportationimpactWeight) + $transportationimpactPrice, 2);
		$amount = number_format($total + $data["transportation"]["transportationPrice"], 2);
		
		$data["amountReal"] = $amount;
		$currency = new Currency;
		$data["amountRealWC"] = $currency->formatWithCurrency($amount);

		$postaladdress = new Postaladdress;
		$data["deliveryaddress"] = $postaladdress->getEntry($deliveryaddressId);
		$data["invoiceaddress"] = $postaladdress->getEntry($invoiceaddressId);

		//print_r($data);exit;

		if ($data["payment"]["paymentgroupId"] == 1)
		{
			/*
			 * Money Transfer
			*/
				
			$data["XID"] = 'MOT_0000'.date("ymdHis");
			$data["amount"] = ($amount<1)?1:$amount;
			$model->displayTemplate("b2c", "checkout_mt", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 3)
		{
			/*
			 * Payment on Delivery
			*/
				
			$data["XID"] = 'POD_0000'.date("ymdHis");
			$data["amount"] = ($amount<1)?1:$amount;
			$model->displayTemplate("b2c", "checkout_pd", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 5)
		{
			/*
			 * world - 0067 - paymentgroupId=5
			*/
				
			$data["XID"] = 'YKB_0000'.date("ymdHis");//Herbir alışveriş işlemi için üye işyeri tarafından oluşturulan 20 karakterli alfa-numerik sipariş numarası
			$data["amount"] = $amount*100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
			$data["instalment"] = ($period==1)?"00":$period;//Taksit sayisi (taksitsiz işlemlerde taksit sayısı "00" gönderilmelidir)
				
			//print_r($data);exit;
				
			$model->displayTemplate("b2c", "checkout_cc_world", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 2)
		{
			/*
			 * axess - 0046 - paymentypeId=2
			*/
				
			$data["clientid"] = "100626123";//Banka tarafından verilen işyeri numarası
			$data["oid"] = 'AKB_0000'.date("ymdHis");//Sipariş numarası
			$data["amount"] = ($amount<1)?1:$amount;//İşlem tutarı (işlem tutarı en az 1.00 ve üzeri olmalıdır.)
			$data["rnd"] = microtime();//Tarih veya rastgele her seferinde üretilen bir değer
			$storekey = "Z1q2w3e4r";//Isyeri anahtari
			///////
			$data["storetype"] = "3d_pay";//3D işlem tipi
			$data["islemtipi"] = "Auth";//Islem tipi: Satış için Auth, Önotorizasyon için PreAuth
			$data["taksit"] = ($period==1)?"":$period;//Taksit sayisi (taksitsiz işlemlerde taksit sayısı boş gönderilmelidir)
			$path = "https://" . $_SERVER["HTTP_HOST"] . _MODULE_DIR_ . "b2c/";
			$data["okUrl"] = $path . "3DPayResults.php";
			$data["failUrl"] = $path . "3DPayResults.php";
			$hashstr = $data["clientid"] . $data["oid"] . $data["amount"] . $data["okUrl"] . $data["failUrl"] . $data["islemtipi"] . $data["taksit"] . $data["rnd"] . $storekey;
			$data["hash"] = base64_encode(pack('H*',sha1($hashstr)));
				
			$data["lang"] = "tr";
			$data["currency"] = "949";
				
				
			//print_r($data);exit;
				
			$model->displayTemplate("b2c", "checkout_cc_axess", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 4)
		{
			/*
			 * bonus - 0062 - paymentypeId=4
			*/

			$data["secure3dsecuritylevel"] = "3D_PAY";//3D_PAY, 3D_FULL, 3D_HALF
			$data["strMode"] = "PROD"; //PROD, TEST
			$data["strApiVersion"] = "v0.01";
			$data["strTerminalProvUserID"] = "PROVAUT";
			$data["strType"] = "sales";
			$data["strAmount"] = $amount*100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
			$data["strCurrencyCode"] = "949";
				
			$data["strInstallmentCount"] = ($period==1)?"":$period; //Taksit Sayısı. Boş gönderilirse taksit yapılmaz
			$data["strTerminalUserID"] = "PROVAUT";
			$data["strOrderID"] = 'GAB_0000'.date("ymdHis");
			$data["strCustomeripaddress"] = CasString::getIP();
			$data["strTerminalID"] = "10012077";
			$strTerminalID_ = "010012077"; //Başına 0 eklenerek 9 digite tamamlanmalıdır.
			$data["strTerminalMerchantID"] = "9258469"; //Üye İşyeri Numarası
			$strStoreKey = "Z1q2w3e4r"; //3D Secure şifreniz
			$strProvisionPassword = "Z1q2w3e4r"; //Terminal UserID şifresi (PROVAUT kullanıcısının şifresi)
			$path = "https://" . $_SERVER["HTTP_HOST"] . _MODULE_DIR_ . "b2c/";
			$data["strSuccessURL"] = $path . "3DPayResults.php";
			$data["strErrorURL"] = $path . "3DPayResults.php";
			$SecurityData = strtoupper(sha1($strProvisionPassword.$strTerminalID_));
			$data["HashData"] = strtoupper(sha1($data["strTerminalID"].$data["strOrderID"].$data["strAmount"].$data["strSuccessURL"].$data["strErrorURL"].$data["strType"].$data["strInstallmentCount"].$strStoreKey.$SecurityData));
				
				
			//print_r($data);exit;
				
			$model->displayTemplate("b2c", "checkout_cc_bonus", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 6)
		{
			/*
			 * Other Credit Cards
			*/
			// TODO: Diğer kredi kartı için form oluştur.
			$data["XID"] = 'CCO_0000'.date("ymdHis");
			$data["amount"] = ($amount<1)?1:$amount;
			$model->displayTemplate("b2c", "checkout_cc_others", $data);
		}

		break;


}