<?php
class Page extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);
		$this->sTableI18n	= $this->sTable."_i18n";

		$this->aAllField		= array("pageId", "pageParent", "pageSorting", "pageIsDefault", "pageRedirect");
		$this->sIndexColumn		= "pageId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->aAllFieldI18n		= array("pageId", "iso639Id", "pageTitle", "pageDescription", "pageContent", "pageKeywords");
		$this->sIndexColumnI18n		= "pageId";
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
	
	public function jsonTree($id=null) {
		return json_encode($this->arrayTree($id));
	}

	private function arrayTree($id=null)
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
			$arr[$i]["id"] = $row[$this->sIndexColumn];
			$arr[$i]["text"] = $row[$this->sTitleColumn];
			if ($children = $this->arrayTree($arr[$i]["id"])) {
				$arr[$i]["children"] = $children;
			}
			else {
				$arr[$i]["href"] = $row["pageHref"];
			}
			$i++;
		}
		return ($arr);
	}

	function arrayPage($multilevel=false, $pageParent=null)
	{
		$sql = array();
		array_push($sql, "select");
		array_push($sql, $this->sTable . ".`pageId`,");
		array_push($sql, $this->sTable . ".`pageParent`,");
		array_push($sql, $this->sTableI18n . ".`pageTitle`");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		array_push($sql, "where 1=1");
		if ($pageParent==null) array_push($sql, "and " . $this->sTable . ".`pageParent` is null");
		else array_push($sql, "and " . $this->sTable . ".`pageParent` = " .$pageParent);
		array_push($sql, "order by " . $this->sSortingColumnFull . " asc");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			if ($multilevel) {
				$arr["items"][$i]["child"] = $this->arrayPage($multilevel, $row["pageId"]);
			}
			$i++;
		}
		return ($arr);
	}


	function getDefaultPage() {
		$pageId = isset($_GET["pageId"])?$_GET["pageId"]:0;
		$goToDefault = true;
		if ($pageId>0) {
			if ($row = $this->getEntry($_GET[$this->sIndexColumn], array("i18n"=>true))) {
				$goToDefault = false;
			}
		}

		if ($goToDefault) {
			$sql = array();
			array_push($sql, "select *");
			array_push($sql, "from " . $this->sTable);
			array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
			array_push($sql, "where " . $this->sTable . ".`pageIsDefault` = :isDefault");
			array_push($sql, "limit 1");
			$sql = implode(" ", $sql);
			//echo($sql);exit;
			
			$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "isDefault"=>1));
			$row = $rows[0];
		}

		return $row;

	}


	function printMenuArray($pageId=null, $pageParent=null) {
		$sql = "SELECT ";
		$sql .= "pageParent, ";
		$sql .= "pageTitle, ";
		$sql .= "pageId ";
		$sql .= "FROM `page` ";
		$sql .= "WHERE `pageLanguage` = :iso639 ";
		if ($pageParent==null) $sql .= "AND `pageParent` IS NULL ";
		else $sql .= "AND `pageParent` = $pageParent ";
		$sql .= "ORDER BY `pageSorting` ASC ";

		$stmt = parent::$cn->prepare($sql);
		$stmt->bindValue(':iso639', $_SESSION["PROJECT_LANGUAGE"], PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$i = 0;
		foreach ($rows as $row) {
			$app[$i] = $row;
			$app[$i]["selected"] = ($pageId==$row["pageId"])?true:false;
			$app[$i]["children"] = $this->printMenuArray($pageId, $row["pageId"]);
			$i++;
		}
		return $app;

	}

	function printMenu($pageId=null, $href=null, $type="horizontal", $multilevel=false, $pageParent=null, $seperator=null) {

		$op1 = '';
		if ($pageParent==null) {
			if ($type=="vertical") {
				$op1 .= '<ul class="jd_menu jd_menu_vertical">';
			}
			elseif ($type=="horizontal") {
				$op1 .= '<ul class="jd_menu">';
			}
			elseif ($type=="navbar") { // TODO Henüz tamamlanmadı
				$op1 .= '<ul class="jd_menu jd_menu_navbar">';
			}
			else {
				$op1 .= '<ul>';
			}
		}

		$sql = "select * ";
		$sql .= "from `" . $this->sTable . "` as `t` ";
		$sql .= "left join `" . $this->sTable . "_i18n` as `pi18n` on `pi18n`.`pageId` = `t`.`pageId` and `pi18n`.`iso639Id` = :iso639 ";
		$sql .= "where 1=1 ";
		if ($pageParent==null) $sql .= "and `t`.`pageParent` is null ";
		else $sql .= "and `t`.`pageParent` = $pageParent ";
		$sql .= "order by `t`.`pageSorting` asc ";

		$stmt = parent::$cn->prepare($sql);
		$stmt->bindValue(':iso639', $_SESSION["PROJECT_LANGUAGE"], PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$iTotalRecords = $stmt->rowCount();

		$i=0;
		if ($iTotalRecords>0) {
			if ($pageParent>0) {
				$op1 .= '<ul>';
			}
			foreach ($rows as $row) {
				$op2 .= '<option value="' . $row["pageId"] . '"';
				$op2 .= ($row["pageId"]==$row["test"])?' selected="selected"':null;
				$op2 .= ($pageId==$row["pageId"])?' disabled="disabled"':null;
				$op2 .= '>' . $seperator . $row["pageTitle"] . '</option>';

				$op1 .= '<li>';
				if ($href!=null) {
					$op1 .= '<a href="' . $href . "?pageId=".$row["pageId"] . '">' . $row["pageTitle"] . '</a>';
				}
				else {
					$op1 .= $row["pageTitle"];
				}
				if ($multilevel) {
					$op1 .= $this->printMenu($pageId, $href, $type, $multilevel, $row["pageId"]);
					$op2 .= $this->printMenu($pageId, $href, $type, $multilevel, $row["pageId"], $seperator."-");
				}
				$op1 .= '</li>';
				$i++;
				$op1 .= ($i==$iTotalRecords)?'</ul>':'';
			}
		}
		return $op1;
	}



	function mungeFormData(&$formvars)
	{
		parent::mungeFormData($formvars);
		foreach ($this->aAllField as $field) {
			$formvars[$field] = trim($formvars[$field]);
		}
	}

	function isValidForm($formvars)
	{
		parent::isValidForm($formvars);
		
		/*

		if(strlen($formvars['pageTitle']) == 0) {
			$this->msg = 'pageTitle_empty';
			return false;
		}

		if(strlen($formvars['pageDescription']) == 0) {
			$this->msg = 'pageDescription_empty';
			return false;
		}

		if(strlen($formvars['pageContent']) == 0) {
			$this->msg = 'pageContent_empty';
			return false;
		}
		
		*/
		
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
			$sWhere .= "WHERE ( ";
			$sWhere .= "page_i18n.pageTitle LIKE '%". $get['sSearch'] ."%' ";
			$sWhere .= "OR page_i18n.pageDescription LIKE '%". $get['sSearch'] ."%' ";
			$sWhere .= "OR page_i18n.pageContent LIKE '%". $get['sSearch'] ."%' ";
			$sWhere .= "OR page_i18n.pageKeywords LIKE '%". $get['sSearch'] ."%' ";
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
			SELECT SQL_CALC_FOUND_ROWS page.pageId, page_i18n.pageTitle, page_i18n.pageKeywords
			from $sTable
			left join page_i18n on page_i18n.pageId = page.pageId and page_i18n.iso639Id = ".$_SESSION["PROJECT_LANGUAGE"]."
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