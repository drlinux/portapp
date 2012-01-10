<?php
class Transportation extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("transportationId", "transportationSorting", "transportationPrice");
		$this->sIndexColumn		= "transportationId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("transportationId", "iso639Id", "transportationTitle", "transportationContent");
		$this->sIndexColumnI18n		= "transportationId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sTable."Sorting";;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTableI18n.".".$this->sTitleColumn;
		
	}
	
	function getTransportation($transportationId)
	{
		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		//array_push($sql, "left join transportationimpact on transportationimpact.transportationId = transportation.transportationId");
		array_push($sql, "where " . $this->sIndexColumnFull . " = :id");
		array_push($sql, "limit 1");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "id"=>$transportationId));
		$row = $rows[0];
		
		$currency = new Currency();
		$row["transportationPriceCur"] = $currency->formatWithCurrency($row["transportationPrice"]);
		return $row;
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
			$sWhere .= "WHERE (transportation_i18n.transportationTitle LIKE '%".$get['sSearch']."%' ) ";
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
			SELECT SQL_CALC_FOUND_ROWS transportation.transportationId, picture.pictureFile, transportation_i18n.transportationTitle
			from transportation
			left join transportation_i18n on transportation_i18n.transportationId = transportation.transportationId and transportation_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
			left join transportation_picture on transportation_picture.transportationId = transportation.transportationId
			left join picture on picture.pictureId = transportation_picture.pictureId
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