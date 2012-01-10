<?php
class Productorder extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productorderId", "userId", "productorderDatetime", "paymentId", "transportationId", "deliveryaddressId", "invoiceaddressId", "creditcardId");
		$this->sIndexColumn		= "productorderId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	function getProductorder($id)
	{
		$sql = array();
		array_push($sql, "select");
		array_push($sql, "transportation_i18n.transportationTitle,");
		array_push($sql, "paymentgroup_i18n.paymentgroupTitle,");
		array_push($sql, "user.userName,");
		array_push($sql, "user.userEmail,");
		array_push($sql, "productorderstatus.*,");
		array_push($sql, "productorderstatus_i18n.*,");
		array_push($sql, $this->sTable . ".*");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join productorderstatus on productorderstatus.productorderstatusId = productorder.productorderstatusId");
		array_push($sql, "left join productorderstatus_i18n on productorderstatus_i18n.productorderstatusId = productorderstatus.productorderstatusId and productorderstatus_i18n.iso639Id = :iso639");
		array_push($sql, "left join user on user.userId = productorder.userId");
		array_push($sql, "left join payment on payment.paymentId = productorder.paymentId");
		array_push($sql, "left join paymentgroup on paymentgroup.paymentgroupId = payment.paymentgroupId");
		array_push($sql, "left join paymentgroup_i18n on paymentgroup_i18n.paymentgroupId = paymentgroup.paymentgroupId and paymentgroup_i18n.iso639Id = :iso639");
		array_push($sql, "left join transportation on transportation.transportationId = productorder.transportationId");
		array_push($sql, "left join transportation_i18n on transportation_i18n.transportationId = transportation.transportationId and transportation_i18n.iso639Id = :iso639");
		array_push($sql, "where " . $this->sIndexColumnFull . " = :id");
		array_push($sql, "limit 1");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("id"=>$id, "iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$row = $rows[0];
		$productsalesmovement = new Productsalesmovement;
		$postaladdress = new Postaladdress;
		$row["productsalesmovement"] = $productsalesmovement->getProductsalesmovementByProductorderId($row["productorderId"]);
		$row["deliveryaddress"] = $postaladdress->getEntry($row["deliveryaddressId"]);
		$row["invoiceaddress"] = $postaladdress->getEntry($row["invoiceaddressId"]);
		return ($row);
	}
	
	
	// TODO: getProductorders ve getProductordersOwned birleştirilebilir.
	function getProductorders()
	{
		$rows = $this->select($this->sTable);
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$productsalesmovement = new Productsalesmovement;
			$arr["aaData"][$i]["productsalesmovement"] = $productsalesmovement->getProductsalesmovementByProductorderId($row["productorderId"]);
			$i++;
		}
		return ($arr);
	}

	function getProductordersOwned()
	{
		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join productorderstatus on productorderstatus.productorderstatusId = productorder.productorderstatusId");
		array_push($sql, "left join productorderstatus_i18n on productorderstatus_i18n.productorderstatusId = productorderstatus.productorderstatusId and productorderstatus_i18n.iso639Id = :iso639");
		array_push($sql, "left join payment on payment.paymentId = productorder.paymentId");
		array_push($sql, "left join paymentgroup on paymentgroup.paymentgroupId = payment.paymentgroupId");
		array_push($sql, "left join paymentgroup_i18n on paymentgroup_i18n.paymentgroupId = paymentgroup.paymentgroupId and paymentgroup_i18n.iso639Id = :iso639");
		array_push($sql, "left join transportation on transportation.transportationId = productorder.transportationId");
		array_push($sql, "left join transportation_i18n on transportation_i18n.transportationId = transportation.transportationId and transportation_i18n.iso639Id = :iso639");
		//array_push($sql, "left join postaladdress as deliveryaddress on deliveryaddress.postaladdressId = productorder.deliveryaddressId");
		//array_push($sql, "left join postaladdress as invoiceaddress on invoiceaddress.postaladdressId = productorder.invoiceaddressId");
		array_push($sql, "where " . $this->sTable . ".userId = :userId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "userId"=>$_SESSION["userId"]));
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$productsalesmovement = new Productsalesmovement;
			$postaladdress = new Postaladdress;
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["aaData"][$i]["productsalesmovement"] = $productsalesmovement->getProductsalesmovementByProductorderId($row["productorderId"]);
				$arr["aaData"][$i]["deliveryaddress"] = $postaladdress->getEntry($row["deliveryaddressId"]);
				$arr["aaData"][$i]["invoiceaddress"] = $postaladdress->getEntry($row["invoiceaddressId"]);
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
		$sWhere = "";
		if ( $get['sSearch'] != "" )
		{
			$sWhere .= "WHERE (productorder.XID LIKE '%".$get['sSearch']."%' ) ";
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
		
		
		$sWhere .= "GROUP BY productorder.XID ";
		//echo $sWhere;exit;
		
			
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS productorder.*, user.userFirstname, user.userLastname, transportation_i18n.transportationTitle, paymentgroup_i18n.paymentgroupTitle, productorderstatus_i18n.productorderstatusTitle
			from productorder
			left join user on user.userId = productorder.userId
			left join transportation on transportation.transportationId = productorder.transportationId
			left join transportation_i18n on transportation_i18n.transportationId = transportation.transportationId
			left join payment on payment.paymentId = productorder.paymentId
			left join paymentgroup on paymentgroup.paymentgroupId = payment.paymentgroupId
			left join paymentgroup_i18n on paymentgroup_i18n.paymentgroupId = paymentgroup.paymentgroupId
			left join productorderstatus on productorderstatus.productorderstatusId = productorder.productorderstatusId
			left join productorderstatus_i18n on productorderstatus_i18n.productorderstatusId = productorderstatus.productorderstatusId AND productorderstatus_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
			$sWhere
			$sOrder
			$sLimit
		";
		//echo $sQuery;exit;
		$rResult = $this->run($sQuery, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
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