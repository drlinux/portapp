<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

//print_r($_POST);exit;

$responseHashparams = $_POST["hashparams"];
$responseHash = $_POST["hash"];
$result = $_POST;
$hash_valid = hash_data( $result,$responseHashparams,$responseHash );
unset($_SESSION["BankError"]);

if(in_array($_POST["mdstatus"], array(null, 7, 8, "")) || !isset($_POST["mdstatus"]))
{
	$_SESSION["BankError"] = $_POST["mderrormessage"];
	header("Location: " . $project['url'] . "modules/b2b/productorder.php?error=true");
}
else if($hash_valid)
{
	if($_POST['response'] == 'Approved')
	{
		$XID = $_POST["orderid"];
		
		$productorder = new Productorder();
		$productorderId = $productorder->saveProductorder($XID, $smarty->getVariable("_PRODUCTORDER_INITIALSTATUS_CC"));
		
		header("Location: " . $project['url'] . "modules/b2b/showproductorder.php?productorderId=" . $productorderId);
		exit;
	}
	else
	{
		if(isset($_POST["hostmsg"]) && (strlen($_POST["hostmsg"]) > 0))
			$_SESSION["BankError"] = $_POST["hostmsg"];
		else
			$_SESSION["BankError"] = "Kart bilgilerinizi veya şifrenizi kontrol edin.";
		
		header("Location: " . $project['url'] . "modules/b2b/productorder.php?error=true");
	}
}
else
{
	$_SESSION["BankError"] = "Bankadan cevap alınamıyor, site yöneticisi ile iletişime geçin.";
	header("Location: " . $project['url'] . "modules/b2b/productorder.php?error=true" );	
	exit;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	


function hash_data($result,$responseHashparams,$responseHash)
{
	$isValidHash = false;
	$storekey="kupa@2023";

	if ($responseHashparams!==NULL && $responseHashparams!=="")
	{
		$digestData = "";
		$paramList = explode(":", $responseHashparams);

		foreach ($paramList as $param)
		{
			if($param !== ""){
				$value= $result[strtolower($param)];
				if($value==null)
				{
					$value="";
				}

				$digestData .= $value;
			}
		}

		$digestData .= $storekey;
		$hashCalculated = base64_encode(pack('H*',sha1($digestData)));

		if($responseHash==$hashCalculated)
		{
			$isValidHash = true;
		}


	}

	return $isValidHash;
}