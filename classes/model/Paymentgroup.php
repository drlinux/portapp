<?php
class Paymentgroup extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("paymentgroupId", "paymentgroupType", "paymentgroupSorting", "paymentgroupClass", "paymentgroupStatus", "bankCode", "paymentgroupMethod", "paymentgroupGate1", "paymentgroupGate2", "paymentgroupMid", "paymentgroupTid", "paymentgroupPosnetid");
		$this->sIndexColumn		= "paymentgroupId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("paymentgroupId", "iso639Id", "paymentgroupTitle", "paymentgroupContent");
		$this->sIndexColumnI18n		= "paymentgroupId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sTable."Sorting";
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTableI18n.".".$this->sTitleColumn;

		$this->sStatusColumn		= $this->sTable."Status";
		$this->sStatusColumnFull	= $this->sTable.".".$this->sStatusColumn;

	}


	function getPaymentgroup($id)
	{
		$sql = array();
		array_push($sql, "select");
		array_push($sql, "picture.pictureFile,");
		array_push($sql, "paymentgroup_i18n.*,");
		array_push($sql, "paymentgroup.*");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		array_push($sql, "left join paymentgroup_picture on paymentgroup_picture.paymentgroupId = paymentgroup.paymentgroupId");
		array_push($sql, "left join picture on picture.pictureId = paymentgroup_picture.pictureId");
		array_push($sql, "where " . $this->sIndexColumnFull . " = :id");
		array_push($sql, "order by " . $this->sSortingColumnFull . " asc");
		$sql = implode(" ", $sql);

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "id"=>$id));
		$row = $rows[0];
		$row["transportation"] = $this->getTransportationsByPaymentgroupId($row[$this->sIndexColumn]);
		$row["payment"] = $this->getPaymentsByPaymentgroupId($row[$this->sIndexColumn]);
		//print_r($row);exit;
		return ($row);
	}

	function getPaymentgroups()
	{
		$sql = array();
		array_push($sql, "select");
		array_push($sql, "picture.pictureFile,");
		array_push($sql, "paymentgroup_i18n.*,");
		array_push($sql, "paymentgroup.*");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		array_push($sql, "left join paymentgroup_picture on paymentgroup_picture.paymentgroupId = paymentgroup.paymentgroupId");
		array_push($sql, "left join picture on picture.pictureId = paymentgroup_picture.pictureId");
		array_push($sql, "where " . $this->sStatusColumnFull . " = true");
		array_push($sql, "order by " . $this->sSortingColumnFull . " asc");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["aaData"][$i]["transportation"] = $this->getTransportationsByPaymentgroupId($row[$this->sIndexColumn]);
			$arr["aaData"][$i]["payment"] = $this->getPaymentsByPaymentgroupId($row[$this->sIndexColumn]);
			$i++;
		}
		return ($arr);
	}


	function getTransportationsByPaymentgroupId($paymentgroupId=null)
	{
		if ($paymentgroupId == null) return null;

		$sql = array();
		array_push($sql, "select");
		array_push($sql, "transportationimpact.transportationimpactWeight,");
		array_push($sql, "transportationimpact.transportationimpactPrice,");
		array_push($sql, "picture.pictureFile,");
		array_push($sql, "transportation_i18n.transportationTitle,");
		array_push($sql, "transportation_i18n.transportationContent,");
		array_push($sql, "transportation.*");
		array_push($sql, "from paymentgroup_transportation");
		array_push($sql, "left join transportation on transportation.transportationId = paymentgroup_transportation.transportationId");
		array_push($sql, "left join transportation_i18n on transportation_i18n.transportationId = transportation.transportationId and transportation_i18n.iso639Id = :iso639");
		array_push($sql, "left join transportation_picture on transportation_picture.transportationId = transportation.transportationId");
		array_push($sql, "left join picture on picture.pictureId = transportation_picture.pictureId");
		array_push($sql, "left join transportationimpact on transportationimpact.transportationId = transportation.transportationId");
		if ($paymentgroupId != null) {
			array_push($sql, "where paymentgroup_transportation.paymentgroupId = " .$paymentgroupId);
		}
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row["transportationId"]] = $row["transportationTitle"];
			$arr["selected"][] = $row["transportationId"];
			$i++;
		}
		return ($arr);
	}


	function getPaymentsByPaymentgroupId($paymentgroupId=null)
	{
		if ($paymentgroupId == null) return null;

		$sql = array();
		array_push($sql, "select");
		array_push($sql, "paymentimpact.paymentimpactWeightRate,");
		array_push($sql, "paymentimpact.paymentimpactWeightPrice,");
		array_push($sql, "paymentimpact.paymentimpactDiscountRate,");
		array_push($sql, "paymentimpact.paymentimpactDiscountPrice,");
		array_push($sql, "payment_i18n.paymentTitle,");
		array_push($sql, "payment.*");
		array_push($sql, "from payment");
		array_push($sql, "left join payment_i18n on payment_i18n.paymentId = payment.paymentId and payment_i18n.iso639Id = :iso639");
		array_push($sql, "left join paymentimpact on paymentimpact.paymentId = payment.paymentId");
		if ($paymentgroupId != null) {
			array_push($sql, "where payment.paymentgroupId = " .$paymentgroupId);
		}
		array_push($sql, "order by payment.paymentPeriod asc");
		$sql = implode(" ", $sql);
		//echo $sql;exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
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
		$sWhere = "";
		if ( $get['sSearch'] != "" )
		{
			$sWhere .= "WHERE (paymentgroup_i18n.paymentgroupTitle LIKE '%".$get['sSearch']."%' ) ";
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
			SELECT SQL_CALC_FOUND_ROWS paymentgroup.paymentgroupId, paymentgroup_i18n.paymentgroupTitle, paymentgroup.paymentgroupSorting, paymentgroup.paymentgroupStatus
			from paymentgroup
			left join paymentgroup_i18n on paymentgroup_i18n.paymentgroupId = paymentgroup.paymentgroupId and paymentgroup_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
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