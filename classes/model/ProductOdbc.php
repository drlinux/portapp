<?php
class ProductOdbc extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productId", "productCode", "productTitle");
		$this->sIndexColumn		= "productId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}

	function getProducts($formvars=null, $params=null)
	{
		$limit = (isset($formvars["limit"]))?intval($formvars["limit"]):100;
		
		$sql = array();
		array_push($sql, "SELECT TOP $limit");
		array_push($sql, "tbStokFiyati.*,");
		array_push($sql, "tbStok.*");
		array_push($sql, "FROM tbStok");
		array_push($sql, "LEFT JOIN tbStokFiyati");
		array_push($sql, "ON tbStokFiyati.nStokId = tbStok.nStokId AND sFiyatTipi = 'PS'");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql);
		$arr["iTotalRecords"] = count($rows);
		foreach ($rows as $row) {
			$arr["aaData"][] = array('Row'=>$row);
		}
		//print_r($arr);exit;
		return ($arr);
	}

}