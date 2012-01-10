<?php
class Salescampaign extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("salescampaignId", "salescampaignTitle", "salescampaignContent", "salescampaignStart", "salescampaignEnd");
		$this->sIndexColumn		= "salescampaignId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
	}
	
	function saveSalescampaign($formvars)
	{
		$table = $this->sTable;
		$where = $this->sIndexColumn . " = :id";
		$bind = array("id"=>$formvars[$this->sIndexColumn]);

		if (!empty($formvars[$this->sIndexColumn]) && $rows = $this->select($table, $where, $bind))
		{
			$this->update($table, $formvars, $where, $bind);
			$id = $formvars[$this->sIndexColumn];
		}
		else
		{
			$this->insert($table, $formvars);
			$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$id = $rows[0]["last_insert_id"];
		}

		$this->delete("salescampaign_productattribute", $this->sIndexColumn." = :id", array("id"=>$id));
		foreach ($formvars["productattributeId"] as $productattributeId) {
			$this->insert("salescampaign_productattribute", array($this->sIndexColumn=>$id, "productattributeId"=>$productattributeId));
		}
		
		return $id;
	}
	
	function getSalescampaign($salescampaignId)
	{
		$row = $this->getEntry($salescampaignId, array("picture"=>true));
		//$row["picture"] = $this->getPictures($salescampaignId);
		$row["productattribute"] = $this->getProductattributeBySalescampaignId($salescampaignId);
		return $row;
	}
	
	private function getProductattributeBySalescampaignId($salescampaignId)
	{
		$sQuery = "
			SELECT 
			picture.*,
			productattribute.*
			FROM salescampaign_productattribute
			LEFT JOIN productattribute ON productattribute.productattributeId = salescampaign_productattribute.productattributeId
			LEFT JOIN product_picture ON product_picture.productId = productattribute.productId AND product_picture.isDefault = true
			LEFT JOIN picture ON picture.pictureId = product_picture.pictureId
			WHERE salescampaign_productattribute.salescampaignId = :salescampaignId
		";
		//echo($sQuery);exit;
		
		$rows = $this->run($sQuery, array("salescampaignId"=>$salescampaignId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		$productattribute = new Productattribute();
		foreach($rows as $row) {
			$arr["aaData"][$i] = $productattribute->getProductattributeByProductattributeId($row["productattributeId"]);
			$arr["options"][$row["productattributeId"]] = $row["productattributeCode"];
			$arr["selected"][$i] = $row["productattributeId"];
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
	public function getSalescampaigns()
	{
		$sQuery = "
			SELECT *
			FROM salescampaign
			LEFT JOIN salescampaign_picture ON salescampaign_picture.salescampaignId = salescampaign.salescampaignId
			LEFT JOIN picture ON picture.pictureId = salescampaign_picture.pictureId
			WHERE :date between salescampaignStart and salescampaignEnd
		";
		$rows = $this->run($sQuery, array("date"=>date("Y-m-d H:i:s")));
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
				$i++;
			}
		}
		return ($arr);
	}
	
}