<?php
class Userpoint extends CasBase
{
	
	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("userpointId", "userId", "userpointtypeId", "userpointAmount");
		$this->sIndexColumn		= "userpointId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	function getUserpointsOwned()
	{
		$sQuery = "
			SELECT 
			userpointtype.*,
			userpoint.*
			FROM userpoint
			LEFT JOIN userpointtype ON userpointtype.userpointtypeId = userpoint.userpointtypeId
			WHERE userpoint.userId = :userId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("userId"=>$_SESSION["userId"]));
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["totalUserpoint"] += $row["userpointAmount"];
				$i++;
			}
		}
		return ($arr);
	}
	
	function addUserpoint($userId, $userpointtypeId)
	{
		$userpointtype = new Userpointtype();
		$upt = $userpointtype->getEntry($userpointtypeId);
		
		$this->insert(
			"userpoint",
			array(
				"userId"=>$userId,
				"userpointtypeId"=>$userpointtypeId,
				"userpointAmount"=>$upt["userpointtypeAmount"],
				"userpointDatetime"=>date("Y-m-d H:i:s")
			)
		);
	}
	
}