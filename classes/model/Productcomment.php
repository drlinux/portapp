<?php
class Productcomment extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productcommentId", "productId", "userId", "productcommentContent", "productcommentDatetime");
		$this->sIndexColumn		= "productcommentId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	function getProductcommentsByProductId($productId)
	{
		$sQuery = "
			SELECT 
			user.userFirstname,
			user.userEmail,
			productcomment.productcommentDatetime,
			productcomment.productcommentContent,
			productcomment.productcommentId
			FROM productcomment
			LEFT JOIN user ON user.userId = productcomment.userId
			WHERE productcomment.productId = :productId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("productId"=>$productId));
		
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$i++;
			}
		}
		return ($arr);
	}

}