<?php
class Advertisement extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("advertisementId", "userId", "advertisementgroupId", "advertisementContent");
		$this->sIndexColumn		= "advertisementId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sTitleColumn			= $this->sTable."Content";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	
	function searchAdvertisements($q)
	{
		$sQuery = "
			SELECT 
			picture.pictureFile,
			advertisement.advertisementContent,
			advertisement.advertisementId
			FROM advertisement
			LEFT JOIN advertisement_picture ON advertisement_picture.advertisementId = advertisement.advertisementId AND advertisement_picture.isDefault = true
			LEFT JOIN picture ON picture.pictureId = advertisement_picture.pictureId
			WHERE advertisement.advertisementContent LIKE '%$q%'
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, null, PDO::FETCH_NUM);
		$i=0;
		foreach ($rows as $row) {
			$arr[$i] = $row;
			//$arr[$i][0] = $row["advertisementId"];
			//$arr[$i][1] = $row["advertisementContent"];
			//$arr[$i][2] = $row["pictureFile"];
			$i++;
		}
		return ($arr);
	}
	
	function getAdvertisementByAdvertisementId($advertisementId)
	{
		$sQuery = "
			SELECT 
			user.userId,
			user.userFirstname,
			user.userEmail,
			picture.pictureFile,
			advertisement.advertisementContent,
			advertisement.advertisementId
			FROM advertisement
			LEFT JOIN user ON user.userId = advertisement.userId
			LEFT JOIN advertisement_picture ON advertisement_picture.advertisementId = advertisement.advertisementId AND advertisement_picture.isDefault = true
			LEFT JOIN picture ON picture.pictureId = advertisement_picture.pictureId
			WHERE advertisement.advertisementId = :advertisementId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("advertisementId"=>$advertisementId));
		return $rows[0];
	}
	
}