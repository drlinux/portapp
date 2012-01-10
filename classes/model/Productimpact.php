<?php
/**
* @package    Productimpact
* @subpackage CasBase
* @copyright  Copyright (c) cas.ict (http://www.casict.com/)
* @license    http://www.casict.com/licenses/
* @author cas.ict
*
*/
class Productimpact extends CasBase
{

	public function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productimpactId", "productId", "roleId", "productPrice", "productimpactWeightRate", "productimpactWeightPrice", "productimpactDiscountRate", "productimpactDiscountPrice");
		$this->sIndexColumn		= "productimpactId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
	
}