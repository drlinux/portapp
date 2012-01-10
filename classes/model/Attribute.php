<?php
class Attribute extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("attributeId", "attributegroupId", "attributeCode", "color");
		$this->sIndexColumn		= "attributeId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("attributeId", "iso639Id", "attributeTitle");
		$this->sIndexColumnI18n		= "attributeId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTableI18n.".".$this->sTitleColumn;
	}

	function getAttributeByAttributeCodeAndAttributegroupId($attributeCode, $attributegroupId)
	{
		$results = $this->select($this->sTable, "attributeCode = :attributeCode and attributegroupId = :attributegroupId", array("attributeCode" => $attributeCode, "attributegroupId"=>$attributegroupId));
		return $results[0];
	}
	
	function getAttribute($id)
	{
		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		array_push($sql, "left join attributegroup on attributegroup.attributegroupId = " . $this->sTable . ".attributegroupId");
		array_push($sql, "left join attributegroup_i18n on attributegroup_i18n.attributegroupId = attributegroup.attributegroupId and attributegroup_i18n.iso639Id = :iso639");
		array_push($sql, "where " . $this->sIndexColumnFull . " = :id");
		array_push($sql, "limit 1");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "id"=>$id));
		$row = $rows[0];
		return $row;
	}


	function getAttributesByAttributegroupId($attributegroupId)
	{
		$sql = array();
		array_push($sql, "select");
		array_push($sql, "attribute_i18n.*,");
		array_push($sql, "attribute.*");
		array_push($sql, "from attribute");
		array_push($sql, "left join attribute_i18n on attribute_i18n.attributeId = attribute.attributeId and attribute_i18n.iso639Id = :iso639");
		array_push($sql, "where attribute.attributegroupId = :attributegroupId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "attributegroupId"=>$attributegroupId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}

}