<?php
class Productattributemovement extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productattributemovementId", "productattributeId", "productattributemovementQuantity", "productattributemovementPriceOC", "productattributemovementDate", "supplierId");
		$this->sIndexColumn		= "productattributemovementId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;
		
	}
	
	function getProductattributemovementByProductattributeId($productattributeId)
	{
		$sQuery = "
			SELECT 
			company.*,
			supplier.*,
			productattributemovement.*
			FROM productattributemovement
			LEFT JOIN supplier ON supplier.supplierId = productattributemovement.supplierId
			LEFT JOIN supplier_company ON supplier_company.supplierId = supplier.supplierId
			LEFT JOIN company ON company.companyId = supplier_company.companyId
			WHERE productattributemovement.productattributeId = :productattributeId
		";
		$rows = $this->run($sQuery, array("productattributeId"=>$productattributeId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
}