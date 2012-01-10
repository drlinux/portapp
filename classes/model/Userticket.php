<?php
class Userticket extends CasBase
{
	
	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("userticketId", "userticketName", "userticketEmail", "userticketPhone", "userticketSubject", "userticketMessage");
		$this->sIndexColumn		= "userticketId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	function mungeFormData(&$formvars)
	{
		return parent::mungeFormData($formvars);
	}
	
	
	function isValidForm($formvars)
	{
		global $smarty;
		
		parent::isValidForm($formvars);
		
		if (!CasMailer::ValidateAddress($formvars["userticketEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_EmailFormatError");
			return false;
		}
		
		// form passed validation
		return true;
	}
	
	function sendForm($formvars)
	{
		global $smarty;
		
		$userticketId = parent::saveEntry($formvars);
		
		if ($userticketId > 0) {
			$mailer = new CasMailer();
			$mailer->Subject = "Web Mesajı";
			$mailer->MsgHTML(sprintf("Ad Soyad: %s<br/>E-posta Adresi: %s<br/>Telefon Numarası: %s<br/>Konu: %s<br/>Mesaj: %s<br/>", 
				$formvars["userticketName"], 
				$formvars["userticketEmail"], 
				$formvars["userticketPhone"], 
				$formvars["userticketSubject"], 
				$formvars["userticketMessage"]
			));
			if(!$mailer->Send()) {
				$this->msg = $smarty->getConfigVariable("ALERT_MailerSendError");//$mailer->ErrorInfo
				return false;
			}
			else {
				$this->msg = $smarty->getConfigVariable("ALERT_MailerSendSuccessfully");
				return true;
			}
		}
		else {
			$this->msg = $smarty->getConfigVariable("ALERT_ErrorOccured");
			return false;
		}
		
	}

}