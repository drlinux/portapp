<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productorder();

switch($_action)
{
	
	case 'provision':
		
		$payment = new Payment();
		$aPayment = $payment->getPayment($_SESSION["paymentId"]);
		//print_r($aPayment);exit;
		
		if ($aPayment["paymentgroup"]["paymentgroupType"] == "mt")
		{
			$XID = 'MT_00000'.date("ymdHis");
			$productorderId = $model->saveProductorder($XID, $smarty->getVariable("_PRODUCTORDER_INITIALSTATUS_MT"));
			
			//header("Location: " . $project['url'] . "modules/b2b/productorder.php?action=showProductorder&productorderId=" . $productorderId);
			echo(json_encode(array("success"=>true, "productorderId"=>$productorderId)));exit;
		}
		elseif ($aPayment["paymentgroup"]["paymentgroupType"] == "pd")
		{
			$XID = 'PD_00000'.date("ymdHis");
			$productorderId = $model->saveProductorder($XID, $smarty->getVariable("_PRODUCTORDER_INITIALSTATUS_PD"));
			
			//header("Location: " . $project['url'] . "modules/b2b/productorder.php?action=showProductorder&productorderId=" . $productorderId);
			echo(json_encode(array("success"=>true, "productorderId"=>$productorderId)));exit;
		}
		elseif ($aPayment["paymentgroup"]["paymentgroupType"] == "cc")
		{
			// Yapı Kredi Bankası
			if ($aPayment["paymentgroup"]["bankCode"] == "0067")
			{
				$XML_SERVICE_URL		= $aPayment["paymentgroup"]["paymentgroupGate1"];
					
				$mid					= $aPayment["paymentgroup"]["paymentgroupMid"];
				$tid					= $aPayment["paymentgroup"]["paymentgroupTid"];
				
				$amount					= $_POST["amount"] * 100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
				$ccno					= $_POST["ccno"];
				$cvc					= $_POST["cvc"];
				$expDateYear			= substr($_POST["expDate"]["Date_Year"], -2);
				$expDateMonth			= $_POST["expDate"]["Date_Month"];
				$expDate				= $expDateYear.$expDateMonth;//YYMM
				$installment			= ($_POST["installment"]==1)?"00":$_POST["installment"];//Taksit sayisi (taksitsiz işlemlerde taksit sayısı "00" gönderilmelidir)
					
				if ( $aPayment["paymentgroup"]["paymentgroupMethod"] == "3dpay" )
				{
					$OOS_TDS_SERVICE_URL= $aPayment["paymentgroup"]["paymentgroupGate2"];
					$posnetid			= $aPayment["paymentgroup"]["paymentgroupPosnetid"];
					$cardHolderName		= $_POST["cardHolderName"];
				
					$XID				= 'CC_00000'.date("ymdHis");//YKB_0000080603143050
				
					$ykb = new YKB();
					$ykb->XML_SERVICE_URL = $XML_SERVICE_URL;
					$ykb->mid = $mid;
					$ykb->tid = $tid;
					$ykb->amount = $amount;
					$ykb->ccno = $ccno;
					$ykb->cvc = $cvc;
					$ykb->expDate = $expDate;
					$ykb->installment = $installment;
					$ykb->XID = $XID;
				
					$ykb->OOS_TDS_SERVICE_URL = $OOS_TDS_SERVICE_URL;
					$ykb->posnetid = $posnetid;
					$ykb->cardHolderName = $cardHolderName;
				
					$result = $ykb->init_curl($ykb->tds_xmldata1());
				
					// HTML Output
					//echo(HtmlEntities($result));exit;
				
					// XML Parse
					$Root = new SimpleXMLElement($result);
					if ( $Root->approved == 1 )
					{
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
						$data["merchantReturnURL"] = $project['url'] . "modules/b2b/productorder_provision-tds.php";
							
						$model->displayTemplate("b2b", $model->sTable."_cc_provision", $data);
					}
					else
					{
						$data["response"] = array(
							"approved"=>$Root->approved,
							"respCode"=>$Root->respCode,
							"respText"=>$Root->respText,
							"yourIP"=>$Root->yourIP,
							"msg"=>"Kart bilgileri hatalı"
						);
						echo "3D Güvenlik için bankaya yönlendirilemiyorsunuz." . "<br/>";
						echo "Hata Kodu: " . $Root->respCode . "<br/>";
						echo "Hata: " . $Root->respText . "<br/>";
						exit;
					}
				
				}
				else
				{
					$XID				= 'CC_000000000'.date("ymdHis");
				
					$ykb = new YKB();
					$ykb->XML_SERVICE_URL = $XML_SERVICE_URL;
					$ykb->mid = $mid;
					$ykb->tid = $tid;
					$ykb->amount = $amount;
					$ykb->ccno = $ccno;
					$ykb->cvc = $cvc;
					$ykb->expDate = $expDate;
					$ykb->installment = $installment;
					$ykb->XID = $XID;
				
					$result = $ykb->init_curl($ykb->notds_xmldata1());
				
					// HTML Output
					//echo(HtmlEntities($result));exit;
						
					// XML Parse
					$Root = new SimpleXMLElement($result);
					if ( $Root->approved == 1 )
					{
						$productorderId = $model->saveProductorder($XID, $smarty->getVariable("_PRODUCTORDER_INITIALSTATUS_CC"));
				
						header("Location: " . $project['url'] . "modules/b2b/productorder.php?action=showProductorder&productorderId=" . $productorderId);exit;
						//echo(json_encode(array("success"=>true, "productorderId"=>$productorderId)));
						exit;
				
					}
					else {
						$data["response"] = array(
							"approved"=>$Root->approved,
							"respCode"=>$Root->respCode,
							"respText"=>$Root->respText,
							"yourIP"=>$Root->yourIP
						);
						echo "Ödeme tamamlanamadı." . "<br/>";
						echo "Hata Kodu: " . $Root->respCode . "<br/>";
						echo "Hata: " . $Root->respText . "<br/>";
						exit;
					}
				}
			}
			// Garanti Bankası
			elseif ($aPayment["paymentgroup"]["bankCode"] == "0062")
			{
				$mid					= $aPayment["paymentgroup"]["paymentgroupMid"];
				$tid					= $aPayment["paymentgroup"]["paymentgroupTid"];
				
				$amount					= $_POST["amount"] * 100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
				$ccno					= $_POST["ccno"];
				$cvc					= $_POST["cvc"];
				$expDateYear			= substr($_POST["expDate"]["Date_Year"], -2);
				$expDateMonth			= $_POST["expDate"]["Date_Month"];
				$installment			= ($_POST["installment"]==1)?"":$_POST["installment"];//Taksit sayisi (taksitsiz işlemlerde taksit sayısı boş gönderilmelidir)
				
				
				
				if ( $aPayment["paymentgroup"]["paymentgroupMethod"] == "3dpay" )
				{
					
					$OOS_TDS_SERVICE_URL= $aPayment["paymentgroup"]["paymentgroupGate2"];
					
					$XID				= 'CC_00000'.date("ymdHis");
					
					
					$garanti = new Garanti();
					$garanti->OOS_TDS_SERVICE_URL = $OOS_TDS_SERVICE_URL;
					$garanti->cardnumber = $ccno;
					$garanti->cardexpiredatemonth = $expDateMonth;
					$garanti->cardexpiredateyear = $expDateYear;
					$garanti->cardcvv2 = $cvc;
					
					$garanti->terminalmerchantid = $mid;
					$garanti->txnamount = $amount;
					$garanti->txninstallmentcount = $installment;
					$garanti->orderid = $XID;
					$garanti->setTerminalid($tid);
					
					$garanti->successurl = "https://www.bedenozgurlugu.com/portapp/_test/vpos/garanti/3DPayResults.php";
					$garanti->errorurl = "https://www.bedenozgurlugu.com/portapp/_test/vpos/garanti/3DPayResults.php";
					
					$garanti->customeripaddress = $_SERVER['REMOTE_ADDR'];
					$garanti->customeremailaddress = "cem@casict.com";
					
					$garanti->storeKey = "Z1q2w3e4r";
					$garanti->provisionPassword = "BO1q2w3e4r";
					
					//$result = $garanti->test();exit;
					//$result = $garanti->init_curl();
					$result = $garanti->init_curl($garanti->tds_data());
					
					// HTML Output
					//echo(HtmlEntities($result));exit;
					
				}
			}
			// Akbank
			elseif ($aPayment["paymentgroup"]["bankCode"] == "0046")
			{
				if ( $aPayment["paymentgroup"]["paymentgroupMethod"] == "3dpay" )
				{
					$OOS_TDS_SERVICE_URL= $aPayment["paymentgroup"]["paymentgroupGate2"];
					
					
					$akbank = new Akbank();
					$akbank->OOS_TDS_SERVICE_URL = $OOS_TDS_SERVICE_URL;
					
					
					
				}
			}
		}
		break;
	
	
	


		
		
	
	case 'listProductorder':
		$data = $model->getProductordersOwned();
		//print_r($data);exit;

		$model->displayTemplate("b2b", $model->sTable."_list", $data);
		break;
		
	case 'showProductorder':
		$data = $model->getProductorder($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
	
		$model->displayTemplate("b2b", $model->sTable."_show", $data);
		break;
		
	case 'jsonBincodes':
		$bankbin = new Bankbin;
		echo(json_encode($bankbin->getBankbincodesByBankcode($_REQUEST["bankCode"])));
		break;
		
	case 'setParameters':
		$voucherCode = $_REQUEST["voucherCode"];
		$paymentId = $_REQUEST["paymentId"];
		$transportationId = $_REQUEST["transportationId"];
		$deliveryaddressId = $_REQUEST["deliveryaddressId"];
		$invoiceaddressId = $_REQUEST["invoiceaddressId"];
		$_SESSION["voucherCode"] = $voucherCode;
		$_SESSION["paymentId"] = $paymentId;
		$_SESSION["transportationId"] = $transportationId;
		$_SESSION["deliveryaddressId"] = $deliveryaddressId;
		$_SESSION["invoiceaddressId"] = $invoiceaddressId;
		header("Location: " . _MODULE_DIR_ . "b2b/" . "productorder.php");
		break;
		
	case 'view':
	default:
		$voucherCode = $_SESSION["voucherCode"];
		$paymentId = $_SESSION["paymentId"];
		$transportationId = $_SESSION["transportationId"];
		$deliveryaddressId = $_SESSION["deliveryaddressId"];
		$invoiceaddressId = $_SESSION["invoiceaddressId"];
		
		$voucher = new Voucher();
		$data["voucher"] = $voucher->getVoucherByVoucherCode($voucherCode);
		$voucherDiscountRate = $data["voucher"]["voucherDiscountRate"];
		$voucherDiscountPrice = $data["voucher"]["voucherDiscountPrice"];
		//print_r($data);exit;
		
		$payment = new Payment();
		$data["payment"] = $payment->getPayment($paymentId);
		//print_r($data);exit;
		
		$transportation = new Transportation();
		$data["transportation"] = $transportation->getTransportation($transportationId);

		$productattribute = new Productattribute();
		$data["productattributebasket"] = $productattribute->getProductattributesFromBasket();
		if (!$data["productattributebasket"]) header("Location: " . _MODULE_DIR_ . "b2b/");
		//print_r($data);exit;

		$productattributebasketTotal = $data["productattributebasket"]["productattributebasketTotal"];
		$paymentimpactWeightRate = $data["payment"]["paymentimpactWeightRate"];
		$paymentimpactWeightPrice = $data["payment"]["paymentimpactWeightPrice"];
		$paymentimpactDiscountRate = $data["payment"]["paymentimpactDiscountRate"];
		$paymentimpactDiscountPrice = $data["payment"]["paymentimpactDiscountPrice"];
		
		$total = $productattributebasketTotal;
		
		$currency = new Currency;
		
		//voucher
		$voucherDiscount = number_format(- $total * $voucherDiscountRate + $voucherDiscountPrice, 2);
		$data["voucherDiscountCur"] = $currency->formatWithCurrency($voucherDiscount);
		$total = $total + $voucherDiscount;
		
		//paymentimpact
		$paymentimpact = number_format($total * $paymentimpactWeightRate + $paymentimpactWeightPrice - $total * $paymentimpactDiscountRate - $paymentimpactDiscountPrice, 2);
		$data["paymentimpactCur"] = $currency->formatWithCurrency($paymentimpact);
		$total = $total + $paymentimpact;
		
		//installment
		$paymentPeriod = intval($data["payment"]["paymentPeriod"]);
		$installment = ($total/$paymentPeriod);

		//$transportationimpactWeight = $data["transportation"]["transportationimpactWeight"];
		//$transportationimpactPrice = $data["transportation"]["transportationimpactPrice"];
		//$amount = number_format($total * (1 + $transportationimpactWeight) + $transportationimpactPrice, 2);
		$amount = number_format($total + $data["transportation"]["transportationPrice"], 2);
		
		$data["amountReal"] = $amount;
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
			
			$data["amount"] = ($amount<1)?1:$amount;
			$model->displayTemplate("b2b", "checkout_mt_pd", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 2)
		{
			/*
			 * Payment on Delivery
			*/
				
			$data["amount"] = ($amount<1)?1:$amount;
			$model->displayTemplate("b2b", "checkout_mt_pd", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 3)
		{
			/*
			 * Other Credit Cards
			*/
			
			$data["amount"] = ($amount<1)?1:$amount;
			$model->displayTemplate("b2b", "checkout_cc", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 4)
		{
			/*
			 * world - 0067 - paymentgroupId=5
			*/
			
			$data["amount"] = $amount*100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
			$model->displayTemplate("b2b", "checkout_cc", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 5)
		{
			/*
			 * bonus - 0062 - paymentypeId=4
			*/
			
			$data["amount"] = $amount*100;//tutar*100 - Alışveriş tutarı (14,8 TL için 1480 giriniz.)
			$model->displayTemplate("b2b", "checkout_cc", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 51)
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
			$path = "https://" . $_SERVER["HTTP_HOST"] . _MODULE_DIR_ . "b2b/";
			$data["strSuccessURL"] = $path . "3DPayResults.php";
			$data["strErrorURL"] = $path . "3DPayResults.php";
			$SecurityData = strtoupper(sha1($strProvisionPassword.$strTerminalID_));
			$data["HashData"] = strtoupper(sha1($data["strTerminalID"].$data["strOrderID"].$data["strAmount"].$data["strSuccessURL"].$data["strErrorURL"].$data["strType"].$data["strInstallmentCount"].$strStoreKey.$SecurityData));
			
			//print_r($data);exit;
			
			$model->displayTemplate("b2b", "checkout_cc_bonus", $data);
		}
		elseif ($data["payment"]["paymentgroupId"] == 6)
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
			$path = "https://" . $_SERVER["HTTP_HOST"] . _MODULE_DIR_ . "b2b/";
			$data["okUrl"] = $path . "3DPayResults.php";
			$data["failUrl"] = $path . "3DPayResults.php";
			$hashstr = $data["clientid"] . $data["oid"] . $data["amount"] . $data["okUrl"] . $data["failUrl"] . $data["islemtipi"] . $data["taksit"] . $data["rnd"] . $storekey;
			$data["hash"] = base64_encode(pack('H*',sha1($hashstr)));
				
			$data["lang"] = "tr";
			$data["currency"] = "949";
			
			//print_r($data);exit;
			
			$model->displayTemplate("b2b", "checkout_cc_axess", $data);
		}

		break;


}