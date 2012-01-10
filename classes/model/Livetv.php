<?php
class Livetv extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("livetvId", "livetvSorting", "livetvTitle", "livetvClipUrl", "livetvNetConnectionUrl", "livetvWidth", "livetvHeight", "livetvPlayerSrc", "livetvPlayerKey", "livetvInfluxisUrl");
		$this->sIndexColumn		= "livetvId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sTable."Sorting";
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}
	
}