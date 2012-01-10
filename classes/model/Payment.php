<?php
class Payment extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("paymentId", "paymentgroupId", "paymentPeriod");
		$this->sIndexColumn		= "paymentId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;
		
		$this->aAllFieldI18n		= array("paymentId", "iso639Id", "paymentTitle");
		$this->sIndexColumnI18n		= "paymentId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTableI18n.".".$this->sTitleColumn;

	}
		
	function getPayment($paymentId)
	{
		$sQuery = "
			SELECT 
			paymentimpact.*,
			payment_i18n.*,
			payment.*
			FROM payment
			LEFT JOIN payment_i18n ON payment_i18n.paymentId = payment.paymentId and payment_i18n.iso639Id = :iso639
			LEFT JOIN paymentimpact ON paymentimpact.paymentId = payment.paymentId
			WHERE payment.paymentId = :paymentId
		";
		$rows = $this->run($sQuery, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "paymentId"=>$paymentId));
		$row = $rows[0];
		
		$paymentgroup = new Paymentgroup;
		$row["paymentgroup"] = $paymentgroup->getPaymentgroup($row["paymentgroupId"]);
		
		return $row;
	}
	
	
	function isExistByPaymentgroupIdAndPaymentPeriod($paymentgroupId, $paymentPeriod)
	{
		$rows = $this->select($this->sTable, "paymentgroupId = :paymentgroupId and paymentPeriod = :paymentPeriod", array("paymentgroupId" => $paymentgroupId, "paymentPeriod" => $paymentPeriod));
		return $rows[0];
	}


}