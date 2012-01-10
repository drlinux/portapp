<?php
class Productorderstatus extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("productorderstatusId", "productorderstatusCode", "productorderstatusColor");
		$this->sIndexColumn		= "productorderstatusId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("productorderstatusId", "iso639Id", "productorderstatusTitle", "productorderstatusNote");
		$this->sIndexColumnI18n		= "productorderstatusId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTableI18n.".".$this->sTitleColumn;
	}
		
}