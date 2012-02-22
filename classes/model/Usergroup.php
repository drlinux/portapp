<?php
class Usergroup extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("usergroupId", "usergroupTitle");
		$this->sIndexColumn		= "usergroupId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}

	function getEntry($id)
	{
		$rows = $this->select($this->sTable, $this->sIndexColumn . " = :id", array("id"=>$id));
		$row = $rows[0];
		$row["user"] = $this->getUsers($row[$this->sIndexColumn]);
		return ($row);
	}

	function getUsers($usergroupId=null)
	{
		if ($usergroupId == null) return null;

		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from usergroup_user");
		array_push($sql, "left join user on user.userId = usergroup_user.userId");
		if ($usergroupId != null) {
			array_push($sql, "where usergroup_user.usergroupId = " .$usergroupId);
		}
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql);
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row["userId"]] = $row["userName"];
			$arr["selected"][] = $row["userId"];
			$i++;
		}
		return ($arr);
	}

}