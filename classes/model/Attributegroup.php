<?php
class Attributegroup extends CasBase
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("attributegroupId", "isColorgroup");
		$this->sIndexColumn		= "attributegroupId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("attributegroupId", "iso639Id", "attributegroupTitle");
		$this->sIndexColumnI18n		= "attributegroupId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTableI18n.".".$this->sTitleColumn;
		
	}
	
	function getAttributegroupsWithAttributes()
	{
		$sQuery = "
			SELECT 
			attributegroup_i18n.*,
			attributegroup.*
			FROM attributegroup
			LEFT JOIN attributegroup_i18n ON attributegroup_i18n.attributegroupId = attributegroup.attributegroupId AND attributegroup_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
		";
		//echo $sQuery;exit;
		$rows = $this->run($sQuery);
		//print_r($rows);exit;
		
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		$attribute = new Attribute();
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["aaData"][$i]["attribute"] = $attribute->getAttributesByAttributegroupId($row["attributegroupId"]);
			$arr["optgroup"][$row["attributegroupTitle"]] = $arr["aaData"][$i]["attribute"]["options"];
			$i++;
		}
		
		//print_r($arr);exit;
		return ($arr);
	}
	
	
	
	function mungeFormData(&$formvars)
	{
		if (is_array($formvars["attributegroupTitle"])) {
			foreach ($formvars["attributegroupTitle"] as $k=>$v) {
				$formvars["attributegroupTitle"][$k] = trim($formvars["attributegroupTitle"][$k]);
			}
		}
	}
	
	function isValidForm($formvars)
	{
		// reset message
		$this->msg = null;

		if (is_array($formvars["attributegroupTitle"])) {
			if(empty($formvars["attributegroupTitle"])) {
				$this->msg = 'attributegroupTitle_empty';
				return false;
			}
		}

		// form passed validation
		return true;
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
		$sWhere = "";
		if ( $get['sSearch'] != "" )
		{
			$sWhere .= "WHERE (attributegroup.isColorgroup LIKE '%".$get['sSearch']."%' OR attributegroup_i18n.attributegroupTitle LIKE '%".$get['sSearch']."%' ) ";
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
			SELECT SQL_CALC_FOUND_ROWS attributegroup.attributegroupId, attributegroup.isColorgroup, attributegroup_i18n.attributegroupTitle
			from attributegroup
			left join attributegroup_i18n on attributegroup_i18n.attributegroupId = attributegroup.attributegroupId and attributegroup_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
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

		//print_r($output);exit;
		return json_encode( $output );

	}

}