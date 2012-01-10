<?php
class Postaladdress extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("postaladdressId", "userId", "postaladdressContent", "postaladdressCity", "postaladdressCounty", "postaladdressPostalcode", "postaladdressCountry");
		$this->sIndexColumn		= "postaladdressId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}

	/**
	 * fix up form data if necessary
	 *
	 * @param array $formvars the form variables
	 */
	function mungeFormData(&$formvars)
	{
		// trim off excess whitespace
		$formvars['addressTitle'] = trim($formvars['addressTitle']);
		$formvars['addressContent'] = trim($formvars['addressContent']);
	}

	/**
	 * test if form information is valid
	 *
	 * @param array $formvars the form variables
	 */
	function isValidForm($formvars)
	{

		// reset message
		$this->msg = null;

		if(strlen($formvars['addressTitle']) == 0) {
			$this->msg = 'addressTitle_empty';
			return false;
		}

		if(strlen($formvars['addressContent']) == 0) {
			$this->msg = 'addressContent_empty';
			return false;
		}

		// form passed validation
		return true;
	}

}