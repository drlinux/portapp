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
	
	function saveSalescampaignTypeAjax($formvars)
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
	
	function saveSalescampaign($formvars, $params=null)
	{
		if($id = $this->saveEntry($formvars))
		{
			// Önceden yüklenmiş resimleri database den al
			$existingPictures = $this->getSalescampaignsPictures($id);
			$maximumPictureCount = 2;
			
			// olası her upload edilecek dosya için döngüye gir
			for($i = 0; $i<$maximumPictureCount; $i++)
			{
				// Kampanyalarda 2. resmin boyutu farklı olacağı için ona göre resize yapıyoruz
				if($i == 1)
				{
					$params["picture"] = array("resize"=>array(180, 180), "isDefault"=>false);
				}
				
				// upload edilecek dosyayı request'ten seç
				$pictureArrayKey = "pictureFile_" . ($i + 1);
				$pictureFile = $formvars[$pictureArrayKey];
				
				// upload edilecek dosyanın gerçekte var olup olmadığını kontrol et, eğer var ise önceki resmi silip yenisini ekle
				if(intval($pictureFile["size"], "10") > 0)
				{
					$order = $i + 1; //$existingPictures[$i]["orderNum"];
					
					// Resmi sil ve database'den kaldır
					$this->delete($this->sTable . "_picture", "salescampaignId=:id AND orderNum=:order", array("id"=>$id, "order"=>$order));
					if(isset($existingPictures[$i]))
					{
						$this->unlinkPicture($existingPictures[$i]["pictureId"]);
					}

					// Yeni resmi yükle
					if ($fileInfo = $this->uploadFile(array("multipart"=>$pictureFile,"picture"=>$params["picture"])))
					{
						$this->insert("picture", array("pictureFile"=>$fileInfo["fileNameWithExtension"]));
						$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
						$pictureId = $rows[0]["last_insert_id"];
					
					
						if ($i === 0) 
						{
							$info = array($this->sIndexColumn=>$id, "pictureId"=>$pictureId, "orderNum"=>$order, "isDefault"=>true);
						}
						else 
						{
							$info = array($this->sIndexColumn=>$id, "pictureId"=>$pictureId, "orderNum"=>$order);
						}
						
						$this->insert($this->sTable."_picture", $info);
					}
				}
			}

			return $id;
		}
		else
			return false;
	}
	
	function deleteSalescampaign($salescampaignId)
	{
		$existingPictures = $this->getSalescampaignsPictures($salescampaignId);
		$pictureCount = sizeof($existingPictures);
		
		$error = false;		
		//$this->delete($this->sTable . "_picture", "salescampaignId=:id AND orderNum=:order", array("id"=>$id, "order"=>$order));
		for($i=0; $i<$pictureCount; $i++)
		{
			if(!$this->unlinkPicture($existingPictures[$i]["pictureId"]))
				$error = true;
		}
		
		$this->delete("salescampaign_productattribute", "salescampaignId=:id", array("id"=>$salescampaignId)) && 
		$this->delete($this->sTable . "_picture", "salescampaignId=:id", array("id"=>$salescampaignId));
		return $this->removeEntry($salescampaignId, true);
	}
	
	function getSalescampaign($salescampaignId)
	{
		$sQuery = "	SELECT *, DATEDIFF(salescampaignEnd, NOW()) AS DifDayCount 
					FROM salescampaign
					LEFT JOIN salescampaign_picture ON salescampaign_picture.salescampaignId = salescampaign.salescampaignId
					LEFT JOIN picture ON picture.pictureId = salescampaign_picture.pictureId
					WHERE (salescampaign_picture.isDefault=1 AND salescampaign.salescampaignId=:id) OR (salescampaign_picture.salescampaignId IS NULL)	LIMIT 0,1";
		
		$temp = $this->run($sQuery, array("id"=>$salescampaignId));
		$row = $temp[0];
		//$row["picture"] = $this->getPictures($salescampaignId);
		$row["productattribute"] = $this->getProductattributeBySalescampaignId($salescampaignId);
		return $row;
	}
	
	function getSimilarProductsFromCampaign($productId, $limit = 3)
	{
		$query = "SELECT 
			salescampaign_productattribute.salescampaignId 
			FROM salescampaign_productattribute
			LEFT JOIN productattribute ON productattribute.productattributeId = salescampaign_productattribute.productattributeId
			WHERE productattribute.productId = :id";
		
		$temp = $this->run($query, array("id"=>$productId));
		$salescampaignId = $temp[0]["salescampaignId"];

		return $this->getProductattributeBySalescampaignId($salescampaignId, $limit);
	}
	
	function getProductattributeBySalescampaignId($salescampaignId, $limit = 3)
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
			LIMIT 0,{$limit}
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
	
	public function getSalescampaignsPictures($salescampaignsId)
	{
		$query 	= "SELECT p.*, scp.orderNum FROM salescampaign_picture AS scp ";
		$query .= "LEFT JOIN picture AS p ON scp.pictureId=p.pictureId ";
		$query .= "WHERE scp.salescampaignId=:id ORDER BY scp.orderNum ASC";
		
		return $this->run($query, array("id"=>$salescampaignsId));
	}
	
	public function getSalescampaigns($status = "active", $pictureOrderNum = 1, $limit=-1)
	{
		$sQuery = "
			SELECT * 
			FROM salescampaign
			LEFT JOIN salescampaign_picture ON salescampaign_picture.salescampaignId = salescampaign.salescampaignId
			LEFT JOIN picture ON picture.pictureId = salescampaign_picture.pictureId";
		
		if($status === "active")
		{
			$sQuery .="	WHERE NOW() between salescampaignStart and salescampaignEnd ";
		}
		else if($status === "time_passed")
		{
			$sQuery .="	WHERE salescampaignEnd < NOW() ";
		}
		if($status === "not_time")
		{
			$sQuery .="	WHERE salescampaignStart > NOW() ";
		}
		
		$sQuery .= "AND salescampaign_picture.orderNum={$pictureOrderNum}";
		$sQuery .= $limit > 0 ? " LIMIT 0,{$limit}" : "";
		
		$rows = $this->run($sQuery);
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