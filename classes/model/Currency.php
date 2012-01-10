<?php
class Currency extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("currencyId", "currencyTitle", "currencyCode", "iso_code_num", "currencySign", "blank", "format", "decimals", "currencyConversionRate", "deleted", "currencyStatus", "currencyHome");
		$this->sIndexColumn		= "currencyId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Code";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;
	}
	
	/**
	 * 
	 * http://converter-currency.com/iso-currency-codes
	 */
	public function formatWithCurrency($amount, $currencySign=null)
	{
		if ($currencySign == null) {
			$rows = $this->select($this->sTable, "currencyHome = :home", array("home"=>1));
			return $amount . " " . $rows[0]["currencySign"];
		}
		else {
			return $amount . " " . $currencySign;
		}
	}

}