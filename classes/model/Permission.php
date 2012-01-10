<?php
class Permission extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("permissionId", "permissionParent", "permissionHref", "permissionSorting");
		$this->sIndexColumn		= "permissionId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("permissionId", "iso639Id", "permissionTitle");
		$this->sIndexColumnI18n		= "permissionId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sTable."Sorting";
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sParentColumn		= $this->sTable."Parent";
		$this->sParentColumnFull	= $this->sTable.".".$this->sParentColumn;
		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTableI18n.".".$this->sTitleColumn;
	}
	
	
	/**
	*
	* Check permission
	* @param string $module  (admin, b2b, b2c)
	*/
	public static function checkPermission($module="admin")
	{
		$path_parts = pathinfo($_SERVER["SCRIPT_NAME"]);
		//$pageHref = $path_parts['dirname'];
		$pageHref = $path_parts['dirname'] . '/' . $path_parts['basename'];
		//$pageHref = $_SERVER["SCRIPT_NAME"];
		//echo($pageHref);exit;
		$permission = new Permission;
		$authenticated = false;
		if ($permissionId = $permission->hrefToPermission($pageHref))
		{
			if (is_array($_SESSION["permissionId"]))
			{
				if (in_array($permissionId, $_SESSION["permissionId"]))
				{
					$authenticated = true;
				}
			}
		}
		return $authenticated;
	}
	
	public static function checkPermissionRedirect($module="admin")
	{
		if (!self::checkPermission($module))
		{
			header("Location: " . _MODULE_DIR_ . $module . "/index.php?action=login");
			exit;
		}
	}
	
	

	public function hrefToPermission($search)
	{
		$results = $this->select("permission", "permissionHref LIKE :search", array(":search" => "%$search%"));
		//$results = $this->select("permission", "permissionHref = :search", array(":search"=>$search));
		return $results[0]["permissionId"];
	}

	public function jsonTree($id=null, $selected=null)
	{
		return json_encode($this->arrayTree($id, $selected));
	}

	private function arrayTree($id=null, $selected=null)
	{
		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		if ($id==null) array_push($sql, "where " . $this->sParentColumnFull . " is null");
		else array_push($sql, "where " . $this->sParentColumnFull . " = " . $id);
		array_push($sql, "order by");
		array_push($sql, $this->sParentColumnFull . " asc,");
		array_push($sql, $this->sSortingColumnFull . " asc");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		
		$i = 0;
		$arr = array();
		foreach ($rows as $row) {
			if (in_array($row["permissionId"], $_SESSION["permissionId"])) {
				$arr[$i]["id"] = $row[$this->sIndexColumn];//treeview
				$arr[$i]["text"] = $row[$this->sTitleColumn];//treeview
				$arr[$i]["key"] = $row[$this->sIndexColumn];//dynatree
				$arr[$i]["title"] = $row[$this->sTitleColumn];//dynatree
				if (is_array($selected)) {
					$arr[$i]["select"] = (in_array($row[$this->sIndexColumn], $selected))?true:false;//dynatree
					$arr[$i]["expand"] = (in_array($row[$this->sIndexColumn], $selected))?true:false;//dynatree
				}
				if ($children = $this->arrayTree($row[$this->sIndexColumn], $selected)) {
					$arr[$i]["children"] = $children;
				}
				else {
					$arr[$i]["href"] = $row["permissionHref"];
				}
				$i++;
			}
		}
		//print_r($arr);exit;
		return ($arr);
	}



	function dataTables($aColumns, $sIndexColumn, $sTable, $get=array())
	{

		/*
		 * Paging
		*/
		$sLimit = "";
		if ( isset( $get['iDisplayStart'] ) && $get['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT " . $get['iDisplayStart'] .", " . $get['iDisplayLength'];
		}


		/*
		 * Ordering
		*/
		if ( isset( $get['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $get['iSortingCols'] ) ; $i++ )
			{
				if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $get['iSortCol_'.$i] ) ] . " " . $get['sSortDir_'.$i] . ", ";
				}
			}

			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}


		/*
		 * Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
		/*
		 $sWhere = "";
		if ( $get['sSearch'] != "" )
		{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
		$sWhere .= $aColumns[$i]." LIKE '%".$get['sSearch']."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
		}
		*/

		/*
		 * Custom Filtering
		*/
		$sWhere = "WHERE (permission.permissionId = permission_i18n.permissionId AND permission_i18n.iso639Id = " . $_SESSION["PROJECT_LANGUAGE"] . ") ";
		if ( $get['sSearch'] != "" )
		{
			$sWhere .= "AND (permission_i18n.permissionTitle LIKE '%".$get['sSearch']."%' ) ";
		}


		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%" . $get['sSearch_'.$i] . "%' ";
			}
		}


		/*
		 * SQL queries
		* Get data to display
		*/
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS permission.permissionId, permission_i18n.permissionTitle, permission.permissionSorting
			from permission
			left join permission_i18n on permission_i18n.permissionId = permission.permissionId and permission_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
		$sWhere
		$sOrder
		$sLimit
		";
		//echo $sQuery;exit;
		$rResult = $this->run($sQuery);
		//print_r($rResult);exit;


		/* Data set length after filtering */
		$sQuery = "
			SELECT FOUND_ROWS() as iFilteredTotal
		";
		$aResultFilterTotal = $this->run($sQuery, PDO::FETCH_NUM);
		$iFilteredTotal = $aResultFilterTotal[0]["iFilteredTotal"];

		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as iTotal
			FROM   $sTable
		";
		$aResultTotal = $this->run($sQuery);
		$iTotal = $aResultTotal[0]["iTotal"];

			
		/*
		 * Output
		*/
		$output = array(
			"sEcho" => intval($get['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		foreach ($rResult as $aRow)
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] == "version" )
				{
					/* Special output formatting for 'version' column */
					$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				}
				else if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
			$output['aaData'][] = $row;
		}

		//return json_encode( $output );
		if ( isset($get['callback']) )
		{
			return $get['callback'].'('.json_encode( $output ).');';
		}
		else
		{
			return json_encode( $output );
		}
	}


	function getPermissionsByRoleId($roleId, $permissionId=null)
	{
		if ($roleId == null) return null;

		$sql = array();
		array_push($sql, "SELECT *");
		array_push($sql, "FROM role_permission");
		array_push($sql, "LEFT JOIN permission on permission.permissionId = role_permission.permissionId");
		array_push($sql, "LEFT JOIN permission_i18n on permission_i18n.permissionId = permission.permissionId AND permission_i18n.iso639Id = :iso639");
		array_push($sql, "WHERE role_permission.roleId = :roleId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("roleId"=>$roleId, "iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
			$arr["selected"][$i] = $row[$this->sIndexColumn];
			if ($permissionId  != null && $permissionId == $row[$this->sIndexColumn]) {
				$arr["defaultx"] = $row;
			}
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}


}