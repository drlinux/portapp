<?php  
    function curPageURL() {
        $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"); 
        $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
        $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
        $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
        return $url;
    }
    
    function currencyFormat(
	    $amount,
	    $currencyCode,
	    $addCurrency) {
	
		if (strlen($amount) < 3)
			$amount = '00'.$amount;
		
		$amount = (int)$amount;
		
        if ($currencyCode != null && (!strpos($currencyCode, 'YT') || !strpos($currencyCode, 'US') || !strpos($currencyCode, 'EU'))) {
			$amount = substr($amount, 0, strlen($amount)-2).','.substr($amount, strlen($amount)-2);
            if($addCurrency)
                return $amount.' '.getCurrencyText($currencyCode);
            else
                return $amount;
        }
		return $amount;
    }
    
	function convertYTLToYKR($amount)
	{
		if(strlen($amount) > 0) {
			$amount = str_replace(".", "", $amount);
			$amount = str_replace(",", ".", $amount);
			return ($amount)*100;
		}
		else
			return "";
	}

	function getCurrencyText($currencyCode)
	{
		if ($currencyCode == "YT")
			return "TL";
		else if ($currencyCode == "TL")
			return "TL";
		else if ($currencyCode == "US")
			return "USD";
		else if ($currencyCode == "EU")
			return "EUR";
		else
			return $currencyCode;
	}
	
    function threeDSecureCheck($threeDMdStatus)
    {
        if(!TD_SECURE_CHECK)
            return true;
        
        $checkList = explode(":", TD_SECURE_CHECK_MASK);
        foreach ($checkList as $value) {
            if($value == $threeDMdStatus)
                return true;
        }
   
        return false;
    }
?> 