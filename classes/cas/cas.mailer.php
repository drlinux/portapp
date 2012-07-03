<?php
require('class.phpmailer.php');

class CasMailer extends PHPMailer
{
	function __construct()
	{
		global $smarty;
		
		$this->Mailer		= "mail";	#telling the class to use SMTP
		$this->SMTPAuth		= false;		#enable SMTP authentication
		$this->SMTPSecure	= "ssl";	#sets the prefix to the servier: "", "ssl", "tls"
										#gmail gibi ssl üzerinden göndermek için php_openssl.dll aktif hale getirmek gerekiyor
		$this->SMTPDebug	= false;	#enables SMTP debug information (for testing)
										#0, false = no message
										#1 = errors and messages
										#2 = messages only
		$this->CharSet		= 'UTF-8';
		$this->ContentType	= 'text/html';
				
		$this->Host			= $smarty->getVariable("_EMAIL_SERVER");
		$this->Port			= (string) $smarty->getVariable("_EMAIL_PORT");
		$this->Username		= $smarty->getVariable("_EMAIL_USERNAME");
		$this->Password		= $smarty->getVariable("_EMAIL_PASSWORD");
		
		$this->From			= $smarty->getVariable("_EMAIL_FROM");
		$this->FromName		= $smarty->getVariable("_EMAIL_FROMNAME");
		
		$this->AddAddress($smarty->getVariable("_EMAIL_FROM"), $smarty->getVariable("_EMAIL_FROMNAME"));
		if ($this->ValidateAddress($smarty->getVariable("_EMAIL_BCC"))) {
			$this->AddBCC($smarty->getVariable("_EMAIL_BCC"));
		}
		
		$this->Subject = "Subject";
		$this->MsgHTML("Message");
		
		/*
		if ($this->Send()) {
			echo "ok";
		}
		else {
			echo $this->ErrorInfo;
		}
		exit;
		*/
	}
	
	function Send()
	{
		$check = parent::Send();
		$this->ClearAddresses();
		$this->ClearAttachments();
		return $check;
	}
	
}