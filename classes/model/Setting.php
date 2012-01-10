<?php

class Setting extends CasBase
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("settingId", "settingParameter", "settingValue");
		$this->sIndexColumn		= "settingId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
		
	public function getSettings()
	{
		$rows = $this->select($this->sTable);
		$iTotalRecords = count($rows);
		$arr["iTotalRecords"] = $iTotalRecords;
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row["settingParameter"]] = $row["settingValue"];
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}

}