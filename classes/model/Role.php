<?php
class Role extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("roleId", "roleTitle", "hasPriceDiscrimination");
		$this->sIndexColumn		= "roleId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;
	}
	
	function getRolesHavingPriceDiscrimination()
	{
		$rows = $this->select($this->sTable, "hasPriceDiscrimination = :hasPriceDiscrimination", array("hasPriceDiscrimination"=>true));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
	function getRoleWithPermissions($id)
	{
		$rows = $this->select($this->sTable, $this->sIndexColumn . " = :id", array("id"=>$id));
		$row = $rows[0];
		
		$permission = new Permission;
		$row["permission"] = $permission->getPermissionsByRoleId($row[$this->sIndexColumn]);
		
		return ($row);
	}
	
	function saveRole($formvars)
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

		$this->delete("role_permission", $this->sIndexColumn." = :id", array("id"=>$id));
		foreach ($formvars["permissionIds"] as $permissionId) {
			$this->insert("role_permission", array($this->sIndexColumn=>$id, "permissionId"=>$permissionId));
		}

		return $id;
	}
	
}