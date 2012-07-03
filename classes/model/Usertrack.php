<?php
class Usertrack extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("usertrackId", "userId", "usertrackDatetime", "usertrackIpn", "usertracktypeId", "usertrackNote");
		$this->sIndexColumn		= "usertrackId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
	}
	
	function getUsertracks()
	{
		$sql = array();
		array_push($sql, "select");
		array_push($sql, "usertracktype.usertracktypeTitle,");
		array_push($sql, "user.userEmail,");
		array_push($sql, "usertrack.*");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join user on user.userId = usertrack.userId");
		array_push($sql, "left join usertracktype on usertracktype.usertracktypeId = usertrack.usertracktypeId");
		array_push($sql, "limit 10");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql);
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
		}
		return ($arr);
	}
		
	public function addTrack($type=1, $note=null)
	{
		global $smarty;
		if ( $smarty->getVariable("_SITE_TRACKING") == "1" ) {
			$this->insert(
				$this->sTable,
				array(
						"userId"=>$_SESSION["userId"],
						"usertrackDatetime"=>date("Y-m-d H:i:s"),
						"usertrackIpn"=>ip2long(gethostbyname($_SERVER['REMOTE_ADDR'])),
						"usertracktypeId"=>$type,
						"usertrackNote"=>$note
				)
			);
		}
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
			$sWhere .= "WHERE (user.userName LIKE '%".$get['sSearch']."%' ) ";
		}
		//echo $sWhere;exit;
		
		
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
			SELECT SQL_CALC_FOUND_ROWS usertrack.*, user.userEmail, usertracktype.usertracktypeTitle
			from usertrack
			left join user on user.userId = usertrack.userId
			left join usertracktype on usertracktype.usertracktypeId = usertrack.usertracktypeId
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
				if ( $aColumns[$i] == "usertrackIp" )
				{
					/* Special output formatting for 'version' column */
					$row[] = long2ip($aRow["usertrackIpn"]);
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