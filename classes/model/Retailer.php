<?php
class Retailer extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("retailerId", "retailerCode");
		$this->sIndexColumn		= "retailerId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	public function getRetailerByUserId($userId)
	{
		$sQuery = "
					SELECT 
					company.*,
					retailer.*
					FROM retailer
					LEFT JOIN retailer_user ON retailer_user.retailerId = retailer.retailerId
					LEFT JOIN user ON user.userId = retailer_user.userId
					LEFT JOIN retailer_company ON retailer_company.retailerId = retailer.retailerId
					LEFT JOIN company ON company.companyId = retailer_company.companyId
					WHERE retailer_user.userId = :userId
				";
		$rows = $this->run($sQuery, array("userId"=>$userId));
		return $rows[0];
	}
			
}