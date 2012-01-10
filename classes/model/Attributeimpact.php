<?php
class Attributeimpact extends CasBase
{

	public function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("attributeimpactId", "productId", "attributeId", "attributeimpactWeightRate", "attributeimpactWeightPrice", "attributeimpactDiscountRate", "attributeimpactDiscountPrice");
		$this->sIndexColumn		= "attributeimpactId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
	
}