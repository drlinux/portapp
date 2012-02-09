<?php
class Voucher extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("voucherId", "voucherTitle", "voucherStart", "voucherEnd", "voucherDiscountRate", "voucherDiscountPrice");
		$this->sIndexColumn		= "voucherId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}
	
	function getVouchercodeByVoucherId($voucherId)
	{
		$sQuery = "
			SELECT 
			voucher.*,
			vouchercode.*
			FROM vouchercode
			LEFT JOIN voucher ON voucher.voucherId = vouchercode.voucherId
			WHERE vouchercode.voucherId = :voucherId
		";
		
		$rows = $this->run($sQuery, array("voucherId"=>$voucherId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$i] = $row["voucherCode"];
			$i++;
		}
		
		return ($arr);
	}
	
	function getVoucherByVoucherCode($voucherCode)
	{
		$sQuery = "
			SELECT 
			voucher.*,
			vouchercode.*
			FROM vouchercode
			LEFT JOIN voucher ON voucher.voucherId = vouchercode.voucherId
			WHERE vouchercode.voucherCode = :voucherCode
		";
		
		$rows = $this->run($sQuery, array("voucherCode"=>$voucherCode));
		return $rows[0];
	}

}