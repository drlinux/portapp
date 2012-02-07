<?php
class Akbank
{
	
	public $XML_SERVICE_URL;
	public $mid;
	public $tid;
	
	// no-TDS
	public $tranDateRequired = 1;
	public $amount;
	public $ccno;
	public $currencyCode = 'YT';
	public $cvc;
	public $expDate;
	public $installment;
	public $XID;
	
	// TDS
	public $OOS_TDS_SERVICE_URL;
	public $posnetid;
	public $cardHolderName;
	public $tranType = 'Sale';
	
	public $bankData;
	public $merchantData;
	public $sign;
	
	public $wpAmount = 0;
	
	public function __construct() {}
	
	public function notds_xmldata1()
	{
		
		return "xmldata=".
					"<posnetRequest>".
						"<mid>$this->mid</mid>".
						"<tid>$this->tid</tid>".
						"<tranDateRequired>$this->tranDateRequired</tranDateRequired>".
						"<sale>".
							"<amount>$this->amount</amount>".
							"<ccno>$this->ccno</ccno>".
							"<currencyCode>$this->currencyCode</currencyCode>".
							"<cvc>$this->cvc</cvc>".
							"<expDate>$this->expDate</expDate>".
							"<installment>$this->installment</installment>".
							"<orderID>$this->XID</orderID>".
						"</sale>".
					"</posnetRequest>"
		;
		return "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>".
			"<CC5Request>".
				"<Name>{NAME}</Name>".
				"<Password>{PASSWORD}</Password>".
				"<ClientId>{CLIENTID}</ClientId>".
				"<IPAddress>{IP}</IPAddress>".
				"<Email>{EMAIL}</Email>".
				"<Mode>P</Mode>".
				"<OrderId>{OID}</OrderId>".
				"<GroupId></GroupId>".
				"<TransId></TransId>".
				"<UserId></UserId>".
				"<Type>{TYPE}</Type>".
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
	}
	
	public function init_curl($request)
	{
		$ch = curl_init(); // initialize curl handle
			
		curl_setopt($ch, CURLOPT_URL, $this->XML_SERVICE_URL); // set url to post to
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request/*$this->notds_xmldata1()*/); // add POST fields
			
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
		return $result;
	}
	

	public function tds_xmldata1()
	{
		return "xmldata=".
					"<posnetRequest>".
						"<mid>$this->mid</mid>".
						"<tid>$this->tid</tid>".
						"<oosRequestData>".
							"<posnetid>$this->posnetid</posnetid>".
							"<ccno>$this->ccno</ccno>".
							"<expDate>$this->expDate</expDate>".
							"<cvc>$this->cvc</cvc>".
							"<amount>$this->amount</amount>".
							"<currencyCode>$this->currencyCode</currencyCode>".
							"<installment>$this->installment</installment>".
							"<XID>$this->XID</XID>".
							"<cardHolderName>$this->cardHolderName</cardHolderName>".
							"<tranType>$this->tranType</tranType>".
						"</oosRequestData>".
					"</posnetRequest>"
		;
	}
	
	public function tds_xmldata2()
	{
		return "xmldata=".
					"<posnetRequest>".
						"<mid>$this->mid</mid>".
						"<tid>$this->tid</tid>".
						"<oosResolveMerchantData>".
							"<bankData>$this->bankData</bankData>".
							"<merchantData>$this->merchantData</merchantData>".
							"<sign>$this->sign</sign>".
						"</oosResolveMerchantData>".
					"</posnetRequest>"
		;
	}
	
	public function tds_xmldata3()
	{
		return "xmldata=".
					"<posnetRequest>".
						"<mid>$this->mid</mid>".
						"<tid>$this->tid</tid>".
						"<oosTranData>".
							"<bankData>$this->bankData</bankData>".
							"<wpAmount>$this->wpAmount</wpAmount>".
						"</oosTranData>".
					"</posnetRequest>"
		;
	}
	
}