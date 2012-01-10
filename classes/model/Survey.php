<?php
class Survey extends CasBase
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("surveyId", "surveyTitle", "surveyStart", "surveyEnd");
		$this->sIndexColumn		= "surveyId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;
		
		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
		
	function getSurvey($surveyId)
	{
		$row = $this->getEntry($surveyId);
		$row["surveyq"] = $this->getSurveyq($row["surveyId"]);
		return ($row);
	}

	function getSurveyq($surveyId)
	{
		$rows = $this->select("surveyq", "surveyId = :surveyId", array("surveyId"=>$surveyId));
		$i=0;
		foreach ($rows as $row) {
			$rows[$i]["surveya"] = $this->getSurveya($row["surveyqId"]);
			$i++;
		}
		return ($rows);
	}

	function getSurveya($surveyqId)
	{
		$rows = $this->select("surveya", "surveyqId = :surveyqId", array("surveyqId"=>$surveyqId));
		return ($rows);
	}
}