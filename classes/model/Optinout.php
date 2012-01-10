<?php
class Optinout extends CasBase
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("optinoutId", "optinoutEmail");
		$this->sIndexColumn		= "optinoutId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;
		
		$this->sTitleColumn			= $this->sTable."Email";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
	
	/**
	 * $optinoutStatus = 1 ^ $rows[0]["optinoutStatus"]; // EXOR
	 */
	function saveOptin($formvars)
	{
		$rows = $this->select($this->sTable, "optinoutEmail = :optinoutEmail", array("optinoutEmail"=>$formvars["optinoutEmail"]));
		if ($rows) {
			$row = $rows[0];
			if ($row["optinoutStatus"] == null || $row["optinoutStatus"] == 0) {
				$optinoutStatus = 1;
				$this->update($this->sTable, array("optinoutEmail"=>$formvars["optinoutEmail"], "optinoutStatus"=>$optinoutStatus), "optinoutId = :optinoutId", array("optinoutId"=>$row["optinoutId"]));
			}
			else {
				
			}
		}
		else {
			$this->insert($this->sTable, array("optinoutEmail"=>$formvars["optinoutEmail"], "optinoutStatus"=>1));
		}
		$this->msg = "success";
	}
	
	function saveOptout($formvars)
	{
		$rows = $this->select($this->sTable, "optinoutEmail = :optinoutEmail", array("optinoutEmail"=>$formvars["optinoutEmail"]));
		if ($rows) {
			$row = $rows[0];
			if ($row["optinoutStatus"] == null || $row["optinoutStatus"] == 0) {
				
			}
			else {
				$optinoutStatus = 0;
				$this->update($this->sTable, array("optinoutEmail"=>$formvars["optinoutEmail"], "optinoutStatus"=>$optinoutStatus), "optinoutId = :optinoutId", array("optinoutId"=>$row["optinoutId"]));
			}
		}
		else {
			$this->insert($this->sTable, array("optinoutEmail"=>$formvars["optinoutEmail"], "optinoutStatus"=>1));
		}
		$this->msg = "success";
	}

	function isValidForm($formvars)
	{
		// reset message
		$this->msg = null;

		$diff = array_diff($this->aAllField, (array) $this->sIndexColumn);

		foreach ($diff as $field) {
			if(strlen($formvars[$field]) == 0) {
				$this->msg = $field . '_empty';
				return false;
			}
		}

		// check others
		if (!CasMailer::ValidateAddress($formvars["optinoutEmail"])) {
			$this->msg = 'optinoutEmail_error';
			return false;
		}

		// form passed validation
		return true;
	}

}