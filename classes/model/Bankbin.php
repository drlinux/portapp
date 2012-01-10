<?php
class Bankbin extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("bankbinId", "bankbinCode", "bankbinCode2", "bankbinBin", "bankbinTitle");
		$this->sIndexColumn		= "bankbinId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;
	}
	
	function getBankbincodesByBankcode($bankCode)
	{
		if ($bankCode == null) return null;

		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from bankbin");
		array_push($sql, "where bankCode = :bankCode");
		$sql = implode(" ", $sql);

		$rows = $this->select($this->sTable, "bankCode = :bankCode", array("bankCode"=>$bankCode));
		foreach ($rows as $row) {
			$arr[] = $row["bankbinBin"];
		}
		return ($arr);
	}
		
}