<?php
class Advertisementgroup extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("advertisementgroupId", "advertisementgroupTitle");
		$this->sIndexColumn		= "advertisementgroupId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
}