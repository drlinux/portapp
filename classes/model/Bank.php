<?php
class Bank extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("bankCode", "bankTitle");
		$this->sIndexColumn		= "bankCode";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;
	}
	
}