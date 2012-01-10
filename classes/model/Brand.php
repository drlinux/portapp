<?php
class Brand extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("brandId", "brandCode", "brandTitle");
		$this->sIndexColumn		= "brandId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sTitleColumn			= $this->sTable."Title";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	function getBrands()
	{
		$sQuery = "
				SELECT 
				picture.*,
				brand.*
				FROM brand
				LEFT JOIN brand_picture ON brand_picture.brandId = brand.brandId
				LEFT JOIN picture ON picture.pictureId = brand_picture.pictureId
			";
		
		$rows = $this->run($sQuery);
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row["brandId"]] = $row["brandTitle"];
			$i++;
		}
			
		return ($arr);
	}

	function getBrandsFromProductHavingPicture()
	{
		$sql = array();
		array_push($sql, "SELECT");
		array_push($sql, "count(product_picture.pictureId) as number_of_picture,");
		array_push($sql, "brand.brandCode,");
		array_push($sql, "brand.brandTitle,");
		array_push($sql, "product.brandId");
		array_push($sql, "FROM product");
		array_push($sql, "LEFT JOIN product_picture on product_picture.productId = product.productId AND product_picture.isDefault = true");
		array_push($sql, "LEFT JOIN brand on brand.brandId = product.brandId");
		array_push($sql, "WHERE product.brandId IS NOT NULL");
		array_push($sql, "GROUP BY product.brandId");
		array_push($sql, "HAVING COUNT(product_picture.pictureId) > 0");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql);
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
			$i++;
		}
			
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
			$sWhere .= "WHERE ( ";
			$sWhere .= "brand.brandCode LIKE '%". $get['sSearch'] ."%' ";
			$sWhere .= "OR brand.brandTitle LIKE '%". $get['sSearch'] ."%' ";
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
			SELECT SQL_CALC_FOUND_ROWS brand.brandId, brand.brandCode, brand.brandTitle
			from $sTable
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