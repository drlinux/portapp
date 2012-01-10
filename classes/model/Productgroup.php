<?php
class Productgroup extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("productgroupId", "productgroupSorting");
		$this->sIndexColumn		= "productgroupId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("productgroupId", "iso639Id", "productgroupTitle");
		$this->sIndexColumnI18n		= "productgroupId";
		$this->sIndexColumnI18nFull	= $this->sTableI18n.".".$this->sIndexColumnI18n;
		$this->sIso639ColumnI18n	= "iso639Id";
		$this->sIso639ColumnI18nFull= $this->sTableI18n.".".$this->sIso639ColumnI18n;

		$this->sSortingColumn		= $this->sTable."Sorting";
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTableI18n.".".$this->sTitleColumn;
	}

	public function getProductgroup($productgroupId)
	{
		$row = $this->getEntry($productgroupId);
		$row["product"] = $this->getProductByProductgroupId($productgroupId);
		return $row;
	}

	private function getProductByProductgroupId($productgroupId)
	{
		$sQuery = "
			SELECT 
			product.*
			FROM productgroup_product
			LEFT JOIN product ON product.productId = productgroup_product.productId
			WHERE productgroup_product.productgroupId = :productgroupId
		";
		//echo($sQuery);exit;
		
		$rows = $this->run($sQuery, array("productgroupId"=>$productgroupId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		$product = new Product();
		foreach($rows as $row) {
			$arr["aaData"][$i] = $product->getProductByProductId($row["productId"]);
			$arr["options"][$row["productId"]] = $row["productCode"];
			$arr["selected"][$i] = $row["productId"];
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
	public function dataTables($aColumns, $sIndexColumn, $sTable, $get=array())
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
			$sWhere .= "WHERE ( ";
			$sWhere .= "productgroup_i18n.productgroupTitle LIKE '%". $get['sSearch'] ."%' ";
			$sWhere .= ") ";
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
		
		
		//$sWhere .= "GROUP BY category.categoryId ";
		//echo $sWhere;exit;
		
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS productgroup.productgroupId, productgroup_i18n.productgroupTitle
			FROM $sTable
			LEFT JOIN productgroup_i18n ON productgroup_i18n.productgroupId = productgroup.productgroupId AND productgroup_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
			$sOrder
			$sWhere
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
		
		if ( isset($get['callback']) )
		{
			return $get['callback'].'('.json_encode( $output ).');';
		}
		else
		{
			return json_encode( $output );
		}
	}

}