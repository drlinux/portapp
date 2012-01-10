<?php
class Iso639 extends CasBase
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("iso639Id", "iso639A2", "iso639Title", "iso639Status");
		$this->sIndexColumn		= "iso639Id";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;
		
		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
		
}