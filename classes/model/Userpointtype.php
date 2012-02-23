<?php
class Userpointtype extends CasBase
{
	
	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("userpointtypeId", "userpointtypeTitle", "userpointtypeAmount");
		$this->sIndexColumn		= "userpointtypeId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
}