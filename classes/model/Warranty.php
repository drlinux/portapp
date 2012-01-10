<?php
class Warranty extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("warrantyId", "warrantyPeriod");
		$this->sIndexColumn		= "warrantyId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Period";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;
	}
			
}